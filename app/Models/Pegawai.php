<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $guarded = [];

    protected $table = 'pegawai';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
