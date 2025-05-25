<?php

namespace App\Http\Controllers;
// Import de la façade
use App\Http\Requests\StoreEmployerRequest;  // Assurez-vous d'utiliser le bon namespace pour vos validations
use App\Models\Employer;
use App\Models\Departement;
use App\Models\Payment;
use App\Models\HeuresTravail;
use App\Models\Absence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Configurations; 
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function index()
{
    // Récupérer tous les employés avec leurs départements, salaires et absences
    $employers = Employer::with(['departement', 'salaries', 'absences'])->orderBy('id', 'asc')->paginate(10);
    
    // Initialisation des variables
    $total_salaire = 0;
    $totalAbsenceHeuresAll = 0;
    $totalHeuresTravailAll = 0;
    $totalHeuresSupplementairesAll = 0;
    
    $currentMonth = Carbon::now();
    $jours_travail = $currentMonth->daysInMonth;  // Nombre de jours dans le mois actuel
    
    $absenceController = new AbsenceController();  // Assurez-vous que le contrôleur des absences est bien instancié
    
    foreach ($employers as $employer) {
        // Calcul des heures d'absence pour cet employeur
        $employer->total_absence_heures = $absenceController->calculerHeuresAbsence($employer->id) ?? 0;
        $totalAbsenceHeuresAll += $employer->total_absence_heures;
        
        // Calculer les heures de travail totales enregistrées pour ce mois
        $heures_travail = HeuresTravail::where('employer_id', $employer->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('heures_travail'); // Somme des heures travaillées dans le mois
        
        // Calculer les heures d'absence pour ce mois
        $absences = Absence::where('employer_id', $employer->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('heures'); // Somme des heures d'absence
        
         // Calculer le total des heures supplémentaires pour l'employeur
         $heures_supplementaires = Overtime::where('employer_id', $employer->id)
         ->whereMonth('date', now()->month)  // Filtrer par mois en cours
         ->whereYear('date', now()->year)    // Filtrer par année en cours
         ->sum('heures');  // Additionner les heures supplémentaires

     // Ajouter cette donnée dans l'objet employeur
     $employer->total_overtime = $heures_supplementaires;
        
 // Calculez les jours ouvrés pour ajuster les paiements
$today = \Carbon\Carbon::now();
$startOfMonth = \Carbon\Carbon::create($today->year, $today->month, 1);
$endOfMonth = \Carbon\Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
$jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés


  // Calcul des heures totales travaillées (en incluant les heures normales, heures supplémentaires et absences)
  $totalHeuresTravail = ($employer->heures_travail * $jours_travail) + $heures_supplementaires - $absences;

  // Vérification si $totalHeuresTravail est un nombre valide
  if (!is_numeric($totalHeuresTravail)) {
      $totalHeuresTravail = 0; // Réinitialiser en cas d'erreur
  }
        
        $totalHeuresTravailAll += $totalHeuresTravail;  // Accumulation des heures totales pour tous les employés
        
        // Calcul du salaire brut (avant les absences)
        $montant_journalier = $employer->montant_journalier;
        $salaire_brut = $montant_journalier * $totalHeuresTravail; // Salaire total pour le mois complet
        
        // Calcul du salaire par heure (en prenant en compte les heures normales et supplémentaires)
        $salaire_par_heure = $montant_journalier / $totalHeuresTravail; // Salaire par heure
        
        // Calcul du montant déduit en fonction des absences
        $montant_deduit = $salaire_par_heure * $absences; // Montant déduit pour les absences
        
        // Calcul du salaire total (net) avant taxes, après absences
        $salaire_total_avant_taxes = $salaire_brut - $montant_deduit;
        
        // Appliquer la taxe sur le salaire total avant taxes
        $taxe = 0.025 * $salaire_total_avant_taxes; // Appliquer la taxe sur le salaire net avant taxes
        
        // Calcul du salaire net après déduction des taxes
        $salaire_net = $salaire_total_avant_taxes - $taxe;
        
        // Ajouter au total des salaires
        $total_salaire += $salaire_net;
        
      
    }
    
    // Passer les données à la vue
    return view('employers.index', compact(
        'employers', 
        'total_salaire', 
        'totalAbsenceHeuresAll', 
        'totalHeuresTravailAll', 
        'totalHeuresSupplementairesAll'
    ));
}


public function storeHeures(Request $request, $employerId)
{
    // Valider les données du formulaire
    $request->validate([
        'date' => 'required|date',
        'heures' => 'required|integer|min:1',
    ]);

    // Récupérer l'employeur
    $employer = Employer::findOrFail($employerId);

    // Enregistrer les heures dans la base de données
    $employer->heuresTravail()->create([
        'date' => $request->date,
        'heures' => $request->heures,
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('employers.ajouterHeures', $employer->id)
                     ->with('success', 'Heures ajoutées avec succès.');
}


 // Affiche le dashboard des salaires
public function dashboard()
{
    // Récupérer tous les employeurs avec leurs heures de travail
    $employers = Employer::with('heures_Travail')->get();
    // Récupérer tous les employés
    $employers = Employer::all();
    // Initialiser la variable pour le total des salaires
    $total_salaire = 0;

    // Récupérer le mois et l'année en cours
    $mois = now()->month;
    $annee = now()->year;

    foreach ($employers as $employer) {
        // Vérifiez que l'employeur a les informations nécessaires
        if ($employer->montant_journalier && $employer->heures_Travail->isNotEmpty()) {
            
            // Calculer le total des heures travaillées pour l'employeur
            $heures_travaillees = $employer->heures_Travail
                ->whereMonth('date', $mois)
                ->whereYear('date', $annee)
                ->sum('heures_travail');
            
            // Calcul du salaire par heure (assurez-vous que cette logique est correcte selon votre modèle)
            $salaire_par_heure = $employer->montant_journalier / $employer->heures_Travail->sum('heures_travail');
            
            // Calcul du salaire total en fonction des heures réellement travaillées
            $salaire_total = $heures_travaillees * $salaire_par_heure;
         // Calculer la somme des salaires nets
    $totalSalaires = $employers->sum('salaire_net');  // 'salaire_net' doit être le nom de la colonne dans la base de données

        }
    }
    
    // Retourner la vue avec les données
    return view('dashboard', compact('totalSalaires', 'employers'));
}


public function storeHeuresTravail(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        'employer_id' => 'required|exists:employers,id',
        'heures_travail' => 'required|numeric',
        'date' => 'required|date',
    ]);

    // Insertion dans la table heures_travail
    DB::table('heures_travail')->insert([
        'employer_id' => $request->input('employer_id'),
        'heures_travail' => $request->input('heures_travail'),
        'date' => $request->input('date'),
    ]);

    return redirect()->route('employers.index');
}


// Exemple dans le contrôleur Employer
public function showEmployer($id)
{

    // Trouver l'employeur par son ID
    $employer = Employer::findOrFail($id);
    // Initialiser le total des heures de travail
    $totalHeuresTravailAll = 0;
// Obtenir le mois et l'année actuels
$currentMonth = Carbon::now();
        
    // Calculer le total des heures de travail (chaque heure de travail multipliée par 30)
    foreach ($employer as $employer) {
        $totalHeuresTravailAll += $employer->heures_travail * 30; // Multiplie les heures de travail par 30
    }
    // Retourner la vue avec l'employeur
    return view('employers.index', compact('employer','totalHeuresTravailAll'));
}

public function ajouterHeures($employerId)
{
    $employer = Employer::findOrFail($employerId);

    // Supposons que tu calcules les heures de travail comme ceci :
    $hoursWorked = HeuresTravail::where('employer_id', $employerId)->sum('nombre_heures');

    return view('employers.add_overtime', [
        'employer' => $employer,
        'hoursWorked' => $hoursWorked, // <-- Cette ligne est essentielle
    ]);
}

    // Affiche le formulaire de création d'un nouvel employeur
    public function create()
    {
        // Récupérer tous les départements
        $departements = Departement::all();

        // Créer une nouvelle instance d'Employer (si besoin)
        $employer = new Employer();

        // Retourner la vue avec les départements et l'employé
        return view('employers.create', compact('departements', 'employer'));
    }

 public function store(Request $request)
{
    // Valider les données d'entrée, sans le champ 'salaire'
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:employers,email',
        'phone' => 'required|string|max:20',
        'montant_journalier' => 'required|numeric|min:0',
        'heures_travail' => 'required|integer|min:1',
        'departement_id' => 'required|exists:departements,id',
    ]);

    // Créer un nouvel employé sans le champ 'salaire'
    Employer::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'montant_journalier' => $request->montant_journalier,
        'heures_travail' => $request->heures_travail,
        'departement_id' => $request->departement_id,
    ]);

    // Rediriger après la création avec un message de succès
    return redirect()->route('employers.index')->with('success', 'Employé créé avec succès.');
}


