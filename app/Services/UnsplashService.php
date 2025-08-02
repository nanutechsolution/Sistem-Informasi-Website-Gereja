<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UnsplashService
{
    public static function getChurchImage()
    {
        $response = Http::get('https://api.unsplash.com/photos/random', [
            'query' => 'church',
            'orientation' => 'landscape',
            'client_id' => config('services.unsplash.access_key'),
        ]);

        if ($response->successful()) {
            return $response->json()['urls']['regular'] ?? null;
        }

        return null;
    }
}