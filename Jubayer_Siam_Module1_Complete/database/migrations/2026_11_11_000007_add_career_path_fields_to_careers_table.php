<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique();
            $table->text('summary')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('skills')->nullable();
            $table->json('industries')->nullable();
            $table->json('previous_roles')->nullable();
            $table->json('next_roles')->nullable();
            $table->json('related_roles')->nullable();
            $table->string('experience_range', 80)->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->string('youtube_url', 2048)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug', 'summary', 'responsibilities', 'skills', 'industries',
                'previous_roles', 'next_roles', 'related_roles', 'experience_range',
                'image_url', 'youtube_url',
            ]);
        });
    }
};
