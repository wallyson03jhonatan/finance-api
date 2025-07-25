<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray($request): array 
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'value' => number_format($this->value, 2, '.', ''),
            'type' => $this->registerType,
            'category' => $this->category,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}