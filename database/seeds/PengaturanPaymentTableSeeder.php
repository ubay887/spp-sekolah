<?php

use Illuminate\Database\Seeder;
use App\Models\PengaturanPayment;

class PengaturanPaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengaturan = PengaturanPayment::create([
            'client_key_sandbox'  => '-',
            'server_key_sandbox'  => '-',
            'client_key_production'  => '-',
            'server_key_production'  => '-',
            'environment' => 'sandbox',
        ]);
    }
}
