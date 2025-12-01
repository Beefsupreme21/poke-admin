<?php

namespace App\Filament\Pages;

use App\Models\Pokemon;
use App\Models\Team;
use App\Models\TeamPokemon;
use BackedEnum;
use Filament\Actions\Action as PageAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Computed;

class TeamBuilder extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected string $view = 'filament.pages.team-builder';
    
    protected static ?string $navigationLabel = 'Build Team';
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    
    protected static ?int $navigationSort = 3;
    
    public ?int $teamId = null;
    
    public string $teamName = '';
    
    public array $selectedPokemon = [null, null, null, null, null, null];
    
    public function mount(): void
    {
        $teamId = request()->query('team');
        
        if ($teamId) {
            $team = Team::with('pokemon')->find($teamId);
            
            if ($team && $team->user_id === auth()->id()) {
                $this->teamId = $team->id;
                $this->teamName = $team->name;
                
                foreach ($team->pokemon as $teamPokemon) {
                    $position = $teamPokemon->position - 1;
                    if ($position >= 0 && $position < 6) {
                        $this->selectedPokemon[$position] = $teamPokemon->pokemon_id;
                    }
                }
            }
        }
    }
    
    protected function getHeaderActions(): array
    {
        return [
            PageAction::make('save')
                ->label('Save Team')
                ->action('saveTeam'),
        ];
    }
    
    public function getBreadcrumbs(): array
    {
        return [];
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Pokemon::query())
            ->columns([
                ImageColumn::make('sprite_url')
                    ->label('Image')
                    ->size(60),
                TextColumn::make('pokedex_id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                TextColumn::make('types')
                    ->view('filament.tables.columns.pokemon-types')
                    ->searchable(query: function ($query, $search) {
                        return $query->where('types', 'like', '%' . strtolower($search) . '%');
                    }),
                TextColumn::make('hp')
                    ->label('HP')
                    ->sortable(),
                TextColumn::make('attack')
                    ->label('Attack')
                    ->sortable(),
                TextColumn::make('defense')
                    ->label('Defense')
                    ->sortable(),
                TextColumn::make('speed')
                    ->label('Speed')
                    ->sortable(),
            ])
            ->defaultSort('pokedex_id')
            ->recordAction(null)
            ->recordUrl(null)
            ->recordActions([
                Action::make('add')
                    ->label('Add to Team')
                    ->icon('heroicon-o-plus')
                    ->action(fn (Pokemon $record) => $this->addPokemon($record->id)),
            ])
            ->paginated([10, 25, 50]);
    }
    
    public function addPokemon(int $pokemonId): void
    {
        // Find first empty slot
        $emptySlot = array_search(null, $this->selectedPokemon);
        
        if ($emptySlot === false) {
            Notification::make()
                ->warning()
                ->title('Team is full')
                ->body('You can only have 6 Pokémon in a team.')
                ->send();
            return;
        }
        
        // Check if already in team
        if (in_array($pokemonId, $this->selectedPokemon)) {
            Notification::make()
                ->warning()
                ->title('Already in team')
                ->body('This Pokémon is already in your team.')
                ->send();
            return;
        }
        
        $this->selectedPokemon[$emptySlot] = $pokemonId;
        
        $pokemon = Pokemon::find($pokemonId);
        if ($pokemon) {
            Notification::make()
                ->success()
                ->title(ucfirst($pokemon->name) . ' added!')
                ->body('Successfully added to your team.')
                ->send();
        }
    }
    
    public function removePokemon(int $slot): void
    {
        $this->selectedPokemon[$slot] = null;
    }
    
    public function saveTeam(): void
    {
        if (empty($this->teamName)) {
            Notification::make()
                ->danger()
                ->title('Team name required')
                ->body('Please enter a name for your team.')
                ->send();
            return;
        }
        
        $pokemonCount = count(array_filter($this->selectedPokemon));
        
        if ($pokemonCount === 0) {
            Notification::make()
                ->danger()
                ->title('No Pokémon selected')
                ->body('Please select at least one Pokémon for your team.')
                ->send();
            return;
        }
        
        if ($this->teamId) {
            // Update existing team
            $team = Team::find($this->teamId);
            
            if ($team && $team->user_id === auth()->id()) {
                $team->update(['name' => $this->teamName]);
                
                // Delete old pokemon
                $team->pokemon()->delete();
                
                // Add new pokemon
                foreach ($this->selectedPokemon as $position => $pokemonId) {
                    if ($pokemonId) {
                        TeamPokemon::create([
                            'team_id' => $team->id,
                            'pokemon_id' => $pokemonId,
                            'position' => $position + 1,
                        ]);
                    }
                }
                
                Notification::make()
                    ->success()
                    ->title('Team updated!')
                    ->body("Your team '{$this->teamName}' has been updated.")
                    ->send();
            }
        } else {
            // Create new team
            $team = Team::create([
                'name' => $this->teamName,
                'user_id' => auth()->id(),
            ]);
            
            foreach ($this->selectedPokemon as $position => $pokemonId) {
                if ($pokemonId) {
                    TeamPokemon::create([
                        'team_id' => $team->id,
                        'pokemon_id' => $pokemonId,
                        'position' => $position + 1,
                    ]);
                }
            }
            
            Notification::make()
                ->success()
                ->title('Team created!')
                ->body("Your team '{$this->teamName}' has been saved.")
                ->send();
        }
        
        // Reset form
        $this->teamId = null;
        $this->teamName = '';
        $this->selectedPokemon = [null, null, null, null, null, null];
        
        $this->redirect(route('filament.admin.resources.teams.index'));
    }
    
    #[Computed]
    public function teamPokemon()
    {
        $ids = array_filter($this->selectedPokemon);
        if (empty($ids)) {
            return collect();
        }
        return Pokemon::whereIn('id', $ids)->get()->keyBy('id');
    }
}
