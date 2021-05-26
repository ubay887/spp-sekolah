<?php

namespace App\Models;

use App\Models\Siswa;
use App\JenisPembayaran;
use App\Models\TagihanDetail;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $guarded = [];

    protected $table = 'tagihan';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenis_pembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }

    public function tagihan_detail()
    {
        return $this->hasMany(TagihanDetail::class);
    }

}
