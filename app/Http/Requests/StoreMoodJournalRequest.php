<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoodJournalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all authenticated users
    }

    public function rules(): array
    {
        return [
            'mood' => 'required|string|max:255',
            'entry' => 'required|string',
            'tags' => 'nullable|array',
            'entry_date' => 'required|date',
        ];
    }
}
