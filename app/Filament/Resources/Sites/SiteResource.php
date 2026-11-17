<?php

namespace App\Filament\Resources\Sites;

use App\Filament\Resources\Sites\Pages\ManageSites;
use App\Models\Site;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Field CRM';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('customers_sites');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->required(),
            TextInput::make('name')->required()->maxLength(150),
            TextInput::make('code')->maxLength(40),
            TextInput::make('address_line')->maxLength(200),
            TextInput::make('city')->maxLength(100),
            TextInput::make('region')->maxLength(100),
            TextInput::make('postal_code')->maxLength(20),
            TextInput::make('country')->default('BD')->maxLength(2),
            TextInput::make('latitude')->numeric(),
            TextInput::make('longitude')->numeric(),
            Textarea::make('access_notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('city')->toggleable(),
                TextColumn::make('region')->toggleable(),
                TextColumn::make('country')->toggleable(),
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
            'index' => ManageSites::route('/'),
        ];
    }
}
