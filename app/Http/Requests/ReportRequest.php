<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => 'nullable|in:income,outcome',
            'period' => 'nullable|in:day,week,month,year',
            'category' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'O tipo deve ser "income" ou "outcome".',
            'period.in' => 'O período deve ser "day", "week", "month" ou "year".',
            'category.string' => 'A categoria deve ser um texto.',
        ];
    }
}
