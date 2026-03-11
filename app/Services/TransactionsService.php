<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Repositories\TransactionsRepository;
use App\Models\Transactions;

class TransactionsService
{
    public function __construct(
        protected TransactionsRepository $repository
    ) {}

    public function list(int $userId): Collection
    {
        return $this->repository->allByUser($userId);
    }

    public function find(int $id, int $userId): ?Transactions
    {
        return $this->repository->findByUser($id, $userId);
    }

    public function create(array $data): Transactions
    {
        return $this->repository->create($data);
    }

    public function update(int $id, int $userId, array $data): ?Transactions
    {
        return $this->repository->updateByUser($id, $userId, $data);
    }

    public function delete(int $id, int $userId): bool
    {
        return $this->repository->deleteByUser($id, $userId);
    }
}