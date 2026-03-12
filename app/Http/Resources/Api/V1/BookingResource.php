<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'notes'  => $this->notes,
            'slot'   => new SlotResource($this->whenLoaded('slot')),
            'user'   => new UserResource($this->whenLoaded('user')),
        ];
    }
}