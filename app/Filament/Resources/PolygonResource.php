<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolygonResource\Pages;
use App\Filament\Resources\PolygonResource\RelationManagers;
use App\Models\Polygon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolygonResource extends Resource
{
    protected static ?string $model = Polygon::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Heading')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Label 1')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                            ]),
                        Forms\Components\Tabs\Tab::make('Label 2')
                            ->schema([
                                Forms\Components\TextInput::make('lat')
                            ]),
                        Forms\Components\Tabs\Tab::make('Label 3')
                            ->schema([
                                Forms\Components\TextInput::make('lon')
                            ]),
                    ]),

                Forms\Components\Grid::make(4)
                    ->schema([
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\TextInput::make('title')->columnSpan(2),
                        Forms\Components\TextInput::make('title')->columnSpan('full')
                        // ...
                    ]),

                Forms\Components\Fieldset::make('555')
                    ->schema([
                        Forms\Components\TextInput::make('lat')
                            ->required()
                            ->placeholder('50.0000'),
                        Forms\Components\TextInput::make('lon')
                            ->required()
                            ->placeholder('10.0000'),
                    ]),

                Forms\Components\Card::make()->columns(2)->schema([
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\TextInput::make('title')
                    // ...
                ]),

                Forms\Components\Section::make('Heading')
                    ->description('Description')
                    ->columns(4)
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\TextInput::make('title')
                    ]),


                Forms\Components\TextInput::make('title')
                    ->required(),
//                Forms\Components\TextInput::make('parent_id')
//                    ->disabled()
//                    ->default(null),
//                Forms\Components\TextInput::make('depth')
//                    ->disabled()
//                    ->default(0),
                Forms\Components\TextInput::make('radius')
                    ->required()
                    ->placeholder('5000')
                    ->helperText('Метров (внимание, может быть много точек)'),
                Forms\Components\TextInput::make('lat')
                    ->required()
                    ->placeholder('50.0000'),
                Forms\Components\TextInput::make('lon')
                    ->required()
                    ->placeholder('10.0000'),
                Forms\Components\Toggle::make('disabled'),
                Forms\Components\Repeater::make('types')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('done')
                    ])
//                    ->disableItemCreation()
//                    ->disableItemDeletion()
                    ->collapsible(),

                Forms\Components\MultiSelect::make('types2')
                    ->relationship('types', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent_id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('depth'),
                Tables\Columns\TextColumn::make('lat'),
                Tables\Columns\TextColumn::make('lon'),
                Tables\Columns\TextColumn::make('radius'),
                Tables\Columns\BooleanColumn::make('disabled'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TypesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolygons::route('/'),
            'create' => Pages\CreatePolygon::route('/create'),
            'edit' => Pages\EditPolygon::route('/{record}/edit'),
        ];
    }
}
