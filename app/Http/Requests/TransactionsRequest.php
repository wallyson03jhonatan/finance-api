<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'min:3', 'max:255'],

            'value' => ['required', 'numeric', 'min:0.01'],

            'registerType' => ['required', 'in:income,outcome'],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'description.min' => 'A descrição deve ter no mínimo 3 caracteres.',
            'description.max' => 'A descrição pode ter no máximo 255 caracteres.',

            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser numérico.',
            'value.min' => 'O valor deve ser maior que zero.',

            'registerType.required' => 'O tipo de registro é obrigatório.',
            'registerType.in' => 'O tipo deve ser income ou outcome.',

            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.integer' => 'A categoria deve ser um ID válido.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}