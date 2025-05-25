<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departement;
use App\Models\Carousel; // Assurez-vous que le modèle existe et est correctement importé

use App\Models\Employer;
use App\Models\Company;
use App\Models\Configurations;
use App\Models\Salary; // Assurez-vous d'importer le modèle Salary
use App\Models\Deduction; // Assurez-vous d'importer le modèle Deduction
use Carbon\Carbon;
use App\Models\Absence;
use App\Models\Payment;
use App\Models\Overtime;
use App\Models\HeuresTravail;
use Illuminate\Http\Request;
use App\Exports\DepartementsExport;
use Maatwebsite\Excel\Facades\Excel;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Compter les départements
            $totalDepartements = session('totalDepartements', Departement::count());
            
            // Récupérer les départements paginés
            $departements = Departement::paginate(10); // 10 départements par page
            $employers = Employer::all();
            $totalEmployers = Employer::count();
            $totalAdministrateurs = User::count();
                 // Obtenir le mois et l'année actuels
                 $currentMonth = Carbon::now();
            // Initialisation des totaux
            $totalHeuresTravailAll = 0; // Exemple de valeur
            $totalAbsenceHeuresAll = 0;   // Exemple de valeur
            $totalSalairesGlobal = 0; // Total des salaires nets
            $heures_supplementaires = 0;
            $employersData = []; // Tableau pour stocker les données des employés
            
            // Obtenir le mois et l'année actuels
            $currentMonth = Carbon::now();
         
            // Assurez-vous que le contrôleur des absences est bien instancié
          foreach ($employers as $employer) {
                
            
                $heures_supplementaires = Overtime::where('employer_id', $employer->id)
    ->whereMonth('date', now()->month)
    ->whereYear('date', now()->year)
    ->sum('heures');

$absences = Absence::where('employer_id', $employer->id)
    ->whereMonth('date', $currentMonth->month)
    ->whereYear('date', $currentMonth->year)
    ->sum('heures');

 

    // --- Calcul du nombre total d'heures de travail prévues pour le mois ---
// Récupérer les paiements
$payments = Payment::latest()->orderBy('id', 'desc')->get();
        

  // Calculez les jours ouvrés pour ajuster les paiements
  $today = \Carbon\Carbon::now();
  $startOfMonth = \Carbon\Carbon::create($today->year, $today->month, 1);
  $endOfMonth = \Carbon\Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
  $jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés

  // Calcul des heures totales travaillées
  $totalHeuresTravail = ($employer->heures_travail * $jours_travail) + $heures_supplementaires - $absences; // Prendre en compte les heures normales, les heures supplémentaires et les absences

  // Récupérer les heures supplémentaires pour cet employeur (individuellement)
  $overtimes = $employer->overtimes;

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
  $salaire_brut = $salaire_par_heure *  $totalHeuresTravail; // Salaire de base pour le mois

  // Calcul du salaire total avant taxes (en tenant compte des absences et des heures supplémentaires)
  $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;

  // --- Calcul de la taxe sur le salaire total avant taxes ---
  $taxe = 0.025 * $salaire_total_avant_taxes;  // Taxe de 2,5%

  // --- Calcul du salaire net après déduction des taxes ---
  $salaire_net = $salaire_total_avant_taxes - $taxe;  // Salaire net après taxes
 
// Maintenant, $totalSalairesGlobal contient la somme totale des salaires
$totalSalairesGlobal += $salaire_net;
                 // Ajouter les heures d'absence de cet employé au total
                 $totalAbsenceHeuresAll +=$absences;
                 $totalHeuresTravailAll += $totalHeuresTravail;
             
                }       
            
        

            // Commenter la partie d'authentification
            if (Auth::check()) {  // Utilisation de la façade Auth
             $employerId = Auth::user()->id;  // Récupérer l'ID de l'utilisateur authentifié
            } else {
               // Rediriger si l'utilisateur n'est pas authentifié
                return redirect()->route('Auth.login')->with('error_msg', 'Veuillez vous connecter pour accéder au tableau de bord.');
            }
    
            // Pour tester sans authentification, définissez un employeur ID statique
            $employerId = 1;  // Exemple de valeur statique, vous pouvez en choisir une autre
        
    
            // Calculer le salaire total basé sur le montant journalier multiplié par 31 jours
            $totalMonthlySalaries = Employer::sum('montant_journalier') * 31;
             // Récupérer tous les employeurs avec leur salaire journalier
       

            // Calculer le total des heures de travail pour tous les employeurs du mois en cours
            $totalHeuresTravail = Employer::join('absences', 'employers.id', '=', 'absences.employer_id')
                ->whereMonth('absences.date', Carbon::now()->month)
                ->sum('employers.heures_travail');  // Vous pouvez changer en fonction de la structure exacte de vos tables
        
            // Assurez-vous de définir la locale sur le français
            Carbon::setLocale('fr');  
            $payementNotification = "";
            $currentDate = Carbon::now(); // Obtenez la date actuelle
            $defaultPayementDateQuery = Configurations::where('type', 'PAYMENT_DATE')->first();
            
            if ($defaultPayementDateQuery) {
                $defaultPayementDate = Carbon::createFromFormat('d', $defaultPayementDateQuery->value); // Créez une date à partir de la valeur
                $sixDaysBefore = $defaultPayementDate->copy()->subDays(6);
                $sixDaysAfter = $defaultPayementDate->copy()->addDays(6);
            
                // Vérifiez si la date actuelle est dans la période de notification
                if ($currentDate->isBetween($sixDaysBefore, $sixDaysAfter, true)) {
                    if ($currentDate->isBefore($defaultPayementDate)) {
                        $daysLeft = $currentDate->diffInDays($defaultPayementDate);
                        $payementNotification = "Le paiement aura lieu dans " . intval($daysLeft) . " jour" . ($daysLeft > 1 ? 's' : '') . ", le " . $defaultPayementDate->translatedFormat('d F') . ".";
                    } elseif ($currentDate->isAfter($defaultPayementDate)) {
                        $daysSince = $defaultPayementDate->diffInDays($currentDate);
                        $payementNotification = "Le paiement a eu lieu il y a " . intval($daysSince) . " jour" . ($daysSince > 1 ? 's' : '') . ", le " . $defaultPayementDate->translatedFormat('d F') . ".";
                    } else {
                        $payementNotification = "Le paiement a lieu aujourd'hui, le " . $defaultPayementDate->translatedFormat('d F') . ".";
                    }
                }
            } else {
                $nextMonth = Carbon::now()->addMonth();
                $nextMonthName = $nextMonth->translatedFormat('F'); // Utilisez translatedFormat pour obtenir le mois en français
                $payementNotification = "Aucune date de paiement définie pour le mois de " . $nextMonthName . ".";
            }
    
            $carousels = Carousel::all();
            // Récupérer tous les employeurs et la première entreprise
            $employers = Employer::all();
            $company = Company::first();
        // Récupérer les données de tendance des salaires
