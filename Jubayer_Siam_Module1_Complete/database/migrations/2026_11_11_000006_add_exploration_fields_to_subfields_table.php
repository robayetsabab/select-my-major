<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subfields', function (Blueprint $table) {
            $table->text('main_focus')->nullable();
            $table->json('typical_tasks')->nullable();
            $table->json('applications')->nullable();
            $table->json('technologies')->nullable();
            $table->text('real_world_example')->nullable();
            $table->string('difficulty', 40)->default('Beginner');
            $table->string('image_url', 2048)->nullable();
            $table->string('youtube_url', 2048)->nullable();
            $table->json('related_slugs')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('subfields', function (Blueprint $table) {
            $table->dropColumn([
                'main_focus', 'typical_tasks', 'applications', 'technologies',
                'real_world_example', 'difficulty', 'image_url', 'youtube_url', 'related_slugs',
            ]);
        });
    }
};
