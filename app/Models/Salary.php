<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', // Clé étrangère vers Employer
        'montant',
        'mois',
        'annee',
    ];

    // Définir la relation inverse avec Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class);  // Un salaire appartient à un employé
    }
}
