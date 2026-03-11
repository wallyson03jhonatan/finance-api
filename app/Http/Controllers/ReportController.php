<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use App\Http\Resources\ReportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $service
    ) {}

    public function index(ReportRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $filters = [
            ...$request->validated(),
            'user_id' => $userId
        ];

        $result = $this->service->getReport($filters);

        return ReportResource::collection($result['transactions'])
            ->additional([
                'totals' => $result['totals']
            ]);
    }
}
