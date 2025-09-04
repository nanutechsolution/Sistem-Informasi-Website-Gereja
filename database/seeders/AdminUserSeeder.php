<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator Gereja',
                'email' => 'admin@gereja.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Maria Suryani',
                'email' => 'sekretaris@gereja.com',
                'role' => 'sekretaris',
            ],
            [
                'name' => 'Paulus Situmorang',
                'email' => 'bendahara@gereja.com',
                'role' => 'bendahara',
            ],
            [
                'name' => 'Pdt. Yohanis Lerebulan',
                'email' => 'pendeta@gereja.com',
                'role' => 'pendeta',
            ],
            // 10 majelis
            ['name' => 'Agustinus Ledo', 'email' => 'majelis1@gereja.com', 'role' => 'majelis'],
            ['name' => 'Martha Nababan', 'email' => 'majelis2@gereja.com', 'role' => 'majelis'],
            ['name' => 'Samuel Karel', 'email' => 'majelis3@gereja.com', 'role' => 'majelis'],
            ['name' => 'Debora Manalu', 'email' => 'majelis4@gereja.com', 'role' => 'majelis'],
            ['name' => 'Yakobus Ndolu', 'email' => 'majelis5@gereja.com', 'role' => 'majelis'],
            ['name' => 'Ester Simanjuntak', 'email' => 'majelis6@gereja.com', 'role' => 'majelis'],
            ['name' => 'Markus Ratuanak', 'email' => 'majelis7@gereja.com', 'role' => 'majelis'],
            ['name' => 'Ruth Halim', 'email' => 'majelis8@gereja.com', 'role' => 'majelis'],
            ['name' => 'Kornelius Blegur', 'email' => 'majelis9@gereja.com', 'role' => 'majelis'],
            ['name' => 'Febe Nirmala', 'email' => 'majelis10@gereja.com', 'role' => 'majelis'],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'), // ganti di produksi
                    'email_verified_at' => now(),
                ]
            );

            $role = Role::firstOrCreate(['name' => $userData['role']]);

            if (!$user->hasRole($userData['role'])) {
                $user->assignRole($userData['role']);
            }
        }

        $this->command->info('Seeder AdminUser selesai dengan admin, sekretaris, bendahara, pendeta, dan 10 majelis.');
    }
}