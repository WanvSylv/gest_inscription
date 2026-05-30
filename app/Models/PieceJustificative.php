<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieceJustificative extends Model
{
    protected $fillable = [
        'inscription_id', 'type_piece', 'chemin_fichier', 'statut_verification', 'commentaire',
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public static function libelles(): array
    {
        return [
            'releve_bac'          => 'Relevé de notes du Bac',
            'releves_l1'          => 'Relevés de notes L1',
            'releves_l2'          => 'Relevés de notes L2',
            'attestation_licence' => 'Attestation de Licence',
            'releves_m1'          => 'Relevés de notes M1',
            'photo'               => 'Photo d\'identité',
            'carte_identite'      => 'Pièce d\'identité (CNI/Passeport)',
            'acte_naissance'      => 'Acte de naissance',
        ];
    }
}
