<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
    public function updateInfo(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);
        $user->update($data);

        return $user->refresh();
    }

    public function updatePassword(int $userId, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        $user->update(['password' => Hash::make($newPassword)]);
    }
}