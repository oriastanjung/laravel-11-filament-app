<?php

namespace App\Filament\Resources\PersonalTaskResource\Pages;

use App\Filament\Resources\PersonalTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonalTasks extends ListRecords
{
    protected static string $resource = PersonalTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
