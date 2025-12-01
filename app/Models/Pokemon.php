<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        'name',
        'pokedex_id',
        'types',
        'sprite_url',
        'height',
        'weight',
        'hp',
        'attack',
        'defense',
        'special_attack',
        'special_defense',
        'speed',
    ];
    
    protected $casts = [
        'types' => 'array',
    ];
}
