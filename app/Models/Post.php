<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // Untuk slug

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relasi dengan user yang membuat postingan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Otomatis buat slug saat menyimpan model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
            if ($post->is_published && is_null($post->published_at)) {
                $post->published_at = now();
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = Str::slug($post->title);
            }
            if ($post->isDirty('is_published') && $post->is_published && is_null($post->published_at)) {
                $post->published_at = now();
            } elseif ($post->isDirty('is_published') && !$post->is_published) {
                $post->published_at = null; // Set null jika tidak dipublikasikan
            }
        });
    }
}
