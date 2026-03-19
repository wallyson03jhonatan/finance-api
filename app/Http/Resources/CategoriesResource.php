<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Categories;

/**
 * @mixin Categories
 */
class CategoriesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at?->format('d/m/Y'),
            'created_at_iso' => $this->created_at?->toISOString(),
        ];
    }
}
