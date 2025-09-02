<?php

namespace Database\Seeders;

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

        // -------------------
        // Roles
        // -------------------
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $secretaryRole = Role::firstOrCreate(['name' => 'sekretaris']);
        $treasurerRole = Role::firstOrCreate(['name' => 'bendahara']);
        $contentEditorRole = Role::firstOrCreate(['name' => 'editor_konten']);
        $councilRole = Role::firstOrCreate(['name' => 'majelis']);
        $ministryMemberRole = Role::firstOrCreate(['name' => 'anggota_pelayanan']);
        $pastorRole = Role::firstOrCreate(['name' => 'pendeta']);
        // -------------------
        // Permissions
        // -------------------
        // Konten & Informasi
        Permission::firstOrCreate(['name' => 'manage announcements']);
        Permission::firstOrCreate(['name' => 'manage schedules']);
        Permission::firstOrCreate(['name' => 'manage news']);
        Permission::firstOrCreate(['name' => 'manage gallery']);

        // Jemaat & Pelayanan
        Permission::firstOrCreate(['name' => 'manage members']);
        Permission::firstOrCreate(['name' => 'manage families']);
        Permission::firstOrCreate(['name' => 'manage ministries']);
        Permission::firstOrCreate(['name' => 'manage events']);

        // Keuangan
        Permission::firstOrCreate(['name' => 'manage finances']);
        Permission::firstOrCreate(['name' => 'manage tithes and offerings']);
        Permission::firstOrCreate(['name' => 'view reports']);

        // Manajemen Users & Roles
        Permission::firstOrCreate(['name' => 'manage users and roles']);

        // -------------------
        // Assign Permissions
        // -------------------
        // Admin → semua permission
        $adminRole->givePermissionTo(Permission::all());

        // Sekretaris
        $secretaryRole->givePermissionTo([
            'manage announcements',
            'manage schedules',
            'manage members',
            'manage ministries',
            'manage events'
        ]);

        // Bendahara
        $treasurerRole->givePermissionTo([
            'manage finances',
            'manage tithes and offerings',
            'view reports'
        ]);

        // Editor Konten
        $contentEditorRole->givePermissionTo([
            'manage news',
            'manage gallery',
            'manage announcements',
            'manage schedules'
        ]);

        // Majelis
        $councilRole->givePermissionTo([
            'manage members',
            'manage ministries',
            'manage schedules',
            'view reports',
            'manage events'
        ]);

        // Anggota Pelayanan
        $ministryMemberRole->givePermissionTo([
            'manage ministries',
            'manage events'
        ]);

        $pastorRole->givePermissionTo([
            'manage schedules',
            'view reports',
            'manage members',
            'manage ministries',
            'manage events'
        ]);
    }
}