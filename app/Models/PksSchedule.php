<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PksSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'date',
        'time',
        'location',
        'leader_name',
        'description',
        'involved_members',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime', // Cast sebagai datetime agar bisa diformat Carbon
        'is_active' => 'boolean',
        // 'involved_members' => 'array', // Jika Anda ingin menyimpan sebagai JSON
    ];
}