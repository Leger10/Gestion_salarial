<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // Appel des seeders personnalisés
        $this->call([
           
          
            RoleSeeder::class,
            AdminSeeder::class,
            ProfilesTableSeeder::class,
           
        ]); 
  
       
    }
}
