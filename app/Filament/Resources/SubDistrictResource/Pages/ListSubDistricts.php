<?php

namespace App\Filament\Resources\SubDistrictResource\Pages;

use App\Filament\Resources\SubDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubDistricts extends ListRecords
{
    protected static string $resource = SubDistrictResource::class;
    protected static ?string $title = 'Upazila';
    protected static ?string $navigationLabel = 'Upazila Lists';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
