<?php

namespace App\Filament\Resources\Inspections;

use App\Filament\Resources\Inspections\Pages\ManageInspections;
use App\Models\Inspection;
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

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Inspection';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('inspections');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('reference')->required()->unique(ignoreRecord: true)->maxLength(40),
            Select::make('work_order_id')->relationship('workOrder', 'number')->searchable()->required(),
            Select::make('technician_id')->relationship('technician', 'name')->searchable(),
            Select::make('checklist_template_id')->relationship('checklistTemplate', 'name')->searchable(),
            Select::make('status')->options([
                'draft' => 'Draft',
                'in_progress' => 'In progress',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->required()->default('draft'),
            Select::make('outcome')->options([
                'passed' => 'Passed',
                'failed' => 'Failed',
                'conditional' => 'Conditional',
            ]),
            TextInput::make('pass_rate')->numeric()->minValue(0)->maxValue(100)->suffix('%'),
            DateTimePicker::make('started_at'),
            DateTimePicker::make('completed_at'),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->searchable()->sortable(),
                TextColumn::make('workOrder.number')->label('WO'),
                TextColumn::make('technician.name')->label('Technician'),
                TextColumn::make('status')->badge(),
                TextColumn::make('outcome')->badge(),
                TextColumn::make('pass_rate')->suffix('%'),
                TextColumn::make('started_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'in_progress' => 'In progress',
                    'completed' => 'Completed',
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
            'index' => ManageInspections::route('/'),
        ];
    }
}
