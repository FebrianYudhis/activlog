<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelDownloadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggalAwal' => ['required', 'date'],
            'tanggalAkhir' => ['required', 'date', 'after_or_equal:tanggalAwal'],
            'pengguna' => ['required', 'exists:users,id'],
        ];
    }
}
