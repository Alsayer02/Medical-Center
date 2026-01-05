<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'doctor_id',
        'appointment_id',
        'diagnosis',
        'doctor_notes',
    ];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
