<?php

namespace App\Filament\Resources\Teams\Schemas;

use App\Services\PokeApiService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        $pokeApi = new PokeApiService();
        
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('test_pokemon')
                    ->label('Test - Select a Pokémon')
                    ->options($pokeApi->getPokemonOptions())
                    ->searchable()
                    ->helperText('This is just to test the PokéAPI integration'),
            ]);
    }
}
