<?php

namespace App;

use App\Models\Siswa;
use App\Models\Pegawai;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'status', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the pegawai record associated with the user.
     */
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function getFotoAttribute()
    {
        if(!empty(auth()->user()->pegawai)){
            return "/pegawai/".auth()->user()->pegawai->foto;
        }

        if(!empty(auth()->user()->siswa)){
            return "/siswa/".auth()->user()->siswa->foto;
        }

        return "/pegawai/pegawai_default.png";
    }
}
