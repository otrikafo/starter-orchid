<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisiteurRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou définir des conditions d'autorisation plus complexes
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:visiteurs',
            'password' => 'required|confirmed|min:8', // 'confirmed' pour la confirmation de mot de passe
        ];
    }
}
