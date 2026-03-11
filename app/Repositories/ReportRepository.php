<?php

namespace App\Repositories;

use App\Models\Transactions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportRepository
{
    public function query(array $filters): Builder
    {
        $query = Transactions::query();

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['type'])) {
            $query->where('registerType', $filters['type']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['period'])) {
            $query->whereBetween(
                'created_at',
                $this->getPeriodRange($filters['period'])
            );
        }

        return $query;
    }

    public function get(array $filters): Collection
    {
        return $this->query($filters)
            ->latest()
            ->get();
    }

    private function getPeriodRange(string $period): array
    {
        $now = now();

        return match ($period) {
            'day' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }
}