<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot; // Penting: extends Pivot

class MinistryMember extends Pivot
{
    use HasFactory;

    // Jika Anda tidak menggunakan kolom `id` pada pivot table, set ini ke false
    public $incrementing = true; // Jika ada ID, default-nya true
    protected $table = 'ministry_members'; // Pastikan nama tabelnya benar

    protected $fillable = [
        'ministry_id',
        'member_id',
        'role',
        'joined_date'
    ];

    protected $casts = [
        'joined_date' => 'date',
    ];

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
