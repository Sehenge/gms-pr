<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepackCategoryResource\Pages;
use App\Filament\Resources\RepackCategoryResource\RelationManagers;
use App\Models\RepackCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RepackCategoryResource extends Resource
{
    protected static ?string $model = RepackCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                IconColumn::make('parsed')->boolean(),
            ])
            ->filters([
                SelectFilter::make('name')
                    ->options([
                        'GOG' => 'ID 78',
                        'RPG' => 'ID 79',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListRepackCategories::route('/'),
            'create' => Pages\CreateRepackCategory::route('/create'),
            'edit' => Pages\EditRepackCategory::route('/{record}/edit'),
        ];
    }
}