$salaryData = $this->getSalaryTrendData();
 // Période sélectionnée
 $periode = $request->input('periode', 'semaine'); // Par défaut 'semaine'

 // Récupérer les salaires en fonction de la période
 $salairesParPeriode = $this->getSalairesParPeriode($periode);


// Retourner la vue avec les données
return view('dashboard', compact(
    'employerId',
    'totalDepartements',
    'departements',
    'totalEmployers',
    'totalAdministrateurs',
    'totalSalairesGlobal',
    'totalMonthlySalaries',
    'employers',
    'salairesParPeriode',
    'company',
    'heures_supplementaires', 
    'salaryData',
    'totalHeuresTravail',

    'payementNotification',
    'carousels',
  'totalHeuresTravailAll',
  'totalAbsenceHeuresAll',

 
));

        } catch (Exception $e) {
            // Retourner à la page précédente avec un message d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }
    
    
    // Les autres méthodes restent les mêmes

    private function getSalairesParPeriode($periode)
    {
        $salaires = [];
        
        switch ($periode) {
            case 'semaine':
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $salaires['semaine'] = Employer::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('salaire_net');
                break;
            
            case 'mois':
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $salaires['mois'] = Employer::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('salaire_net');
                break;
            
            case 'trimestre':
                $startOfQuarter = Carbon::now()->startOfQuarter();
                $endOfQuarter = Carbon::now()->endOfQuarter();
                $salaires['trimestre'] = Employer::whereBetween('created_at', [$startOfQuarter, $endOfQuarter])->sum('salaire_net');
                break;
            
            case 'semestre':
                $startOfSemester = Carbon::now()->subMonths(6)->startOfMonth();
                $endOfSemester = Carbon::now()->endOfMonth();
                $salaires['semestre'] = Employer::whereBetween('created_at', [$startOfSemester, $endOfSemester])->sum('salaire_net');
                break;
            
            case 'annee':
                $startOfYear = Carbon::now()->startOfYear();
                $endOfYear = Carbon::now()->endOfYear();
                $salaires['annee'] = Employer::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('salaire_net');
                break;
            
            default:
                $salaires['semaine'] = 0;
                break;
        }
    
        return $salaires;
    }
  
    

    private function getSalaryTrendData()
    {
        return Salary::select(DB::raw('DATE(created_at) as date, SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }


     // Méthode pour l'administrateur
    public function admin()
    {
        return view('dashboard.admin');
    }

    // Méthode pour le visiteur
    public function visiteur()
    {
        return view('dashboard.visiteur');
    }
    private function getOvertimeData()
    {
        return DB::table('payslips')
            ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('SUM(overtime_pay) as totalOvertime'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))
            ->orderBy('month', 'asc')
            ->get();
    }

    private function getDeductionsData()
    {
        return Deduction::select(DB::raw('DATE(created_at) as date, SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('dashboard');
    }

    return back()->with('error_msg', 'Identifiants invalides');
}

public function showSidebar()
{
    // Suppose que la table Configurations a une ligne pour le logo
    $configuration = Configurations::first(); 

    // Passer la variable à la vue
    return view('layouts.sidebar', compact('configuration'));
}
public function showDashboard()
{
    // Récupérer la configuration de l'application, par exemple, pour le logo
    $configuration = Configurations::first(); // ou une autre logique pour récupérer la configuration nécessaire

    // Passer la configuration à la vue
    return view('dashboard', compact('configuration'));
}



public function getSalairesParMoisAnnee()
{
    // Récupérer tous les salaires avec leurs informations associées
    $salaires = Salary::all(); // ou tu peux utiliser une autre méthode pour récupérer les données spécifiques

    // Initialisation du tableau pour stocker les salaires nets par mois et année
    $salairesParMoisEtAnnee = [];

    // Calcul du salaire net par mois et année
    foreach ($salaires as $salary) {
        // Récupérer les informations nécessaires
        $employer = $salary->employer; // Assumons que chaque salaire est lié à un employeur

        // Récupérer les informations nécessaires pour chaque employeur
        $today = Carbon::now();
        $startOfMonth = Carbon::create($today->year, $today->month, 1);
        $endOfMonth = Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
        $jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés

        // Calcul des heures totales travaillées
        $totalHeuresTravail = ($employer->heures_travail * $jours_travail) + $employer->heures_supplementaires - $employer->absences;

        // --- Calcul du salaire brut ---
        $montant_journalier = $employer->montant_journalier;
        $salaire_par_heure = $montant_journalier / $employer->heures_travail; // Calcul du salaire horaire

        // --- Calcul des montants pour absences et heures supplémentaires ---
        $montant_deduit = $salaire_par_heure * $employer->absences;  // Déduction pour les absences
        $montant_heures_supplementaires = $salaire_par_heure * $employer->heures_supplementaires;  // Montant des heures supplémentaires

        // --- Calcul du salaire brut avant taxes ---
        $salaire_brut = $montant_journalier * $jours_travail;

        // Calcul du salaire total avant taxes
        $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;

        // --- Calcul de la taxe sur le salaire total avant taxes ---
        $taxe = 0.025 * $salaire_total_avant_taxes;  // Taxe de 2,5%

        // --- Calcul du salaire net après déduction des taxes ---
        $salaire_net = $salaire_total_avant_taxes - $taxe;  // Salaire net après taxes

        // Organiser les données pour l'affichage par mois et année
        $mois = $salary->mois;
        $annee = $salary->annee;

        // Ajouter le salaire net au tableau sous la clé mois-annee
        $salairesParMoisEtAnnee["$mois-$annee"] = $salaire_net;
    }

    // Retourner les données à la vue ou effectuer d'autres actions
    return view('dashboard', compact('salairesParMoisEtAnnee'));
}


}
