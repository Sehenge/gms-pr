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
        Schema::table('repack_categories', function (Blueprint $table) {
            $table->boolean('parsed')->after('url')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repack_categories', function (Blueprint $table) {
            $table->dropColumn('parsed');
        });
    }
};
