<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'gender',
        'age',
    ];
    public function Appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
