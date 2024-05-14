<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Grant extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationParentItem = 'Reports';
    protected static ?string $navigationGroup = 'Report';
    protected static string $view = 'filament.pages.grant';
    protected static ?string $title = 'Grant Report';
    protected static ?string $navigationLabel = 'Grant Report';
}
