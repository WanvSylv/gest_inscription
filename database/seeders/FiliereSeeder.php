<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filiere;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        $etablissement = \App\Models\Etablissement::where('code', 'HOREB')->first();

        if (!$etablissement) {
            $this->command->warn('Etablissement HOREB introuvable. Lancez EtablissementSeeder d\'abord.');
            return;
        }

        $filieres = [
            ['nom' => 'Informatique et Systèmes',   'code' => 'INFO',  'niveau' => 'Licence', 'frais_inscription' => 150000, 'description' => 'Développement logiciel et systèmes', 'actif' => true],
            ['nom' => 'Gestion des Entreprises',     'code' => 'GEST',  'niveau' => 'Licence', 'frais_inscription' => 120000, 'description' => 'Management, comptabilité et administration', 'actif' => true],
            ['nom' => 'Droit des Affaires',           'code' => 'DROIT', 'niveau' => 'Licence', 'frais_inscription' => 110000, 'description' => 'Droit commercial, fiscal et des affaires', 'actif' => true],
            ['nom' => 'Sciences Économiques',         'code' => 'ECO',   'niveau' => 'Licence', 'frais_inscription' => 115000, 'description' => 'Économie, finance et statistiques', 'actif' => true],
            ['nom' => 'Marketing & Communication',    'code' => 'MKT',   'niveau' => 'Licence', 'frais_inscription' => 125000, 'description' => 'Marketing digital et communication', 'actif' => true],
            ['nom' => 'Banque & Finance',             'code' => 'BF',    'niveau' => 'Licence', 'frais_inscription' => 130000, 'description' => 'Gestion bancaire et marchés financiers', 'actif' => true],
            ['nom' => 'Ressources Humaines',          'code' => 'RH',    'niveau' => 'Licence', 'frais_inscription' => 120000, 'description' => 'Gestion des talents et droit social', 'actif' => true],
            ['nom' => 'Génie Civil & BTP',            'code' => 'GC',    'niveau' => 'Licence', 'frais_inscription' => 160000, 'description' => 'Construction, urbanisme et travaux publics', 'actif' => true],
        ];

        foreach ($filieres as $filiere) {
            Filiere::firstOrCreate(
                ['code' => $filiere['code']],
                array_merge($filiere, ['etablissement_id' => $etablissement->id])
            );
        }
    }
}
