<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
// use Password;

/**
 * Handle Login Request
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 * 
*/

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|confirmed|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function tryToRegister(): bool {
        $user = User::query()->create($this->validated());
        
        auth()->login($user);
        
        return true;
    }
}
