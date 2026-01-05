<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_datetime',
        'appointment_status',
    ];
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function patient(){
        return $this->belongsTo(patient::class);
    }
    public function medicalRecords(){
        return $this->hasMany(MedicalRecord::class);
    }
}
