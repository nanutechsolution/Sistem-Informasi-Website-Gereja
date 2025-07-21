<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import ini untuk relasi BelongsTo

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'published_at',
        'user_id', // Penting: pastikan ini ada karena ada foreign key ke tabel users
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi dengan model User (untuk mengetahui siapa yang mempublish berita).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
