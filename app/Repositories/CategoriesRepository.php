<?php

namespace App\Repositories;

use App\Models\Categories;

class CategoriesRepository
{

    public function allByUser(int $userId)
    {
        return Categories::where('user_id', $userId)->get();
    } 

    public function findByUser(int $id, int $userId)
    {
        return Categories::where('id', $id)
            ->where('user_id', $userId)
            ->first(); 
    }

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function updateByUser(int $id, int $userId, array $data)
    {
        $transaction = Categories::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        $transaction->update($data);
        return $transaction;
    }

    public function deleteByUser(int $id, int $userId): void
    {
        $transaction = Categories::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        $transaction->delete();
    }
}
