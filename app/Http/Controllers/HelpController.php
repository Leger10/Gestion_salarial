<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     // Méthode pour afficher la page d'aide
     public function index()
     {
         // Retourner la vue de la page d'aide
         return view('aide.index');
     }
 
     // Méthode pour soumettre un formulaire de contact
     public function contact(Request $request)
     {
         // Valider les données du formulaire
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|max:255',
             'message' => 'required|string',
         ]);
 
         // Logic pour traiter la soumission du formulaire, par exemple, envoyer un email ou sauvegarder dans la base de données
         // Exemple simple: afficher un message de succès
         return back()->with('success', 'Votre message a été envoyé avec succès.');
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
