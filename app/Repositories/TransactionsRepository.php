<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepository
{

    public function allByUser(int $userId)
    {
        return Transactions::where('user_id', $userId)->get();
    }

    public function findByUser(int $id, int $userId)
    {
        return Transactions::where('id', $id)
            ->where('user_id', $userId)
            ->first(); 
    }

    public function create(array $data)
    {
        return Transactions::create($data);
    }

    public function updateByUser(int $id, int $userId, array $data)
    {
        $transaction = Transactions::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        $transaction->update($data);
        return $transaction;
    }

    public function deleteByUser(int $id, int $userId): void
    {
        $transaction = Transactions::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        $transaction->delete();
    }
}
