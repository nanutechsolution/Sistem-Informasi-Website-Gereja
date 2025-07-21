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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Tipe notifikasi (e.g., 'announcement_expired', 'new_event', 'contact_message')
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Isi pesan notifikasi
            $table->unsignedBigInteger('user_id')->nullable(); // User yang menerima notifikasi (jika spesifik)
            $table->boolean('is_read')->default(false); // Status sudah dibaca atau belum
            $table->string('link')->nullable(); // Link terkait notifikasi (misal: link ke detail pengumuman)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
