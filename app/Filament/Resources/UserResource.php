<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Members/Teachers';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_district_id')
                    ->required()
                    ->relationship('subDistrict','e_name'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uid')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nid')
                    ->maxLength(255),
                Forms\Components\TextInput::make('blood_group')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('father_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mother_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spouse_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('present_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('permanent_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('joining_date')
                    ->maxLength(255),
                Forms\Components\TextInput::make('prl_date')
                    ->maxLength(255),
                Forms\Components\TextInput::make('designation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('school_name')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('payscale')
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_salary_withdraw')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                // Forms\Components\DateTimePicker::make('email_verified_at'),
                // Forms\Components\TextInput::make('password')
                //     ->password()
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('two_factor_secret')
                //     ->maxLength(65535)
                //     ->columnSpanFull(),
                // Forms\Components\Textarea::make('two_factor_recovery_codes')
                //     ->maxLength(65535)
                //     ->columnSpanFull(),
                // Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
                // Forms\Components\TextInput::make('current_team_id')
                //     ->numeric(),
                Forms\Components\FileUpload::make('profile_photo_path')
                    ,
                // Forms\Components\Toggle::make('completed')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_url')
                ->circular(),
                Tables\Columns\TextColumn::make('subDistrict.district.e_name')
                    ->sortable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subDistrict.e_name')
                    ->sortable()
                    ->label('Upazila')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nid')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('father_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mother_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('spouse_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('present_address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('permanent_address')
                    // ->searchable(),
                Tables\Columns\TextColumn::make('joining_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prl_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('school_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payscale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_salary_withdraw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('current_team_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('profile_photo_path')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('completed')
                    // ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
              
                SelectFilter::make('district')
                ->preload()
                ->relationship('subDistrict.district', 'e_name')
                ->searchable(),  SelectFilter::make('upazila')
                ->preload()
                ->relationship('subDistrict', 'e_name')
                ->searchable()
            ], layout: FiltersLayout::AboveContent)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
