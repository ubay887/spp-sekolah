<?php

namespace App\Imports;

use App\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
// use Maatwebsite\Excel\Concerns\WithLimit;


class SiswaImport implements ToModel, WithHeadingRow
{
    // private $rows = 0;
    // public $limit = 12;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $tgl_lahir = date_format(date_create($row['tanggal_lahir']), "Y-m-d");
        $jk = ($row['jk'] === 'L') ? 'male' : 'female';
        
        $kelas = Kelas::where('nama_kelas', '=', $row['kelas'])->get()->first();
        
        if(empty($kelas)){
            
            $kelas = Kelas::create([
                'nama_kelas' => $row['kelas']
            ]);
            
        }
        
        $tesid = uniqid();
        
        $user = User::create([
            'name' => $row['nama'],
            'username' => $row['nis'],
            'email' => "email-$tesid@example.com",
            'password'  => bcrypt('123456'),
            'status'  => true,
        ]);

        $user->assignRole('siswa');
        
        $siswa = new Siswa([
            'nis' => $row['nis'],
            'nama_lengkap' => $row['nama'],
            'jenis_kelamin' => $jk,
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $tgl_lahir,
            'no_telp' => $row['no_telp'],
            'alamat' => $row['alamat'],
            'nama_ibu_kandung' => $row['nama_ibu_kandung'],
            'nama_ayah_kandung' => $row['nama_ayah_kandung'],
            'no_telp_orangtua' => $row['no_telp_orang_tua'],
            'status' => 'Aktif',
            'kelas_id' => $kelas->id,
            'user_id' => $user->id,
            'foto' => 'siswa_default.png',
        ]);

        return $siswa;
    }

    // public function limit(): int
    // {
    //     return $this->limit;
    // }

}
