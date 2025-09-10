<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnsplashService;

class DownloadUnsplashImages extends Command
{
    protected $signature = 'unsplash:download {count=1}';
    protected $description = 'Download stok gambar Unsplash ke public/images/unsplash';

    public function handle()
    {
        $count = (int) $this->argument('count');

        $this->info("Mulai mendownload $count gambar...");

        for ($i = 1; $i <= $count; $i++) {
            $path = UnsplashService::saveChurchImage();
            if ($path) {
                $this->info("[$i/$count] Gambar tersimpan: $path");
            } else {
                $this->error("[$i/$count] Gagal mendownload gambar.");
            }
        }

        $this->info("Selesai!");
    }
}
