<?php

namespace App\Filament\Resources\LlcResource\Widgets;

use App\Models\DocumentoRequerido;
use App\Models\Llc;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Storage;

class Documentos extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public ?Llc $record = null;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                DocumentoRequerido::where('llc_id', $this->record->id)
            )
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->label('Nuevo Documento')
                    ->modalHeading('Crear Nuevo Documento')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Crear')
                    ->form([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (array $data) {
                        $data['llc_id'] = $this->record->id;
                        DocumentoRequerido::create($data);
                    }),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'subido',
                        'danger' => 'rechazado',
                    ])
                    ->default('warning'),
                Tables\Columns\TextColumn::make('archivo')
                    ->label('Archivo')
                    ->formatStateUsing(function (string $state, DocumentoRequerido $record) {
                        return $record->estado !== 'pendiente' ? 
                            Tables\Actions\Action::make('download')
                                ->label('Descargar')
                                ->url('/storage/' . $record->archivo, '_blank')
                                ->color('success')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->visible($record->archivo !== null) : 
                            null;
                    })
                    ->default(null),
            ]);
    }
}
