<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rental_id' => $this->rental_id,
            'name' => $this->name,
            'description' => $this->description,
            'daily_price' => number_format($this->daily_price, 2, '.', ''), // Zapewnienie formatu float
            'stock_available' => $this->stock_quantity,
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->pluck('name');
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}