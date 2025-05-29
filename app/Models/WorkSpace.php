<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkSpace extends Model
{
    protected $table = 'workspaces';

    protected $fillable = [
        'name',
        'category_id',
        'type',
        'description',
        'hourly_rate',
        'daily_rate',
        'is_available',
        'image'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Get the category that owns the workspace.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkSpaceCategory::class, 'category_id');
    }

    /**
     * Get the bookings for this workspace
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
