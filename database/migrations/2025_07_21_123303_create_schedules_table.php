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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul ibadah/acara
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->date('date');    // Tanggal acara
            $table->time('time');    // Waktu acara
            $table->string('location')->nullable(); // Lokasi (misal: Gereja Induk, Gedung Serbaguna)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
