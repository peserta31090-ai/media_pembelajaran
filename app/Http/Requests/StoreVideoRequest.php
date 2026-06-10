<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'link_video' => 'required|string|max:500',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'nullable|exists:mapels,id',
        ];
    }
}
