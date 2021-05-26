<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Detail_pembayaran extends Model
{
    protected $guarded = [];

    protected $table = 'detail_pembayaran';

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    // public function getHargaAttribute()
    // {
    //     return number_format($this->attributes['harga']);
    // }
    
    public function transaksi_pembayaran()
    {
        return $this->belongsTo(TransaksiPembayaran::class);
    }

}
