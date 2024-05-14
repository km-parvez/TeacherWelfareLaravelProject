<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Subs extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationParentItem = 'Reports';
    protected static ?string $navigationGroup = 'Report';
    protected static string $view = 'filament.pages.subs';
    protected static ?string $title = 'Subscription Payment Report';
    protected static ?string $navigationLabel = 'Subscription Payment Report';
}
