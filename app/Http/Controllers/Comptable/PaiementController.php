<?php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $statut = $request->get('statut');

        $query = Paiement::with(['etudiant', 'inscription.filiere'])
            ->when($search, function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('etudiant', function ($q2) use ($search) {
                      $q2->where('nom', 'like', "%{$search}%")
                         ->orWhere('prenom', 'like', "%{$search}%")
                         ->orWhere('email_personnel', 'like', "%{$search}%");
                  });
            })
            ->when($statut, function ($q) use ($statut) {
                $q->where('statut', $statut);
            });

        $paiements = $query->latest()->paginate(15);

        // Stats
        $stats = [
            'total_revenu' => Paiement::where('statut', 'approved')->sum('montant'),
            'payes_count' => Paiement::where('statut', 'approved')->count(),
            'en_attente_count' => Paiement::where('statut', 'pending')->count(),
            'montant_moyen' => Paiement::where('statut', 'approved')->avg('montant') ?? 0,
        ];

        return view('comptable.paiements.index', compact('paiements', 'stats', 'search', 'statut'));
    }

    public function show(Paiement $paiement)
    {
        $paiement->load(['etudiant', 'inscription.filiere']);
        return view('comptable.paiements.show', compact('paiement'));
    }

    public function telechargerRecu(Paiement $paiement)
    {
        $paiement->load(['etudiant', 'inscription.filiere']);

        // Si le chemin du reçu est défini et le fichier existe, on le propose en téléchargement
        if ($paiement->recu_chemin && Storage::disk('public')->exists($paiement->recu_chemin)) {
            return Storage::disk('public')->download($paiement->recu_chemin);
        }

        // Sinon, on génère le reçu PDF à la volée de manière ultra-robuste
        try {
            $inscription = Inscription::with(['etudiant', 'filiere'])->findOrFail($paiement->inscription_id);
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', [
                'inscription' => $inscription,
                'paiement' => $paiement
            ]);

            $fileName = 'Recu_Paiement_' . ($inscription->etudiant->matricule ?? 'MANUEL_' . $paiement->id) . '.pdf';
            
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération à la volée du reçu PDF: ' . $e->getMessage());
            return back()->with('error', 'Le reçu PDF n\'a pas pu être généré. Veuillez réessayer.');
        }
    }
}
