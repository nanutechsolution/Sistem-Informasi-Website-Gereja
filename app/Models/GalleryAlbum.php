<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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

    public function getImageUrl()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        if ($this->unsplash_image_url) {
            return $this->unsplash_image_url;
        }

        // Fetch image once from Unsplash
        $response = Http::get('https://api.unsplash.com/photos/random', [
            'query' =>  'church',
            'orientation' => 'landscape',
            'client_id' => config('services.unsplash.access_key'),
            'unique' => Str::uuid(), // prevent duplicates from cache
        ]);

        if ($response->successful()) {
            $url = $response->json()['urls']['regular'] ?? null;
            // Save to model, so next time it's used from DB
            $this->unsplash_image_url = $url;
            $this->save();

            return $url;
        }

        // Fallback super aman
        return 'https://source.unsplash.com/featured/?church';
    }
}