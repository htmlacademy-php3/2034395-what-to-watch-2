<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('poster_image')->nullable();
            $table->text('preview_image')->nullable();
            $table->text('background_image')->nullable();
            $table->text('background_color')->nullable();
            $table->text('video_link')->nullable();
            $table->text('preview_video_link')->nullable();
            $table->text('description')->nullable();
            $table->text('director')->nullable();
            $table->integer('run_time')->nullable();
            $table->integer('released')->nullable();
            $table->string('imdb_id')->unique();
            $table->string('status')->default('pending');
            $table->boolean('is_promo')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
