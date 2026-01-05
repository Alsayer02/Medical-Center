<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\HandleTransaction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateDoctor extends CreateRecord
{
    use HandleTransaction;
    protected static string $resource = DoctorResource::class;
    protected function handleRecordCreation(array $data): Doctor
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'doctor',
            ]);
            return Doctor::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'specialization' => $data['specialization'],
                'phone' => $data['phone'],
            ]);
        });
    }
}
