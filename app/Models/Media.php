<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_album_id',
        'type',
        'path',
        'thumbnail_path',
        'caption',
        'mediable_id',
        'mediable_type' // Kolom untuk relasi polimorfik
    ];

    public function galleryAlbum(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
