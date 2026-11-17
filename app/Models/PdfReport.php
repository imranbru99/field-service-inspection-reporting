<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfReport extends Model
{
    protected $fillable = [
        'inspection_id',
        'work_order_id',
        'generated_by',
        'title',
        'slug',
        'status',
        'locale',
        'page_count',
        'file_path',
        'summary',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'page_count' => 'integer',
            'generated_at' => 'datetime',
        ];
    }

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
