<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus kolom family_id di pks_schedules
        Schema::table('pks_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('pks_schedules', 'family_id')) {
                $table->dropForeign(['family_id']);
                $table->dropColumn('family_id');
            }
        });

        // Buat pivot table
        Schema::create('pks_schedule_family', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pks_schedule_id')->constrained('pks_schedules')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->decimal('offering', 12, 2)->nullable(); // Persembahan tiap keluarga
            $table->timestamps();

            $table->unique(['pks_schedule_id', 'family_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pks_schedule_family');

        Schema::table('pks_schedules', function (Blueprint $table) {
            $table->foreignId('family_id')->nullable()->constrained('families')->onDelete('set null');
        });
    }
};