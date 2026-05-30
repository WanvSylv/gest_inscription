<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'inscription_id',
        'etudiant_id',
        'transaction_id',
        'montant',
        'devise',
        'statut',
        'methode',
        'recu_chemin',
        'paye_le',
    ];

    protected $casts = [
        'paye_le' => 'datetime',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
