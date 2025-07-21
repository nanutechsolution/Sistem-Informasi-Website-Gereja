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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL yang SEO-friendly
            $table->longText('content'); // Isi berita/pengumuman
            $table->string('image')->nullable(); // Gambar thumbnail atau banner
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis/admin yang membuat postingan
            $table->boolean('is_published')->default(false); // Apakah sudah dipublikasikan
            $table->timestamp('published_at')->nullable(); // Tanggal publikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
