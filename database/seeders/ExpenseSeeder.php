<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@gereja.com')->first();
        if (!$adminUser) {
            $adminUser = User::factory()->create(['email' => 'admin@gereja.com']);
        }

        $gajiPegawai = ExpenseCategory::where('name', 'Gaji Pegawai')->first();
        $biayaListrik = ExpenseCategory::where('name', 'Biaya Listrik')->first();
        $pemeliharaanGedung = ExpenseCategory::where('name', 'Pemeliharaan Gedung')->first();

        // Pastikan kategori ada
        if (!$gajiPegawai || !$biayaListrik || !$pemeliharaanGedung) {
            $this->call(ExpenseCategorySeeder::class); // Panggil seeder kategori jika belum ada
            $gajiPegawai = ExpenseCategory::where('name', 'Gaji Pegawai')->first();
            $biayaListrik = ExpenseCategory::where('name', 'Biaya Listrik')->first();
            $pemeliharaanGedung = ExpenseCategory::where('name', 'Pemeliharaan Gedung')->first();
        }

        // Tambah beberapa data pengeluaran
        for ($i = 0; $i < 10; $i++) {
            $category = collect([$gajiPegawai, $biayaListrik, $pemeliharaanGedung])->random();
            $amount = rand(200000, 3000000); // 200rb - 3jt
            $date = now()->subDays(rand(1, 60)); // Dalam 2 bulan terakhir

            $expense = Expense::create([
                'expense_category_id' => $category->id,
                'amount' => $amount,
                'description' => 'Pembayaran ' . $category->name . ' bulan ' . $date->format('M Y'),
                'transaction_date' => $date,
                'recipient' => (rand(0, 1) == 1) ? 'PLN' : 'Toko Material',
                'recorded_by_user_id' => $adminUser->id,
            ]);

            // Tambahkan bukti transaksi dummy secara acak
            if (rand(0, 1) == 1 && file_exists(storage_path('app/dummy_images/dummy-proof.jpg'))) {
                $path = Storage::disk('public')->putFile('expense_proofs', new \Illuminate\Http\File(storage_path('app/dummy_images/dummy-proof.jpg')));
                $expense->update(['proof_of_transaction' => $path]);
            }
        }
    }
}
