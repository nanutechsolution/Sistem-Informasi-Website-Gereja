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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // --- PASTIKAN HANYA DUA BARIS INI (SLUG DAN IMAGE) YANG ADA SETELAH TITLE ---
            $table->string('slug')->unique(); // Ini adalah definisi tunggal untuk slug
            $table->string('image')->nullable(); // Ini adalah definisi tunggal untuk image
            // --- TIDAK BOLEH ADA BARIS LAIN YANG MENDEFINISIKAN SLUG ATAU IMAGE DI SINI ---

            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('organizer')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('scheduled');

            $table->timestamps();
        });

        // Tabel event_attendances - ini tidak ada perubahan
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();
            $table->unique(['event_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendances');
        Schema::dropIfExists('events');
    }
};
