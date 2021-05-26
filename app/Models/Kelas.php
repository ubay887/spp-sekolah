<?php

namespace App\Models;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas'];

    protected $table = 'kelas';

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
