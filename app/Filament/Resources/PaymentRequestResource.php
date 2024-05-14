<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentRequestResource\Pages;
use App\Filament\Resources\PaymentRequestResource\RelationManagers;
use App\Models\PaymentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentRequestResource extends Resource
{
    protected static ?string $model = PaymentRequest::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Subscription Payment Lists';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('status')
                    ->required(),
                Forms\Components\Textarea::make('details')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('user.name')
                ->searchable()->label('Member')
                ->sortable(),
            Tables\Columns\TextColumn::make('user.uid')
                ->searchable()->label('Member ID')
                ->sortable(),
            Tables\Columns\TextColumn::make('user.subDistrict.e_name')
                ->searchable()
                ->sortable()->label('Upazila'),
            Tables\Columns\TextColumn::make('user.subDistrict.district.e_name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('user.phone')
                ->searchable()->label('Phone')
                ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([SelectFilter::make('district')
                    ->relationship('user.subDistrict.district', 'e_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('upazila')
                    ->relationship('user.subDistrict', 'e_name')
                    ->searchable()
                    ->preload()
                
            ], layout: FiltersLayout::AboveContent)
            ->actions([Tables\Actions\Action::make('receipt')->button()->color('info'),
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
            'index' => Pages\ListPaymentRequests::route('/'),
            'create' => Pages\CreatePaymentRequest::route('/create'),
            'view' => Pages\ViewPaymentRequest::route('/{record}'),
            'edit' => Pages\EditPaymentRequest::route('/{record}/edit'),
        ];
    }
}
