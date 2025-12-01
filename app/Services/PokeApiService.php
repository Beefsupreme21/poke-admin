<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokeApiService
{
    private const BASE_URL = 'https://pokeapi.co/api/v2';
    
    public function getPokemonList(int $limit = 151, int $offset = 0)
    {
        return Cache::remember("pokemon_list_{$limit}_{$offset}", 3600, function () use ($limit, $offset) {
            $response = Http::get(self::BASE_URL . '/pokemon', [
                'limit' => $limit,
                'offset' => $offset,
            ]);
            
            return $response->successful() ? $response->json()['results'] : [];
        });
    }
    
    public function getPokemonListWithDetails(int $limit = 151, int $offset = 0)
    {
        $list = $this->getPokemonList($limit, $offset);
        
        return collect($list)->map(function ($pokemon) {
            $id = $this->extractIdFromUrl($pokemon['url']);
            return $this->getPokemon($id);
        })->filter()->toArray();
    }
    
    public function getPokemon(int $id)
    {
        return Cache::remember("pokemon_{$id}", 3600, function () use ($id) {
            $response = Http::get(self::BASE_URL . "/pokemon/{$id}");
            
            return $response->successful() ? $response->json() : null;
        });
    }
    
    public function searchPokemon(string $query)
    {
        $allPokemon = $this->getPokemonList(1000);
        
        return collect($allPokemon)->filter(function ($pokemon) use ($query) {
            return str_contains(strtolower($pokemon['name']), strtolower($query));
        })->values()->all();
    }
    
    public function getPokemonOptions()
    {
        $list = $this->getPokemonList(151);
        
        return collect($list)->mapWithKeys(function ($pokemon) {
            $id = $this->extractIdFromUrl($pokemon['url']);
            return [$id => ucfirst($pokemon['name'])];
        })->toArray();
    }
    
    private function extractIdFromUrl(string $url): int
    {
        $parts = explode('/', rtrim($url, '/'));
        return (int) end($parts);
    }
}

