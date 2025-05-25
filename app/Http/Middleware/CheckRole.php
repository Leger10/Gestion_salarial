<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles Méthodes de rôle acceptées (ex: isAdmin, isSuperAdmin)
     */
//     public function handle(Request $request, Closure $next, ...$roles)
//     {
//         $user = Auth::user();

//         if (!$user) {
//             return redirect()->route('login');
//         }

//         // Vérifie si l'utilisateur a l'un des rôles spécifiés
//         if ($user->role->name == 'Administrateur' || $user->role->name == 'Super Administrateur') {

//             return $next($request);
//             # code...
//         } else {
//             abort(403, 'Accès interdit.');
//         }




//         if ($user->role->name == 'Utilisateur') {
//             // Si aucun rôle ne correspond
//             abort(403, 'Accès interdit.');

//             # code...
//         } else {
//             return $next($request);
//         }
//     }
 }
