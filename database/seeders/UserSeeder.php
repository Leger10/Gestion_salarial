<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'Utilisateur Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('azerty'), // Hachage du mot de passe
        ]);

       // Création des rôles
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $employee = Role::create(['name' => 'employé']);

    
        $manageEmployees = Permission::create(['name' => 'gérer les employés']);
        $viewReports = Permission::create(['name' => 'voir les rapports']);

        // Attribution des permissions aux rôles
        $admin->givePermissionTo( $manageEmployees, $viewReports);
        $manager->givePermissionTo( $viewReports);
     

        // Attribution des rôles aux utilisateurs
        $user = User::find(1); // Remplacez par l'ID de l'utilisateur concerné
        $user->assignRole('admin');
    }
    }

