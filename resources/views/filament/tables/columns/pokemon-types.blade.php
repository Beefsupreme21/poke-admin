@php
    $types = $getState();
    
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

<div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
    @foreach($types as $type)
        @php
            $typeLower = strtolower($type);
            $colors = $typeColors[$typeLower] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
        @endphp
        <span style="padding: 0.25rem 0.75rem; font-size: 0.75rem; border-radius: 9999px; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; font-weight: 500;">
            {{ ucfirst($type) }}
        </span>
    @endforeach
</div>

