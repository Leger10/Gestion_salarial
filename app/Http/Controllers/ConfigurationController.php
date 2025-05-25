<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreConfigRequest; // Assurez-vous que ce chemin est correct
use App\Models\Configurations; // Assurez-vous que ce chemin est correct
use Exception;

class ConfigurationController extends Controller
{
   public function index()
    {
        $allConfigurations = Configurations::latest()->paginate(10);
        return view('config.index', compact('allConfigurations'));
    } 
    public function create()
{
    $config = new \stdClass();
    $config->type = 'PAYMENT_DATE'; // Assurez-vous que cela est correctement défini

    return view('config.create', compact('config'));
}


public function store(StoreConfigRequest $request)
{
    try {
        // Créer une nouvelle instance de Configuration
        $configuration = new Configurations();

        // Affecter les valeurs validées aux attributs
        $configuration->type = $request->type;
        $configuration->value = $request->value;
        // Logique de sauvegarde des autres champs
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            if ($file->isValid() && $file->getSize() <= 2048 * 1024) { // Limite à 2 Mo
                // Vérification de l'extension
                if (in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                    $path = $file->store('logos', 'public');
                    // Sauvegarder le chemin du logo dans la base de données
                    $configuration->logo = $path;
                } else {
                    return redirect()->back()->withErrors(['logo' => 'Le fichier doit être une image valide.']);
                }
            } else {
                return redirect()->back()->withErrors(['logo' => 'Le fichier est trop volumineux ou invalide.']);
            }
        }

        // Sauvegarder la configuration dans la base de données
        $configuration->save();

        // Rediriger vers l'index des configurations avec un message de succès
        return redirect()->route('configurations.index')->with([
            'success' => 'Nouvelle configuration ajoutée avec succès.',
            'config' => $configuration // Passer la configuration créée à la session
        ]);
    } catch (Exception $e) {
        // Afficher l'erreur pour le débogage
        dd($e);
    }
}  




public function delete(Configurations $configuration)
{
    try {
        // Supprimer l'instance de Configuration
        $configuration->delete();

        // Rediriger vers l'index des configurations avec un message de succès
        return redirect()->route('configurations.index')->with('success', 'Configuration supprimée avec succès.');
    } catch (Exception $e) {
        // Afficher l'erreur pour le débogage
        dd($e);
    }
}




}
