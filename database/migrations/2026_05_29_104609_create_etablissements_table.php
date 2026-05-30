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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code', 50)->unique();
            $table->text('adresse');
            $table->string('email');
            $table->string('telephone', 20)->nullable();
            $table->string('api_token')->nullable();
            $table->boolean('actif')->default(true);
            $table->boolean('est_principal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etablissements');
    }
};
