<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengumumanRequest extends FormRequest
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
            'file' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
            'status' => 'required|in:draft,publish',
        ];
    }
}
