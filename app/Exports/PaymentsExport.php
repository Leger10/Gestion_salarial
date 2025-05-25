<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
      // Collecte les paiements à exporter
      public function collection()
      {
          // Récupère tous les paiements avec les informations sur l'employeur
          return Payment::with('employer')->get();  // Utilise la relation 'employer' pour inclure les informations du salarié
      }

 // Ajoute les en-têtes du tableau Excel
 public function headings(): array
 {
     return [
         '#',
         'Référence',
         'Nom de l\'Employeur',
         'Email de l\'Employeur',
         'Téléphone de l\'Employeur',
         'Service de l\'Employeur',
         'Montant Journalier',
         'Heures de Travail',
         'Heures Totales',
         'Salaire Total Avant Taxes',
         'Taxe Retenue',
         'Salaire Net',
         'Date de la Transaction',
         'Mois',
         'Année',
         'Action',
     ];
 }
 public function map($payment): array
 {
     // Détails sur l'employeur
     $employer = $payment->employer;
 
   // S'assurer que les heures supplémentaires et absences existent
   $heures_supplementaires = $payment->heures_supplementaires ?? 0; // Utilisation de 0 si non défini
   $absences = $payment->absences ?? 0; // Utilisation de 0 si non défini


     // Calculez les jours ouvrés pour ajuster les paiements
     $today = \Carbon\Carbon::now();
     $startOfMonth = \Carbon\Carbon::create($today->year, $today->month, 1);
     $endOfMonth = \Carbon\Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
     $jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés
 
  
    // Calcul des heures totales travaillées
    $totalHeuresTravail = ($employer->heures_travail * $jours_travail) + $heures_supplementaires - $absences; // Prendre en compte les heures normales, les heures supplémentaires et les absences

    // Récupérer les heures supplémentaires pour cet employeur (individuellement)
    $overtimes = $payment->employer->overtimes;

    // Option 1 : Si vous voulez lister les heures supplémentaires individuellement, vous pouvez les afficher sous forme de chaîne
    $overtimeList = $overtimes->map(function ($overtime) {
        return $overtime->heures . ' heures';
    })->implode(', ');  // Cela crée une chaîne séparée par des virgules

     // --- Calcul du salaire brut ---
     $montant_journalier = $employer->montant_journalier;
     // --- Calcul du salaire par heure ---
     $salaire_par_heure = $montant_journalier / $employer->heures_travail; // Calcul du salaire horaire basé sur le montant journalier
 
     // --- Calcul des montants pour absences et heures supplémentaires ---
     $montant_deduit = $salaire_par_heure * $absences;  // Déduction pour les absences
     $montant_heures_supplementaires = $salaire_par_heure * $heures_supplementaires;  // Montant des heures supplémentaires
 
     // --- Calcul du salaire brut avant taxes ---
     $salaire_brut = $salaire_par_heure * $totalHeuresTravail; // Salaire de base pour le mois
 
     // Calcul du salaire total avant taxes (en tenant compte des absences et des heures supplémentaires)
     $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;
 
     // --- Calcul de la taxe sur le salaire total avant taxes ---
     $taxe = 0.025 * $salaire_total_avant_taxes;  // Taxe de 2,5%
 
     // --- Calcul du salaire net après déduction des taxes ---
     $salaire_net = $salaire_total_avant_taxes - $taxe;  // Salaire net après taxes
 
     // Récupérer le nom du département
     $departementNom = $employer->departement ? $employer->departement->nom : 'Non renseigné';
 
     return [
         $payment->id,
         $payment->reference,
         $employer ? $employer->nom . ' ' . $employer->prenom : 'Non trouvé',
         $employer ? $employer->email : 'Non renseigné',
         $employer ? $employer->phone : 'Non renseigné',
         $departementNom,  // Affiche le département de l'employé
         $payment->montant_journalier,
         $employer->heures_travail,  // Heures de travail par jour de l'employé
         $totalHeuresTravail,  // Heures totales calculées
         $salaire_total_avant_taxes, // Salaire avant taxes calculé
         $taxe, // Taxe calculée
         $salaire_net, // Salaire net calculé
         $payment->created_at->format('d/m/Y'),  // Formatage de la date de la transaction
         $payment->created_at->format('F'),     // Mois de la transaction
         $payment->created_at->year,            // Année de la transaction
   
         'Payer',  // Vous pouvez ajouter des liens ou des actions ici, si nécessaire
     ];
 }

 
 // Exporte les paiements vers un fichier Excel
 public function exportPayments() 
 {
     return Excel::download(new PaymentsExport, 'paiements.xlsx');
 }
 
 public function export()
{
    return Excel::download(new PaymentsExport, 'paiements.xlsx');
}
}