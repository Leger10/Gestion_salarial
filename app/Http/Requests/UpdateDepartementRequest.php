<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartementRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Changez ceci selon votre logique d'autorisation
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom du département est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
        ];
    }
}
