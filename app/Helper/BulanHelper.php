<?php 

namespace App\Helper;

use App\Setting;

class BulanHelper
{
    public static function getBulan()
    {
        $bulan = [
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
        ];
        return $bulan;
    }

    public static function getBulanSingkat()
    {
        $bulan = [
            'Jul',
            'Agus',
            'Sept',
            'Okt',
            'Nov',
            'Des',
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
        ];
        return $bulan;
    }

}