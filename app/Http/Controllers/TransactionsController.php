<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use App\Services\TransactionsService;
use App\Http\Resources\TransactionsResource;
use Illuminate\Http\JsonResponse;

class TransactionsController extends Controller
{
    protected $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $userId = auth()->id();
        $transactions = $this->service->list($userId);

        return response()->json(TransactionsResource::collection($transactions));
    }

    public function show($id): JsonResponse
    {
        $userId = auth()->id();
        $transaction = $this->service->find($id, $userId);

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json(new TransactionsResource($transaction));
    }

    public function store(TransactionsRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $transaction = $this->service->create($data);

        return response()->json([
            'message' => 'Transação criada com sucesso!',
            'data' => new TransactionsResource($transaction),
        ], 201);
    }
    
    public function update(TransactionsRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $userId = auth()->id();

        $transaction = $this->service->update($id, $userId, $data);

        return response()->json([
            'message' => 'Transação atualizada com sucesso!',
            'data'    => new TransactionsResource($transaction),
        ]);
    }
   
    public function destroy($id): JsonResponse
    {
        $userId = auth()->id();
        $this->service->delete($id, $userId);

        return response()->json([
            'message' => 'Transação removida com sucesso!',
        ]);
    }
}
