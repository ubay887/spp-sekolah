<?php

namespace App\Models;

use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Model;

class TagihanDetail extends Model
{
    protected $guarded = [];

    protected $table = 'tagihan_details';

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
