<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher la page de connexion avec les carrousels
    public function login()
    {
        $carousels = Carousel::all();
        return view('auth.login', compact('carousels'));
    }

    // Déterminer où rediriger après connexion
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('dashboard');
        }
    }

    // Définir les accès en fonction de l'email
    public function DefineAccess($email)
    {
        try {
            $user = User::where('email', $email)->first();
            $verificationCode = rand(100000, 999999);

            if ($user) {
                return view('dashboard', compact('email','verificationCode'));
            } else {
                return redirect()->route('auth.login')->with('error', 'Utilisateur non trouvé. Veuillez vérifier vos informations.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la définition des accès.');
        }
    }

    // Formulaire de vérification avec code
    public function showVerificationForm($code)
    {
        return view('auth.verify_code', ['code' => $code]);
    }

   public function handleLogin(Request $request)
{
    // Validation des données
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Tentative de trouver l'utilisateur en fonction de l'email
    $user = User::where('email', $request->email)->first();

    // Vérification du mot de passe
    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Vous êtes connecté avec succès!');
    }

    return back()->withErrors([
        'email' => 'Les informations de connexion sont incorrectes.',
    ])->onlyInput('email');
}


    // Page d'accès initiale avec carrousels
    public function showAccessPage()
    {
        $carousels = Carousel::all();
        return view('auth.defineAccess', compact('carousels'));
    }
}
