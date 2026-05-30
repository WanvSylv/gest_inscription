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
        FedaPay::setApiKey(config('fedapay.secret_key', env('FEDAPAY_SECRET_KEY')));
        FedaPay::setEnvironment(env('FEDAPAY_SANDBOX', true) ? 'sandbox' : 'live');
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
                "description" => "Paiement de scolarité - HOREB ACADEMY",
                "amount" => $inscription->filiere->montant_scolarite,
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
            return back()->with('error', 'Une erreur est survenue lors de l\'initialisation du paiement.');
        }
    }

    public function success($token)
    {
        $inscription = Inscription::where('token_paiement', $token)->firstOrFail();

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
