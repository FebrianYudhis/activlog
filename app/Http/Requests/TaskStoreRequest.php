<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tugas' => ['required', 'string'],
            'waktu' => ['required', 'date_format:H:i'],
        ];
    }
}
