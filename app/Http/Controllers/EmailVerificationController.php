<?php

namespace App\Http\Controllers;

use App\Services\EmailVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function __construct(protected EmailVerificationService $service)
    {
    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $this->service->verify($request->input('code'));

        return response()->json(['message' => 'E-mail confirmado com sucesso!']);
    }

    public function resend(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->email_verification_status === 'confirmed') {
            return response()->json(['message' => 'E-mail já confirmado.'], 422);
        }

        $this->service->sendCode($user->id, $user->email);

        return response()->json(['message' => 'Novo código enviado para seu e-mail.']);
    }
}