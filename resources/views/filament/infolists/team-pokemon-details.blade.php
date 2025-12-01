@php
    $team = $getRecord();
    $teamPokemon = $team->pokemon()->with('pokemon')->orderBy('position')->get();
    
    $typeColors = [
        'normal' => ['bg' => '#A8A878', 'text' => '#ffffff'],
        'fire' => ['bg' => '#F08030', 'text' => '#ffffff'],
        'water' => ['bg' => '#6890F0', 'text' => '#ffffff'],
        'electric' => ['bg' => '#F8D030', 'text' => '#000000'],
        'grass' => ['bg' => '#78C850', 'text' => '#ffffff'],
        'ice' => ['bg' => '#98D8D8', 'text' => '#000000'],
        'fighting' => ['bg' => '#C03028', 'text' => '#ffffff'],
        'poison' => ['bg' => '#A040A0', 'text' => '#ffffff'],
        'ground' => ['bg' => '#E0C068', 'text' => '#000000'],
        'flying' => ['bg' => '#A890F0', 'text' => '#ffffff'],
        'psychic' => ['bg' => '#F85888', 'text' => '#ffffff'],
        'bug' => ['bg' => '#A8B820', 'text' => '#ffffff'],
        'rock' => ['bg' => '#B8A038', 'text' => '#ffffff'],
        'ghost' => ['bg' => '#705898', 'text' => '#ffffff'],
        'dragon' => ['bg' => '#7038F8', 'text' => '#ffffff'],
        'dark' => ['bg' => '#705848', 'text' => '#ffffff'],
        'steel' => ['bg' => '#B8B8D0', 'text' => '#000000'],
        'fairy' => ['bg' => '#EE99AC', 'text' => '#000000'],
    ];
@endphp

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; width: 100%;">
    @foreach($teamPokemon as $teamMember)
        @php
            $pokemon = $teamMember->pokemon;
        @endphp
        
        @if($pokemon)
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.25rem;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}" style="width: 80px; height: 80px;">
                    
                    <div style="flex: 1;">
                        <div style="margin-bottom: 0.5rem;">
                            <span style="font-size: 0.875rem; color: #6b7280;">#{{ $pokemon->pokedex_id }}</span>
                            <h3 style="font-size: 1.125rem; font-weight: 600; text-transform: capitalize;">{{ $pokemon->name }}</h3>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem; flex-wrap: wrap;">
                            @foreach($pokemon->types as $type)
                                @php
                                    $typeLower = strtolower($type);
                                    $colors = $typeColors[$typeLower] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                                @endphp
                                <span style="padding: 0.25rem 0.75rem; font-size: 0.75rem; border-radius: 9999px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; font-weight: 500;">
                                    {{ ucfirst($type) }}
                                </span>
                            @endforeach
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.875rem;">
                            <div>
                                <span style="color: #6b7280;">HP:</span>
                                <span style="font-weight: 500;">{{ $pokemon->hp }}</span>
                            </div>
                            <div>
                                <span style="color: #6b7280;">Attack:</span>
                                <span style="font-weight: 500;">{{ $pokemon->attack }}</span>
                            </div>
                            <div>
                                <span style="color: #6b7280;">Defense:</span>
                                <span style="font-weight: 500;">{{ $pokemon->defense }}</span>
                            </div>
                            <div>
                                <span style="color: #6b7280;">Speed:</span>
                                <span style="font-weight: 500;">{{ $pokemon->speed }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

