<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            $table->foreignId('etablissement_source_id')->constrained('etablissements')->cascadeOnDelete();
            $table->foreignId('etablissement_destination_id')->constrained('etablissements')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'approuve', 'refuse', 'effectue'])->default('en_attente');
            $table->text('motif')->nullable();
            $table->boolean('impaye_bloque')->default(false);
            $table->foreignId('valide_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('date_transfert')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
