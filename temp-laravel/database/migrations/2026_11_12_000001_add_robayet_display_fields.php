<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->json('reasons')->nullable();
            $table->string('best_for')->nullable();
            $table->string('accent', 7)->default('#2563eb');
            $table->unsignedInteger('sort_order')->default(0);
        });

        Schema::table('certifications', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->boolean('is_free')->default(false);
            $table->text('free_option')->nullable();
            $table->string('official_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropColumn(['price', 'is_free', 'free_option', 'official_url', 'sort_order']);
        });

        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn(['reasons', 'best_for', 'accent', 'sort_order']);
        });
    }
};
