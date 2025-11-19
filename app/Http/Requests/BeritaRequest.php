<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|max:255',
            'isi' => 'nullable',
            'gambar' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,publish',
        ];
    }
}
