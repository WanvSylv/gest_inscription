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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            $table->foreignId('filiere_id')->nullable()->constrained('filieres')->nullOnDelete();
            $table->string('annee_academique', 20);
            $table->string('niveau', 50);
            $table->enum('statut', ['en_attente', 'valide_academique', 'rejete_modifiable', 'rejete_definitif', 'paye', 'inscrit'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->foreignId('valide_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('limite_paiement')->nullable();
            $table->string('token_paiement')->unique()->nullable();
            $table->foreignId('etablissement_id')->nullable()->constrained('etablissements')->nullOnDelete();
            $table->integer('nombre_resoumissions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
