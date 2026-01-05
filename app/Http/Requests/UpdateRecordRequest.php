<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecordRequest extends FormRequest
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
        $record = $this->route('medical_record');
        return [
            'doctor_id' => 'nullable|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id|unique:medical_records,appointment_id,' .  ($record?->id ?? 'NULL'),
            'diagnosis' => 'nullable|string',
            'doctor_notes' => 'nullable|string',
        ];
    }
}
