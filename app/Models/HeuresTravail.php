<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeuresTravail extends Model
{
    use HasFactory;

    // Spécifiez explicitement le nom de la table si elle ne suit pas la convention plurielle
    protected $table = 'heures_travail';

    // Liste des champs assignables en masse
    protected $fillable = [
        'employer_id',
        'date',
        'heures_travail',
        'est_present',
    ];

    // Si la colonne 'date' est utilisée comme une date normale, vous pouvez la définir
    protected $dates = ['date']; // Laravel reconnaîtra ce champ comme une instance de Carbon
// Modèle HeureTravail
public function employer()
{
    return $this->belongsTo(Employer::class, 'employer_id');
}

    
    public function absence()
    {
        return $this->belongsTo(Absence::class);
    }

    public function toggleGray($id)
{
    $heuresTravail = HeuresTravail::findOrFail($id); // Récupérez l'enregistrement correspondant
    $heuresTravail->is_grayed_out = !$heuresTravail->is_grayed_out; // Toggle de la valeur
    $heuresTravail->save();

    return back();
}
public static function calculateTotalWorkedHours($employeeId, $startDate, $endDate)
{
    // Calculer les heures travaillées
    $workedHours = self::where('employer_id', $employeeId)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->where('est_present', true) // Seules les heures où l'employé est présent
                        ->sum('heures_travail'); // Somme des heures travaillées

    // Ajouter les heures supplémentaires
    $overtimeHours = Overtime::calculateTotalOvertime($employeeId, $startDate, $endDate);

    // Retourner le total des heures (travaillées + supplémentaires)
    return $workedHours + $overtimeHours;
}

}
