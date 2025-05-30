<?php

        namespace App\Models;

        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\Relations\BelongsTo;
        use Illuminate\Database\Eloquent\Relations\BelongsToMany;
        use Illuminate\Database\Eloquent\Relations\HasMany;

        class GroupChat extends Model
        {
            protected $fillable = [
                'booking_id',
                'created_by',
                'name',
            ];

            /**
             * Get the booking associated with this group chat.
             */
            public function booking(): BelongsTo
            {
                return $this->belongsTo(Booking::class);
            }

            /**
             * Get the creator of this group chat.
             */
            public function creator(): BelongsTo
            {
                return $this->belongsTo(User::class, 'created_by');
            }

            /**
             * Get the users in this group chat.
             */
            public function users(): BelongsToMany
            {
                return $this->belongsToMany(User::class, 'group_chat_users')
                    ->withPivot('is_admin')
                    ->withTimestamps();
            }

            /**
             * Get the messages in this group chat.
             */
            public function messages(): HasMany
            {
                return $this->hasMany(GroupChatMessage::class);
            }

            /**
             * Check if a user is in this group chat.
             */
            public function hasUser(User $user): bool
            {
                return $this->users()->where('user_id', $user->id)->exists();
            }

            /**
             * Check if a user is an admin in this group chat.
             */
            public function isAdmin(User $user): bool
            {
                $chatUser = $this->users()->where('user_id', $user->id)->first();
                return $chatUser && $chatUser->pivot->is_admin;
            }

            /**
             * Add a user to the group chat.
             * Only the creator or admins can add users.
             */
            public function addUser(User $currentUser, User $userToAdd): bool
            {
                if ($currentUser->id !== $this->created_by && !$this->isAdmin($currentUser)) {
                    return false;
                }

                if (!$this->hasUser($userToAdd)) {
                    $this->users()->attach($userToAdd->id, [
                        'is_admin' => false
                    ]);
                }

                return true;
            }
        }
