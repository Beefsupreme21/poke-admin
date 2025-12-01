<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Team Name Input -->
        <x-filament::section>
            <x-slot name="heading">
                Team Information
            </x-slot>
            
            <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model="teamName"
                    placeholder="Enter your team name..."
                />
            </x-filament::input.wrapper>
        </x-filament::section>

        <!-- Team Slots -->
        <x-filament::section>
            <x-slot name="heading">
                Your Team ({{ count(array_filter($selectedPokemon)) }}/6)
            </x-slot>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; padding: 2rem 0; text-align: center;">
                @foreach($selectedPokemon as $index => $pokemonId)
                    <div style="width: 150px; height: 150px; flex-shrink: 0; border: 1px solid #d1d5db; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer;"
                         @if($pokemonId) wire:click="removePokemon({{ $index }})" @endif>
                        @if($pokemonId && $this->teamPokemon->has($pokemonId))
                            @php
                                $pokemon = $this->teamPokemon[$pokemonId];
                            @endphp
                            <div style="text-align: center;">
                                <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}" style="width: 80px; height: 80px; margin: 0 auto;">
                                <div style="font-size: 0.75rem; font-weight: 500; text-transform: capitalize; margin-top: 0.25rem;">{{ $pokemon->name }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">Click to remove</div>
                            </div>
                        @else
                            <div style="text-align: center; color: #9ca3af;">
                                <div style="font-size: 2.25rem; margin-bottom: 0.5rem;">+</div>
                                <div style="font-size: 0.75rem;">Empty Slot</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        <!-- Available Pokémon -->
        <x-filament::section>
            <x-slot name="heading">
                Available Pokémon
            </x-slot>
            
            {{ $this->table }}
        </x-filament::section>
    </div>
</x-filament-panels::page>
