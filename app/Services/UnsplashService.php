<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UnsplashService
{


    public static function saveGalleryImage()
    {
        $response = Http::get('https://api.unsplash.com/photos/random', [
            'query' => 'church',
            'orientation' => 'landscape',
            'client_id' => config('services.unsplash.access_key'),
        ]);

        if ($response->successful()) {
            $imageUrl = $response->json()['urls']['regular'] ?? null;

            if ($imageUrl) {
                // Buat ukuran random antara 400-1200px width
                $randomWidth = rand(400, 1200);
                $randomHeight = rand(300, 900);

                // Modifikasi URL Unsplash untuk size random
                $imageUrl .= "?w={$randomWidth}&h={$randomHeight}&fit=crop";

                $imageContents = Http::get($imageUrl)->body();

                $filename = 'gallery_' . Str::random(10) . '.jpg';
                $folder = public_path('images/gallery');

                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true);
                }

                $filePath = $folder . '/' . $filename;
                file_put_contents($filePath, $imageContents);

                return 'images/gallery/' . $filename;
            }
        }

        return null;
    }
    /**
     * Download dan simpan stok gambar ke public/images/unsplash
     * Return path relatif file yang disimpan
     */
    public static function saveChurchImage()
    {
        // Request random image dari Unsplash
        $response = Http::get('https://api.unsplash.com/photos/random', [
            'query' => 'church',
            'orientation' => 'landscape',
            'client_id' => config('services.unsplash.access_key'),
        ]);

        if ($response->successful()) {
            $imageUrl = $response->json()['urls']['regular'] ?? null;

            if ($imageUrl) {
                $imageContents = Http::get($imageUrl)->body();

                // Generate nama file unik
                $filename = 'church_' . Str::random(10) . '.jpg';

                // Pastikan folder ada
                $folder = public_path('images/unsplash');
                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true);
                }

                // Simpan file
                $filePath = $folder . '/' . $filename;
                file_put_contents($filePath, $imageContents);

                // Return path relatif
                return 'images/unsplash/' . $filename;
            }
        }

        return null;
    }
}
