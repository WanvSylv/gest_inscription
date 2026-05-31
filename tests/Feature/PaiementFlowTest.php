<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Etablissement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaiementFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_page_can_be_accessed_with_valid_token()
    {
        $etablissement = new Etablissement();
        $etablissement->nom = 'HOREB ACADEMY';
        $etablissement->code = 'HOREB';
        $etablissement->adresse = 'Abidjan';
        $etablissement->email = 'contact@horeb.academy';
        $etablissement->save();

        $etudiant = Etudiant::create([
            'prenom' => 'Jean',
            'nom' => 'Test',
            'email_personnel' => 'jean.test@example.com',
            'date_naissance' => '2000-01-01',
            'lieu_naissance' => 'Abidjan',
            'nationalite' => 'Ivoirienne',
            'telephone' => '+22501020304',
        ]);
        
        $filiere = Filiere::create([
            'nom' => 'Test Filiere',
            'code' => 'TFIL',
            'niveau' => 'Licence',
            'frais_inscription' => 500000,
            'description' => 'Test',
            'etablissement_id' => $etablissement->id,
            'actif' => true,
        ]);

        $inscription = Inscription::create([
            'etudiant_id' => $etudiant->id,
            'filiere_id' => $filiere->id,
            'annee_academique' => '2026-2027',
            'statut' => 'valide_academique',
            'niveau' => 'Licence 1',
            'token_paiement' => Str::random(40),
            'date_validation' => now(),
            'etablissement_id' => $etablissement->id,
        ]);

        $response = $this->get(route('paiement.show', ['token' => $inscription->token_paiement]));

        $response->assertStatus(200);
        $response->assertSee('Payer via FedaPay');
        $response->assertSee(number_format(500000, 0, ',', ' '));
    }

    public function test_webhook_approves_payment_creates_user_and_sends_email()
    {
        Mail::fake();
        Storage::fake('public');
        
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $etablissement = new Etablissement();
        $etablissement->nom = 'HOREB ACADEMY';
        $etablissement->code = 'HOREB';
        $etablissement->adresse = 'Abidjan';
        $etablissement->email = 'contact@horeb.academy';
        $etablissement->save();

        $etudiant = Etudiant::create([
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'email_personnel' => 'jean.dupont@example.com',
            'date_naissance' => '2000-01-01',
            'lieu_naissance' => 'Abidjan',
            'nationalite' => 'Ivoirienne',
            'telephone' => '+22501020304',
            'user_id' => null,
            'matricule' => null
        ]);
        
        $filiere = Filiere::create([
            'nom' => 'Génie Logiciel',
            'code' => 'GL',
            'niveau' => 'Licence',
            'frais_inscription' => 500000,
            'description' => 'Test',
            'etablissement_id' => $etablissement->id,
            'actif' => true,
        ]);

        $inscription = Inscription::create([
            'etudiant_id' => $etudiant->id,
            'filiere_id' => $filiere->id,
            'annee_academique' => '2026-2027',
            'statut' => 'valide_academique',
            'niveau' => 'Licence 1',
            'token_paiement' => Str::random(40),
            'date_validation' => now(),
            'etablissement_id' => $etablissement->id,
        ]);

        $payload = [
            'entity' => [
                'id' => 'transaction_12345',
                'status' => 'approved',
                'amount' => 500000,
                'mode' => 'mobile_money',
                'approved_at' => now()->toIso8601String(),
                'custom_metadata' => [
                    'inscription_id' => $inscription->id,
                    'token_paiement' => $inscription->token_paiement
                ],
                'customer' => [
                    'email' => 'jean.dupont@example.com'
                ]
            ]
        ];

        $response = $this->postJson(route('webhook.fedapay'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Paiement traité avec succès']);

        $inscription->refresh();
        $this->assertEquals('inscrit', $inscription->statut);

        $paiement = Paiement::where('inscription_id', $inscription->id)->first();
        $this->assertNotNull($paiement);
        $this->assertEquals('transaction_12345', $paiement->transaction_id);

        $etudiant->refresh();
        $this->assertNotNull($etudiant->user_id);
        $this->assertNotNull($etudiant->matricule);
        $this->assertStringStartsWith('HA-', $etudiant->matricule);

        $user = \App\Models\User::find($etudiant->user_id);
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('etudiant'));

        Mail::assertSent(\App\Mail\PaymentReceiptEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        // Assert PDF was stored
        $this->assertNotNull($paiement->recu_chemin);
        Storage::disk('public')->assertExists($paiement->recu_chemin);
    }
}
