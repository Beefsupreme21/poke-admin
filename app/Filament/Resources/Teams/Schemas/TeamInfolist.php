<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Schema;

class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ViewEntry::make('pokemon')
                    ->view('filament.infolists.team-pokemon-details')
                    ->label('Team Members')
                    ->columnSpanFull(),
            ]);
    }
}
