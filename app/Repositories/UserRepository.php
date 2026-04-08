<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function updateInfo(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);
        $user->update($data);

        return $user->refresh();
    }
}