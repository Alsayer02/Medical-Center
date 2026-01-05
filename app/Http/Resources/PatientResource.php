<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Patient_id'   => $this->id,
            'name'         => $this->name,
            'phone_number' => $this->phone_number,
            'gender'       => $this->gender,
            'Age'          => $this->age,
        ];
    }
}
