<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // <--- PASTIKAN INI ADA

class IncomeSeeder extends Seeder
{

    use WithoutModelEvents;
    /**
     * The Faker instance for generating random data.
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan admin user ada
        $adminUser = User::where('email', 'admin@gereja.com')->first();
        if (!$adminUser) {
            // Buat user admin jika tidak ada (meskipun seharusnya dibuat oleh AdminUserSeeder)
            $adminUser = User::factory()->create(['email' => 'admin@gereja.com', 'password' => bcrypt('password')]);
        }

        // Pastikan kategori pemasukan ada. Jika tidak, panggil seedernya.
        if (IncomeCategory::count() === 0) {
            $this->call(IncomeCategorySeeder::class);
        }
        $incomeCategories = IncomeCategory::all();

        // Peringatan jika masih tidak ada kategori setelah mencoba seed
        if ($incomeCategories->isEmpty()) {
            $this->command->warn('No income categories found even after attempting to seed. Please check IncomeCategorySeeder.');
            return;
        }

        // Hapus semua file bukti transaksi lama dari storage
        // Penting: Pastikan path 'income_proofs' ada di public disk
        if (Storage::disk('public')->exists('income_proofs')) {
            Storage::disk('public')->deleteDirectory('income_proofs');
        }
        Storage::disk('public')->makeDirectory('income_proofs');


        $proofImageExists = file_exists(storage_path('app/dummy_images/dummy-proof.jpg'));

        // Buat data pemasukan untuk 12 bulan terakhir
        for ($month = 0; $month < 12; $month++) {
            $currentMonth = Carbon::now()->subMonths($month);
            $daysInMonth = $currentMonth->daysInMonth;

            // Buat 5-15 transaksi per bulan
            for ($i = 0; $i < rand(5, 15); $i++) {
                $category = $incomeCategories->random(); // Pilih kategori secara acak
                $amount = rand(500000, 10000000); // Variasi jumlah lebih besar: 500rb - 10jt
                $date = $currentMonth->copy()->startOfMonth()->addDays(rand(0, $daysInMonth - 1));

                Income::create([
                    'income_category_id' => $category->id,
                    'amount' => $amount,
                    'description' => 'Pemasukan ' . $category->name . ' bulan ' . $date->format('M Y'),
                    'transaction_date' => $date,
                    'source' => (rand(0, 1) == 1) ? 'Jemaat Anonim' : 'Jemaat ' . $this->faker->lastName() . ' ' . $this->faker->firstName(), // <-- Pastikan $this->faker tersedia dari Seeder
                    'recorded_by_user_id' => $adminUser->id,
                ]);

                // Tambahkan bukti transaksi dummy secara acak
                if (rand(0, 3) == 0 && $proofImageExists) { // 25% kemungkinan ada bukti
                    $lastIncome = Income::latest()->first(); // Ambil income terakhir yang baru dibuat
                    if ($lastIncome) {
                        $path = Storage::disk('public')->putFile('income_proofs', new \Illuminate\Http\File(storage_path('app/dummy_images/dummy-proof.jpg')));
                        $lastIncome->update(['proof_of_transaction' => $path]);
                    }
                }
            }
        }
    }
}
