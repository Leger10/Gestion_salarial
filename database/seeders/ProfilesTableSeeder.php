<?php 
  
namespace Database\Seeders; 
  
use App\Models\User; 
use App\Models\Profile; 
use Illuminate\Database\Seeder; 
  
class ProfilesTableSeeder extends Seeder 
{ 
    /** 
     * Run the database seeds. 
     */ 
    public function run(): void 
    { 
        // Crée un profil pour chaque utilisateur existant 
        User::all()->each(function ($user) { 
            Profile::create([ 
                'user_id' => $user->id, 
                'adresse' => '123 Rue Exemple', 
                'phone' => '0123456789', 
                'photo' => 'avatars/default.png', 
            ]); 
        }); 
    } 
} 