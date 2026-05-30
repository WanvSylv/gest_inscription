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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')->constrained('inscriptions')->cascadeOnDelete();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            $table->string('transaction_id')->unique();
            $table->decimal('montant', 10, 2);
            $table->string('devise', 10);
            $table->enum('statut', ['pending', 'approved', 'declined', 'cancelled'])->default('pending');
            $table->string('methode', 50)->nullable();
            $table->string('recu_chemin')->nullable();
            $table->timestamp('paye_le')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
