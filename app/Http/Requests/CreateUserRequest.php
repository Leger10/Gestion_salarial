<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
{
    return [
        'nom.required' => 'Le nom est requis.',
        'prenom.required' => 'Le prénom est requis.',
        'email.required' => 'L\'adresse e-mail est obligatoire.',
        'email.email' => 'L\'adresse e-mail n\'est pas valide.',
        'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        // 'password.required' => 'Le mot de passe est requis.',
        // 'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        // 'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ];
}

}
 