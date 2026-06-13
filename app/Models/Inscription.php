<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'etudiant_id', 'filiere_id', 'annee_academique', 'niveau',
        'statut', 'motif_rejet', 'date_validation', 'valide_par',
        'limite_paiement', 'token_paiement', 'etablissement_id',
        'nombre_resoumissions', 'frais_validation',
        'dernier_diplome', 'annee_diplome', 'etablissement_diplome', 'specialite_diplome',
    ];

    protected $casts = [
        'date_validation' => 'datetime',
        'limite_paiement' => 'datetime',
    ];

    const STATUTS = [
        'en_attente'         => ['label' => 'En attente',    'color' => 'yellow'],
        'valide_academique'  => ['label' => 'Validé',        'color' => 'blue'],
        'rejete_modifiable'  => ['label' => 'Rejeté (modifiable)', 'color' => 'orange'],
        'rejete_definitif'   => ['label' => 'Rejeté',        'color' => 'red'],
        'paye'               => ['label' => 'Payé',          'color' => 'purple'],
        'inscrit'            => ['label' => 'Inscrit',       'color' => 'green'],
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function validePar()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function piecesJustificatives()
    {
        return $this->hasMany(PieceJustificative::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
