<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'employers';

    // Attributs modifiables
    protected $fillable = [
        'departement_id',
        'nom',
        'prenom',
        'email',
        'phone',
        'heures_travail',  // Nombre d'heures de travail par jour
        'montant_journalier', // Salaire journalier de l'employé
        'salaire',           // Salaire de base de l'employé
        'date',              // Date d'embauche de l'employé
    ];

    // Relation avec le modèle Departement
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    // Relation avec le modèle Salary
    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employer_id');
    }

    // Relation avec le modèle HeuresTravail
    public function heuresTravail()
    {
        return $this->hasMany(HeuresTravail::class, 'employer_id');
    }

    // Relation avec le modèle Absence
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    // Relation avec le modèle Overtime (heures supplémentaires)
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    // Relation avec le modèle Payment (paiements)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Méthode pour calculer le salaire basé sur les heures travaillées et les heures supplémentaires
    public function calculerSalaire()
    {
        if (!$this->montant_journalier || !$this->heures_travail) {
            return 0; // Retourner 0 si les informations essentielles sont manquantes
        }

        $mois = now()->month;
        $annee = now()->year;

        // Calcul des heures travaillées dans le mois
        $heures_travaillees = $this->heuresTravail()
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->sum('heures_travail');

        // Calcul des heures supplémentaires dans le mois
        $heures_supplementaires = $this->overtimes()
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->sum('heures');

        // Calcul du taux horaire basé sur le salaire journalier et le nombre d'heures de travail par jour
        $tauxHoraire = $this->montant_journalier / $this->heures_travail;  // Salaire journalier / heures par jour

        // Calcul du salaire de base pour les heures travaillées
        $salaireBase = $heures_travaillees * $tauxHoraire;

        // Calcul du salaire des heures supplémentaires (s'il y en a)
        $salaireHeuresSupp = $heures_supplementaires * ($tauxHoraire * 1.5); // Exemple : heures sup payées 1.5x le taux horaire

        // Retourner le salaire total
        return $salaireBase + $salaireHeuresSupp;
    }

    // Méthode pour vérifier et éviter un salaire incorrect
    public static function boot()
    {
        parent::boot();

        static::saving(function ($employer) {
            if ($employer->heures_travail <= 0) {
                throw new \Exception('Le nombre d\'heures de travail doit être supérieur à zéro');
            }
        });
    }

    // Toggle de l'état de l'employé (grisé ou non)
    public function toggleGray()
    {
        $this->is_grayed_out = !$this->is_grayed_out;
        $this->save();
    }

    // Méthode pour charger une vue avec les données associées
    public function loadView($view, $data = [])
    {
        return view($view, $data);
    }public function routeNotificationForMail($notification)
{
    return $this->email;
}
    public function routeNotificationForSms($notification)
    {
        return $this->phone;
    }
}

