<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'phone' => 'required|string|unique:employers,phone',
            'heures_travail' => 'required|numeric|min:0', // Ajout de la règle de validation pour heures de travail
            'montant_journalier' => 'required|numeric|max:999999999.99', // Ajustez la limite si nécessaire // Ajout de 'numeric' pour valider les montants
            'departement_id' => 'required|exists:departements,id', // Correction de la règle 'exists'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Le mail est requis',
            'email.unique' => 'Le mail existe déjà',
            'phone.required' => 'Le numéro de téléphone est requis',
            'phone.unique' => 'Le numéro de téléphone existe déjà',
            'montant_journalier.required' => 'Le montant_journalier  est requis',
            'departement_id.required' => 'Le département est requis',
            'departement_id.exists' => 'Le département sélectionné n\'existe pas',
            'heures_travail.required' => 'Les heures de travail sont obligatoires.',
            'heures_travail.numeric' => 'Les heures de travail doivent être un nombre.',
            'heures_travail.min' => 'Les heures de travail doivent être supérieures ou égales à 0.',
        ];
    }
    
}
