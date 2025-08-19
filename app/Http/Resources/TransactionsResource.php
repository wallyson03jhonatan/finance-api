<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TransactionsResource extends JsonResource
{
    public function toArray($request): array
    {
        $categoryName = $this->category?->name ?? $this->category?->description ?? null;

        $searchable = Str::ascii(mb_strtolower(
            ($this->description ?? '') . ' ' .
            ($categoryName ?? '') . ' ' .
            (string) $this->value . ' ' .
            ($this->registerType ?? '')
        ));

        return [
            'id'                   => $this->id,
            'description'          => $this->description,
            'value_raw'            => $this->value,
            'value'                => "R$ " . number_format($this->value, 2, ',', '.'),
            'type'                 => $this->registerType,
            'category_id'          => $this->category_id,
            'category_description' => $categoryName,
            'created_at'           => $this->created_at?->format('d/m/Y'),
            'created_at_iso'       => $this->created_at?->setTimezone('UTC')->toIso8601String(),
            'searchable'           => $searchable
        ];
    }
}