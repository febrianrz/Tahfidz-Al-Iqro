<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Laporan', 'students')
                ->value(Report::count())
                ->chart([0, 100, 50, 80, 120, 30, 70, 50, 150, 140])
                ->icon('heroicon-s-users'),
        ];
    }
}
