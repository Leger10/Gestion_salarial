<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'departement_id',
        'nom',
        'prenom',
        'email',
        'phone',
        'heures_travail',
        'statut_paiement',
        'retard_paiement',
        'salaire',
    ];
    public function calculerSalaire($heures_travail)
    {
        $jours = 31;
        return $this->montant_journalier * $heures_travail * $jours;
    }
    
    // Relation avec le modèle Departement
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    // Modèle Employer
public function absences()
{
    return $this->hasMany(Absence::class);  // Assurez-vous que la relation est bien définie.
}
public function someMethod($employerId)
{
    $Employer = Employer::find($employerId);

    return view('employers.ajouterHeures', compact('Employer'));
}


}
