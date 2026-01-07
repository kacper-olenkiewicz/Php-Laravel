<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'customer_name' => $this->user->name ?? 'N/A',
            'dates' => [
                'start' => $this->start_date->toDateTimeString(),
                'end' => $this->end_date->toDateTimeString(),
            ],
            'status' => $this->status,
            'total_amount' => number_format($this->total_amount, 2, '.', ''),
            'items' => BookingItemResource::collection($this->whenLoaded('items')), // Wymaga stworzenia BookingItemResource
            'payment_status' => $this->payment->status ?? 'Nie opłacono',
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}