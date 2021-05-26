<?php

namespace App\Models;

use App\JenisPembayaran;
use Illuminate\Database\Eloquent\Model;

class Tahunajaran extends Model
{
    protected $guarded = [];

    protected $table = 'tahunajaran';

    public function jenis_pembayaran()
    {
        return $this->hasMany(JenisPembayaran::class);
    }
}
