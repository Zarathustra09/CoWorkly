<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkSpaceCategory extends Model
{
    protected $table = 'workspace_categories';

    protected $fillable = [
        'name',
        'description',
        'icon'
    ];

    /**
     * Get the workspaces for the category.
     */
    public function workspaces(): HasMany
    {
        return $this->hasMany(WorkSpace::class, 'category_id');
    }
}
