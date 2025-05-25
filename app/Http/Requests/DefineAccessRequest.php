<?php

// app/Http/Requests/DefineAccessRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefineAccessRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assurez-vous que l'utilisateur est autorisé à soumettre la demande
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required| same:password_confirmation',
            'password_confirmation' => 'required|same:password',
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
            'password.same' => 'Le mot de passe invalide.',
            'password_confirmation.same' => 'Les mots de passe ne correspondent pas.',
        ];
    }
}
