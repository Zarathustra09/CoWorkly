<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class GroupChatMessage extends Model
    {
        protected $fillable = [
            'group_chat_id',
            'user_id',
            'message',
            'is_read',
        ];

        protected $casts = [
            'is_read' => 'boolean',
        ];

        /**
         * Get the group chat that owns the message.
         */
        public function groupChat(): BelongsTo
        {
            return $this->belongsTo(GroupChat::class);
        }

        /**
         * Get the user who sent the message.
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
    }
