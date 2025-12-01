<?php

namespace App\Filament\Pages;

use App\Services\PokeApiService;
use Filament\Pages\Page;

class Pokemon extends Page
{
    protected string $view = 'filament.pages.pokemon';
    
    protected static ?string $navigationLabel = 'Pokémon';
    
    protected static ?int $navigationSort = 1;
    
    public array $pokemonList = [];
    
    public function mount(): void
    {
        $pokeApi = new PokeApiService();
        // Just get first 20 for now to test
        $this->pokemonList = $pokeApi->getPokemonListWithDetails(20);
    }
}
