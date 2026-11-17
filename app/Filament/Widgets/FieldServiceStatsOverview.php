<?php

namespace App\Filament\Widgets;

use App\Models\Inspection;
use App\Models\PdfReport;
use App\Models\PhotoEvidence;
use App\Models\WorkOrder;
use App\Services\ModuleManager;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FieldServiceStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $hours = app(ModuleManager::class)->weeklyHoursSaved();

        return [
            Stat::make('Open Work Orders', WorkOrder::query()->whereIn('status', ['open', 'assigned', 'in_progress'])->count())
                ->description('Active field dispatch queue')
                ->color('primary'),
            Stat::make('Inspections Today', Inspection::query()->whereDate('started_at', today())->count())
                ->description('Started on site today')
                ->color('info'),
            Stat::make('Photo Evidence', PhotoEvidence::query()->count())
                ->description('Captured field photos')
                ->color('success'),
            Stat::make('PDF Reports Ready', PdfReport::query()->where('status', 'ready')->count())
                ->description("{$hours} hrs/week estimated capacity")
                ->color('warning'),
        ];
    }
}
