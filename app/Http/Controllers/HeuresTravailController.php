<?php
namespace App\Http\Controllers;

use App\Models\HeuresTravail;
use App\Models\Employer;  // Assurez-vous que le modèle Employer est importé
use Illuminate\Http\Request;

class HeuresTravailController extends Controller
{
    // Méthode pour afficher le formulaire
    public function create()
    {
        // Afficher le formulaire pour enregistrer les heures de travail
        return view('heures.create');
    }

    // Méthode pour enregistrer les heures de travail
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'employer_id' => 'required|exists:employers,id', // Vérifie que l'employeur existe
            'heures_travail' => 'required|numeric|min:0',     // Validation des heures
            'date' => 'required|date|date_format:Y-m-d',       // Validation de la date au format YYYY-MM-DD
        ]);
    
        // Enregistrement des heures de travail dans la base de données
        HeuresTravail::create([
            'employer_id' => $request->employer_id,
            'heures_travail' => $request->heures_travail,
            'date' => $request->date,
        ]);
    
        // Redirection après l'enregistrement
        return redirect()->route('heures.create') // Redirige vers la page de création pour ajouter plus d'heures
            ->with('success', 'Heures de travail enregistrées avec succès.');
    }
    public function ajouterHeures($employerId)
{
    // Récupérer l'employeur
    $employer = Employer::findOrFail($employerId);

    // Calculer la somme des heures travaillées
    $hoursWorked = HeuresTravail::where('employer_id', $employerId)->sum('heures_travail');

    return view('employers.ajouterHeures', ['employer' => $employer, 'hoursWorked' => $hoursWorked]);
}


}
