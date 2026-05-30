<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'user_id', 'matricule', 'nom', 'prenom', 'email_personnel',
        'date_naissance', 'lieu_naissance', 'nationalite',
        'telephone', 'adresse', 'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
