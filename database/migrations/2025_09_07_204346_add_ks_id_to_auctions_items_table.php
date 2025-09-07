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
        Schema::table('auction_items', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->unsignedBigInteger('ks_id')->nullable();
            $table->foreign('ks_id')->references('id')->on('kas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auction_items', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropForeign('auction_items_ks_id_foreign');
            $table->dropColumn('ks_id');
        });
    }
};