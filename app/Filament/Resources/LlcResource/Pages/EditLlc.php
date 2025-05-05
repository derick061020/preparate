<?php

namespace App\Filament\Resources\LlcResource\Pages;

use App\Filament\Resources\LlcResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\LlcResource\Widgets\Documentos;

class EditLlc extends EditRecord
{
    protected static string $resource = LlcResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Documentos::class,
        ];
    }
}
