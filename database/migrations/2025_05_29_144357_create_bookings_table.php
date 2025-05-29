<?php

            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;

            return new class extends Migration
            {
                /**
                 * Run the migrations.
                 */
                public function up(): void
                {
                    Schema::create('bookings', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('workspace_id')->constrained('workspaces');
                        $table->foreignId('user_id')->constrained('users');
                        $table->dateTime('start_datetime');
                        $table->dateTime('end_datetime');
                        $table->enum('booking_type', ['hourly', 'daily']);
                        $table->decimal('total_cost', 8, 2);
                        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
                        $table->timestamps();

                        $table->index(['workspace_id', 'start_datetime', 'end_datetime']);
                        $table->index('user_id');
                    });
                }

                /**
                 * Reverse the migrations.
                 */
                public function down(): void
                {
                    Schema::dropIfExists('bookings');
                }
            };
