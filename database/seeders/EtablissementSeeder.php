<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Etablissement;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etablissement::firstOrCreate(
            ['code' => 'HOREB'],
            [
                'nom' => 'HOREB ACADEMY',
                'adresse' => 'Campus Principal, Abidjan',
                'email' => 'contact@horeb.academy',
                'telephone' => '+2250102030405',
                'est_principal' => true,
                'actif' => true
            ]
        );
    }
}
