<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-c-view-columns';

    protected static ?string $navigationGroup = 'Configuración';
    protected static ?string $modelLabel = 'Planes';
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre del Plan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('precio')
                            ->label('Precio')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(999999999)
                            ->step(0.01)
                            ->prefix('$'),

                        Forms\Components\Repeater::make('descripcion')
                            ->label('Descripción')
                            ->schema([
                                Forms\Components\Textarea::make('contenido')
                                    ->label('Item')
                                    ->required()
                                    ->maxLength(65535),
                            ])
                            ->minItems(1)
                            ->defaultItems(1),

                        Forms\Components\Repeater::make('documentos')
                            ->label('Documentos Incluidos')
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre del Documento')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('descripcion')
                                    ->label('Descripción del Documento')
                                    ->required()
                                    ->maxLength(65535),
                            ])
                            ->minItems(1)
                            ->defaultItems(1),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),

                Tables\Columns\TextColumn::make('precio')
                    ->label('Precio')
                    ->money('usd')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }    
}
