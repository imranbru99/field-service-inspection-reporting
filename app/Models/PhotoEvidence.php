<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoEvidence extends Model
{
    protected $table = 'photo_evidences';

    protected $fillable = [
        'inspection_id',
        'inspection_checklist_item_id',
        'captured_by',
        'caption',
        'file_path',
        'mime_type',
        'file_size_kb',
        'latitude',
        'longitude',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'file_size_kb' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'captured_at' => 'datetime',
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(InspectionChecklistItem::class, 'inspection_checklist_item_id');
    }

    public function capturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captured_by');
    }
}
