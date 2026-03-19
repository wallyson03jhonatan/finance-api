<?php

namespace App\Http\Controllers;

use App\Exceptions\CategoryInUseException;
use App\Http\Requests\CategoriesRequest;
use App\Services\CategoriesService;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{

    public function __construct(
        protected CategoriesService $service
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $categories = $this->service->list(auth()->id());

        return CategoriesResource::collection($categories);
    }

    public function show(int $id): CategoriesResource
    {
        $category = $this->service->find($id, auth()->id());

        abort_if(!$category, 404, "Categoria não encontrada");

        return new CategoriesResource($category);
    }

    public function store(CategoriesRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $category = $this->service->create($data);

        return (new CategoriesResource($category))->response()->setStatusCode(201);
    }

    public function update(CategoriesRequest $request, int $id): CategoriesResource|JsonResponse
    {
        $category = $this->service->update(
            $id,
            auth()->id(),
            $request->validated()
        );

        abort_if(!$category, 404, 'Categoria não encontrada.');

        return new CategoriesResource($category);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->service->delete($id, auth()->id());

            abort_if(!$deleted, 404, 'Categoria não encontrada.');

            return response()->json(['message' => 'Categoria removida com sucesso!']);

        } catch (CategoryInUseException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
