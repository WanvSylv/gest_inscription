<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom', 'code', 'description', 'actif'];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
