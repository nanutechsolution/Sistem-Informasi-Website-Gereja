<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'title',
        'content',
        'published_at',
    ];

    // Tentukan tipe data untuk kolom tanggal agar otomatis di-cast ke objek Carbon
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
