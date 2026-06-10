<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->siswa->user_id,
            'password' => 'nullable|string|min:8',
            'nis' => 'required|string|max:50|unique:siswas,nis,'.$this->siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ];
    }
}
