<?php

namespace App\Filament\Resources\MedicalRecords\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MedicalRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('doctor_id')
                    ->required()
                    ->numeric(),
                TextInput::make('appointment_id')
                    ->required()
                    ->numeric(),
                Textarea::make('diagnosis')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('doctor_notes')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
