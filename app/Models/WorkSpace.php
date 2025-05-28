<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkSpace extends Model
{
    protected $table = 'workspaces';

    protected $fillable = [
        'name',
        'category_id',
        'type',
        'description',
        'capacity',
        'location',
        'amenities',
        'hourly_rate',
        'daily_rate',
        'is_available',
        'is_premium',
        'images',
        'equipment',
        'accessibility_features'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'equipment' => 'array',
        'accessibility_features' => 'array',
        'is_available' => 'boolean',
        'is_premium' => 'boolean',
    ];

    /**
     * Get the category that owns the workspace.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkSpaceCategory::class, 'category_id');
    }
}
