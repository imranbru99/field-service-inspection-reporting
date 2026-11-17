<?php

namespace App\Services;

use App\Models\Inspection;
use App\Models\PdfReport;
use App\Models\WorkSummary;
use Illuminate\Support\Str;

class InspectionReportService
{
    public function generatePdf(Inspection $inspection, ?int $generatedBy = null): PdfReport
    {
        $inspection->loadMissing(['workOrder.customer', 'workOrder.site', 'checklistItems', 'photos']);

        $title = 'Inspection Report — '.$inspection->reference;
        $slug = Str::slug($title).'-'.Str::lower(Str::random(4));

        return PdfReport::query()->create([
            'inspection_id' => $inspection->id,
            'work_order_id' => $inspection->work_order_id,
            'generated_by' => $generatedBy ?? $inspection->technician_id,
            'title' => $title,
            'slug' => $slug,
            'status' => 'ready',
            'locale' => 'en',
            'page_count' => max(2, 1 + (int) ceil($inspection->photos->count() / 4)),
            'file_path' => 'reports/'.$slug.'.pdf',
            'summary' => sprintf(
                'Pass rate %s%% across %d checklist items with %d photo evidence files.',
                $inspection->pass_rate,
                $inspection->checklistItems->count(),
                $inspection->photos->count()
            ),
            'generated_at' => now(),
        ]);
    }

    public function generateCustomerSummary(Inspection $inspection, ?int $authoredBy = null): WorkSummary
    {
        $inspection->loadMissing(['workOrder.customer', 'findings', 'photos']);

        return WorkSummary::query()->create([
            'inspection_id' => $inspection->id,
            'work_order_id' => $inspection->work_order_id,
            'customer_id' => $inspection->workOrder?->customer_id,
            'authored_by' => $authoredBy ?? $inspection->technician_id,
            'title' => 'Work Summary — '.$inspection->reference,
            'status' => 'ready',
            'headline' => $inspection->outcome === 'passed'
                ? 'Inspection completed successfully'
                : 'Inspection completed with findings',
            'body' => $inspection->notes
                ?: 'Technician completed the field checklist and attached supporting photo evidence.',
            'recommendations' => $inspection->findings->pluck('recommendation')->filter()->implode("\n")
                ?: 'No urgent follow-up recommended.',
            'photo_count' => $inspection->photos->count(),
            'published_at' => now(),
        ]);
    }
}
