<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom', 'code', 'niveau', 'description', 'frais_inscription', 'etablissement_id', 'actif'];

    protected $casts = [
        'frais_inscription' => 'decimal:2',
        'actif' => 'boolean',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
