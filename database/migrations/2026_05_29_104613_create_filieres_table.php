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
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained('etablissements')->cascadeOnDelete();
            $table->string('nom');
            $table->string('code', 50)->unique();
            $table->string('niveau', 50);
            $table->text('description')->nullable();
            $table->decimal('frais_inscription', 10, 2);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
