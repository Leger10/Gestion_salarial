<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartementsExport;
use App\Http\Requests\SaveDepartementRequest;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Employer;
use Exception;


class DepartementController extends Controller
{
    public function index()
    {
        $employers = Employer::all();
        $departements = Departement::paginate(10);
        return view('departements.index', compact('departements','employers'));
    }
    
    public function create()
    {
        return view('departements.create');
    }

    public function store(SaveDepartementRequest $request)
    {
       
            // Créer une nouvelle instance de Departement
            $departement = new Departement();
            $departement->nom = $request->nom; // Assurez-vous que 'nom' est dans votre formulaire
            $departement->save(); // Enregistrer le département
        
            
    
        return redirect()->route('departements.index')->with('success', 'Département ajouté avec succès.');
    }
    

    public function show($id)
    {
         // Récupérer un employeur spécifique par son ID
    $employer = Employer::findOrFail($id);

        $departement = Departement::findOrFail($id);
        return view('departements.show', compact('departement','employer'));
    }

    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('departements.edit', compact('departement'));
    }

    public function update(Request $request, int $id)
{
        $request->validate([
            'nom' => 'required|string|max:255|unique:departements,nom,' . $id,
        ]);
    
    $departement = Departement::findOrFail($id);
        $departement->nom = $request->nom;
        $departement->save();

    return redirect()->route('departements.index')->with('success', 'Département mis à jour avec succès.');
}



    public function destroy($id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return redirect()->route('departements.index')->with('error', 'Le département spécifié n\'existe pas.');
        }

        if ($departement->employers()->count() > 0) {
            return redirect()->route('departements.index')->with('error', 'Impossible de supprimer le département car il est associé à des employés.');
        }

        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès.');
}

    public function search(Request $request)
    {
        $search = $request->input('query');
        $departements = Departement::where('nom', 'LIKE', "%{$search}%")->get();
        return view('departements.index', compact('departements'));
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
}
