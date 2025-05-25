<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'employer_id',
        'date',
        'heures',
        'is_grayed_out',
        'note', // Si vous avez un champ pour la justification
        'original_heures', // Si vous souhaitez sauvegarder les heures d'origine
    ];
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


    public static function calculateTotalOvertime($employeeId, $startDate, $endDate)
    {
        // Calculer le total des heures supplémentaires pour l'employé dans la période donnée
        return self::where('employer_id', $employeeId)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('heures');  // Total des heures supplémentaires
    }
    // Définir la relation avec l'employeur (Employer)
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
