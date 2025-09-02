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
        Schema::create('pks_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name'); // Nama kegiatan, cth: PKS Sektor A, Ibadah Rumah Tangga
            $table->string('day_of_week');
            $table->date('date');
            $table->time('time');
            $table->string('location'); // Lokasi rumah/tempat PKS
            $table->string('leader_name'); // Nama pemimpin PKS
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->text('involved_members')->nullable(); // Anggota yang terlibat, bisa disimpan sebagai string/JSON
            $table->boolean('is_active')->default(true); // Status aktif, apakah ditampilkan di publik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pks_schedules');
    }
};