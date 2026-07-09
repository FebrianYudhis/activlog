<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogbookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'jadwalDinas' => ['required', 'exists:schedules,id'],
        ];
    }
}
