<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupChatUser extends Pivot
{
    protected $table = 'group_chat_users';

    protected $fillable = [
        'group_chat_id',
        'user_id',
        'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Get the group chat that this user belongs to.
     */
    public function groupChat(): BelongsTo
    {
        return $this->belongsTo(GroupChat::class);
    }

    /**
     * Get the user who is in this group chat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
