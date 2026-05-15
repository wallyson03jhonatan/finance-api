<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends Controller
{
    public function __construct(protected PasswordResetService $service)
    {
    }

    public function forgot(PasswordResetRequest $request): JsonResponse
    {
        $this->service->forgot($request->input('email'));

        return response()->json([
            'message' => 'Se este e-mail estiver cadastrado, você receberá um link em breve.',
        ]);
    }

    public function reset(PasswordResetRequest $request): JsonResponse
    {
        $this->service->reset(
            $request->input('email'),
            $request->input('token'),
            $request->input('password')
        );

        return response()->json([
            'message' => 'Senha redefinida com sucesso. Faça login novamente.',
        ]);
    }
}
