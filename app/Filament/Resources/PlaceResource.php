<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Filament\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('types'),

//                Forms\Components\TextInput::make('place_id')
//                    ->maxLength(255),
                Forms\Components\TextInput::make('rating'),
                Forms\Components\TextInput::make('ratings_total'),

//                Forms\Components\TextInput::make('lat')
//                    ->required(),
//                Forms\Components\TextInput::make('lon')
//                    ->required(),

                Forms\Components\Fieldset::make('Coordinates')
                    ->schema([
                        Forms\Components\TextInput::make('lat')
                            ->required()
                            ->placeholder('50.0000'),
                        Forms\Components\TextInput::make('lon')
                            ->required()
                            ->placeholder('10.0000'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
//                Tables\Columns\TextColumn::make('place_id'),
                Tables\Columns\TextColumn::make('rating'),
                Tables\Columns\TextColumn::make('ratings_total'),
//                Tables\Columns\TextColumn::make('types'),
//                Tables\Columns\TextColumn::make('lat'),
//                Tables\Columns\TextColumn::make('lon'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePlaces::route('/'),
        ];
    }
}
