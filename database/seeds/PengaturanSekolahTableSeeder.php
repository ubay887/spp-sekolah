<?php

use Illuminate\Database\Seeder;
use App\Models\PengaturanSekolah;

class PengaturanSekolahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengaturan = PengaturanSekolah::create([
            'nama_sekolah'  => 'SMP Negeri 1 Antah Berantah',
            'alamat'  => 'Jl. Maju Mundur No 12',
            'kota' => 'Takberujung',
            'email' => '-',
            'no_telp' => '-',
        ]);
    }
}
