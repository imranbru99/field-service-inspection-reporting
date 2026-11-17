<?php

namespace App\Filament\Resources\PhotoEvidences\Pages;

use App\Filament\Resources\PhotoEvidences\PhotoEvidenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePhotoEvidences extends ManageRecords
{
    protected static string $resource = PhotoEvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
