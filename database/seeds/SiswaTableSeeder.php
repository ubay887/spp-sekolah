<?php

use App\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas1 = Kelas::create([
            'nama_kelas' => 'Kelas 10',
        ]);

        $siswa1 = factory(Siswa::class, 20)->make()->each( function ($siswa){
                    $uniq = uniqid();
                    $user = User::create([
                        'name' => $siswa->nama_lengkap,
                        'username' => $siswa->nis,
                        'email' => "example-$uniq@example.com",
                        'password' => bcrypt('123456'),
                        'status' => true,
                    ]);
                    $user->assignRole('siswa');
                    $siswa->user_id = $user->id;
                    $siswa->save();
                });
        $kelas1->siswa()->saveMany($siswa1);
        
        $kelas2 = Kelas::create([
            'nama_kelas' => 'Kelas 11',
        ]);

        $siswa2 = factory(Siswa::class, 20)->make()->each( function ($siswa){
                    $uniq = uniqid();
                    $user = User::create([
                        'name' => $siswa->nama_lengkap,
                        'username' => $siswa->nis,
                        'email' => "example-$uniq@example.com",
                        'password' => bcrypt('123456'),
                        'status' => true,
                    ]);
                    $user->assignRole('siswa');
                    $siswa->user_id = $user->id;
                    $siswa->save();
                });
        $kelas2->siswa()->saveMany($siswa2);

        $kelas3 = Kelas::create([
            'nama_kelas' => 'Kelas 12',
        ]);

        $siswa3 = factory(Siswa::class, 40)->make()->each( function ($siswa){
                    $uniq = uniqid();
                    $user = User::create([
                        'name' => $siswa->nama_lengkap,
                        'username' => $siswa->nis,
                        'email' => "example-$uniq@example.com",
                        'password' => bcrypt('123456'),
                        'status' => true,
                    ]);
                    $user->assignRole('siswa');
                    $siswa->user_id = $user->id;
                    $siswa->save();
                });
        $kelas3->siswa()->saveMany($siswa3);

        // Kelas::create([
        //     'nama_kelas' => 'Kelas 11',
        // ])->each( function ($kelas10){
        //     $siswa = factory(Siswa::class, 10)->make()->each( function ($siswa){
        //         $uniq = uniqid();
        //         $user = User::create([
        //             'name' => $siswa->nama_lengkap,
        //             'username' => $siswa->nis,
        //             'email' => "example-$uniq@example.com",
        //             'password' => bcrypt('123456'),
        //             'status' => true,
        //         ]);
        //         $user->assignRole('user');
        //     });
        //     $kelas10->siswa()->saveMany($siswa);
        // });

        // $kelas11 = Kelas::create([
        //     'nama_kelas' => 'Kelas 11',
        // ])->each( function ($kelas11){
        //     $siswa = factory(Siswa::class, 7)->make()->each( function ($siswa){
        //         $uniq = uniqid();
        //         $user = User::create([
        //             'name' => $siswa->nama_lengkap,
        //             'username' => $siswa->nis,
        //             'email' => "example-$uniq@example.com",
        //             'password' => bcrypt('123456'),
        //             'status' => true,
        //         ]);
        //         $user->assignRole('user');
        //     });
        //     $kelas11->siswa()->saveMany($siswa);
        // });

        // $kelas12 = Kelas::create([
        //     'nama_kelas' => 'Kelas 12',
        // ])->each( function ($kelas12){
        //     $siswa = factory(Siswa::class, 15)->make()->each( function ($siswa){
        //         $uniq = uniqid();
        //         $user = User::create([
        //             'name' => $siswa->nama_lengkap,
        //             'username' => $siswa->nis,
        //             'email' => "example-$uniq@example.com",
        //             'password' => bcrypt('123456'),
        //             'status' => true,
        //         ]);
        //         $user->assignRole('user');
        //     });
        //     $kelas12->siswa()->saveMany($siswa);
        // });

        // $siswa = factory(Siswa::class, 10)->make();
        // $siswa = factory(Siswa::class, 10)->create()->each( function ($siswa){
        //     $uniq = uniqid();
        //     User::create([
        //         'name' => $siswa->nama_lengkap,
        //         'username' => $siswa->nis,
        //         'email' => "example-$uniq@example.com",
        //         'password' => bcrypt('123456'),
        //         'status' => true,
        //     ]);
        // });
        // $kelas->siswa()->saveMany($siswa);
    }
}
