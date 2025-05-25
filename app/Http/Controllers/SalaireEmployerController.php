<?php

namespace App\Http\Controllers;

use App\Models\SalaireEmployer;
use App\Models\Employer;
use Illuminate\Http\Request;

class SalaireEmployerController extends Controller
{
    // Afficher tous les salaires
    public function index()
    {
        $salaires = SalaireEmployer::all();
        return view('salaires.index', compact('salaires'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $employers = Employer::select('id', 'nom')->get(); // Charger uniquement les colonnes nécessaires
        return view('salaires.create', compact('employers'));
    }

    // Enregistrer un nouveau salaire
    public function store(Request $request)
    {
        $request->validate([
            'employer_id' => 'required|exists:employers,id',
            'montant' => 'required|numeric|min:0|max:1000000',
        ]);

        try {
            SalaireEmployer::create($request->all());
            return redirect()->route('salaires.index')->with('success', 'Salaire créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('salaires.create')->with('error', 'Erreur lors de la création du salaire. Veuillez réessayer.');
        }
    }

    // Afficher un salaire spécifique
    public function show(SalaireEmployer $salaire)
    {
        return view('salaires.show', compact('salaire'));
    }

    // Afficher le formulaire de modification
    public function edit(SalaireEmployer $salaire)
    {
        $employers = Employer::select('id', 'nom')->get(); // Charger uniquement les colonnes nécessaires
        return view('salaires.edit', compact('salaire', 'employers'));
    }

    // Mettre à jour un salaire
    public function update(Request $request, SalaireEmployer $salaire)
    {
        $request->validate([
            'employer_id' => 'required|exists:employers,id',
            'montant' => 'required|numeric|min:0|max:1000000',
        ]);

        try {
            $salaire->update($request->all());
            return redirect()->route('salaires.index')->with('success', 'Salaire mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('salaires.edit', $salaire->id)->with('error', 'Erreur lors de la mise à jour du salaire. Veuillez réessayer.');
        }
    }

    // Supprimer un salaire
    public function destroy(SalaireEmployer $salaire)
    {
        try {
            $salaire->delete();
            return redirect()->route('salaires.index')->with('success', 'Salaire supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('salaires.index')->with('error', 'Erreur lors de la suppression du salaire. Veuillez réessayer.');
        }
    }
}
