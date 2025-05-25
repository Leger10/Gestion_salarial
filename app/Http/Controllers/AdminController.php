<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDefineAccessRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Models\Employer;

use App\Notifications\AdminCreatedNotification;
use App\Notifications\PasswordUpdatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

use Exception;
use Illuminate\Support\Str;

use App\Models\Carousel;

class AdminController extends Controller
{
    // Afficher la liste des administrateurs
    public function index()
    {
        $admins = User::paginate(10); // Remplacez 'role' par la colonne appropriée si nécessaire
        return view('admin.index', compact('admins'));
    }

   public function show($id)
{
    // Ensure you're fetching the admin based on ID, or check the query logic
    $admin = User::find($id);
    if ($admin === null) {
        // Return some error or a proper message
        return redirect()->route('admin.index')->with('error', 'Admin not found.');
    }

    return view('admin.show', compact('admin'));
}
public function showDefineAccess()
{
    // Récupérer les carrousels depuis la base de données ou une autre source
    $carousels = Carousel::all();  // Exemple si vous avez une table "carousels"

    // Passer la variable à la vue
    return view('auth.defineAccess', compact('carousels'));
}

    // Afficher le formulaire de création d'un administrateur
    public function create()
    {
        return view('admin.create');
    }



    // public function store(StoreAdminRequest $request)
    // {
    //     // Validation des champs
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //     ]);
    
    //     // Créer un utilisateur (administrateur)
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = Hash::make('default'); // Mot de passe par défaut
    //     $user->save();
    
    //     // Générer un code de vérification
    //     $verificationCode = rand(1000, 9999);
    
    //     // Mettre à jour l'utilisateur avec le code de vérification
    //     $user->verification_code = $verificationCode;
    //     $user->save();
    //     $email = $request->input('email');
    //     // Envoyer l'email de vérification
    //     // Pas besoin de récupérer à nouveau l'utilisateur, car vous l'avez déjà dans la variable $user
    //     Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));
    
    //     // Rediriger avec succès
    //     return redirect()->route('auth.defineAccess', ['email' => $email])->with('success', 'Administrateur créé et un code lui a été envoyé pour la confirmation de son compte.');
    // }


public function store(StoreAdminRequest $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role_id' => 'required|in:1,2,3',
    ]);

    $verificationCode = rand(1000, 9999); // ✅ ici

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role_id = $request->role_id;
    $user->password = Hash::make('default');
   $verificationCode = rand(1000, 9999);
$user->verification_code = $verificationCode;
$user->save();

Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));

    return redirect()
        ->route('auth.defineAccess', ['email' => $user->email])
        ->with('success', 'Administrateur créé. Un code de vérification a été envoyé.');
}



public function verify(Request $request)
{
   $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required|numeric',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || $user->verification_code != $request->verification_code) {
        return redirect()->back()->with('error', 'Le code de vérification est incorrect.');
    }

    // Mettre à jour le mot de passe et vérifier l’email
    $user->update([
        'password' => bcrypt($request->password),
        'email_verified_at' => now(),
        'verification_code' => null,
    ]);
    // Envoi d'une notification ou d'un email de confirmation

    Auth::login($user); // 🔐 Connecte l'utilisateur automatiquement

    // ✅ Rediriger selon le rôle
    switch ($user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard');
        case 2:
            return redirect()->route('visitor.dashboard');
        case 3:
            return redirect()->route('superadmin.dashboard');
        default:
            return redirect()->route('dashboard');
    }
}





    // Mettre à jour les informations d'un administrateur
    public function update(UpdateAdminRequest $request, User $user)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        try {
            // Mise à jour des informations de l'administrateur
            $user->update($validatedData);

            return redirect()->route('auth.defineAccess')->with('success', 'L\'administrateur a été mis à jour avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'administrateur.');
        }
    }

public function sendVerificationCode(Request $request)
{
    $request->validate(['email' => 'required|email']);
    
    $user = User::where('email', $request->email)->firstOrFail();
    
    $verificationCode = rand(1000, 9999); // Code à 4 chiffres
    
    $user->update([
        'verification_code' => $verificationCode,
        'verification_code_expires_at' => now()->addMinutes(15),
    ]);
    
    // Envoi de l'email avec l'utilisateur et le code
    Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));
    
    return redirect()->route('account.verify.form', ['email' => $user->email])
                   ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
}
public function verifyAccount(Request $request)
{
    $validated = $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
        'verification_code' => [
            'required',
            'digits:4', // ✅ Code à 4 chiffres
            function ($attribute, $value, $fail) use ($request) {
                $user = User::where('email', $request->email)->first();

                if (!$user || (string)$user->verification_code !== (string)$value) {
                    return $fail('Le code de vérification est incorrect.');
                }

                if ($user->verification_code_expires_at && now()->gt($user->verification_code_expires_at)) {
                    return $fail('Le code de vérification a expiré.');
                }
            }
        ],
        'password' => ['required', 'string', 'confirmed', 'min:8'],
    ]);

    $user = User::where('email', $validated['email'])->firstOrFail();

    $user->update([
        'password' => Hash::make($validated['password']),
        'email_verified_at' => now(),
        'verification_code' => null,
        'verification_code_expires_at' => null,
    ]);
    // Connexion de l'utilisateur
    Auth::login($user);

    // Redirection vers le tableau de bord approprié
    return $this->redirectToDashboard($user);
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Vous êtes bien déconnecté.');
}


