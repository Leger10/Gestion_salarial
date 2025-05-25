<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartementsExport;
use App\Http\Requests\SaveDepartementRequest;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DepartementController extends Controller
{
    // Afficher tous les départements
    
public function index(Request $request)
{
    // Vérifie si l'utilisateur est connecté
    if (!Auth::check()) {
        return redirect()->route('auth.login');
    }

    $user = Auth::user();

    if ($user->role_id === null) {
        return redirect()->route('auth.login');
    }

    $userRole = $user->role->name ?? null;

    // Construction de la requête filtrée
    $query = Departement::query();

    if ($request->filled('search')) {
        $query->where('nom', 'like', '%' . $request->search . '%');
    }

    $departements = $query->get(); // Garder les résultats filtrés

    return view('departements.index', [
        'departements' => $departements,
        'isAdmin' => in_array($userRole, ['Administrateur', 'Super Administrateur']),
        'isSuperAdmin' => $userRole === 'Super Administrateur',
        'isUser' => $userRole === 'Utilisateur',
    ]);
}
   public function export(Request $request)
    {
        $query = Departement::query();

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $departements = $query->select('id', 'nom')->get();

        return Excel::download(new DepartementsExport($departements), 'departements.xlsx');
    }


    // Afficher le formulaire de création
    public function create()
    {
        return view('departements.create');
    }

    public function edit($id)
{
    $departement = Departement::findOrFail($id); // Récupère le département
    return view('departements.edit', compact('departement'));
}


    // Enregistrer un nouveau département
    public function store(SaveDepartementRequest $request)
    {
        // Valider les données
        $request->validate([
            'nom' => 'required',
            'poste' => 'required',  // Exemple de champ supplémentaire
        ]);

        // Créer un nouveau département
        Departement::create($request->all());
        return redirect()->route('departements.index')->with('success', 'Département créé avec succès.');
    }

    // Mettre à jour un département
    public function update(Request $request, Departement $departement)
    {
        // Valider les données
        $request->validate([
            'nom' => 'required',
            'poste' => 'required',  // Exemple de validation
        ]);

        // Mettre à jour le département
        $departement->update($request->all());
        return redirect()->route('departements.index')->with('success', 'Département mis à jour avec succès.');
    }

    // Supprimer un département
    public function destroy(Departement $departement)
    {
        // Supprimer le département
        $departement->delete();
        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Recherche des départements par nom
        $departements = Departement::where('nom', 'like', '%' . $query . '%')
            ->get();
    
        return response()->json([
            'departements' => $departements
        ]);
    }
  

}
