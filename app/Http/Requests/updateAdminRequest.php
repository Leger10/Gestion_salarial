<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('admin')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $adminId,
            'password' => 'nullable|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'nom_complet.required' => 'Le nom complet est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Le format de l\'email est invalide.',
            'email.unique' => 'L\'email existe déjà.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ];
    }
}
