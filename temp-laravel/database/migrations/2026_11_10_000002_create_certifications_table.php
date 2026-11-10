<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('provider');
            $table->enum('type', ['certification', 'resource'])->default('certification');
            $table->string('level')->default('Beginner');
            $table->decimal('price_usd', 8, 2)->nullable();   // null = varies / subscription
            $table->string('price_note')->nullable();
            $table->boolean('has_free_option')->default(false);
            $table->string('source_url');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
