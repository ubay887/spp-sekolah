<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Detail_pembayaran;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembayaran extends Model
{
    protected $guarded = [];

    protected $table = 'transaksi_pembayaran';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    //Model relationships ke detail_pembayaran menggunakan hasMany
    public function detail_pembayaran()
    {
        return $this->hasMany(Detail_pembayaran::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getForHumanAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])-> diffForHumans();
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    public function getDueDateAttribute()
    {
        $dueDate = new Carbon($this->attributes['created_at']);
        $dueDate = $dueDate->addDays(1);
        return Carbon::parse($dueDate)->format('d M Y H:i');
    }

    public function getPembayaranDetailAttribute($value)
    {
        $pembayaranDetail = json_decode($value);

        if($this->metode_pembayaran === "BNI VA" || $this->metode_pembayaran === "Bank Lainnya" ){
            if(!empty($pembayaranDetail)){
                return $pembayaranDetail->va_numbers[0]->va_number;
            }
        }

        if($this->metode_pembayaran === "BCA VA"){
            if(!empty($pembayaranDetail)){
                return $pembayaranDetail->va_numbers[0]->va_number;
            }
        }

        if($this->metode_pembayaran === "MANDIRI VA"){
            if(!empty($pembayaranDetail)){
                // return ['bill_key' => $pembayaranDetail->bill_key, 'biller_code' => $pembayaranDetail->biller_code];
                return "Bill Key : $pembayaranDetail->bill_key, Biller Code : $pembayaranDetail->biller_code";
            }
        }

        if($this->metode_pembayaran === "PERMATA VA"){
            if(!empty($pembayaranDetail)){
                return $pembayaranDetail->permata_va_number;
            }
        }
        // return json_decode($value);
        return null;
    }
}
