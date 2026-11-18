<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('career_stories', function(Blueprint $t) {
   $t->id(); $t->foreignId('major_id')->constrained()->cascadeOnDelete(); $t->string('slug')->unique();
   $t->string('name'); $t->string('role_title'); $t->string('country')->nullable(); $t->string('organization')->nullable();
   $t->text('short_bio'); $t->text('education')->nullable(); $t->text('first_job')->nullable(); $t->text('current_position')->nullable();
   $t->json('skills')->nullable(); $t->json('achievements')->nullable(); $t->json('career_steps')->nullable(); $t->text('learning_takeaways')->nullable();
   $t->string('photo_url',2048)->nullable(); $t->string('wikipedia_url',2048)->nullable(); $t->string('professional_url',2048)->nullable(); $t->string('source_url',2048)->nullable();
   $t->boolean('is_featured')->default(false); $t->timestamps(); $t->index(['major_id','country']);
  });
  Schema::create('quiz_attempts', function(Blueprint $t) {
   $t->id(); $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $t->string('session_key',80)->nullable()->index();
   $t->json('answers'); $t->json('scores'); $t->string('recommended_major'); $t->unsignedTinyInteger('answered_count')->default(0); $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('quiz_attempts'); Schema::dropIfExists('career_stories'); }
};