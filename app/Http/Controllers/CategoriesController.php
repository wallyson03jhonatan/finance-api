<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Services\CategoriesService;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    protected $service;

    public function __construct(CategoriesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $userId = auth()->id();
        $categories = $this->service->list($userId);

        return response()->json(CategoriesResource::collection($categories));
    }

    public function show($id): JsonResponse
    {
        $userId = auth()->id();
        $category = $this->service->find($id, $userId);

        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada.'], 404);
        }

        return response()->json(new CategoriesResource($category));
    }

    public function store(CategoriesRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $category = $this->service->create($data);

        return response()->json([
            'message' => 'Categoria criada com sucesso!',
            'data' => new CategoriesResource($category),
        ], 201);
    }
    
    public function update(CategoriesRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $userId = auth()->id();

        $category = $this->service->update($id, $userId, $data);

        return response()->json([
            'message' => 'Categoria atualizada com sucesso!',
            'data'    => new CategoriesResource($category),
        ]);
    }
   
    public function destroy($id): JsonResponse
    {
        $userId = auth()->id();
        $this->service->delete($id, $userId);

        return response()->json([
            'message' => 'Categoria removida com sucesso!',
        ]);
    }
}
