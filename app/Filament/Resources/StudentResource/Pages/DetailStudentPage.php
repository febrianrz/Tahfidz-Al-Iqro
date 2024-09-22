<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use App\Filament\Resources\StudentResource;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

;

class DetailStudentPage extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected static ?string $title = 'Detail Santri';

    protected function getHeaderActions(): array
    {
        return [
            // Tambahkan aksi header jika diperlukan
        ];
    }

    protected function getViewData(): array
    {
        return [
            'data' => [],
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Data Santri')
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('born_at'),
                            TextEntry::make('gender'),
                            TextEntry::make('address'),
                            TextEntry::make('status'),
                            ImageEntry::make('photo'),
                        ])->columns(2),
                    Tabs\Tab::make('Report Hafalan')
                        ->schema([
                            
                        ]),
                    Tabs\Tab::make('Grafik')
                        ->schema([
                            // ...
                        ]),
                ])
            ])->columns(1);
    }
}
