<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsEmail;

class UserCreationService
{
    /**
     * Creates a user account for a student after successful pre-registration/payment.
     *
     * @param \App\Models\Etudiant $etudiant
     * @return User
     */
    public function createStudentUser(\App\Models\Etudiant $etudiant): User
    {
        // Generate unique email
        $email = $this->generateUniqueEmail($etudiant->prenom, $etudiant->nom);
        
        // Generate random password
        $plainPassword = Str::random(10);
        
        // Create user
        $user = User::create([
            'name' => $etudiant->prenom . ' ' . $etudiant->nom,
            'email' => $email,
            'password' => Hash::make($plainPassword),
            'is_active' => true,
            'password_changed' => false,
            'credentials_displayed' => false,
        ]);
        
        // Assign role
        $user->assignRole('etudiant');

        // Assign user_id to etudiant
        $etudiant->user_id = $user->id;

        // Generate Matricule: HA-YYYY-XXXX
        $year = date('Y');
        $count = \App\Models\Etudiant::where('matricule', 'like', "HA-{$year}-%")->count() + 1;
        $etudiant->matricule = sprintf('HA-%s-%04d', $year, $count);
        $etudiant->save();
        
        // Return user and plainPassword so the caller can send the email with the receipt
        $user->plainPassword = $plainPassword; // Temporary for email
        
        return $user;
    }

    /**
     * Generates a unique email in the format prenom.nom@horeb.academy
     */
    protected function generateUniqueEmail(string $prenom, string $nom): string
    {
        $domain = '@horeb.academy';
        
        // Clean up strings (remove accents, lowercase, replace spaces)
        $cleanPrenom = Str::slug($prenom, '');
        $cleanNom = Str::slug($nom, '');
        
        $baseEmail = $cleanPrenom . '.' . $cleanNom;
        $email = $baseEmail . $domain;
        
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . $domain;
            $counter++;
        }
        
        return $email;
    }
}
