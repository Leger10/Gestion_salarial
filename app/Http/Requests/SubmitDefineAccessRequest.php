<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitDefineAccessRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        // Vérifie si l'utilisateur est autorisé à faire cette demande
        return true; // Vous pouvez ajouter une logique de vérification ici si nécessaire
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array 
     */
    public function rules()
    {
        return [
            'password' => 'required|same:password_confirmation', // Règle de validation pour le mot de passe
            'password_confirmation' => 'required|same:password', // Vérifie que les mots de passe correspondent
            'code' => 'required|digits:4|exists:resets_code_password, code', // Validation pour le code de réinitialisation
        ];
    }

    /**
     * Personnaliser les messages de validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.same' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.same' => 'Les mots de passe ne correspondent pas. Veuillez réessayer.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'code.required' => 'Le code de réinitialisation est requis.',
            'code.digits' => 'Le code de réinitialisation doit comporter 4 chiffres.',
            'code.exists' => 'Le code que vous avez saisi est invalide ou a expiré. Consulter votre boite mail .',
        ];
    }
}
