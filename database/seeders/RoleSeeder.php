<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $secretaryRole = Role::firstOrCreate(['name' => 'sekretaris']);
        $treasurerRole = Role::firstOrCreate(['name' => 'bendahara']);
        $contentEditorRole = Role::firstOrCreate(['name' => 'editor_konten']);
        // Anda bisa tambahkan role lain sesuai kebutuhan, misal 'anggota_pelayanan'

        // Buat Permissions (Contoh Saja, akan lebih banyak nanti)
        // Manajemen Pengumuman
        Permission::firstOrCreate(['name' => 'manage announcements']);
        // Manajemen Jadwal
        Permission::firstOrCreate(['name' => 'manage schedules']);
        // Manajemen Berita
        Permission::firstOrCreate(['name' => 'manage news']);
        // Manajemen Galeri
        Permission::firstOrCreate(['name' => 'manage gallery']);
        // Manajemen Jemaat
        Permission::firstOrCreate(['name' => 'manage members']);
        // Manajemen Pelayanan
        Permission::firstOrCreate(['name' => 'manage ministries']);
        // Manajemen Keuangan
        Permission::firstOrCreate(['name' => 'manage finances']);
        // Manajemen Pengguna & Hak Akses (hanya admin)
        Permission::firstOrCreate(['name' => 'manage users and roles']);


        // Berikan izin ke role
        $adminRole->givePermissionTo(Permission::all()); // Admin punya semua izin

        $secretaryRole->givePermissionTo([
            'manage announcements',
            'manage schedules',
            'manage members',
            'manage ministries'
        ]);

        $treasurerRole->givePermissionTo([
            'manage finances',
            // mungkin juga bisa melihat laporan jemaat
        ]);

        $contentEditorRole->givePermissionTo([
            'manage news',
            'manage gallery',
            'manage announcements',
            'manage schedules'
        ]);
    }
}
