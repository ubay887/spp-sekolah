<?php

use Faker\Factory;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        //user 1
        $user1 = \App\User::create([
            'name'  => $faker->name,
            'username'  => rand(1211000, 1211999),
            'email' => $faker->email,
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user1 = $user1->assignRole('admin');

        $pegawai1 = Pegawai::create([
            'nip' => $user1->username,
            'nama_pegawai' => $user1->name,
            'no_telp' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'foto' => 'pegawai_default.png',
            'user_id' => $user1->id,
        ]);

        //user 2
        $user2 = \App\User::create([
            'name'  => 'Lee Ji Eun',
            'username'  => '05161993',
            'email' => 'jieun@isengoding.my.id',
            'password'  => bcrypt('password'),
            'status'  => true,
        ]);
        $user2 = $user2->assignRole('pegawai');

        $pegawai2 = Pegawai::create([
            'nip' => $user2->username,
            'nama_pegawai' => $user2->name,
            'no_telp' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'foto' => 'pegawai_default.png',
            'user_id' => $user2->id,
        ]);
                    
        
    }
}
