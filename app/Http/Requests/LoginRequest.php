<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Handle Login Request
 * 
 * @property-read string $email
 * @property-read string $password
 * 
*/

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Attempt to login in the system
     *
     * @return bool
    */
    public function attempt(): bool
    {
        if (
            $user = User::query()
                ->where('email', '=', $this->email)
                ->first()
        ) {

            if (Hash::check($this->password, $user->password)) {
                auth()->login($user);
                     
                return true;
            }
        }

        return false;
    }
}
