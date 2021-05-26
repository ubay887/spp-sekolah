<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manajemen users', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen roles', 'guard_name' => 'web']);

        Permission::create(['name' => 'manajemen tahun ajaran', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen kelas', 'guard_name' => 'web']);
        // Permission::create(['name' => 'manajemen wali kelas', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen pegawai', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen kelulusan', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen pindah kelas', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen siswa', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen jenis pembayaran', 'guard_name' => 'web']);
        Permission::create(['name' => 'manajemen transaksi pembayaran', 'guard_name' => 'web']);
        Permission::create(['name' => 'laporan pembayaran', 'guard_name' => 'web']);
        Permission::create(['name' => 'laporan tagihan', 'guard_name' => 'web']);

        
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'pegawai', 'guard_name' => 'web'])
            ->givePermissionTo([
                'manajemen siswa',
                'manajemen transaksi pembayaran',
                ]);

        $role = Role::create(['name' => 'siswa', 'guard_name' => 'web'])
            ->givePermissionTo([
                'manajemen siswa',
                ]);
    }
}
