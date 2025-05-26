<?php

namespace App\Http\Controllers;

use App\Models\Configurations;
use App\Models\Employer;
use App\Models\Absence;
use App\Models\User;
use App\Models\Overtime;
use App\Notifications\PaiementEffectue;
use App\Models\HeuresTravail;
use App\Models\Payment; // Ensure the Payment model is imported
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Http;
use App\Exports\PaymentsExport;
use App\Services\FileService;
use Maatwebsite\Excel\Facades\Excel;
use League\CommonMark\Reference\Reference;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;

class PayementController extends Controller
{


    public function index(Request $request)
    {

        // Récupérer la date de paiement définie dans la configuration
        $defaultPayementDate = Configurations::where('type', 'PAYMENT_DATE')->first();
        $payments = Payment::latest()->orderBy('id', 'desc')->paginate(10);
        // Calculez les jours ouvrés pour ajuster les paiements
        $today = \Carbon\Carbon::now();
        $startOfMonth = \Carbon\Carbon::create($today->year, $today->month, 1);
        $endOfMonth = \Carbon\Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
        $jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés

        // Si la configuration existe, la récupérer sous forme de date
        if ($defaultPayementDate) {
            // Vérifiez si la valeur est un nombre (jour seulement)
            $payementDateString = $defaultPayementDate->value;

            // Si la valeur est juste un jour du mois, ajoutez un mois et une année
            if (is_numeric($payementDateString)) {
                // Ajoutez la date du mois courant et l'année courante
                $payementDateString = Carbon::now()->year . '-' . Carbon::now()->month . '-' . $payementDateString;
            }

            // Analyser la date complète
            try {
                $payementDate = Carbon::parse($payementDateString);
            } catch (\Exception $e) {
                // Gérer le cas où la date ne peut pas être analysée
                $payementDate = Carbon::now(); // Valeur par défaut
            }
        } else {
            // Gérer le cas où il n'y a pas de configuration de date définie, ou définir une valeur par défaut
            $payementDate = Carbon::now();
        }

        // Récupérer la date actuelle
        $today = Carbon::now();

        // Déterminer si nous sommes à la date de paiement
        $isPaymentDateReached = $today->isSameDay($payementDate);

        // Initialiser une variable pour savoir si le bouton "Effectuer un paiement" doit être affiché
        $showPaymentButton = false;

        // Si nous sommes le jour du paiement, afficher le bouton pour effectuer un paiement
        if ($isPaymentDateReached) {
            $showPaymentButton = true;
        }
        // Récupérer la valeur de la recherche
        $query = $request->input('query');
        $filter = $request->input('filter', 'option-1');  // Valeur par défaut : "Total"

        // Construire la requête de base
        $paymentsQuery = Payment::with('employer');

        // Appliquer un filtre en fonction de la sélection dans le menu déroulant
        if ($filter == 'option-2') {
            // Paiements de la semaine actuelle
            $paymentsQuery->whereBetween('launch_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'option-3') {
            // Paiements du mois actuel
            $paymentsQuery->whereMonth('launch_date', Carbon::now()->month);
        } elseif ($filter == 'option-4') {
            // Paiements des 3 derniers mois
            $paymentsQuery->where('launch_date', '>=', Carbon::now()->subMonths(3));
        } elseif ($filter == 'option-5') {
            // Paiements des 6 derniers mois
            $paymentsQuery->where('launch_date', '>=', Carbon::now()->subMonths(6));
        }

        // Si une recherche est effectuée par référence, ajouter la condition
        if ($query) {
            $paymentsQuery->where('reference', 'like', '%' . $query . '%');
        }
 // Bloc d'envoi d'email supprimé car les variables nécessaires ne sont pas définies dans ce contexte.

        // Récupérer les paiements
        $payments = $paymentsQuery->get();
        $payments = Payment::where('reference', 'like', '%' . $query . '%')
            ->with('employer')
            ->paginate(10);  // Affiche 10 paiements par page

        // Passer les variables à la vue
        return view('payements.index', compact('payments', 'showPaymentButton', 'payementDate'));
    }

    public function initPayement()
    {
        // Recherche du paiement avec l'ID

        // Liste des mois en anglais et en français
        $monthMapping = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ];

        // Récupérer le mois actuel en anglais
        $currentMonth = Carbon::now();
        $currentMonthEnglish = $currentMonth->format('F');
        $currentMonthFrench = $monthMapping[$currentMonthEnglish];
        $currentYear = $currentMonth->format('Y');

        // Récupérer les employeurs qui n'ont pas encore effectué de paiement ce mois-ci
        $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonthFrench, $currentYear) {
            $query->where('month', '=', $currentMonthFrench)
                ->where('year', '=', $currentYear);
        })->get();

        foreach ($employers as $employer) {
            // Calculer le nombre de jours travaillés
            $jours_travaille = HeuresTravail::where('employer_id', $employer->id)
                ->whereMonth('date', $currentMonth->month)
                ->whereYear('date', $currentMonth->year)
                ->distinct('date')
                ->count();

            // Récupérer les heures de travail et les absences
            $heures_travail = HeuresTravail::where('employer_id', $employer->id)
                ->whereMonth('date', $currentMonth->month)
                ->whereYear('date', $currentMonth->year)
                ->sum('heures_travail');

            $heures_supplementaires = Overtime::where('employer_id', $employer->id)
                ->whereMonth('date', $currentMonth->month)
                ->whereYear('date', $currentMonth->year)
                ->sum('heures');
            $absences = Absence::where('employer_id', $employer->id)
                ->whereMonth('date', $currentMonth->month)
                ->whereYear('date', $currentMonth->year)
                ->sum('heures');

            $montant_journalier = $employer->montant_journalier;
            $salaire_par_heure = $montant_journalier / $employer->heures_travail;
            $montant_deduit = $salaire_par_heure * $absences;
            $montant_heures_supplementaires = $salaire_par_heure * $heures_supplementaires;
            $salaire_brut = $salaire_par_heure * $heures_travail;
            $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;
            $taxe = 0.025 * $salaire_total_avant_taxes;
            $salaire_net = $salaire_total_avant_taxes - $taxe;
            $reference = 'REF-' . \Illuminate\Support\Str::random(8);

            $payment = new Payment();
            $payment->reference = $reference;
            $payment->employer_id = $employer->id;
            $payment->montant_journalier = $montant_journalier;
            $payment->heures_travail = $heures_travail;
            $payment->heures_totales = $heures_travail;
            $payment->heures_absence = $absences;
            $payment->salaire_total_avant_taxes = $salaire_total_avant_taxes;
            $payment->taxe = $taxe;
            $payment->salaire_net = $salaire_net;
            $payment->launch_date = Carbon::now();
            $payment->done_time = Carbon::now();
            $payment->status = 'SUCCESS';
            $payment->month = $currentMonthFrench;
            $payment->year = $currentYear;
                $payment->save();

                 try {
                        // Envoi corrigé sans le 5ème paramètre
                        Mail::to($employer->email)->send(new PaymentConfirmation(
                            $employer,
                            $payment, // Contient déjà le salaire_net sauvegardé
                            $currentMonthFrench,
                            $currentYear
                        ));
                    } catch (\Exception $e) {
                        Log::error("Erreur email: " . $e->getMessage());
                    }

            // Vérifier si la liste des employeurs non payés est vide
            if ($employers->count() == 0) {
                return redirect()->back()->with('error', "Tous les employeurs ont été payés pour le mois de $currentMonthFrench.");
            }

            // Récupération des jours ouvrés du mois
            $startOfMonth = Carbon::create($currentYear, $currentMonth->month, 1);
            $endOfMonth = Carbon::create($currentYear, $currentMonth->month, $startOfMonth->daysInMonth);
            $jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés

            // Calculer le salaire pour chaque employeur
            foreach ($employers as $employer) {
                // Vérifier s'il a déjà été payé ce mois-ci
                $aEtePaye = $employer->payments()->where('month', '=', $currentMonthFrench)
                    ->where('year', '=', $currentYear)
                    ->exists();

                // Si l'employé n'a pas été payé, procéder au calcul du paiement
                if (!$aEtePaye) {
                    // Calculer le nombre de jours travaillés
                    $jours_travaille = HeuresTravail::where('employer_id', $employer->id)
                        ->whereMonth('date', $currentMonth->month)
                        ->whereYear('date', $currentMonth->year)
                        ->distinct('date') // Compter les jours distincts travaillés
                        ->count();


                    // Récupérer les heures de travail et les absences
                    $heures_travail = HeuresTravail::where('employer_id', $employer->id)
                        ->whereMonth('date', $currentMonth->month)
                        ->whereYear('date', $currentMonth->year)
                        ->sum('heures_travail');

                    // Récupérer les heures supplémentaires et les absences
                    $heures_supplementaires = Overtime::where('employer_id', $employer->id)
                        ->whereMonth('date', $currentMonth->month)
                        ->whereYear('date', $currentMonth->year)
                        ->sum('heures');
                    $absences = Absence::where('employer_id', $employer->id)
                        ->whereMonth('date', $currentMonth->month)
                        ->whereYear('date', $currentMonth->year)
                        ->sum('heures');
             
                // Calcul du salaire brut et du salaire net
                $montant_journalier = $employer->montant_journalier;
                $salaire_par_heure = $montant_journalier / $employer->heures_travail;
                $montant_deduit = $salaire_par_heure * $absences; // Déduction pour les absences
                $montant_heures_supplementaires = $salaire_par_heure * $heures_supplementaires;

                // Calcul du salaire brut avant taxes
                $salaire_brut = $salaire_par_heure * $heures_travail;

                // Calcul du salaire total avant taxes
                $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;

                // Calcul de la taxe de 2,5%
                $taxe = 0.025 * $salaire_total_avant_taxes;

                // Salaire net après déduction des taxes
                $salaire_net = $salaire_total_avant_taxes - $taxe;

              
                 
                }
            }
        }

        // Retourner un message de succès
        return redirect()->back()->with('success_message', 'Paiement effectué avec succès pour le mois de ' . $currentMonthFrench);
    }




    private function sendSMS($phoneNumber, $message)
{
    try {
        $phoneNumber = '+226' . substr(preg_replace('/[^0-9]/', '', $phoneNumber), -8);

        $client = new \Twilio\Rest\Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        $client->messages->create($phoneNumber, [
            'from' => env('TWILIO_FROM'),
            'body' => $message
        ]);

        Log::info("SMS envoyé à $phoneNumber");
    } catch (\Exception $e) {
        Log::error("Erreur envoi SMS : " . $e->getMessage());
    }
}


    public function checkPaymentEligibility($employeeId)
    {
        // Récupérer les informations de l'employé (supposons que vous avez une table pour cela)
        $employee = Employer::find($employeeId); // Assurez-vous d'utiliser la bonne méthode pour récupérer l'employé.

        // Date d'entrée de l'employé
        $startDate = new \Carbon\Carbon($employee->start_date);

        // Date actuelle pour le calcul du mois
        $endDate = new \Carbon\Carbon('last day of this month'); // Fin du mois

        // Nombre total d'heures à travailler dans ce mois
        $totalHoursInMonth = $this->calculateTotalWorkingHours($startDate, $endDate);

        // Vérifiez si l'employé a travaillé ces heures en utilisant HeuresTravail
        $workedHours = $this->calculateWorkedHours($employeeId, $startDate, $endDate);

        // Si l'employé n'a pas travaillé toutes les heures nécessaires, empêche le paiement
        if ($workedHours < $totalHoursInMonth) {
            return redirect()->back()->withErrors(['error' => 'L\'employé n\'a pas travaillé toutes les heures requises ce mois-ci.']);
        }

        return true; // L'employé est éligible pour le paiement
    }

    public function calculateTotalWorkingHours($startDate, $endDate)
    {
        // Cette fonction calcule le nombre total d'heures travaillées en fonction des jours ouvrables
        $totalHours = 0;
        $currentDate = $startDate;

        // Parcourir chaque jour ouvrable du mois
        while ($currentDate->lte($endDate)) {
            // Vérifier si c'est un jour ouvrable (ex: lundi à vendredi)
            if ($currentDate->isWeekday()) {
                $totalHours += 8; // Supposons que chaque jour de travail fait 8 heures
            }
            $currentDate->addDay();
        }

        return $totalHours;
    }

    public function calculateWorkedHours($employeeId, $startDate, $endDate)
    {
        // Ici vous utilisez le modèle HeuresTravail pour calculer les heures travaillées
        // Filtrer les heures travaillées par l'employé pour la période donnée
        $workedHours = HeuresTravail::where('employee_id', $employeeId)  // Assurez-vous que 'employee_id' est bien dans votre table HeuresTravail
            ->whereBetween('date', [$startDate, $endDate]) // Assurez-vous que 'date' est la colonne correcte dans votre table
            ->sum('hours_worked');  // Supposons que la colonne 'hours_worked' contient les heures travaillées

        return $workedHours;
    }



    public function destroy($id)
    {
        // Delete the associated payments first
        Payment::where('employer_id', $id)->delete();

        // Now delete the employer
        Employer::find($id)->delete();

        // Retourner une réponse (par exemple, redirection)
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }




    public function downloadInvoice(Payment $payment)
    {

        // Récupérer les configurations de l'application
        $appName = Configurations::where('type', 'APP_NAME')->first();
        // Get the current month and year
        $currentMonth = Carbon::now();
        $paymentDateValue = Configurations::where('type', 'PAYMENT_DATE')->first();

        // If PAYMENT_DATE exists, combine the value with the current month and year
        if ($paymentDateValue) {
            // Assuming the payment date is just a day, for example '17'
            $paymentDate = Carbon::createFromDate($currentMonth->year, $currentMonth->month, $paymentDateValue->value);
        } else {
            // Fallback if there's no value set in the configuration
            $paymentDate = Carbon::now(); // default to current date if no payment date is configured
        }

        // Format the date for display
        $formattedPaymentDate = $paymentDate->format('d F Y'); // Example: 17 December 2024
        // Récupérer la configuration qui contient le logo
        $configuration = Configurations::where('type', 'APP_NAME')->first();


        $logoUrl = Configurations::where('type', 'LOGO_URL')->first();
        // Charger les informations sur l'employé
        $employer = Employer::findOrFail($payment->employer_id);


        // Récupérer les heures supplémentaires de l'employeur pour ce mois
        $heures_supplementaires = Overtime::where('employer_id', $employer->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('heures'); // Somme des heures supplémentaires pour ce mois
        // Récupérer les heures de travail totales enregistrées pour ce mois
        $heures_travail = HeuresTravail::where('employer_id', $employer->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('heures_travail'); // Somme des heures travaillées

        // Calculer les heures d'absence pour ce mois
        $absences = Absence::where('employer_id', $employer->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('heures'); // Somme des heures d'absence


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
        // Récupérer les configurations de l'application
        $appName = Configurations::where('type', 'APP_NAME')->first();
        $logoUrl = $configuration && $configuration->logo ? asset('storage/' . $configuration->logo) : null;


        // Générer le PDF avec les données
        $pdf = PDF::loadView('payments.invoice', compact(
            'employer',
            'payment',
            'configuration',
            'totalHeuresTravail',
            'absences',
            'salaire_total_avant_taxes',
            'taxe',
            'salaire_net',
            'appName',
            'formattedPaymentDate',
            'logoUrl',
            'heures_supplementaires',
        ));

        // Télécharger le fichier PDF
        return $pdf->download('bulletin_salaire_' . $payment->id . '.pdf');
    }

    public function showBulletinSalaire($id)
    {
        // Récupérer la configuration de l'application
        $appNameConfig = \App\Models\Configurations::getConfigByType('APP_NAME');
        $appName = $appNameConfig ? $appNameConfig->value : 'Nom de l\'application non défini';

        // Récupérer la configuration de la date de paiement
        $paymentDateConfig = \App\Models\Configurations::getConfigByType('PAYMENT_DATE');
        $paymentDate = $paymentDateConfig ? $paymentDateConfig->value : 'Non définie';

        // Récupérer l'employé (par exemple)
        $payment = Payment::find($id);

        // Passer les configurations et d'autres données à la vue
        return view('bulletin_salaire_pdf', compact('appName', 'paymentDate', 'payment'));
    }


    public function someMethod() // Déplacer la logique dans une méthode
    {
        // Exemple de logique correcte
        $configuration = new Configurations();
        $configuration->app_name = 'Nom de l\'Application';
        $configuration->logo = 'path/to/logo.png'; // Exemple de chemin du logo
        $configuration->save();

        // Vous pouvez aussi passer cette configuration à une vue ou l'utiliser dans une autre logique
        return view('someview', compact('configuration'));
    }


    public function showDashboard()
    {
        // Définir la variable $showPaymentButton
        $showPaymentButton = true;  // ou une condition pour la définir

        // Retourner la vue avec la variable
        return view('paiements.index', compact('showPaymentButton'));
    }




    public function collection()
    {
        $payments = Payment::all();
        // Vérifiez la sortie ici
        return $payments;
    }

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Exporter des utilisateurs vers un fichier Excel.
     */
    public function exportUsers()
    {
        $data = User::all();  // Vous pouvez personnaliser cette partie pour exporter les données nécessaires
        $filename = 'users_export.xlsx';

        $fileUrl = $this->fileService->exportToExcel($data, $filename);

        return response()->json(['file_url' => $fileUrl]);
    }

    /**
     * Importer un fichier Excel avec des utilisateurs.
     */
    public function importUsers(Request $request)
    {
        $this->fileService->importFromExcel($request, 'file');  // 'file' est le nom du champ dans votre formulaire

        return response()->json(['message' => 'Import terminé!']);
    }

    public function export()
    {
        return Excel::download(new PaymentsExport, 'payments.xlsx');
    }

    public function show($id)
    {
        // Recherche du paiement avec l'ID
        $payement = Payment::findOrFail($id);

        // Retourner la vue avec les données du paiement
        return view('payement.show', compact('payement'));
    }
}
