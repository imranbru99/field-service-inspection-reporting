<?php

namespace App\Filament\Resources\PdfReports\Pages;

use App\Filament\Resources\PdfReports\PdfReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePdfReports extends ManageRecords
{
    protected static string $resource = PdfReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
