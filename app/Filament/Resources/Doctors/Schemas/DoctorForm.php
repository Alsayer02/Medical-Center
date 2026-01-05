<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
// use pages\App\Filament\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Resources\DoctorResource\Pages;
class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')->required()->email(),
                TextInput::make('specialization')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('password')->required((fn($livewire) => $livewire instanceof CreateRecord))->password(),
            ]);
    }
}
