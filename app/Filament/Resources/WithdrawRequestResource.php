<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawRequestResource\Pages;
use App\Filament\Resources\WithdrawRequestResource\RelationManagers;
use App\Models\WithdrawRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawRequestResource extends Resource
{
    protected static ?string $model = WithdrawRequest::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Grants List';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->required()
                ->relationship('user','name')
                ->preload(),
                Forms\Components\Select::make('status')->options([0 => 'Pending',
                1 => 'Accepted',
                2 => 'Rejected',

                ]),
                Forms\Components\Select::make('type')->options([1 => 'Medical Aid',
                2 => 'Scholarship',
                ]),
                Forms\Components\TextInput::make('amount')
                ->required()
                ->numeric(),
                Forms\Components\TextInput::make('requested_amount')
                ->required()
                ->numeric(),
                Forms\Components\TextInput::make('current_payscale')
                ->required()
                ->numeric(),
                Forms\Components\TextInput::make('total_salary_withdraw')
                ->required()
                ->numeric(),
                Forms\Components\TextInput::make('requested_for_name')
                ->required(),
                Forms\Components\DatePicker::make('requested_for_date_of_birth')
                ->required(),

                Forms\Components\Textarea::make('education_details')
                ->nullable(),
                Forms\Components\Textarea::make('disease_details')
                ->nullable(),
                Forms\Components\Textarea::make('old_scholarship_details')
                ->nullable(),
                Forms\Components\Textarea::make('latest_payment_receipt_details')
                ->nullable(),
                Forms\Components\Textarea::make('details')
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()->label('Member')
                    ->sortable()
                    ,
                Tables\Columns\TextColumn::make('user.uid')
                    ->searchable()->label('Member ID')
                    ->sortable()
                    ,
                Tables\Columns\TextColumn::make('user.subDistrict.e_name')
                    ->searchable()
                    ->sortable()->label('Upazila')
                    ,
                Tables\Columns\TextColumn::make('user.subDistrict.district.e_name')
                    ->searchable()
                    ->sortable()
                    ,
            Tables\Columns\TextColumn::make('user.phone')
                ->searchable()->label('Phone')
                ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()
                    ->sortable()
                    ,
                Tables\Columns\TextColumn::make('requested_amount')
                    ->searchable()
                    ->sortable()
                    ,
            Tables\Columns\TextColumn::make('status')->formatStateUsing(
                fn (string $state) =>
                match ((int)$state) {
                    0 => 'Pending',
                    1 => 'Accepted',

                    2 => 'Rejected',
                }
            )->searchable()->sortable(),
            Tables\Columns\TextColumn::make('type')->formatStateUsing(
                fn (string $state) =>
                match ((int)$state) {

                    1 => 'Medical Aid',
                    2 => 'Scholarship',

                }
            )->searchable()->sortable(),
                // Tables\Columns\TextColumn::make('requested_for_date_of_birth')
                //     ->dateTime('d/m/Y')
                //     ->sortable()
                //     ,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([ SelectFilter::make('district')
            ->relationship('user.subDistrict.district', 'e_name')
            ->searchable()
            ->preload(),
            SelectFilter::make('upazila')
            ->relationship('user.subDistrict', 'e_name')
            ->searchable()
            ->preload()
           
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\Action::make('accept')->button()->color('success'),
                Tables\Actions\Action::make('deny')->color('danger')->button(),
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
            'index' => Pages\ListWithdrawRequests::route('/'),
            'create' => Pages\CreateWithdrawRequest::route('/create'),
            'view' => Pages\ViewWithdrawRequest::route('/{record}'),
            'edit' => Pages\EditWithdrawRequest::route('/{record}/edit'),
        ];
    }
}
