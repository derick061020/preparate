<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LlcResource\Pages;
use App\Filament\Resources\LlcResource\RelationManagers;
use App\Models\Llc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Tables;
use App\Filament\Resources\LlcResource\Widgets\Documentos;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LlcResource extends Resource
{
    protected static ?string $model = Llc::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Información del LLC')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Datos Básicos')
                            ->schema([
                                Forms\Components\TextInput::make('business_name')
                                    ->label('Nombre del Negocio')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('business_type')
                                    ->label('Tipo de Negocio')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('business_description')
                                    ->label('Descripción del Negocio')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Ubicación')
                            ->schema([
                                Forms\Components\TextInput::make('street_address')
                                    ->label('Dirección')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->label('Ciudad')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('state')
                                    ->label('Estado')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contacto')
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->label('Correo Electrónico')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->label('Teléfono')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Tabs\Tab::make('Sistema')
                            ->schema([
                                Forms\Components\Select::make('usuario')
                                    ->label('Usuario')
                                    ->relationship('usuario', 'name')
                                    ->required()
                                    ->searchable()
                                    ->hiddenOn('edit')
                                    ->preload(),
                                Forms\Components\Select::make('estado')
                                    ->label('Estado del Proceso')
                                    ->options([
                                        'pendiente' => 'Pendiente',
                                        'completado' => 'Completado',
                                        'en_proceso' => 'En Proceso',
                                        'cancelado' => 'Cancelado',
                                    ])
                                    ->required()
                                    ->columnSpanFull()
                                    ->default('pendiente'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business_name')
                    ->label('Nombre del Negocio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('business_type')
                    ->label('Tipo de Negocio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ciudad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado del Proceso')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'pendiente' => 'warning',
                            'completado' => 'success',
                            'en_proceso' => 'primary',
                            'cancelado' => 'danger',
                            default => 'gray',
                        };
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('street_address')
                    ->label('Dirección')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->options([
                        'AL' => 'Alabama',
                        'AK' => 'Alaska',
                        'AZ' => 'Arizona',
                        'AR' => 'Arkansas',
                        'CA' => 'California',
                        'CO' => 'Colorado',
                        'CT' => 'Connecticut',
                        'DE' => 'Delaware',
                        'FL' => 'Florida',
                        'GA' => 'Georgia',
                        'HI' => 'Hawaii',
                        'ID' => 'Idaho',
                        'IL' => 'Illinois',
                        'IN' => 'Indiana',
                        'IA' => 'Iowa',
                        'KS' => 'Kansas',
                        'KY' => 'Kentucky',
                        'LA' => 'Louisiana',
                        'ME' => 'Maine',
                        'MD' => 'Maryland',
                        'MA' => 'Massachusetts',
                        'MI' => 'Michigan',
                        'MN' => 'Minnesota',
                        'MS' => 'Mississippi',
                        'MO' => 'Missouri',
                        'MT' => 'Montana',
                        'NE' => 'Nebraska',
                        'NV' => 'Nevada',
                        'NH' => 'New Hampshire',
                        'NJ' => 'New Jersey',
                        'NM' => 'New Mexico',
                        'NY' => 'New York',
                        'NC' => 'North Carolina',
                        'ND' => 'North Dakota',
                        'OH' => 'Ohio',
                        'OK' => 'Oklahoma',
                        'OR' => 'Oregon',
                        'PA' => 'Pennsylvania',
                        'RI' => 'Rhode Island',
                        'SC' => 'South Carolina',
                        'SD' => 'South Dakota',
                        'TN' => 'Tennessee',
                        'TX' => 'Texas',
                        'UT' => 'Utah',
                        'VT' => 'Vermont',
                        'VA' => 'Virginia',
                        'WA' => 'Washington',
                        'WV' => 'West Virginia',
                        'WI' => 'Wisconsin',
                        'WY' => 'Wyoming',
                    ]),
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado del Proceso')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'completado' => 'Completado',
                        'en_proceso' => 'En Proceso',
                        'cancelado' => 'Cancelado',
                    ]),
                Tables\Filters\SelectFilter::make('usuario')
                    ->label('Usuario')
                    ->relationship('usuario', 'name'),
                DateRangeFilter::make('created_at')
                    ->label('Fecha de Creación'),
                /*Tables\Filters\SelectFilter::make('antiguedad')
                    ->label('Antigüedad')
                    ->options([
                        '1' => 'Menos de 1 año',
                        '2' => '1-2 años',
                        '3' => '2-3 años',
                        '4' => 'Más de 3 años',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $years = $data['antiguedad'] ?? null;
                        
                        if ($years) {
                            $query->whereRaw("DATEDIFF(NOW(), created_at) >= ?", [($years - 1) * 365])
                                ->whereRaw("DATEDIFF(NOW(), created_at) < ?", [$years * 365]);
                        }
                        
                        return $query;
                    }),*/
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('change_status')
                    ->label('Cambiar Estado')
                    ->form([
                        Forms\Components\Select::make('estado')
                            ->label('Nuevo Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'completado' => 'Completado',
                                'en_proceso' => 'En Proceso',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required(),
                    ])
                    ->action(function (Llc $record, array $data): void {
                        $record->update([
                            'estado' => $data['estado'],
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getWidgets(): array
    {
        return [
            Documentos::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLlcs::route('/'),
            'create' => Pages\CreateLlc::route('/create'),
            'edit' => Pages\EditLlc::route('/{record}/edit'),
        ];
    }
}
