<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('icon')->default('bi-mortarboard');
            $table->string('tagline');
            $table->text('overview');
            $table->text('why_choose');          // one reason per line
            $table->string('difficulty')->default('Medium');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
