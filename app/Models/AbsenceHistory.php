<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceHistory extends Model
{
    use HasFactory;

    // Nom de la table (si elle diffère du nom par défaut, qui est le pluriel du nom du modèle)
    protected $table = 'absence_histories';

    // Les champs qui peuvent être massivement assignés (évitez l'assignation de champs non sécurisés)
    protected $fillable = [
        'absence_id',
        'employer_id',
        'heures',
        'is_grayed_out',
        'changed_at',
    ];

    // Si vous ne souhaitez pas utiliser les timestamps automatiques, vous pouvez les désactiver
    public $timestamps = false; // Cette ligne est optionnelle si vous ne voulez pas de colonnes `created_at` et `updated_at` dans la table.

    // Vous pouvez également définir des relations (par exemple, avec l'absence ou l'employé)
    public function absence()
    {
        return $this->belongsTo(Absence::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
