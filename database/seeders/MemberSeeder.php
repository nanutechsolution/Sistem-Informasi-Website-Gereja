<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User; // Jika ingin mengaitkan dengan user

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada setidaknya 1 user admin atau dummy user
        $adminUser = User::where('email', 'admin@gereja.com')->first();
        if (!$adminUser) {
            $adminUser = User::factory()->create(['email' => 'admin@gereja.com']);
        }

        Member::create([
            'user_id' => $adminUser->id,
            'full_name' => 'Jemaat Utama Aktif',
            'nik' => '3201010101010001',
            'gender' => 'Laki-laki',
            'date_of_birth' => '1985-05-15',
            'place_of_birth' => 'Sumba Barat Daya',
            'blood_type' => 'A+',
            'address' => 'Jl. Gereja Lama No. 10',
            'city' => 'Kota Waingapu',
            'province' => 'Nusa Tenggara Timur',
            'postal_code' => '87111',
            'phone_number' => '081234567890',
            'email' => 'jemaat.utama@example.com',
            'baptism_date' => '1986-01-20',
            'sidi_date' => '2000-03-05',
            'marital_status' => 'Menikah',
            'notes' => 'Anggota aktif, sering terlibat pelayanan.',
            'status' => 'Aktif',
            'join_date' => '2005-07-01',
        ]);

        Member::factory(20)->create(); // Buat 20 anggota dummy lainnya
    }
}
