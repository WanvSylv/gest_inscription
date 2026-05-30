<?php

namespace App\Http\Controllers\Academique;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut', 'en_attente');

        $inscriptions = Inscription::with(['etudiant', 'filiere'])
            ->when($statut !== 'tous', fn($q) => $q->where('statut', $statut))
            ->latest()
            ->paginate(15);

        $stats = [
            'en_attente'        => Inscription::where('statut', 'en_attente')->count(),
            'valide_academique' => Inscription::where('statut', 'valide_academique')->count(),
            'rejete_modifiable' => Inscription::where('statut', 'rejete_modifiable')->count(),
            'rejete_definitif'  => Inscription::where('statut', 'rejete_definitif')->count(),
            'paye'              => Inscription::where('statut', 'paye')->count(),
            'inscrit'           => Inscription::where('statut', 'inscrit')->count(),
        ];

        return view('academique.inscriptions.index', compact('inscriptions', 'stats', 'statut'));
    }

    public function show(Inscription $inscription)
    {
        $inscription->load(['etudiant', 'filiere', 'piecesJustificatives', 'validePar']);
        $libelles = \App\Models\PieceJustificative::libelles();
        return view('academique.inscriptions.show', compact('inscription', 'libelles'));
    }

    public function valider(Request $request, Inscription $inscription)
    {
        if ($inscription->statut !== 'en_attente') {
            return back()->with('error', 'Ce dossier ne peut pas être validé dans son état actuel.');
        }

        $inscription->update([
            'statut'          => 'valide_academique',
            'date_validation' => now(),
            'valide_par'      => Auth::id(),
            'limite_paiement' => now()->addHours(72),
            'token_paiement'  => Str::uuid(),
        ]);

        // @todo Send email + SMS notification to student
        return back()->with('success', 'Dossier validé. Le lien de paiement a été généré (72h).');
    }

    public function rejeter(Request $request, Inscription $inscription)
    {
        $request->validate([
            'motif_rejet'        => 'required|string|min:10',
            'autoriser_modif'    => 'nullable|boolean',
        ]);

        $nouveauStatut = $request->boolean('autoriser_modif')
            ? 'rejete_modifiable'
            : 'rejete_definitif';

        $inscription->update([
            'statut'      => $nouveauStatut,
            'motif_rejet' => $request->motif_rejet,
            'valide_par'  => Auth::id(),
        ]);

        // @todo Send email + SMS notification to student
        return back()->with('success', 'Dossier rejeté avec succès.');
    }
}
