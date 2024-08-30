<?php

namespace App\Filament\Resources\TaskKaryawanResource\Pages;

use App\Filament\Resources\TaskKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskKaryawans extends ListRecords
{
    protected static string $resource = TaskKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
