@php
    $team = $getRecord();
    $teamPokemon = $team->pokemon()->with('pokemon')->orderBy('position')->get();
    $pokemonByPosition = $teamPokemon->keyBy('position');
@endphp

<div style="display: flex; gap: 0.5rem;">
    @for($i = 1; $i <= 6; $i++)
        @php
            $teamMember = $pokemonByPosition->get($i);
            $pokemon = $teamMember?->pokemon;
        @endphp
        
        <div style="width: 60px; text-align: center;">
            @if($pokemon)
                <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}" style="width: 50px; height: 50px; margin: 0 auto;">
                <div style="font-size: 10px; text-transform: capitalize;">{{ $pokemon->name }}</div>
            @else
                <div style="width: 50px; height: 50px; border: 1px dashed #d1d5db; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: #9ca3af;">
                    -
                </div>
            @endif
        </div>
    @endfor
</div>

