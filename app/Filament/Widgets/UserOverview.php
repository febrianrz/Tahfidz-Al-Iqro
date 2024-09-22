<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\WaliSantri;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Santri', 'students')
                ->value(Student::count())
                ->icon('heroicon-s-users'),
            Stat::make('Total Halaqoh', 'teachers')
                ->value(Teacher::count())
                ->icon('heroicon-s-user-group'),
            Stat::make('Total Wali Santri', 'parents')
                ->value(WaliSantri::count())
                ->icon('heroicon-s-user'),
        ];
    }
}
