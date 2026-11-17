<?php

namespace App\Filament\Widgets;

use App\Models\WorkOrder;
use App\Services\ModuleManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OpenWorkOrdersWidget extends TableWidget
{
    protected static ?string $heading = 'Open work orders';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return app(ModuleManager::class)->enabled('work_orders');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WorkOrder::query()
                    ->with(['customer', 'technician'])
                    ->whereIn('status', ['open', 'assigned', 'in_progress'])
                    ->latest('due_at')
            )
            ->columns([
                TextColumn::make('number')->label('WO #')->searchable(),
                TextColumn::make('title')->limit(40),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('technician.name')->label('Technician')->placeholder('Unassigned'),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('due_at')->dateTime()->sortable(),
            ])
            ->paginated([5, 10]);
    }
}
