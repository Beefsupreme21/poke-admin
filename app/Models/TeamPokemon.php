<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPokemon extends Model
{
    protected $fillable = ['team_id', 'pokemon_id', 'position'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }
}
