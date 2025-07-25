<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'description' => 'required|string|min:3|max:255',
            'value' => 'required|numeric',
            'registerType' => 'required|in:income,outcome',
            'category' => 'string|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'value.required' => 'O valor é obrigatório.',
            'registerType.in' => 'O tipo deve ser income ou outcome.',
        ];
    }

}
