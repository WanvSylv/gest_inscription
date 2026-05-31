<?php

namespace App\Http\Controllers\Academique;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Etablissement;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount('inscriptions')->orderBy('nom')->paginate(15);

        $stats = [
            'total' => Filiere::count(),
            'actives' => Filiere::where('actif', true)->count(),
            'moyenne_frais' => Filiere::avg('frais_inscription') ?? 0,
        ];

        return view('academique.filieres.index', compact('filieres', 'stats'));
    }

    public function create()
    {
        $etablissements = Etablissement::all();
        // default to HOREB academy if exists
        $defaultEtablissement = Etablissement::where('code', 'HOREB')->first() ?? Etablissement::first();

        return view('academique.filieres.create', compact('etablissements', 'defaultEtablissement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:filieres,code',
            'niveau' => 'required|string|max:50',
            'frais_inscription' => 'required|numeric|min:0',
            'etablissement_id' => 'required|exists:etablissements,id',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        Filiere::create([
            'nom' => $request->nom,
            'code' => strtoupper($request->code),
            'niveau' => $request->niveau,
            'frais_inscription' => $request->frais_inscription,
            'etablissement_id' => $request->etablissement_id,
            'description' => $request->description,
            'actif' => $request->boolean('actif', true),
        ]);

        return redirect()->route('academique.filieres.index')
            ->with('success', 'Filière créée avec succès !');
    }

    public function edit(Filiere $filiere)
    {
        $etablissements = Etablissement::all();
        return view('academique.filieres.edit', compact('filiere', 'etablissements'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:filieres,code,' . $filiere->id,
            'niveau' => 'required|string|max:50',
            'frais_inscription' => 'required|numeric|min:0',
            'etablissement_id' => 'required|exists:etablissements,id',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $filiere->update([
            'nom' => $request->nom,
            'code' => strtoupper($request->code),
            'niveau' => $request->niveau,
            'frais_inscription' => $request->frais_inscription,
            'etablissement_id' => $request->etablissement_id,
            'description' => $request->description,
            'actif' => $request->boolean('actif', false),
        ]);

        return redirect()->route('academique.filieres.index')
            ->with('success', 'Filière mise à jour avec succès !');
    }

    public function destroy(Filiere $filiere)
    {
        // Check if there are active inscriptions
        if ($filiere->inscriptions()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette filière car des dossiers d\'inscription y sont rattachés.');
        }

        $filiere->delete();

        return redirect()->route('academique.filieres.index')
            ->with('success', 'Filière supprimée avec succès !');
    }
}
