<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSoalKuisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string|max:255',
            'opsi_b' => 'required|string|max:255',
            'opsi_c' => 'required|string|max:255',
            'opsi_d' => 'required|string|max:255',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ];
    }
}
