<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $doctor = $this->route('doctor');
        $doctorId = $this->route('doctor');
        $doctor = Doctor::find($doctorId);
        return [
            'name' => 'sometimes|string|max:255',
            'specialization' => 'sometimes|string|max:255',
            'phone' => 'sometimes|numeric|unique:doctors,phone,' . $doctorId,
            'email' => 'sometimes|email|unique:users,email,' . ($doctor?->user_id),
            'password' => 'sometimes|string|min:8|confirmed',
        ];
    }
}
