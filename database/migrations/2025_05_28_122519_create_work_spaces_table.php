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
                    Schema::create('workspaces', function (Blueprint $table) {
                        $table->id();
                        $table->string('name');
                        $table->foreignId('category_id')->constrained('workspace_categories');
                        $table->enum('type', ['desk', 'meeting_room', 'study_pod']);
                        $table->text('description')->nullable();
                        $table->decimal('hourly_rate', 8, 2)->nullable();
                        $table->decimal('daily_rate', 8, 2)->nullable();
                        $table->boolean('is_available')->default(true);
                        $table->string('image')->nullable();
                        $table->timestamps();

                        $table->index(['type', 'is_available']);
                    });
                }

                /**
                 * Reverse the migrations.
                 */
                public function down(): void
                {
                    Schema::dropIfExists('workspaces');
                }
            };
