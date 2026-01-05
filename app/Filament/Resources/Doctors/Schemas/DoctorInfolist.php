<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DoctorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Doctor Name'),
                TextEntry::make('specialization')->label('Specialization'),
                TextEntry::make('phone')->label('Phone Number'),
                TextEntry::make('user.email')
                    ->label('Email')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
