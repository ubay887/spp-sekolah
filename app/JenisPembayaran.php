<?php

namespace App;

use App\Models\Tagihan;
use App\Models\Tahunajaran;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $guarded = [];

    protected $table = 'jenis_pembayaran';

    public function tahunajaran()
    {
        return $this->belongsTo(Tahunajaran::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function getLunasAttribute()
    {
        $lunas = Tagihan::where('jenis_pembayaran_id', $this->attributes['id'])
                    ->whereHas('tagihan_detail', function ($query) {
                        $query->where('status', 'Lunas');
                    })->count();
        return $lunas;
    }

    public function getBelumLunasAttribute()
    {
        $blunas = Tagihan::where('jenis_pembayaran_id', $this->attributes['id'])
                    ->whereHas('tagihan_detail', function ($query) {
                        $query->where('status', 'Belum Lunas');
                    })->count();
        return $blunas;
    }

    public function getTotalByrAttribute()
    {
        $totayByr = Tagihan::where('jenis_pembayaran_id', $this->attributes['id'])
                    ->whereHas('tagihan_detail', function ($query) {
                        $query->where('total_bayar', '<>', 0);
                    })->count();
        return $totayByr;
    }
}
