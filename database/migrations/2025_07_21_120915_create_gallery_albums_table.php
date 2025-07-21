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
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('event_date')->nullable(); // Tanggal kegiatan terkait album
            $table->string('cover_image')->nullable(); // Gambar cover album
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_album_id')->nullable()->constrained('gallery_albums')->onDelete('cascade');
            $table->string('type'); // 'image' atau 'video'
            $table->string('path'); // Path file media
            $table->string('thumbnail_path')->nullable(); // Path thumbnail untuk video
            $table->text('caption')->nullable();
            $table->morphs('mediable'); // Untuk relasi polimorfik (misal: berita punya banyak gambar)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('gallery_albums');
    }
};
