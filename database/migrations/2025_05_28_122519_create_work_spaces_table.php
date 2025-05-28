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
            $table->foreignId('category_id')->constrained('workspace_categories')->onDelete('restrict');
            $table->enum('type', ['desk', 'meeting_room', 'study_pod', 'phone_booth', 'lounge']);
            $table->text('description')->nullable();
            $table->integer('capacity')->default(1);
            $table->string('location')->nullable(); // floor, section, etc.
            $table->json('amenities')->nullable(); // ["wifi", "monitor", "whiteboard"]
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->json('images')->nullable(); // array of image URLs
            $table->json('equipment')->nullable(); // available equipment
            $table->timestamps();

            $table->index(['type']);
            $table->index(['is_available']);
            $table->index(['category_id']);
            $table->index(['capacity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_spaces');
    }
};
