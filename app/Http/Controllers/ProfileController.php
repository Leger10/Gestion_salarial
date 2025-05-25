<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
     /** 
     * Afficher le profil de l'utilisateur spécifié. 
     */ 
 public function show($id) 
    { 
        $user = User::with('profile')->findOrFail($id); 
        return view('profiles.show', compact('user')); 
    } 

} 

