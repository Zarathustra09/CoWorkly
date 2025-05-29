<?php

            namespace App\Models;

            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Database\Eloquent\Relations\BelongsTo;

            class Booking extends Model
            {
                protected $fillable = [
                    'workspace_id',
                    'user_id',
                    'start_datetime',
                    'end_datetime',
                    'booking_type',
                    'total_cost',
                    'status',
                    'payment_method',
                    'payment_reference',
                ];

                protected $casts = [
                    'start_datetime' => 'datetime',
                    'end_datetime' => 'datetime',
                    'total_cost' => 'decimal:2',
                ];

                /**
                 * Get the workspace for this booking.
                 */
                public function workspace(): BelongsTo
                {
                    return $this->belongsTo(WorkSpace::class);
                }

                /**
                 * Get the user who made the booking.
                 */
                public function user(): BelongsTo
                {
                    return $this->belongsTo(User::class);
                }

                /**
                 * Check if booking is for hourly rate
                 */
                public function isHourly(): bool
                {
                    return $this->booking_type === 'hourly';
                }

                /**
                 * Calculate the duration in days
                 */
                public function getDurationInDays(): int
                {
                    return $this->start_datetime->diffInDays($this->end_datetime) + 1;
                }
            }
