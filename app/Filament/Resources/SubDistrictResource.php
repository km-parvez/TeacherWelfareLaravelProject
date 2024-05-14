<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubDistrictResource\Pages;
use App\Filament\Resources\SubDistrictResource\RelationManagers;
use App\Models\SubDistrict;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubDistrictResource extends Resource
{
    protected static ?string $model = SubDistrict::class;
    protected static ?string $navigationGroup = 'Settings';
    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $title = 'Upazila';
    protected static ?string $navigationLabel = 'Upazila';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('district_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('e_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('b_name')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('district.e_name')
                    ->sortable()->label('District'),
                Tables\Columns\TextColumn::make('district.b_name')
                    ->sortable()->label('জেলা'),
                Tables\Columns\TextColumn::make('e_name')
                    ->searchable()->label('Name'),
                Tables\Columns\TextColumn::make('b_name')
                    ->searchable()->label('নাম'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSubDistricts::route('/'),
            'create' => Pages\CreateSubDistrict::route('/create'),
            'view' => Pages\ViewSubDistrict::route('/{record}'),
            'edit' => Pages\EditSubDistrict::route('/{record}/edit'),
        ];
    }
}
