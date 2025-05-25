<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    DepartementController,
    EmployerController,
    HelpController,
    HourSalaryController,
    PayslipController,
    SalaryListController,
    CompanyController,
    ConfigurationController,
    DeductionController,
    OvertimeDataController,
    SalaryExportController,
    AccountController,
    AbsenceController,
    AdminController,
    PayementController,
    ProfileController,
};
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SalaireEmployerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HeuresTravailController;
use Illuminate\Support\Facades\Mail;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
// Route pour la page de connexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/profiles/{user}', [ProfileController::class, 'show'])->name('profiles.show');



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   // Ressources pour les employeurs
Route::prefix('employers')->group(function () {
    Route::get('/', [EmployerController::class, 'index'])->name('employers.index');
    Route::get('/create', [EmployerController::class, 'create'])->name('employers.create');
    Route::post('/', [EmployerController::class, 'store'])->name('employers.store');
    
    Route::get('/employers/{id}', [EmployerController::class, 'show'])->name('employers.show');

    
    // Affichage du salaire d'un employeur (si cette méthode est différente)
    Route::get('/salaire/{id}', [EmployerController::class, 'show1'])->name('employers.show1');
    
    // Modification des informations d'un employeur
    Route::get('/{employer}/edit', [EmployerController::class, 'edit'])->name('employers.edit');
    Route::put('/{employer}', [EmployerController::class, 'update'])->name('employers.update');
      // Recherche d'employeurs
      Route::get('/search', [EmployerController::class, 'search'])->name('employers.search');
    // Suppression d'un employeur
    Route::delete('/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');

    
Route::put('/employers/{employer}/overtime/{overtime}/toggle-gray', [EmployerController::class, 'toggleGrayOvertime'])->name('employers.toggleGrayOvertime');
Route::get('employers/{employer}/add-overtime', [EmployerController::class, 'showAddOvertimeForm'])->name('employers.add_overtime');
// Route pour griser/dégriser les heures supplémentaires
Route::put('/employers/{employer}/overtime/{overtime}/toggle-gray', [EmployerController::class, 'toggleGrayOvertime'])->name('overtimes.toggleGrayOvertime');
// Afficher les détails d'une heure supplémentaire
Route::get('/employers/{employer}/overtime/{overtime}', [EmployerController::class, 'showOvertime'])->name('overtimes.show');
Route::put('employers/{employer}/overtime/{overtime}', [EmployerController::class, 'updateOvertime']);
    Route::prefix('employers')->group(function () {
        Route::get('{employer}/overtime/create', [EmployerController::class, 'createOvertime'])->name('employers.overtime.create');
        Route::post('{employer}/overtime', [EmployerController::class, 'storeOvertime'])->name('employers.overtime.store');
        Route::post('/employers/store_overtime', [EmployerController::class, 'store'])->name('employers.store_overtime');

    });

// Route pour afficher les détails d'un employeur
Route::get('employers/{employer}', [EmployerController::class, 'showEmployer'])->name('employers.details');
// Route pour afficher les heures supplémentaires d'un employeur
Route::get('employers/{employer}/overtime/{overtime}', [EmployerController::class, 'showOvertime'])->name('employers.show_overtime');
// Route pour afficher le formulaire d'édition des heures supplémentaires
Route::get('employers/{employer}/overtime/{overtime}/edit', [EmployerController::class, 'editOvertime'])->name('employers.edit_overtime');
Route::put('employers/{employer}/overtime/{overtime}', [EmployerController::class, 'updateOvertime'])->name('overtimes.update');

       
// Route pour afficher le formulaire pour ajouter des heures pour un employé spécifique (méthode GET)


// Route pour stocker les heures de travail ajoutées pour un employé spécifique (méthode POST)
Route::post('/employers/{employerId}/ajouter-heures', [EmployerController::class, 'storeHeures'])->name('employers.storeHeures');

// Route pour afficher les heures de travail d'un employé pour un mois donné
Route::get('/employers/{employerId}/heures/mois', [HeuresTravailController::class, 'monthly'])->name('heures_travail.monthly');
// Route pour afficher la vue de confirmation avant suppression

        Route::prefix('configurations')->group(function () {
        Route::get('/', [ConfigurationController::class, 'index'])->name('configurations.index');
        Route::get('/create', [ConfigurationController::class, 'create'])->name('configurations.create');
        Route::post('/', [ConfigurationController::class, 'store'])->name('configurations.store');
        Route::delete('/{configuration}', [ConfigurationController::class, 'delete'])->name('configurations.delete');
        });
        
});