// Affiche les détails d'un employeur spécifique
public function show($id)
{
    // Calculez les jours ouvrés pour ajuster les paiements
$today = \Carbon\Carbon::now();
$startOfMonth = \Carbon\Carbon::create($today->year, $today->month, 1);
$endOfMonth = \Carbon\Carbon::create($today->year, $today->month, $startOfMonth->daysInMonth);
$jours_travail = $startOfMonth->diffInWeekdays($endOfMonth); // Nombre de jours ouvrés
    // Récupérer l'employeur avec les relations 'departement' et 'salaries'
    $employer = Employer::with('departement', 'salaries')->findOrFail($id);

    // Paginer les employeurs
    $employers = Employer::paginate(10);

    // Vérifier que 'heures_travail' existe et calculer le total des heures de travail
    // Utiliser le nombre de jours du mois actuel au lieu de 30
    $totalHeuresTravail =$employer->heures_travail * $jours_travail ; 

    // Retourner la vue avec l'employeur et le total des heures de travail
    return view('employers.show', compact('employer', 'totalHeuresTravail'));
}


public function salaire()
{
    // Paginate the employers
    $employers = Employer::paginate(10); // Adjust the number to the desired items per page

    return view('employers.salaire', compact('employers'));
}

public function show1($id)
{
    // 1. Récupération sécurisée de l'utilisateur connecté
    $user = Auth::user();
    
    // 2. Vérification des rôles
    if (!$user || !in_array($user->role->name, ['Super Administrateur', 'Administrateur'])) {
        abort(403, 'Accès réservé aux administrateurs');
    }
    // Récupérer l'employé
    $employer = Employer::findOrFail($id);

    // --- Calcul des heures travaillées, d'absence et des heures supplémentaires ---
    $currentMonth = Carbon::now(); // Mois et année actuels
    
    $heures_travail = HeuresTravail::where('employer_id', $employer->id)
        ->whereMonth('date', $currentMonth->month)
        ->whereYear('date', $currentMonth->year)
        ->sum('heures_travail'); // Somme des heures travaillées dans le mois

    $absences = Absence::where('employer_id', $employer->id)
        ->whereMonth('date', $currentMonth->month)
        ->whereYear('date', $currentMonth->year)
        ->sum('heures'); // Somme des heures d'absence dans le mois

    $heures_supplementaires = Overtime::where('employer_id', $employer->id)
        ->whereMonth('date', $currentMonth->month)
        ->whereYear('date', $currentMonth->year)
        ->sum('heures'); // Somme des heures supplémentaires

    // --- Calcul du salaire horaire ---
    // Le salaire horaire est basé sur le montant journalier de l'employé
    $salaire_par_heure = $employer->montant_journalier / $employer->heures_travail;  // Salaire horaire

    // --- Calcul du salaire brut ---
    // Calcul des heures totales (heures normales + heures supplémentaires - absences)
    $totalHeuresTravail = $heures_travail + $heures_supplementaires - $absences;

    // Salaire brut : salaire horaire * total des heures travaillées
    $salaire_brut = $salaire_par_heure * $totalHeuresTravail;

    // --- Calcul des montants pour absences et heures supplémentaires ---
    $montant_deduit = $salaire_par_heure * $absences;  // Déduction pour les absences
    $montant_heures_supplementaires = $salaire_par_heure * $heures_supplementaires;  // Montant des heures supplémentaires

    // Calcul du salaire total avant taxes
    $salaire_total_avant_taxes = $salaire_brut + $montant_heures_supplementaires - $montant_deduit;

    // --- Calcul de la taxe sur le salaire ---
    $taxe = 0.025 * $salaire_total_avant_taxes;  // Taxe de 2,5%

    // --- Calcul du salaire net ---
    $salaire_net = $salaire_total_avant_taxes - $taxe;  // Salaire net après taxes
    
    // --- Récupérer la configuration de l'application ---
    $appName = Configurations::where('type', 'APP_NAME')->first();
    $paymentDateValue = Configurations::where('type', 'PAYMENT_DATE')->first();
    if ($paymentDateValue) {
        $paymentDate = Carbon::createFromDate($currentMonth->year, $currentMonth->month, $paymentDateValue->value);
    } else {
        $paymentDate = Carbon::now();
    }

    $formattedPaymentDate = $paymentDate->format('d F Y');

    $configuration = Configurations::where('type', 'APP_NAME')->first();

    // Retourner la vue avec toutes les données nécessaires
    return view('employers.show1', compact(
        'employer', 
        'heures_travail', 
        'absences', 
        'heures_supplementaires', 
        'totalHeuresTravail', 
        'salaire_brut', 
        'montant_deduit', 
        'salaire_total_avant_taxes', 
        'taxe', 
        'salaire_net',
        'configuration',
        'paymentDate',
        'formattedPaymentDate',
        'appName'
    ));
}




    public function showHeures()
    {
        // Récupérer tous les employeurs
        $employers = Employer::all(); // Vous pouvez filtrer ou trier si nécessaire
        
        // Retourner la vue avec les employeurs
        return view('employers.ajouterHeures', compact('employers'));
    }

    // Affiche le formulaire d'édition d'un employeur
    public function edit(int $id)
    {
        $employer = Employer::findOrFail($id);
        $departements = Departement::all();
        return view('employers.edit', compact('employer', 'departements'));
    }

    // In your EmployerController or the relevant controller

