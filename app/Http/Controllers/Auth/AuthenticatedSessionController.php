<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
   

public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role_id === 'admin') {
        return redirect()->intended('/dashboard/admin');
    } elseif ($user->role_id === 'visiteur') {
        return redirect()->intended('/dashboard/visiteur');
    }

    return redirect()->intended(RouteServiceProvider::HOME); // fallback
}
public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('auth.login'); // ou la page que tu veux
}


}
