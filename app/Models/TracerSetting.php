<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerSetting extends Model
{
    protected $fillable = [
        'tingkat_keterserapan',
        'keterserapan_trend',
        'keterserapan_trend_warna',
        'masa_tunggu',
        'masa_tunggu_sub',
        'masa_tunggu_sub_warna',
        'kesesuaian',
        'kesesuaian_sub',
        'kesesuaian_sub_warna',
        'total_alumni',
        'total_alumni_sub',
        'total_alumni_sub_warna',
        'catatan_bmw',
    ];
}
