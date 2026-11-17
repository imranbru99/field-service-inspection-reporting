<?php

namespace App\Filament\Resources\WorkOrders;

use App\Filament\Resources\WorkOrders\Pages\ManageWorkOrders;
use App\Models\WorkOrder;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class WorkOrderResource extends Resource
{
    protected static ?string $model = WorkOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('work_orders');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('number')->required()->unique(ignoreRecord: true)->maxLength(40),
            TextInput::make('title')->required()->maxLength(200),
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->required(),
            Select::make('site_id')->relationship('site', 'name')->searchable(),
            Select::make('technician_id')->relationship('technician', 'name')->searchable(),
            Select::make('checklist_template_id')->relationship('checklistTemplate', 'name')->searchable(),
            Select::make('priority')->options([
                'low' => 'Low',
                'normal' => 'Normal',
                'high' => 'High',
                'urgent' => 'Urgent',
            ])->required()->default('normal'),
            Select::make('status')->options([
                'open' => 'Open',
                'assigned' => 'Assigned',
                'in_progress' => 'In progress',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->required()->default('open'),
            TextInput::make('service_type')->maxLength(100),
            DateTimePicker::make('scheduled_at'),
            DateTimePicker::make('due_at'),
            Textarea::make('description')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable(),
                TextColumn::make('title')->limit(36)->searchable(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('technician.name')->label('Technician')->placeholder('—'),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('due_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'open' => 'Open',
                    'assigned' => 'Assigned',
                    'in_progress' => 'In progress',
                    'completed' => 'Completed',
                ]),
                SelectFilter::make('priority')->options([
                    'low' => 'Low',
                    'normal' => 'Normal',
                    'high' => 'High',
                    'urgent' => 'Urgent',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWorkOrders::route('/'),
        ];
    }
}
