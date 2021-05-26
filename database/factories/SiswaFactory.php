<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Kelas;
use App\Models\Siswa;
use Faker\Generator as Faker;


$factory->define(Siswa::class, function (Faker $faker) {
    $gender = $faker->randomElement(['male', 'female']);
    $year = $faker->dateTimeBetween($startDate = '-18 years', $endDate = '-15 years');
    $kode = substr($year->format('Y'), 1, 3);
    return [
        'nis' => $kode.rand(111, 999).rand(1111,9999),
        'nama_lengkap' => $faker->firstName($gender)." ".$faker->lastName($gender),
        'jenis_kelamin' => $gender,
        'tanggal_lahir' => $year,
        'tempat_lahir' => $faker->city,
        'no_telp' => $faker->phoneNumber,
        'alamat' => $faker->address,
        'nama_ibu_kandung' => $faker->name('female'),
        'nama_ayah_kandung' => $faker->name('male'),
        'no_telp_orangtua' => $faker->phoneNumber,
        'status' => 'Aktif',
        'foto' => 'siswa_default.png',
        'user_id' => '3',
    ];
});
