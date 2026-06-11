<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\EmailVerificationService;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function __construct(protected EmailVerificationService $emailVerificationService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_verification_status' => 'pending',
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        try {
            $this->emailVerificationService->sendCode($user->id, $user->email);
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar código de verificação no registro', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            // usuário já criado e com token — segue o fluxo; código pode ser reenviado via /api/email/resend
        }

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
}
