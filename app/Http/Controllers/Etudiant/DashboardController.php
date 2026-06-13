<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $etudiant = $user->etudiant()->with(['inscriptions.filiere', 'inscriptions.paiements', 'inscriptions.piecesJustificatives'])->first();

        if (!$etudiant) {
            return view('etudiant.dashboard', ['etudiant' => null, 'inscription' => null, 'paiement' => null]);
        }

        // Inscription la plus récente (la plus avancée)
        $inscription = $etudiant->inscriptions->sortByDesc('created_at')->first();
        $paiement    = $inscription?->paiements->where('statut', 'approved')->first();

        return view('etudiant.dashboard', compact('etudiant', 'inscription', 'paiement'));
    }
}