public function showEmployerSalary($id)
{
    $employers = Employer::paginate(10);

    // Get the salaries for this employer (assuming you have a 'salaries' relationship defined)
    $salaries = $employers->salaries;

    // Pass both $employer and $salaries to the view
    return view('employers.salaire', compact('employer', 'salaries'));
}



public function update(Request $request, $id)
{
    // Validation des champs
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'montant_journalier' => 'required|numeric|min:0',
        'departement_id' => 'required|exists:departements,id',
        'heures_travail' => 'required|numeric|min:0',  // Validation pour heures_travail
       
    ]);

    // Trouver l'employeur par son ID
    $employer = Employer::findOrFail($id);

    // Mettre à jour toutes les informations de l'employé, y compris le salaire et les heures de travail
    $employer->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'montant_journalier' => $request->montant_journalier,
        'departement_id' => $request->departement_id,
        'heures_travail' => $request->heures_travail, // Mise à jour des heures de travail
        
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('employers.index')->with('success', 'Employé mis à jour avec succès.');
}



    // Supprime un employeur
    public function destroy(int $id)
    {
        $employer = Employer::findOrFail($id);
        $employer->delete();
        return redirect()->route('employers.index')->with('success', 'Employé supprimé avec succès.');
    }

    // Affiche le salaire d'un employeur en fonction de l'ID
    public function showSalaire()
    {
        $employers = Employer::paginate(10);
      
        return view('employers.salaire',compact('employers'));
    }


