<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->string('image_url', 2048)->nullable();
            $table->string('video_url', 2048)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn(['image_url', 'video_url']);
        });
    }
};
