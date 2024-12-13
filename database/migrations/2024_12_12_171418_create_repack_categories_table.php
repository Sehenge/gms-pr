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
        Schema::create('repack_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');

            /*$table->string('title');
            $table->string('lang')->default('ru');
            $table->string('url');
            $table->string('image');
            $table->text('description');
            $table->string('update_data');*/

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repack_categories');
    }
};
