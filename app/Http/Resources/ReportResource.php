<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Transactions;

/**
 * @mixin Transactions
 */
class ReportResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,

            'value_raw' => $this->value,
            'value' => $this->formatCurrency($this->value),

            'type' => $this->registerType,
            'category_id' => $this->category_id,

            'created_at' => $this->created_at?->format('d/m/Y'),
            'created_at_iso' => $this->created_at?->toIso8601String(),
        ];
    }

    private function formatCurrency(float $value): string
    {
        return "R$ " . number_format($value, 2, ',', '.');
    }
}