<?php

namespace Tests\Feature\Comptable;

use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PaiementControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $comptableUser;
    protected $etudiantUser;
    protected $etablissement;
    protected $filiere;
    protected $etudiant;
    protected $inscription;
    protected $paiement;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        $this->seed(\Database\Seeders\RoleSeeder::class);

        // Create Users
        $this->adminUser = User::factory()->create(['password_changed' => true]);
        $this->adminUser->assignRole('admin');

        $this->comptableUser = User::factory()->create(['password_changed' => true]);
        $this->comptableUser->assignRole('comptable');

        $this->etudiantUser = User::factory()->create(['password_changed' => true]);
        $this->etudiantUser->assignRole('etudiant');

        // Create Etablissement manually (bypassing mass assignment)
        $this->etablissement = new Etablissement();
        $this->etablissement->nom = 'HOREB ACADEMY';
        $this->etablissement->code = 'HOREB';
        $this->etablissement->adresse = 'Abidjan';
        $this->etablissement->email = 'contact@horeb.academy';
        $this->etablissement->save();

        // Create Student
        $this->etudiant = Etudiant::create([
            'prenom' => 'Koffi',
            'nom' => 'Kouame',
            'email_personnel' => 'koffi@example.com',
            'date_naissance' => '1998-05-15',
            'lieu_naissance' => 'Bouake',
            'nationalite' => 'Ivoirienne',
            'telephone' => '+22507080901',
            'user_id' => $this->etudiantUser->id,
            'matricule' => 'HA-001'
        ]);

        // Create Filiere
        $this->filiere = Filiere::create([
            'nom' => 'Informatique',
            'code' => 'INFO',
            'niveau' => 'Licence',
            'frais_inscription' => 150000,
            'etablissement_id' => $this->etablissement->id,
            'actif' => true
        ]);

        // Create Inscription
        $this->inscription = Inscription::create([
            'etudiant_id' => $this->etudiant->id,
            'filiere_id' => $this->filiere->id,
            'annee_academique' => '2026-2027',
            'statut' => 'paye',
            'niveau' => 'Licence 1',
            'etablissement_id' => $this->etablissement->id,
        ]);

        // Create Paiement
        $this->paiement = Paiement::create([
            'inscription_id' => $this->inscription->id,
            'etudiant_id' => $this->etudiant->id,
            'transaction_id' => 'TX_99999',
            'montant' => 150000,
            'devise' => 'XOF',
            'statut' => 'approved',
            'methode' => 'mobile_money',
            'paye_le' => now()
        ]);
    }

    public function test_guests_and_unauthorized_roles_cannot_access_payments_panel()
    {
        // Guests redirect to login
        $response = $this->get(route('comptable.paiements.index'));
        $response->assertRedirect(route('login'));

        // Students receive forbidden / redirect
        $response = $this->actingAs($this->etudiantUser)->get(route('comptable.paiements.index'));
        $response->assertStatus(403);
    }

    public function test_comptable_and_admin_can_access_payments_index()
    {
        // Comptable access
        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.index'));
        $response->assertStatus(200);
        $response->assertSee('Suivi des paiements');
        $response->assertSee('TX_99999');
        $response->assertSee('Kouame');

        // Admin access
        $response = $this->actingAs($this->adminUser)->get(route('comptable.paiements.index'));
        $response->assertStatus(200);
    }

    public function test_comptable_can_filter_payments()
    {
        // Filter by search query
        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.index', ['search' => 'Kouame']));
        $response->assertStatus(200);
        $response->assertSee('TX_99999');

        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.index', ['search' => 'INEXISTANT']));
        $response->assertStatus(200);
        $response->assertDontSee('TX_99999');

        // Filter by status
        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.index', ['statut' => 'approved']));
        $response->assertStatus(200);
        $response->assertSee('TX_99999');

        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.index', ['statut' => 'pending']));
        $response->assertStatus(200);
        $response->assertDontSee('TX_99999');
    }

    public function test_comptable_can_view_payment_details()
    {
        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.show', $this->paiement));
        
        $response->assertStatus(200);
        $response->assertSee('Détails de la transaction');
        $response->assertSee('TX_99999');
        $response->assertSee('Koffi Kouame');
        $response->assertSee('Informatique');
        $response->assertSee('Solde exact');
    }

    public function test_comptable_can_download_receipt_pdf_generation_fallback()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->comptableUser)->get(route('comptable.paiements.recu', $this->paiement));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
