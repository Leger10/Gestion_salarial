<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employer;
use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    // Afficher les heures supplémentaires pour un employé donné
public function show($employerId)
{
    // Récupérer l'employeur
    $employer = Employer::findOrFail($employerId);

    // Récupérer les heures supplémentaires pour cet employeur pour le mois en cours
    $overtimes = Overtime::where('employer_id', $employerId)
                         ->whereMonth('date', now()->month)  // Filtrer par mois en cours
                         ->whereYear('date', now()->year)    // Filtrer par année en cours
                         ->get();  // Récupérer toutes les heures supplémentaires

    // Calculer le total des heures supplémentaires
    $totalOvertimeHeures = $overtimes->sum('heures');  // Additionner les heures supplémentaires

    // Heures de travail de l'employeur
    $hoursWorked = $employer->heures_travail;

    // Passer l'employeur, les heures supplémentaires et les heures de travail à la vue
    return view('employers.add_overtime', [
        'employer' => $employer,
        'overtimes' => $overtimes,  // Passer les heures supplémentaires à la vue
        'totalOvertime' => $totalOvertimeHeures,  // Passer le total des heures supplémentaires
        'hoursWorked' => $hoursWorked,  // Passer les heures de travail de l'employeur à la vue
    ]);
}


    // Ajouter ou mettre à jour une heure supplémentaire
    public function store(Request $request, $employerId)
    {
        // Récupérer les données de l'employeur
        $employer = Employer::findOrFail($employerId);
    
        // S'assurer que les heures de travail de l'employeur ne sont pas nulles
        $hoursWorked = $employer->heures_travail ?? 0;
        
        // Valider les données d'entrée
        $request->validate([
            'date' => 'required|date',  // Vérifier que la date est valide
            'heures' => 'required|numeric|min:1|max:' . $hoursWorked,  // Les heures doivent être comprises entre 1 et les heures de travail de l'employeur
        ]);
    
        // Vérifier si une heure supplémentaire existe déjà pour cet employeur à cette date
        $existingOvertime = Overtime::where('employer_id', $employerId)
                                    ->where('date', $request->date)
                                    ->first();
    
        if ($existingOvertime) {
            // Si l'heure supplémentaire existe déjà, mettre à jour les heures
            $existingOvertime->update([
                'heures' => $request->heures,  // Mettre à jour les heures supplémentaires
            ]);
        } else {
            // Sinon, créer une nouvelle heure supplémentaire
            Overtime::create([
                'employer_id' => $employerId,
                'date' => $request->date,
                'heures' => $request->heures,  // Enregistrer les heures supplémentaires
            ]);
        }
    
    // Recalculer le total des heures supplémentaires après l'ajout/maj
    $totalOvertimeHeures = Overtime::where('employer_id', $employerId)
                                  ->whereMonth('date', now()->month)
                                  ->whereYear('date', now()->year)
                                  ->sum('heures');

    // Rediriger vers la page d'ajout des heures supplémentaires avec le total mis à jour
    return redirect()->route('employers.add_overtime', ['employerId' => $employerId])
                     ->with('success', 'Heure supplémentaire ajoutée ou mise à jour avec succès.')
                     ->with('totalOvertime', $totalOvertimeHeures); // Passer le total mis à jour
}

    public function toggleGray($employerId, $overtimeId, Request $request)
{
    // Trouver l'employé et l'heure supplémentaire par leurs IDs
    $employer = Employer::findOrFail($employerId);
    $overtime = Overtime::findOrFail($overtimeId);

    // Valider que la note est présente si l'heure supplémentaire n'est pas grisée
    if (!$overtime->is_grayed_out && (!$request->has('note') || empty($request->note))) {
        return redirect()->back()->withErrors(['note' => 'La justification est obligatoire.']);
    }

    // Si l'heure supplémentaire est déjà grisée, réactivez-la et restaurez les heures, sinon, grisez-la
    if ($overtime->is_grayed_out) {
        $overtime->is_grayed_out = false;
        $overtime->heures = $overtime->original_heures !== null ? $overtime->original_heures : 8; // Restaure les heures originales
    } else {
        $overtime->is_grayed_out = true;
        $overtime->heures = 0; // Réinitialise les heures à 0 si grisé
        $overtime->note = $request->note; // Enregistrer la justification pour le grisé
    }

    // Sauvegarder l'heure supplémentaire mise à jour
    $overtime->save();

    // Calculer le total des heures supplémentaires non grises pour cet employé
    $totalOvertimeHeures = Overtime::where('employer_id', $overtime->employer_id)
                                  ->where('is_grayed_out', false)
                                  ->sum('heures');

    // Rediriger avec un message de succès et le total mis à jour des heures supplémentaires
    return redirect()->route('employers.add_overtime', ['employerId' => $employerId])
                     ->with('success', 'Heure supplémentaire mise à jour.')
                     ->with('totalOvertimeHeures', $totalOvertimeHeures)
                     ->with('overtimes', Overtime::where('employer_id', $employerId)->get());  // Ajouter les heures supplémentaires actuelles
}

}
