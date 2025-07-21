<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'cover_image'
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
