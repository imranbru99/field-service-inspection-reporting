<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkSummary extends Model
{
    protected $fillable = [
        'inspection_id',
        'work_order_id',
        'customer_id',
        'authored_by',
        'title',
        'status',
        'headline',
        'body',
        'recommendations',
        'photo_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'photo_count' => 'integer',
            'published_at' => 'datetime',
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authored_by');
    }
}
