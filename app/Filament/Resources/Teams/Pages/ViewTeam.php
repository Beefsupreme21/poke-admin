<?php

namespace App\Filament\Resources\Teams\Pages;

use App\Filament\Resources\Teams\TeamResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTeam extends ViewRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->url(fn () => route('filament.admin.pages.team-builder', ['team' => $this->record->id])),
        ];
    }
    
    public function getTitle(): string
    {
        return $this->record->name;
    }
    
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
