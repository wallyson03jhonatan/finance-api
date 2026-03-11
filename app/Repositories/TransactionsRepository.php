<?php

namespace App\Repositories;

use App\Models\Transactions;
use Illuminate\Support\Collection;

class TransactionsRepository
{
    public function allByUser(int $userId): Collection
    {
        return Transactions::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findByUser(int $id, int $userId): ?Transactions
    {
        return Transactions::with('category')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): Transactions
    {
        return Transactions::create($data);
    }

    public function updateByUser(int $id, int $userId, array $data): ?Transactions
    {
        $transaction = Transactions::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$transaction) {
            return null;
        }

        $transaction->update($data);

        return $transaction->refresh();
    }

    public function deleteByUser(int $id, int $userId): bool
    {
        $transaction = Transactions::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$transaction) {
            return false;
        }

        return $transaction->delete();
    }
}