public function addHours(Request $request, $id)
{
    // Validation des données d'entrée
    $validated = $request->validate([
        'date' => 'required|date',
        'heures_travail' => 'required|numeric',
    ]);

    // Ajouter les heures travaillées pour un employé
    HeuresTravail::create([
        'employer_id' => $id,
        'date' => $validated['date'],
        'heures_travail' => $validated['heures_travail'],
        'est_present' => true, // L'employé est présent ce jour-là
    ]);

    return redirect()->route('employers.show_overtime', $id)->with('success', 'Heures ajoutées avec succès!');
}
// App\Http\Controllers\EmployerController.php

public function addAbsence(Request $request, $employerId)
{
    // Valider la date d'absence
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
    ]);

    // Créer une nouvelle absence
    Absence::create([
        'employer_id' => $employerId,
        'date' => $request->date,
    ]);

    return back()->with('success', 'Absence enregistrée avec succès.');
}

 // Afficher le formulaire d'ajout des heures supplémentaires pour un employeur
 public function showAddOvertimeForm($employerId)
 {
     // Récupérer l'employeur
     $employer = Employer::findOrFail($employerId);

    // Récupérer les heures supplémentaires de cet employeur
    $overtimes = Overtime::where('employer_id', $employerId)->get();
     // Retourner la vue avec l'employeur
     return view('employers.add_overtime', compact('employer','overtimes'));
 }



