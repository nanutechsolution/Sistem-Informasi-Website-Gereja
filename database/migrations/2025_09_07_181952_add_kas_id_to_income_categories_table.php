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
        Schema::table('income_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('ks_id')->nullable();
            $table->foreign('ks_id')->references('id')->on('kas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->dropForeign(['ks_id']);
            $table->dropColumn('ks_id');
        });
    }
};