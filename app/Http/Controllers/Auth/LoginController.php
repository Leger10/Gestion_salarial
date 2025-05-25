<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function loginView()
    {
        return view('auth.login');
    }

    /**
     * Tableau de bord pour l'administrateur.
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Tableau de bord pour un utilisateur normal.
     */
    public function visitorDashboard()
    {
        return view('visitor.dashboard');
    }

    /**
     * Traite l'authentification de l'utilisateur.
     */
   public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

      switch ($user->role_id) {
    case 1:
        return redirect()->route('admin.dashboard');
    case 2:
        return redirect()->route('visitor.dashboard');
    case 3:
        return redirect()->route('superadmin.dashboard'); // ✅ nouveau
    default:
        return redirect()->route('dashboard');
}
}
    return back()->withErrors([
        'email' => 'Les informations fournies sont incorrectes.',
    ])->onlyInput('email');
}

}
