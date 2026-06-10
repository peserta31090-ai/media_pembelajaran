<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->guru->user_id,
            'password' => 'nullable|string|min:8',
            'nip' => 'required|string|max:50|unique:gurus,nip,'.$this->guru->id,
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ];
    }
}
