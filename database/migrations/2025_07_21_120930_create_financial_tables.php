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
        Schema::create('income_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Misal: Persembahan Mingguan, Perpuluhan, Donasi Umum
            $table->text('description')->nullable(); // <-- TAMBAHKAN BARIS INI
            $table->timestamps();
        });


        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Misal: Listrik, Gaji Pegawai, Pemeliharaan Gedung
            $table->text('description')->nullable(); // <-- TAMBAHKAN BARIS INI
            $table->timestamps();
        });


        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('income_category_id')->constrained()->onDelete('restrict');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->string('source')->nullable(); // Misal: Dari jemaat A, Anonim
            $table->string('proof_of_transaction')->nullable(); // Path upload bukti transaksi
            $table->foreignId('recorded_by_user_id')->constrained('users')->onDelete('restrict'); // Siapa yang mencatat
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_category_id')->constrained()->onDelete('restrict');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->string('recipient')->nullable(); // Penerima pengeluaran
            $table->string('proof_of_transaction')->nullable(); // Path upload bukti transaksi
            $table->foreignId('recorded_by_user_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('income_categories');
    }
};
