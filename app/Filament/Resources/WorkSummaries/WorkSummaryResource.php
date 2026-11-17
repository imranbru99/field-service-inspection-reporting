<?php

namespace App\Filament\Resources\WorkSummaries;

use App\Filament\Resources\WorkSummaries\Pages\ManageWorkSummaries;
use App\Models\WorkSummary;
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
use Filament\Tables\Table;
use UnitEnum;

class WorkSummaryResource extends Resource
{
    protected static ?string $model = WorkSummary::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Reporting';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('customer_summaries');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('inspection_id')->relationship('inspection', 'reference')->searchable()->required(),
            Select::make('work_order_id')->relationship('workOrder', 'number')->searchable(),
            Select::make('customer_id')->relationship('customer', 'name')->searchable(),
            Select::make('authored_by')->relationship('author', 'name')->searchable(),
            TextInput::make('title')->required()->maxLength(200),
            Select::make('status')->options([
                'draft' => 'Draft',
                'ready' => 'Ready',
                'sent' => 'Sent',
            ])->required()->default('draft'),
            TextInput::make('headline')->maxLength(200),
            Textarea::make('body')->columnSpanFull(),
            Textarea::make('recommendations')->columnSpanFull(),
            TextInput::make('photo_count')->numeric()->default(0),
            DateTimePicker::make('published_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('status')->badge(),
                TextColumn::make('photo_count')->label('Photos'),
                TextColumn::make('published_at')->dateTime()->sortable(),
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
            'index' => ManageWorkSummaries::route('/'),
        ];
    }
}
