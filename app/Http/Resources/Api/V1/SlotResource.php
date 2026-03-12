<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'starts_at'  => $this->starts_at->format('Y-m-d H:i'),
            'ends_at'    => $this->ends_at->format('Y-m-d H:i'),
            'doctor'     => new DoctorResource($this->whenLoaded('doctor')),
            'service'    => new ServiceResource($this->whenLoaded('service')),
            'is_available' => $this->is_available,
        ];
    }
}