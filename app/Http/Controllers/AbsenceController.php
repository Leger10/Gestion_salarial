<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employer;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    // Show Absences for a specific Employer
    public function show($employerId)
    {
        // Récupérer l'employeur
        $employer = Employer::findOrFail($employerId);
    
        // Récupérer les absences de l'employeur pour le mois en cours
        $absences = Absence::where('employer_id', $employerId)
            ->whereMonth('date', Carbon::now()->month)
            ->get();
    // Calculer le total des heures d'absence sans inclure les absences grises
    $totalAbsenceHeures = $absences->where('is_grayed_out', false)->sum('heures'); // Exclure les heures grises du total
        // Heures de travail de l'employeur
        $hoursWorked = $employer->heures_travail;
    
        // Calcul du total des heures d'absence
        $totalAbsenceHeures = $absences->sum('heures'); // Somme des heures d'absence
    
        // Retourner la vue avec les données
        return view('absences.show', compact('employer', 'absences', 'hoursWorked', 'totalAbsenceHeures'));
    }
    
    public function toggleGray($employerId, $absenceId, $note = null)
    {
        // Trouver l'employé et l'absence par leurs IDs
        $employer = Employer::findOrFail($employerId);
        $absence = Absence::findOrFail($absenceId);
    
        // Valider que la note est présente si l'absence n'est pas grisée
        if (!$absence->is_grayed_out && (!isset($_POST['note']) || empty($_POST['note']))) {
            return redirect()->back()->withErrors(['note' => 'La justification est obligatoire.']);
        }
    
        // Si l'absence est déjà grisée, réactivez-la et restaurez les heures, sinon, grisez-la
        if ($absence->is_grayed_out) {
            $absence->is_grayed_out = false;
            $absence->heures = $absence->original_heures !== null ? $absence->original_heures : 8; // Restaure les heures originales
        } else {
            $absence->is_grayed_out = true;
            $absence->heures = 0; // Réinitialise les heures à 0 si grisé
            $absence->note = $_POST['note']; // Enregistrer la justification pour le grisé
        }
    
        // Sauvegarder l'absence mise à jour
        $absence->save();
    
        // Calculer le total des heures d'absence non grisés pour cet employé
        $totalAbsenceHeures = Absence::where('employer_id', $absence->employer_id)
                                     ->where('is_grayed_out', false)
                                     ->sum('heures');
    
        // Rediriger avec un message de succès et le total mis à jour des heures d'absence
        return redirect()->route('absences.show', ['employer' => $employerId])
                         ->with('updatedTotal', 'Absence mise à jour.')
                         ->with('totalAbsenceHeures', $totalAbsenceHeures);
    }
    
    public function update(Request $request, $id)
{
    // Validation
    $request->validate([
        'heures_absence' => 'required|integer', 
    ]);

    $absence = Absence::find($id);
    $absence->heures = $request->input('heures');
    $absence->is_grayed_out = 0; // Exemple de mise à jour de l'état
    $absence->save();

    return redirect()->route('employers.index')->with('success', 'Absence mise à jour.');
}




// AbsenceController.php
public function index()
{
    $absences = Absence::all();  // Vous pouvez aussi appliquer un filtre ou une pagination ici.
    return view('absences.index', compact('absences'));  // Renvoyer la vue des absences
}

public function store(Request $request, $employerId)
{
    // Récupérer les données de l'employeur
    $employer = Employer::find($employerId);

    // Vérifier si l'employeur existe
    if (!$employer) {
        return redirect()->route('employers.index')->with('error', 'Employer not found.');
    }

    // S'assurer que les heures de travail de l'employeur ne sont pas nulles
    $hoursWorked = $employer->heures_travail ?? 0;
    
    // Valider les données d'entrée
    $request->validate([
        'date' => 'required|date',  // Vérifier que la date est valide
        'heures' => 'required|numeric|min:1|max:' . $hoursWorked,  // Les heures doivent être comprises entre 1 et les heures de travail de l'employeur
    ]);

    // Vérifier si une absence existe déjà pour cet employeur à cette date
    $existingAbsence = Absence::where('employer_id', $employerId)
                              ->where('date', $request->date)
                              ->first();

    if ($existingAbsence) {
        // Si l'absence existe déjà, mettre à jour les heures
        $existingAbsence->update([
            'heures' => $request->heures,  // Mettre à jour les heures d'absence
        ]);
    } else {
        // Sinon, créer une nouvelle absence
        Absence::create([
            'employer_id' => $employerId,
            'date' => $request->date,
            'heures' => $request->heures,  // Enregistrer les heures d'absence
        ]);
    }

    // Recalculer le total des heures d'absence pour cet employeur pour le mois en cours
    $totalAbsenceHeures = Absence::where('employer_id', $employerId)
                                 ->whereMonth('date', now()->month)  // Filtrer par mois en cours
                                 ->whereYear('date', now()->year)    // Filtrer par année en cours
                                 ->sum('heures');  // Additionner les heures d'absence

    // Rediriger vers la page des absences de l'employeur avec un message de succès et le total des heures d'absence
    return redirect()->route('absences.show', ['employer' => $employerId])
                     ->with('success', 'Absence added or updated successfully.')
                     ->with('totalAbsenceHeures', $totalAbsenceHeures);  // Passer le total des heures d'absence à la vue
}




public function toggleAbsenceStatus($absenceId)
{
    $absence = Absence::find($absenceId);
    $employer = $absence->employer; // Récupérer l'employé lié à l'absence

    // Si l'absence est déjà grisée, on la réactive
    if ($absence->is_grayed_out) {
        $absence->is_grayed_out = false;

        // Rétablir les heures originales ou une valeur par défaut
        if ($absence->original_heures !== null) {
            $absence->heures = $absence->original_heures;
        } else {
            $absence->heures = 8;  // Valeur par défaut si non spécifiée
        }

        // Ajouter les heures au total global d'absence de l'employé
        $employer->totalAbsenceHeures += $absence->heures;
    } else {
        // Griser l'absence et mettre les heures à zéro
        $absence->is_grayed_out = true;
        $absence->original_heures = $absence->heures; // Sauvegarder les heures avant de griser
        $absence->heures = 0;

        // Réduire les heures au total global d'absence de l'employé
        $employer->totalAbsenceHeures -= $absence->original_heures;
    }

    // Sauvegarder les modifications de l'absence et de l'employé
    $absence->save();
    $employer->save();

    // Rediriger ou renvoyer la vue avec les mises à jour
    return redirect()->route('absences.show', ['id' => $absence->id])
                     ->with('success', 'Statut de l\'absence mis à jour avec succès');
}

public function showMonthlyHours()
{
    // Calculer le total des heures d'absence de tous les employés
    $totalAbsenceHeuresAll = $this->calculerHeuresAbsence(null); // Passez null pour tous les employés

    // Retourner la vue avec les heures d'absence totales
    return view('absences.monthly', compact('totalAbsenceHeuresAll'));
}

public function calculerHeuresAbsence($employerId, $month = null)
{
    $month = $month ?? Carbon::now()->month; // Si aucun mois n'est passé en paramètre, utiliser le mois actuel

    // Récupérer les absences pour un employé pour le mois spécifié
    $absences = Absence::where('employer_id', $employerId)
                       ->whereMonth('date', $month)  // Mois donné
                       ->get();

    // Total des heures d'absence (filtrage des valeurs nulles)
    $totalAbsenceHeures = $absences->filter(function ($absence) {
        return !is_null($absence->heures); // Filtrer les absences où les heures ne sont pas nulles
    })->sum('heures');

    return $totalAbsenceHeures;
}


}
