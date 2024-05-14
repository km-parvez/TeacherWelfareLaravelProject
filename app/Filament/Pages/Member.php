<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Member extends Page
{
   
    protected static ?string $navigationParentItem = 'Reports';
    protected static ?string $navigationGroup = 'Report';
    protected static string $view = 'filament.pages.member';
    protected static ?string $title = 'Member/Teachers Report';
    protected static ?string $navigationLabel = 'Member/Teachers Report';
}
