<?php

namespace App\Filament\Resources\PersonalTaskResource\Pages;

use App\Filament\Resources\PersonalTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonalTask extends CreateRecord
{
    protected static string $resource = PersonalTaskResource::class;
}
