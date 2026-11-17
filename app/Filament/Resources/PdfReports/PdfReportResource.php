<?php

namespace App\Filament\Resources\PdfReports;

use App\Filament\Resources\PdfReports\Pages\ManagePdfReports;
use App\Models\PdfReport;
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

class PdfReportResource extends Resource
{
    protected static ?string $model = PdfReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Reporting';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('pdf_reports');
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
            Select::make('generated_by')->relationship('generator', 'name')->searchable(),
            TextInput::make('title')->required()->maxLength(200),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(200),
            Select::make('status')->options([
                'draft' => 'Draft',
                'ready' => 'Ready',
                'sent' => 'Sent',
            ])->required()->default('draft'),
            TextInput::make('locale')->default('en')->maxLength(10),
            TextInput::make('page_count')->numeric()->default(1),
            TextInput::make('file_path')->maxLength(255),
            Textarea::make('summary')->columnSpanFull(),
            DateTimePicker::make('generated_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('inspection.reference')->label('Inspection'),
                TextColumn::make('status')->badge(),
                TextColumn::make('locale')->badge(),
                TextColumn::make('page_count')->label('Pages'),
                TextColumn::make('generated_at')->dateTime()->sortable(),
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
            'index' => ManagePdfReports::route('/'),
        ];
    }
}
