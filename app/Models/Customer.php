<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'contact_name',
        'email',
        'phone',
        'industry',
        'status',
        'notes',
    ];

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function workSummaries(): HasMany
    {
        return $this->hasMany(WorkSummary::class);
    }
}
