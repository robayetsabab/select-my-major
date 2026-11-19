<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('senior_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subfield_id')->nullable()->constrained()->nullOnDelete();
            $table->string('student_name');
            $table->string('batch', 40);
            $table->string('status', 20)->default('current'); // current | completed
            $table->string('stage_label', 80);                // e.g. "4th year" or "Graduated 2025"
            $table->string('current_position')->nullable();
            $table->string('headline');
            $table->text('story');
            $table->text('advice');
            $table->text('challenges');
            $table->text('best_part');
            $table->json('skills')->nullable();
            $table->unsignedTinyInteger('satisfaction')->default(4);   // 1-5
            $table->unsignedTinyInteger('difficulty')->default(3);     // 1-5
            $table->boolean('would_choose_again')->default(true);
            $table->unsignedInteger('helpful_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->index(['major_id', 'status']);
        });

        Schema::create('experience_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('senior_experience_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'senior_experience_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_votes');
        Schema::dropIfExists('senior_experiences');
    }
};
