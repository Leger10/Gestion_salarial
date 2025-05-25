<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        // Ajoutez ici les départements que vous souhaitez insérer
        $departements = [
            ['nom' => 'Département A'],
            ['nom' => 'Département B'],
            ['nom' => 'Département C'],
            ['nom' => 'Marketing'],
            ['nom' => 'Communication'],
            ['nom' => 'Gestion Ressources humaines'],
            ['nom' => 'Secretariat '],
            // Ajoutez d'autres départements selon vos besoins
        ];
  // Ajoutez ici les départements que vous souhaitez insérer
  User::firstOrCreate(
    ['nom' => 'Département A'],
    ['nom' => 'Département B'],
    ['nom' => 'Département C'],
    ['nom' => 'Marketing'],
    ['nom' => 'Communication'],
    ['nom' => 'Gestion Ressources humaines'],
    ['nom' => 'Secretariat '],
    // Ajoutez d'autres départements selon vos besoins
);


        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}
