<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(RoleAndPermissionTableSeeder::class);
        $this->call(PegawaiTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        // $this->call(SiswaTableSeeder::class);
        $this->call(PengaturanPaymentTableSeeder::class);
        $this->call(PengaturanSekolahTableSeeder::class);
    }
}
