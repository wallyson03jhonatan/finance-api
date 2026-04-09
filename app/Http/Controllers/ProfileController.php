<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileInfoRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $service)
    {
    }

    public function updateInfo(UpdateProfileInfoRequest $request): UserResource
    {
        $user = $this->service->updateInfo(
            auth()->id(),
            $request->validated()
        );

        return new UserResource($user);
    }

    public function updatePassword(UpdateProfilePasswordRequest $request): JsonResponse
    {
        $this->service->updatePassword(
            auth()->id(),
            $request->validated('current_password'),
            $request->validated('new_password')
        );

        return response()->json(['message' => 'Senha atualizada com sucesso. Faça login novamente.']);
    }
}
