<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\TransactionsRepository;

class TransactionsService
{
    protected TransactionsRepository $repository;

    public function __construct(TransactionsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(int $userId): Collection
    {
        return $this->repository->allByUser($userId);
    }

    public function find(int $id, int $userId)
    {
        return $this->repository->findByUser($id, $userId);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, int $userId, array $data)
    {
        return $this->repository->updateByUser($id, $userId, $data);
    }

    public function delete(int $id, int $userId): void
    {
        $this->repository->deleteByUser($id, $userId);
    }
}
