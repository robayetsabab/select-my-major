<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->json('required_skills');
            $table->json('prerequisites');
            $table->string('difficulty');
            $table->json('roadmap');
            $table->json('certifications');
            $table->json('career_opportunities');
            $table->text('job_market_bd');
            $table->text('job_market_international');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
