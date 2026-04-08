<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class ProfileService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function updateInfo(int $userId, array $data): User
    {
        return $this->repository->updateInfo($userId, $data);
    }
}