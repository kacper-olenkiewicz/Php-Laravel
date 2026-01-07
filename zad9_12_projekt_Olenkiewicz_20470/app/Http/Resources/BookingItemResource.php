<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingItemResource extends JsonResource
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
            'product' => $this->product->name ?? 'Usunięty produkt',
            'quantity' => $this->quantity,
            'price_per_day' => number_format($this->price_per_day, 2, '.', ''),
            'days' => $this->days,
        ];
    }
}