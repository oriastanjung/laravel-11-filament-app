<?php

namespace App\Filament\Resources\PersonalTaskResource\Pages;

use App\Filament\Resources\PersonalTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalTask extends EditRecord
{
    protected static string $resource = PersonalTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
