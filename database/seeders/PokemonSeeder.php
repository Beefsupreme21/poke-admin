<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use App\Services\PokeApiService;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    public function run(): void
    {
        $pokeApi = new PokeApiService();
        $pokemonList = $pokeApi->getPokemonListWithDetails(151);
        
        foreach ($pokemonList as $pokemonData) {
            $stats = collect($pokemonData['stats'])->keyBy('stat.name');
            
            Pokemon::updateOrCreate(
                ['pokedex_id' => $pokemonData['id']],
                [
                    'name' => $pokemonData['name'],
                    'types' => collect($pokemonData['types'])->pluck('type.name')->toArray(),
                    'sprite_url' => $pokemonData['sprites']['front_default'] ?? null,
                    'height' => $pokemonData['height'] ?? null,
                    'weight' => $pokemonData['weight'] ?? null,
                    'hp' => $stats->get('hp')['base_stat'] ?? null,
                    'attack' => $stats->get('attack')['base_stat'] ?? null,
                    'defense' => $stats->get('defense')['base_stat'] ?? null,
                    'special_attack' => $stats->get('special-attack')['base_stat'] ?? null,
                    'special_defense' => $stats->get('special-defense')['base_stat'] ?? null,
                    'speed' => $stats->get('speed')['base_stat'] ?? null,
                ]
            );
            
            $this->command->info("Seeded: {$pokemonData['name']}");
        }
        
        $this->command->info('Done! Seeded ' . count($pokemonList) . ' Pokémon!');
    }
}
