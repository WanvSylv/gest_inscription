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
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->string('dernier_diplome', 100)->nullable()->after('frais_validation');
            $table->year('annee_diplome')->nullable()->after('dernier_diplome');
            $table->string('etablissement_diplome')->nullable()->after('annee_diplome');
            $table->string('specialite_diplome')->nullable()->after('etablissement_diplome');
        });
    }

    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropColumn(['dernier_diplome', 'annee_diplome', 'etablissement_diplome', 'specialite_diplome']);
        });
    }
};