protected function redirectToDashboard(User $user)
{
    switch ((int)$user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue Administrateur !');
        case 2:
            return redirect()->route('visitor.dashboard')->with('success', 'Bienvenue Visiteur !');
        case 3:
            return redirect()->route('superadmin.dashboard')->with('success', 'Bienvenue Super Admin !');
        default:
            return redirect('/home')->with('success', 'Connexion réussie.');
    }
}

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        // Recherche des administrateurs par le nom
        $admins = User::where('name', 'like', '%' . $searchTerm . '%')->paginate(10);
    
        return view('admin.index', compact('admins'));
    }
    
    public function delete($id)
    {
        // Trouver l'administrateur par ID
        $admin = User::find($id); // Remplacez "User" par le modèle correspondant si nécessaire
    
        if ($admin) {
            // Supprimer l'administrateur
            $admin->delete();
    
            // Retourner avec un message de succès
            return redirect()->route('admin.index')->with('success', 'Administrateur supprimé avec succès.');
        } else {
            // Si l'administrateur n'est pas trouvé
            return redirect()->route('admin.index')->with('error', 'Administrateur non trouvé.');
        }
    }
    
    
// AdminController.php

public function showValidationForm($verificationCode, $email)
{
    // Logique pour afficher le formulaire de validation avec le code et l'email
    return view('auth.validate', [
        'verificationCode' => $verificationCode,
        'email' => $email,
    ]);
}



public function DefineAccess($email)
{
    try {
        // Récupère l'utilisateur
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Utilisateur non trouvé.');
        }

        // ❗ Ne pas générer un nouveau code si un existe déjà
        if (!$user->verification_code) {
            // Générer un nouveau code si aucun code n’existe
            $user->verification_code = rand(1000, 9999);
            $user->save();

            // Envoyer un mail avec le code
            Mail::to($user->email)->send(new VerificationCodeMail($user, $user->verification_code));
        }

        // Afficher la vue sans renvoyer le mail
        return view('auth.defineAccess', [
            'email' => $user->email,
            'verificationCode' => $user->verification_code,
        ]);
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la définition des accès.');
    }
}

   

    // // Définir les accès pour un administrateur
    // public function submitDefineAccess(SubmitDefineAccessRequest $request)
    // {
    //     try {
    //         // Vérifier si l'utilisateur existe
    //         $user = User::where('email', $request->email)->first();

    //         if ($user) {
    //             // Mise à jour du mot de passe et du champ de validation de l'email
    //             $user->password = Hash::make($request->password);
    //             $user->email_verified_at = Carbon::now();
    //             $user->save();

    //             // Vérifier s'il existe des codes de réinitialisation pour cet utilisateur
    //             $existingCode = ResetCodePassword::where('email', $user->email)->count();

    //             // Condition "supérieur ou égal"
    //             if ($existingCode >= 1) {
    //                 // Supprimer les codes de réinitialisation existants
    //                 ResetCodePassword::where('email', $user->email)->delete();
    //             }

    //             // Redirection vers le tableau de bord avec un message de succès
    //             return redirect()->route('handlelogin')->with('success', 'Vos accès ont été correctement définis.');
    //         } else {
    //             // Si l'utilisateur n'existe pas, rediriger vers la page de connexion
    //             return redirect()->route('auth.login')->with('error', 'Utilisateur non trouvé. Veuillez vérifier vos informations.');
    //         }
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'Une erreur est survenue lors de la définition des accès. Veuillez réessayer.');
    //     }
    // }


public function submitDefineAccess(Request $request, $email)
{
    $request->validate([
        'verification_code' => 'required',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::where('email', $email)->firstOrFail();

    if ($user->verification_code !== $request->verification_code) {
        return back()->withErrors(['verification_code' => 'Code invalide']);
    }

    $user->password = Hash::make($request->password);
    $user->verification_code = null; // Supprimer le code après usage
    $user->save();

    Auth::login($user);

    // Redirection dynamique selon le rôle
    switch ($user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard');
        case 2:
            return redirect()->route('visitor.dashboard');
        case 3:
            return redirect()->route('superadmin.dashboard');
        default:
            return redirect()->route('dashboard');
    }
}


    // Connexion de l'administrateur
    public function handlelogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Vous êtes connecté avec succès!');
        } else {
            return back()->withErrors([
                'email' => 'Les informations de connexion sont incorrectes.',
            ])->onlyInput('email');
        }
    }
    public function handleVerification(Request $request)
    {
        // Validation des données, y compris la correspondance des mots de passe
        $request->validate([
            'verification_code' => 'required|numeric',
            'password' => 'required|min:8|confirmed',  // Validation du mot de passe et de sa confirmation
        ]);
    
        // Récupérer l'utilisateur basé sur l'email
        $user = User::where('email', $request->email)->first();
    
        // Vérification du code de vérification (exemple simple, à adapter selon votre logique)
        if ($user && $user->verification_code == $request->verification_code) {
            // Si le code de vérification est correct, mettre à jour le mot de passe
            $user->password = bcrypt($request->password);
            $user->save();
    
            return redirect()->route('auth.login')->with('success', 'Votre mot de passe a été mis à jour.');
        }
    
        // Si le code de vérification est incorrect
        return back()->with('error', 'Code de vérification invalide.');
    }
    
    
}
