<?php 

namespace App\Helper;

use App\Setting;
use App\Models\PengaturanSekolah;

class SettingHelper
{
    public static function getSetting()
    {
        $settings = Setting::get()->first();
        return $settings;
    }

    public static function getSettingSekolah()
    {
        return PengaturanSekolah::get()->first();
    }

}