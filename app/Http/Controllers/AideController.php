<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function index()
    {
        return view('aide.index');
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required',
        ]);

        // Envoyer l'email à l'adresse de destination
        Mail::raw($validated['message'], function ($message) {
            $message->to('songosseleger@gmail.com')
                    ->subject('Message de la section Aide')
                    ->from('no-reply@votre-domaine.com'); // Utilisez une adresse générique ici
        });

        return redirect()->back()->with('success', 'Message envoyé avec succès !');
    }
}
