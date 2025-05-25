<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\UserPasswordMail;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function create()
    {
        return view('auth.register'); // Crée la vue resources/views/auth/register.blade.php
    }

    /**
     * Traite l'inscription.
     */
    public function store(CreateUserRequest $request)
    {
        // Générer un mot de passe aléatoire
        $randomPassword = Str::random(10);

        // Créer l'utilisateur avec le mot de passe crypté
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($randomPassword),
            'role_id' => 2,
        ]);

        // Envoyer l'email
        Mail::to($user->email)->send(new UserPasswordMail($user->nom, $user->email, $randomPassword, $user->prenom));

        return redirect()->back()->with('success', 'Utilisateur enregistré avec succès ! Un email contenant ses identifiants lui a été envoyé.');
    }
}