public function createOvertime($employerId)
{
    $employer = Employer::findOrFail($employerId);
    return view('employers.add_overtime', compact('employer'));
}
public function storeOvertime($employerId, Request $request)
{
    $validatedData = $request->validate([
        'heures' => 'required|numeric',
        'date' => 'required|date',
        'commentaire' => 'nullable|string',
    ]);

    $employer = Employer::findOrFail($employerId);
    $employer->overtimes()->create($validatedData);

    return redirect()->route('employers.details', $employerId)->with('success', 'Heure supplémentaire ajoutée.');
}
public function show_Overtime($employerId)
{
    $employer = Employer::with('overtimes')->findOrFail($employerId);
    return view('employers.details', compact('employer'));
}
public function showOvertime($employerId, $overtimeId)
{
    $employer = Employer::findOrFail($employerId);
    $overtime = $employer->overtimes()->findOrFail($overtimeId);

    return view('employers.show_overtime', compact('overtime', 'employer'));
}
public function editOvertime($employerId, $overtimeId)
{
    $employer = Employer::findOrFail($employerId);
    $overtime = $employer->overtimes()->findOrFail($overtimeId);

    return view('employers.edit_overtime', compact('overtime', 'employer'));
}

public function updateOvertime($employerId, $overtimeId, Request $request)
{
    // Find the employer and overtime record
    $overtime = Overtime::where('employer_id', $employerId)->findOrFail($overtimeId);
    $employer = Employer::findOrFail($employerId);

    // If the overtime is being grayed out (marked as absence or non-credited)
    if (!$overtime->is_grayed_out) {
        // Deduct the overtime hours from the employer's total working hours
        $employer->totalHeuresTravail -= $overtime->heures;  // Ensure this matches the column name in the database

        // Update the overtime record to be grayed out
        $overtime->is_grayed_out = true;
        $overtime->justification = null; // Reset any previous justification
    } else {
        // If it is already grayed out, we restore the hours when de-graying
        $employer->totalHeuresTravail += $overtime->heures;  // Ensure this matches the column name in the database

        // Un-gray the overtime
        $overtime->is_grayed_out = false;

        // Save justification if provided
        if ($request->has('justification')) {
            $overtime->justification = $request->justification;
        }
    }

    // Save changes to both the overtime and employer models
    $overtime->save();
    $employer->save();

    return redirect()->back();
}



public function search(Request $request)
{
    $searchQuery = $request->input('search');
    $employers = Employer::where('nom', 'LIKE', "%{$searchQuery}%")
                         ->orWhere('prenom', 'LIKE', "%{$searchQuery}%")
                         ->get();

    // Retourne les résultats au format JSON
    return response()->json(['employers' => $employers]);
}


}









