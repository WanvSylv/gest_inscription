<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Inscription;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate frais_validation for existing validated inscriptions
        foreach (Inscription::where('statut', 'valide_academique')->where('frais_validation', 0)->with('filiere')->cursor() as $inscription) {
            if ($inscription->filiere && $inscription->filiere->frais_inscription) {
                $inscription->frais_validation = $inscription->filiere->frais_inscription;
                $inscription->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No revert needed for data backfill
    }
};
