<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize data before validation
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->type ? strtolower($this->type) : null,
            'period' => $this->period ? strtolower($this->period) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'type' => [
                'nullable',
                Rule::in(['income', 'outcome'])
            ],

            'period' => [
                'nullable',
                Rule::in(['day', 'week', 'month', 'year'])
            ],

            'category_id' => [
                'nullable',
                'string',
                'max:100'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'O tipo deve ser "income" ou "outcome".',
            'period.in' => 'O período deve ser "day", "week", "month" ou "year".',
            'category_id.string' => 'A categoria deve ser um texto.',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => 'tipo',
            'period' => 'período',
            'category_id' => 'categoria',
        ];
    }
}