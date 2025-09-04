<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Drop tabel jika sudah ada untuk memastikan migrasi bersih
        Schema::dropIfExists('auction_transactions');
        Schema::dropIfExists('auction_items');

        // Tabel untuk menyimpan data barang yang tersedia untuk lelang/penjualan
        Schema::create('auction_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->integer('total_quantity')->default(1);
            $table->timestamps();
        });

        // Tabel untuk mencatat setiap transaksi penjualan lelang
        Schema::create('auction_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained('auction_items')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->integer('quantity_bought')->default(1);
            $table->decimal('final_price', 12, 2);
            $table->enum('payment_status', ['pending', 'installment', 'paid'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_transactions');
        Schema::dropIfExists('auction_items');
    }
};
