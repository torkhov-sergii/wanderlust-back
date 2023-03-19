<?php

namespace App\Filament\Resources\PolygonResource\Pages;

use App\Filament\Resources\PolygonResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolygons extends ListRecords
{
    protected static string $resource = PolygonResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
