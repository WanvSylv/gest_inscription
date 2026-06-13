<?php

namespace App\Http\Controllers;

use App\Mail\DossierRecuEmail;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\PieceJustificative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PreinscriptionController extends Controller
{
    public function create()
    {
        // Vérifier que l'email a été validé via OTP
        if (!session('email_verifie')) {
            return redirect()->route('preinscription.verify-email')
                ->with('info', 'Veuillez d\'abord vérifier votre adresse email.');
        }

        $filieres = Filiere::where('actif', true)->get();
        $emailVerifie = session('email_verifie');
        return view('preinscription.create', compact('filieres', 'emailVerifie'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'nationalite' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'email_personnel' => 'required|email|max:255|unique:etudiants,email_personnel',
            'filiere_id' => 'required|exists:filieres,id',
            'niveau_entree' => 'required|in:L1,L2,L3,M1,M2',
            'annee_academique' => 'required|string',
            
            // Academic history validation (Step 2)
            'dernier_diplome' => 'required|string|max:100',
            'annee_diplome' => 'required|integer',
            'etablissement_diplome' => 'required|string|max:255',
            'specialite_diplome' => 'required|string|max:255',
            
            // Files Validation based on level
            'releve_bac' => 'required_if:niveau_entree,L1,L2,L3|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'releves_l1' => 'required_if:niveau_entree,L2,L3|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'releves_l2' => 'required_if:niveau_entree,L3|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attestation_licence' => 'required_if:niveau_entree,M1,M2|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'releves_m1' => 'required_if:niveau_entree,M2|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'carte_identite' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'acte_naissance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $inscriptionSauvee = null;
        $etudiantSauve = null;

        DB::beginTransaction();
        try {
            $etudiant = Etudiant::create($request->only([
                'prenom', 'nom', 'date_naissance', 'lieu_naissance',
                'nationalite', 'telephone', 'adresse', 'email_personnel'
            ]));

            $inscription = Inscription::create([
                'etudiant_id'          => $etudiant->id,
                'filiere_id'           => $request->filiere_id,
                'annee_academique'     => $request->annee_academique,
                'niveau'               => $request->niveau_entree,
                'statut'               => 'en_attente',
                'dernier_diplome'      => $request->dernier_diplome,
                'annee_diplome'        => $request->annee_diplome,
                'etablissement_diplome' => $request->etablissement_diplome,
                'specialite_diplome'   => $request->specialite_diplome,
            ]);

            $filesToUpload = [
                'releve_bac', 'releves_l1', 'releves_l2', 'attestation_licence', 'releves_m1',
                'photo', 'carte_identite', 'acte_naissance'
            ];

            foreach ($filesToUpload as $fileType) {
                if ($request->hasFile($fileType)) {
                    $path = $request->file($fileType)->store('pieces_justificatives/' . $etudiant->id, 'public');
                    PieceJustificative::create([
                        'inscription_id'      => $inscription->id,
                        'type_piece'          => $fileType,
                        'chemin_fichier'      => $path,
                        'statut_verification' => 'en_attente',
                    ]);
                }
            }

            DB::commit();
            $inscriptionSauvee = $inscription;
            $etudiantSauve     = $etudiant;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur enregistrement dossier: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }

        // Vider la session
        session()->forget('email_verifie');

        // Envoyer les emails — COMPLÈTEMENT ISOLÉ de la transaction DB
        try {
            $inscriptionSauvee->load(['etudiant', 'filiere']);
            Mail::to($etudiantSauve->email_personnel)
                ->send(new DossierRecuEmail($inscriptionSauvee));
            Mail::to(env('ADMIN_EMAIL', 'horebacademy@manosphone.com'))
                ->send(new \App\Mail\NouveauDossierAdminEmail($inscriptionSauvee));
        } catch (\Throwable $e) {
            Log::error('Erreur envoi mail dossier reçu: ' . $e->getMessage());
        }

        return redirect()->route('preinscription.success')->with('success', 'Votre dossier a été soumis avec succès.');
    }

    public function success()
    {
        return view('preinscription.success');
    }
}
