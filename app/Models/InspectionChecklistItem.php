<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionChecklistItem extends Model
{
    protected $fillable = [
        'inspection_id',
        'checklist_template_item_id',
        'label',
        'result',
        'is_critical',
        'notes',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_critical' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function templateItem(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplateItem::class, 'checklist_template_item_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoEvidence::class);
    }
}
