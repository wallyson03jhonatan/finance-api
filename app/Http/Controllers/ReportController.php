<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use App\Http\Resources\ReportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    protected ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function index(ReportRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['message' => 'Não autorizado'], 401);
        }

        $filters = $request->validated();
        $filters['user_id'] = $userId;

        $transactions = $this->service->filter($filters);

        $totalIncome = $transactions->where('registerType', 'income')->sum('value');
        $totalOutcome = $transactions->where('registerType', 'outcome')->sum('value');
        $total = $totalIncome - $totalOutcome;
        
        return ReportResource::collection($transactions)
        ->additional([
            'totals' => [
                'total' => number_format($total, 2, '.', ''),
                'total_income' => number_format($totalIncome, 2, '.', ''),
                'total_outcome' => number_format($totalOutcome, 2, '.', ''),
            ]
        ]);

    }
}