// Routes pour les départements
Route::prefix('departements')->group(function () {
    // Route pour la liste des départements
    Route::get('/', [DepartementController::class, 'index'])->name('departements.index');
    
    // Route pour afficher le formulaire de création
    Route::get('/create', [DepartementController::class, 'create'])->name('departements.create');
    
    // Route pour enregistrer un département (POST)
    Route::post('/', [DepartementController::class, 'store'])->name('departements.store'); 
    
    // Route pour afficher un département spécifique
    Route::get('/{departement}', [DepartementController::class, 'show'])->name('departements.show');
    
    // Route pour afficher le formulaire d'édition d'un département
    Route::get('/{departement}/edit', [DepartementController::class, 'edit'])->name('departements.edit');
    
    // Route pour mettre à jour un département (PUT)
    Route::put('/{departement}', [DepartementController::class, 'update'])->name('departements.update');
    
    // Route pour supprimer un département (DELETE)
    Route::delete('/{departement}', [DepartementController::class, 'destroy'])->name('departements.destroy');
    
    // Route pour rechercher un département
    Route::get('/search', [DepartementController::class, 'search'])->name('departements.search');
});
// Routes pour les admin
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');

    // Route pour afficher un administrateur spécifique
    Route::get('/{id}', [AdminController::class, 'show'])->name('admin.show'); // Utilisation correcte de l'ID

    Route::delete('/admin/{id}', [AdminController::class, 'delete'])->name('admin.delete');
});

    Route::get('/validate_account/{email}', [AdminController::class, 'defineAccess'])->name('admin.validate');
    Route::get('/admin/verify/{id}', [AdminController::class, 'showVerificationForm'])->name('admin.verify.form');
    
    Route::get('/verification', [AdminController::class, 'show'])->name('verification.show');
    Route::post('/verification', [AdminController::class, 'verify'])->name('verification.verify');
  // Routes de validation
Route::prefix('admin')->group(function () {
 
    Route::post('/verify-account', [AdminController::class, 'verifyAccount'])->name('account.verify');
   
    // Route pour soumettre la validation du compte avec le code
    Route::post('/validate-account', [AdminController::class, 'validateAccount'])->name('validate-account.submit');

    // Routes supplémentaires pour la gestion de la vérification du compte

    Route::post('/admin/verify/{id}', [AdminController::class, 'submitVerification'])->name('admin.verify.submit');
    
    // Route pour afficher le formulaire de validation du code
    Route::get('/validation-code', [AdminController::class, 'showValidationForm'])->name('admin.validateCode');
    
    // Route pour soumettre la validation du code
    Route::post('/validation-code', [AdminController::class, 'validateCode'])->name('admin.validateCode.submit');
});
Route::get('/validate{email}', [AdminController::class, 'DefineAccess'])->name('auth.validate');
Route::get('/define-access/{email}', [AdminController::class, 'DefineAccess'])->name('auth.defineAccess');
 Route::get('employers/salaire', [EmployerController::class, 'showSalaire'])->name('employers.salaire');
 Route::get('/define-access', [AdminController::class, 'showDefineAccess']);
 Route::post('/define-access/{email}', [AdminController::class, 'submitDefineAccess'])->name('submitDefineAccess');

 Route::get('/test-email', function() {
     Mail::raw('Ceci est un test', function ($message) {
         $message->to('votre_email@example.com')
                 ->subject('Test de configuration d\'e-mail');
     });
 
     return 'E-mail envoyé!';
 });
 

  
   



// Routes pour les absences
Route::prefix('employers/{employer}')->group(function () {
Route::get('/absences', [AbsenceController::class, 'show'])->name('absences.show');
    Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');
    Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
    Route::put('/absences/{absence}', [AbsenceController::class, 'update'])->name('absences.update');
    // Toggle Gray (marquer comme grisé / dégrisé)
    Route::put('/absences/{absence}/toggleGray', [AbsenceController::class, 'toggleGray'])->name('absences.toggleGray');
});


// Routes pour les heures de travail
Route::prefix('heures')->group(function () {
    // Route pour ajouter des heures de travail à un employé
Route::get('/employers/ajouterHeures/{employer}', [EmployerController::class, 'ajouterHeures'])->name('employers.ajouterHeures');

    // Créer des heures de travail
    Route::post('/store', [HeuresTravailController::class, 'store'])->name('heures.store');
    Route::get('/create', [HeuresTravailController::class, 'create'])->name('heures.create');
});


// Dans routes/web.php
Route::resource('payments', PayementController::class);

Route::prefix('payment')->group(function () {
    Route::get('/', [PayementController::class, 'index'])->name('paiements.index');
    Route::get('/make', [PayementController::class, 'initPayement'])->name('paiements.init');
    // Dans routes/web.php
Route::delete('/payments/{id}', [PayementController::class, 'destroy'])->name('paiements.destroy');
Route::get('download-invoice/{payment}', [PayementController::class, 'downloadInvoice'])->name('payment.download');
Route::get('/payment/{payment}/download-invoice', [PayementController::class, 'downloadInvoice'])->name('payments.downloadInvoice');
});

// Routes d'aide
Route::get('/aide', [HelpController::class, 'index'])->name('aide.index'); // Afficher la page d'aide
Route::post('/aide', [HelpController::class, 'contact'])->name('aide.contact'); // Soumettre le formulaire de contact

Route::get('payments/export', [PayementController::class, 'export'])->name('payments.export');
Route::get('/payement/{id}', [PayementController::class, 'show']);
Route::get('/export-users', [PayementController::class, 'exportUsers']);
Route::post('/import-users', [PayementController::class, 'importUsers']);
Route::get('payments/export', function () {
    return Excel::download(new PaymentsExport, 'payments.xlsx');
})->name('payments.export');