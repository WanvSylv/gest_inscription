<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\User;
use App\Services\UserCreationService;
use Carbon\Carbon;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    public function __construct()
    {
        FedaPay::setApiKey(config('fedapay.secret_key'));
        FedaPay::setEnvironment(config('fedapay.sandbox') ? 'sandbox' : 'live');
    }

    public function show($token)
    {
        $inscription = Inscription::with(['etudiant', 'filiere'])
            ->where('token_paiement', $token)
            ->firstOrFail();

        // Vérifier si déjà payé ou inscrit
        if (in_array($inscription->statut, ['paye', 'inscrit'])) {
            return redirect()->route('paiement.success', ['token' => $token])
                ->with('info', 'Ce dossier a déjà été payé.');
        }

        // Vérifier si le délai est expiré (72h après validation)
        if ($inscription->date_validation && Carbon::now()->diffInHours($inscription->date_validation) > 72) {
            return abort(403, 'Le délai de 72h pour le paiement est expiré. Veuillez contacter l\'administration.');
        }

        return view('paiement.show', compact('inscription'));
    }

    public function payer(Request $request, $token)
    {
        $inscription = Inscription::with(['etudiant', 'filiere'])
            ->where('token_paiement', $token)
            ->firstOrFail();

        if (in_array($inscription->statut, ['paye', 'inscrit'])) {
            return redirect()->route('paiement.success', ['token' => $token]);
        }

        try {
            $transaction = Transaction::create([
                "description" => "Paiement des frais de validation d'inscription - HOREB ACADEMY",
                "amount" => (int) $inscription->filiere->frais_inscription,
                "currency" => ["iso" => "XOF"],
                "callback_url" => route('paiement.success', ['token' => $token]),
                "customer" => [
                    "firstname" => $inscription->etudiant->prenom,
                    "lastname" => $inscription->etudiant->nom,
                    "email" => $inscription->etudiant->email_personnel,
                    "phone_number" => [
                        "number" => $inscription->etudiant->telephone,
                        "country" => "bj"
                    ]
                ],
                "custom_metadata" => [
                    "inscription_id" => $inscription->id,
                    "token_paiement" => $token
                ]
            ]);

            $payToken = $transaction->generateToken();

            return redirect($payToken->url);
        } catch (\Exception $e) {
            Log::error('FedaPay Transaction Error: ' . $e->getMessage());
            
            $detail = $e->getMessage();
            if ($e instanceof \FedaPay\Error\Base && $e->getErrorMessage()) {
                $detail = $e->getErrorMessage();
                if ($e->getErrors()) {
                    $detail .= ' (' . implode(', ', array_map(function($k, $v) {
                        return $k . ': ' . (is_array($v) ? implode(', ', $v) : $v);
                    }, array_keys($e->getErrors()), $e->getErrors())) . ')';
                }
            }

            return back()->with('error', 'Une erreur est survenue lors de l\'initialisation du paiement : ' . $detail);
        }
    }

    public function success(Request $request, $token)
    {
        $inscription = Inscription::with(['etudiant', 'filiere'])
            ->where('token_paiement', $token)
            ->firstOrFail();

        // Si déjà inscrit → succès confirmé
        if ($inscription->statut === 'inscrit') {
            $paiement = $inscription->paiements()->latest()->first();
            return view('paiement.success', compact('inscription', 'paiement'));
        }

        // FedaPay transmet l'id de transaction via query string
        $transactionId = $request->query('id');

        if ($transactionId) {
            try {
                $transaction = Transaction::retrieve($transactionId);

                if ($transaction->status === 'approved') {
                    // Traiter le paiement ici (fallback si le webhook n'a pas encore tiré)
                    $existingPaiement = Paiement::where('transaction_id', $transactionId)->first();

                    if (!$existingPaiement) {
                        DB::beginTransaction();
                        try {
                            $paiementDb = Paiement::create([
                                'inscription_id' => $inscription->id,
                                'etudiant_id'    => $inscription->etudiant_id,
                                'transaction_id' => $transactionId,
                                'montant'        => $transaction->amount,
                                'devise'         => 'XOF',
                                'statut'         => 'approved',
                                'methode'        => $transaction->mode ?? 'mobile_money',
                                'paye_le'        => \Carbon\Carbon::parse($transaction->approved_at ?? now()),
                            ]);

                            $inscription->statut = 'inscrit';
                            $inscription->save();

                            if (!$inscription->etudiant->user_id) {
                                $user = app(\App\Services\UserCreationService::class)->createStudentUser($inscription->etudiant);
                                $inscription->load('etudiant');
                            } else {
                                $user = $inscription->etudiant->user;
                                $user->plainPassword = 'Non applicable (Compte existant)';
                            }

                            // PDF reçu
                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', [
                                'inscription' => $inscription,
                                'paiement'    => $paiementDb,
                            ]);
                            $pdfContent = $pdf->output();
                            $pdfName    = 'Recu_Paiement_' . $inscription->etudiant->matricule . '.pdf';
                            $pdfPath    = 'recus/' . $pdfName;
                            \Illuminate\Support\Facades\Storage::disk('public')->put($pdfPath, $pdfContent);
                            $paiementDb->recu_chemin = $pdfPath;
                            $paiementDb->save();

                            DB::commit();

                            // Email identifiants + reçu (hors transaction)
                            try {
                                \Illuminate\Support\Facades\Mail::to($user->email)
                                    ->send(new \App\Mail\PaymentReceiptEmail($user, $user->plainPassword, $pdfContent, $pdfName));
                            } catch (\Throwable $e) {
                                Log::error('Email identifiants non envoyé: ' . $e->getMessage());
                            }

                            $existingPaiement = $paiementDb;
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Erreur traitement paiement success: ' . $e->getMessage());
                        }
                    }

                    // Recharger l'inscription (statut peut avoir changé)
                    $inscription->refresh();
                    $paiement = $existingPaiement ?? $inscription->paiements()->latest()->first();
                    return view('paiement.success', compact('inscription', 'paiement'));
                }

                if (in_array($transaction->status, ['declined', 'cancelled'])) {
                    return redirect()->route('paiement.show', ['token' => $token])
                        ->with('error', 'Paiement ' . ($transaction->status === 'cancelled' ? 'annulé' : 'refusé') . '. Veuillez réessayer.');
                }

            } catch (\Exception $e) {
                Log::error('FedaPay retrieve error: ' . $e->getMessage());
            }
        }

        // Pas encore traité → retour vers la page paiement
        if ($inscription->statut === 'valide_academique') {
            return redirect()->route('paiement.show', ['token' => $token])
                ->with('info', 'Votre paiement est en cours de traitement. Vous recevrez une confirmation par email.');
        }

        return view('paiement.success', compact('inscription'));
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Webhook FedaPay Reçu', $payload);

        // FedaPay webhooks have "name" (event name) and "entity" (transaction details)
        if (!isset($payload['entity']) || !isset($payload['entity']['status'])) {
            return response()->json(['message' => 'Format invalide'], 400);
        }

        $transactionInfo = $payload['entity'];

        if ($transactionInfo['status'] === 'approved') {
            DB::beginTransaction();
            try {
                // Utilisons le custom_metadata pour retrouver l'inscription de manière fiable
                $inscriptionId = $transactionInfo['custom_metadata']['inscription_id'] ?? null;
                
                if (!$inscriptionId) {
                    // Fallback sur email
                    $customerEmail = $transactionInfo['customer']['email'] ?? null;
                    if (!$customerEmail) {
                        return response()->json(['message' => 'Impossible de lier la transaction à une inscription'], 400);
                    }
                    $inscription = Inscription::whereHas('etudiant', function($q) use ($customerEmail) {
                        $q->where('email_personnel', $customerEmail);
                    })->whereIn('statut', ['valide_academique', 'en_attente'])->first();
                } else {
                    $inscription = Inscription::find($inscriptionId);
                }

                if (!$inscription) {
                    return response()->json(['message' => 'Inscription non trouvée'], 404);
                }

                // Vérifier si le paiement existe déjà (idempotence)
                $existingPaiement = Paiement::where('transaction_id', $transactionInfo['id'])->first();
                if ($existingPaiement) {
                    return response()->json(['message' => 'Paiement déjà traité']);
                }

                // Créer le paiement
                Paiement::create([
                    'inscription_id' => $inscription->id,
                    'etudiant_id' => $inscription->etudiant_id,
                    'transaction_id' => $transactionInfo['id'],
                    'montant' => $transactionInfo['amount'],
                    'devise' => 'XOF',
                    'statut' => 'approved',
                    'methode' => $transactionInfo['mode'] ?? 'mobile_money',
                    'paye_le' => Carbon::parse($transactionInfo['approved_at'] ?? now())
                ]);

                // Mettre à jour l'inscription
                $inscription->statut = 'inscrit';
                $inscription->save();

                // Créer le compte utilisateur et associer l'étudiant
                // Si l'étudiant n'a pas encore de compte
                if (!$inscription->etudiant->user_id) {
                    $user = app(UserCreationService::class)->createStudentUser($inscription->etudiant);
                    
                    // Recharge l'étudiant pour avoir le matricule fraîchement généré
                    $inscription->load('etudiant');
                } else {
                    $user = $inscription->etudiant->user;
                    $user->plainPassword = 'Non applicable (Compte existant)'; // Pour l'email
                }

                $paiementDb = Paiement::where('transaction_id', $transactionInfo['id'])->first();

                // Générer le reçu PDF
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', [
                    'inscription' => $inscription,
                    'paiement' => $paiementDb
                ]);
                
                $pdfContent = $pdf->output();
                $pdfName = 'Recu_Paiement_' . $inscription->etudiant->matricule . '.pdf';

                // Sauvegarder le PDF (optionnel mais recommandé)
                $pdfPath = 'recus/' . $pdfName;
                \Illuminate\Support\Facades\Storage::disk('public')->put($pdfPath, $pdfContent);
                
                $paiementDb->recu_chemin = $pdfPath;
                $paiementDb->save();

                // Envoyer l'email
                \Illuminate\Support\Facades\Mail::to($user->email)
                    ->send(new \App\Mail\PaymentReceiptEmail($user, $user->plainPassword, $pdfContent, $pdfName));

                DB::commit();

                return response()->json(['message' => 'Paiement traité avec succès']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erreur Webhook FedaPay', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Erreur de traitement'], 500);
            }
        }

        return response()->json(['message' => 'Événement ignoré']);
    }
}
