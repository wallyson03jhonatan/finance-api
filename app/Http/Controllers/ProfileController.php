<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileInfoRequest;
use App\Http\Resources\UserResource;
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
}
