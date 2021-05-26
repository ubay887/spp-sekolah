<?php

namespace App\Models;

use App\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $guarded = [];

    protected $table = 'siswa';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function getJkAttribute()
    {
        return ($this->jenis_kelamin === "male") ? 'L' : 'P';
    }

    public function getJumlahLakiAttribute()
    {
        return "oke";
    }
}
