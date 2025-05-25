<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
        public function index()
    {
            // Récupère tous les super administrateurs
        $superadmins = User::where('role_id', 3)->get();

        return view('superadmin.dashboard', compact('superadmins'));
    }
   
}
