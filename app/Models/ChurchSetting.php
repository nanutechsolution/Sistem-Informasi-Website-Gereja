<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchSetting extends Model
{
    protected $fillable = [
        'nama_gereja',
        'alamat',
        'telepon',
        'email',
        'website',
        'logo_path',
        'facebook',
        'instagram',
        'youtube',
        'maps_embed',
        'motto',
        'visi',
        'misi',
        'ayat_firman_sumber',
        'ayat_firman',
        'sejarah_singkat',

    ];
}
