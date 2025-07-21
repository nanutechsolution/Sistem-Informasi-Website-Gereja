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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama pelayanan (misal: Pelayanan Anak, Pelayanan Musik)
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Pivot table untuk anggota pelayanan
        Schema::create('ministry_members', function (Blueprint $table) {
            $table->foreignId('ministry_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('role')->nullable(); // Misal: Koordinator, Anggota, Sekretaris
            $table->date('joined_date')->nullable();
            $table->primary(['ministry_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministry_members');
        Schema::dropIfExists('ministries');
    }
};
