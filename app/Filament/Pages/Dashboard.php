<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.pages.dashboard';


    public function getTitle(): string|Htmlable
    {
        return 'Welcomes';   
    }
        
    

    public function panel(Panel $panel): Panel
    {
        return $panel->pages([]);
    }
}
