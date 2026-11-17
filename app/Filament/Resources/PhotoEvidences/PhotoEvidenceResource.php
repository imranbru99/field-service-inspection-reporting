<?php

namespace App\Filament\Resources\PhotoEvidences;

use App\Filament\Resources\PhotoEvidences\Pages\ManagePhotoEvidences;
use App\Models\PhotoEvidence;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PhotoEvidenceResource extends Resource
{
    protected static ?string $model = PhotoEvidence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    protected static string|UnitEnum|null $navigationGroup = 'Evidence';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('photo_evidence');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('inspection_id')->relationship('inspection', 'reference')->searchable()->required(),
            Select::make('inspection_checklist_item_id')->relationship('checklistItem', 'label')->searchable()->label('Checklist item'),
            Select::make('captured_by')->relationship('capturer', 'name')->searchable(),
            TextInput::make('caption')->maxLength(200),
            TextInput::make('file_path')->required()->maxLength(255),
            TextInput::make('mime_type')->maxLength(80),
            TextInput::make('file_size_kb')->numeric()->default(0),
            TextInput::make('latitude')->numeric(),
            TextInput::make('longitude')->numeric(),
            DateTimePicker::make('captured_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inspection.reference')->label('Inspection')->searchable(),
                TextColumn::make('caption')->limit(40),
                TextColumn::make('capturer.name')->label('Captured by'),
                TextColumn::make('file_size_kb')->suffix(' KB'),
                TextColumn::make('captured_at')->dateTime()->sortable(),
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
            'index' => ManagePhotoEvidences::route('/'),
        ];
    }
}
