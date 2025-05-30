<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class WorkSpace extends Model
    {
        protected $table = 'workspaces';

        /**
         * Define workspace types as constants
         */
        public const TYPE_DESK = 'desk';
        public const TYPE_MEETING_ROOM = 'meeting_room';
        public const TYPE_STUDY_POD = 'study_pod';

        /**
         * Get all available workspace types
         */
        public static function getTypes(): array
        {
            return [
                self::TYPE_DESK,
                self::TYPE_MEETING_ROOM,
                self::TYPE_STUDY_POD,
            ];
        }

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
