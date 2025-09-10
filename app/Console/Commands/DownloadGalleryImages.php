<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnsplashService;

class DownloadGalleryImages extends Command
{
    protected $signature = 'gallery:download {count=1}';
    protected $description = 'Download stok gambar Unsplash ke public/images/gallery';

    public function handle()
    {
        $count = (int) $this->argument('count');
        $this->info("Mulai mendownload $count gambar untuk Galeri...");

        for ($i = 1; $i <= $count; $i++) {
            $path = UnsplashService::saveGalleryImage();
            if ($path) {
                $this->info("[$i/$count] Gambar tersimpan: $path");
            } else {
                $this->error("[$i/$count] Gagal mendownload gambar.");
            }
        }

        $this->info("Selesai mendownload stok Galeri!");
    }
}
