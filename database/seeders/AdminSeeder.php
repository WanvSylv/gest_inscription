<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer que les rôles existent
        $roleAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleAcademique = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'academique', 'guard_name' => 'web']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@horeb.academy'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'password_changed' => true,
            ]
        );

        $admin->assignRole('admin');

        $academique = User::firstOrCreate(
            ['email' => 'academique@horeb.academy'],
            [
                'name' => 'Directeur Académique',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'password_changed' => true,
            ]
        );

        $academique->assignRole('academique');
    }
}
