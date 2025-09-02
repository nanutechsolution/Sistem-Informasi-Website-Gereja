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
        Schema::table('pks_schedules', function (Blueprint $table) {
            $table->dropColumn(['activity_name', 'location', 'leader_name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pks_schedules', function (Blueprint $table) {
            $table->string('activity_name')->after('id');
            $table->string('location')->after('time');
            $table->string('leader_name')->after('location');
            $table->text('description')->after('leader_name')->nullable();
        });
    }
};