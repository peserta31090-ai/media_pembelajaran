<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:6',
            'nis' => 'required|string|max:50|unique:siswas',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ];
    }
}
