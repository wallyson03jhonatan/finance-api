<?php

namespace App\Services;

use App\Exceptions\CategoryInUseException;
use Illuminate\Support\Collection;
use App\Repositories\CategoriesRepository;
use App\Models\Categories;

class CategoriesService
{

    public function __construct(protected CategoriesRepository $repository)
    {
    }

    public function list(int $userId): Collection
    {
        return $this->repository->allByUser($userId);
    }

    public function find(int $id, int $userId): ?Categories
    {
        return $this->repository->findByUser($id, $userId);
    }

    public function create(array $data): Categories
    {
        return $this->repository->create($data);
    }

    public function update(int $id, int $userId, array $data): ?Categories
    {
        return $this->repository->updateByUser($id, $userId, $data);
    }

    public function delete(int $id, int $userId): bool
    {
        if ($this->repository->isInUse($id)) {
            throw new CategoryInUseException();
        }
        
        return $this->repository->deleteByUser($id, $userId);
    }
}
