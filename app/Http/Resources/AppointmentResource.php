<?php

namespace App\Http\Resources;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'appointment_datetime' => $this->appointment_datetime,
            'appointment_status'   => $this->appointment_status,
            'doctor'               => new DoctorResource($this->doctor),
            'patient'              => new PatientResource($this->patient),
        ];
    }
}
