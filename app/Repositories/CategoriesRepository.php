<?php

namespace App\Repositories;

use App\Models\Categories;
use Illuminate\Support\Collection;

class CategoriesRepository
{

    public function allByUser(int $userId): Collection
    {
        return Categories::where('user_id', $userId)->get();
    }

    public function findByUser(int $id, int $userId): ?Categories
    {
        return Categories::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): Categories
    {
        return Categories::create($data);
    }

    public function updateByUser(int $id, int $userId, array $data): ?Categories
    {
        $category = Categories::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$category) {
            return null;
        }

        $category->update($data);

        return $category->refresh();
    }

    public function deleteByUser(int $id, int $userId): bool
    {
        $category = Categories::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$category) {
            return false;
        }

        return $category->delete();
    }

    public function isInUse(int $id): bool
    {
        $category = Categories::where('id', $id)->first();

        if (!$category) {
            return false;
        }

        return $category->transactions()->exists();
    }
}
