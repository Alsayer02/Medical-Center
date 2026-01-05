<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'doctor_id'    => $this->doctor_id,
            'diagnosis'    => $this->diagnosis,
            'doctor_notes' => $this->doctor_notes,
            'appointment'  => new AppointmentResource($this->appointment),
            'created_at'   => $this->created_at?->format('Y-m-d'),
        ];
    }
}
