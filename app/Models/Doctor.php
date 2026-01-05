<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'specialization',
        'phone',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
    protected static function booted()
    {
        static::deleting(function ($doctor) {
            // حذف المستخدم المرتبط قبل حذف الدكتور
            if ($doctor->user) {
                $doctor->user->delete();
            }
        });
    }
}
