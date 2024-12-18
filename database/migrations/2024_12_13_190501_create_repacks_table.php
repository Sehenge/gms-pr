<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repacks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('tg_posted')->default(false);
            $table->string('genre')->nullable();
            $table->string('language', 2)->default('en');
            $table->string('size')->nullable();
            $table->foreignId('category_id')->references('id')->on('repack_categories')->onDelete('cascade');
            $table->string('release_date')->nullable();
            $table->string('repack_url')->nullable();
            $table->text('requirements')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->string('update_date')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repacks');
    }
};
