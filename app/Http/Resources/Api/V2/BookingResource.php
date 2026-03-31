<?php

namespace App\Http\Resources\Api\V2;

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
            'id'           => $this->id,
            'status'       => $this->status,
            'status_label' => match($this->status) {
                'pending'   => 'In attesa',
                'confirmed' => 'Confermata',
                'cancelled' => 'Annullata',
                default     => 'Sconosciuto',
            },
            'notes' => $this->notes,
        ];
    }
}
