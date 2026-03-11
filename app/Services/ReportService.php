<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    public function __construct(protected ReportRepository $repository)
    {
    }

    public function getReport(array $filters): array
    {
        $transactions = $this->repository->get($filters);

        $totalIncome = $transactions->where('registerType', 'income')->sum('value');
        $totalOutcome = $transactions->where('registerType', 'outcome')->sum('value');

        return [
            'transactions' => $transactions,
            'totals' => [
                'total' => $this->formatCurrency($totalIncome - $totalOutcome),
                'total_income' => $this->formatCurrency($totalIncome),
                'total_outcome' => $this->formatCurrency($totalOutcome),
            ],
        ];
    }

    private function formatCurrency(float $value): string
    {
        return "R$ " . number_format($value, 2, ',', '.');
    }
}