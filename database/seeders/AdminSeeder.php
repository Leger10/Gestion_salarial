<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrateur
        User::updateOrCreate(
            ['email' => 'ba@gmail.com'],
            [
                'nom' => 'Ba',
                'prenom' => 'Ali',
                'password' => Hash::make('password'),
                'role_id' => 1
            ]
        );

        // Super admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nom' => 'Bako',
                'prenom' => 'adama',
                'password' => Hash::make('password'),
                'role_id' => 3
            ]
        );

        // Utilisateur
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'nom' => 'Ali',
            
                'prenom' => 'Mane',
                'password' => Hash::make('password'),
                'role_id' => 2
            ]
        );
    }
}
