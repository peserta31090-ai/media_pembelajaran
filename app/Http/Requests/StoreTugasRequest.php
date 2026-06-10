<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'required|date|after:now',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'nullable|exists:mapels,id',
        ];
    }
}
