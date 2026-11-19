<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('category', 40); // interest | skill | preference | work_style
            $table->string('question');
            $table->string('hint')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            // Weighted score per major slug, e.g. {"cyber-security":3,"robotics":1,"software-testing":0,"data-science":1}
            $table->json('scores');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('answers');      // {question_id: option_id}
            $table->json('scores');       // {major_slug: raw score}
            $table->json('percentages');  // {major_slug: percent}
            $table->foreignId('top_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->foreignId('runner_up_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->string('confidence', 20)->default('Moderate');
            $table->boolean('is_tie')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
    }
};
