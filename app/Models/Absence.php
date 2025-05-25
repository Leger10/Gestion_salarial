<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    // Définition des attributs modifiables
    protected $fillable = ['employer_id', 'date', 'heures', 'is_grayed_out'];

    // Définir les castings pour certains attributs si nécessaire (ex: pour convertir la date au format DateTime)
    protected $casts = [
        'date' => 'datetime',  // Assurez-vous que la date soit bien stockée au format DateTime
        'is_grayed_out' => 'boolean',  // Assurez-vous que le champ `is_grayed_out` soit bien un booléen
    ];

    // Relation avec le modèle Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class); // Chaque absence appartient à un employé
    }
    public function heuresTravail()
    {
        return $this->hasMany(HeuresTravail::class, 'absence_id');
    }

    public static function calculateTotalAbsence($employeeId, $startDate, $endDate)
    {
        // Calculer le total des heures d'absence pour l'employé dans la période donnée
        return self::where('employer_id', $employeeId)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('heures');  // Total des heures d'absence
    }
}

