<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('major_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['question', 'feedback']);
            $table->enum('category', ['major', 'learning_resource', 'career']);
            $table->string('title', 150);
            $table->text('body');
            $table->enum('status', ['pending', 'published', 'rejected'])->default('pending');
            $table->text('admin_reply')->nullable();
            $table->timestamps();
            $table->index(['type', 'category', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_questions');
    }
};
