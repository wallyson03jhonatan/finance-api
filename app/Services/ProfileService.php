<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function updateInfo(int $userId, array $data): User
    {
        return $this->repository->updateInfo($userId, $data);
    }

    public function updatePassword(int $userId, string $currentPassword, string $newPassword): void
    {
        $user = User::findOrFail($userId);

        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'A senha atual está incorreta.',
            ]);
        }

        $this->repository->updatePassword($userId, $newPassword);

        $user->tokens()->delete();
    }
}