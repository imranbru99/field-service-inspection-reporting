<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistTemplateItem extends Model
{
    protected $fillable = [
        'checklist_template_id',
        'sort_order',
        'label',
        'item_type',
        'requires_photo',
        'is_critical',
        'guidance',
    ];

    protected function casts(): array
    {
        return [
            'requires_photo' => 'boolean',
            'is_critical' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }
}
