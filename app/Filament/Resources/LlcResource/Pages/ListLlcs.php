<?php

namespace App\Filament\Resources\LlcResource\Pages;

use App\Filament\Resources\LlcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLlcs extends ListRecords
{
    protected static string $resource = LlcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
