<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use App\Models\Doctor;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected  function mutateFormDataBeforeFill(array $data): array
    {
        if ($record = static::getRecord()) {
            $data['email'] = $record->user->email;
        }

        return $data;
    }


    protected function handleRecordUpdate($record, array $data): Doctor
    {
        return DB::transaction(function () use ($record, $data) {

            // تحديث المستخدم
            $record->user->update([
                'email' => $data['email'],
                ...(isset($data['password']) && $data['password']
                    ? ['password' => Hash::make($data['password'])]
                    : []),
            ]);

            // تحديث الطبيب
            $record->update([
                'name' => $data['name'],
                'specialization' => $data['specialization'],
                'phone' => $data['phone'],
            ]);

            return $record;
        });
    }
}
