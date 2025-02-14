<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgenceRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou définir des conditions d'autorisation plus complexes
    }

    public function rules(): array
    {
        return [
            'raison_sociale' => 'required|string|max:255',
            'siege' => 'required|string|max:255',
            'nif' => 'required|string|max:20|unique:agences',
            'stat' => 'required|string|max:20|unique:agences',
            'email' => 'required|email|max:255|unique:agences',
            'password' => 'required|confirmed|min:8', // 'confirmed' pour la confirmation de mot de passe
        ];
    }
}
