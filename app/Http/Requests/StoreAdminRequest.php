<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Changer 'nom' en 'nom_complet'
            'email' => 'required|email|unique:email,users', // Enlever la partie avec $this->user->id
         
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom de L\'Administrateur est requis.', // Ajuster le message
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Le format de l\'email est invalide.',
            'email.unique' => 'L\'email existe déjà.',
            
        ];
    }
}
