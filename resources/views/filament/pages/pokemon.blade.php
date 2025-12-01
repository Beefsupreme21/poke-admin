<x-filament-panels::page>
    <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 rounded-xl">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
                    <th class="px-4 py-3 text-left text-sm font-semibold">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Types</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($pokemonList as $pokemon)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3">
                            <img src="{{ $pokemon['sprites']['front_default'] }}" alt="{{ $pokemon['name'] }}" class="w-16 h-16">
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $pokemon['id'] }}</td>
                        <td class="px-4 py-3 text-sm font-medium capitalize">{{ $pokemon['name'] }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                @if(isset($pokemon['types']) && is_array($pokemon['types']))
                                    @foreach($pokemon['types'] as $type)
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ ucfirst($type['type']['name']) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
