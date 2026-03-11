<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Models\Transactions;

/**
 * @mixin Transactions
 */
class TransactionsResource extends JsonResource
{
    public function toArray($request): array
    {
        $categoryName = $this->category?->name ?? $this->category?->description;

        return [
            'id' => $this->id,
            'description' => $this->description,

            'value' => [
                'raw' => $this->value,
                'formatted' => 'R$ ' . number_format($this->value, 2, ',', '.'),
            ],

            'type' => $this->registerType,

            'category' => [
                'id' => $this->category_id,
                'description' => $categoryName,
            ],

            'dates' => [
                'created_at' => $this->created_at?->format('d/m/Y'),
                'created_at_iso' => $this->created_at?->toISOString(),
            ],

            'searchable' => Str::ascii(
                mb_strtolower(
                    ($this->description ?? '') . ' ' .
                    ($categoryName ?? '') . ' ' .
                    (string) $this->value . ' ' .
                    ($this->registerType ?? '')
                )
            )
        ];
    }
}