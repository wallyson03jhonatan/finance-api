<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use App\Services\TransactionsService;
use App\Http\Resources\TransactionsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionsController extends Controller
{
    public function __construct(
        protected TransactionsService $service
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $transactions = $this->service->list(auth()->id());

        return TransactionsResource::collection($transactions);
    }

    public function show(int $id): TransactionsResource
    {
        $transaction = $this->service->find($id, auth()->id());

        abort_if(!$transaction, 404, 'Transação não encontrada.');

        return new TransactionsResource($transaction);
    }

    public function store(TransactionsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $transaction = $this->service->create($data);

        return (new TransactionsResource($transaction))
            ->response()
            ->setStatusCode(201);
    }

    public function update(TransactionsRequest $request, int $id): TransactionsResource
    {
        $transaction = $this->service->update(
            $id,
            auth()->id(),
            $request->validated()
        );

        abort_if(!$transaction, 404, 'Transação não encontrada.');

        return new TransactionsResource($transaction);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id, auth()->id());

        abort_if(!$deleted, 404, 'Transação não encontrada.');

        return response()->json([
            'message' => 'Transação removida com sucesso!'
        ]);
    }
}