<?php

namespace App\Filament\Resources\WorkSummaries\Pages;

use App\Filament\Resources\WorkSummaries\WorkSummaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkSummaries extends ManageRecords
{
    protected static string $resource = WorkSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
