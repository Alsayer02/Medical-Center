<?php

namespace App\Filament\Resources\MedicalRecords\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MedicalRecordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('doctor_id')
                    ->numeric(),
                TextEntry::make('appointment_id')
                    ->numeric(),
                TextEntry::make('diagnosis')
                    ->columnSpanFull(),
                TextEntry::make('doctor_notes')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
