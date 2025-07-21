<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Opsional, tapi baik untuk kejelasan

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
        // 'time' => 'datetime', // Jika Anda ingin mengelola waktu sebagai objek Carbon lengkap
        // Atau biarkan Laravel menanganinya sebagai string jika hanya perlu HH:MM:SS
    ];

    // Opsional: Accessor untuk format waktu yang lebih mudah di blade
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->attributes['time'])->format('H:i');
    }
}
