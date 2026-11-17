<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    protected $fillable = [
        'reference',
        'work_order_id',
        'technician_id',
        'checklist_template_id',
        'status',
        'outcome',
        'pass_rate',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'pass_rate' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function checklistTemplate(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class);
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(InspectionChecklistItem::class)->orderBy('sort_order');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoEvidence::class);
    }

    public function findings(): HasMany
    {
        return $this->hasMany(InspectionFinding::class);
    }

    public function pdfReports(): HasMany
    {
        return $this->hasMany(PdfReport::class);
    }

    public function workSummaries(): HasMany
    {
        return $this->hasMany(WorkSummary::class);
    }
}
