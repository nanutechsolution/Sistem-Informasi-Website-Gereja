<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat pengguna admin jika belum ada
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gereja.com'],
            [
                'name' => 'Administrator Gereja',
                'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat di produksi!
                'email_verified_at' => now(),
            ]
        );

        // Pastikan role 'admin' sudah ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Berikan role 'admin' kepada user admin
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }

        // Tambahkan contoh user lain jika perlu
        $secretaryUser = User::firstOrCreate(
            ['email' => 'sekretaris@gereja.com'],
            [
                'name' => 'Sekretaris Gereja',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $secretaryRole = Role::firstOrCreate(['name' => 'sekretaris']);
        if (!$secretaryUser->hasRole('sekretaris')) {
            $secretaryUser->assignRole('sekretaris');
        }
    }
}
