<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryAlbum;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $albumsData = [
            [
                'name' => 'Kunjungan Diakonia ke Panti Asuhan',
                'description' => 'Momen kebersamaan Komisi Diakonia dengan anak-anak panti asuhan.',
                'event_date' => '2024-03-10',
                'cover_image' => null,
                'media_count' => 5, // Jumlah media dummy yang akan dibuat
            ],
            [
                'name' => 'Ibadah Natal 2024',
                'description' => 'Foto-foto kemeriahan ibadah Natal tahun 2024.',
                'event_date' => '2024-12-25',
                'cover_image' => null,
                'media_count' => 8,
            ],
            [
                'name' => 'Lomba Kemerdekaan 17 Agustus',
                'description' => 'Keceriaan jemaat mengikuti berbagai lomba dalam rangka HUT RI.',
                'event_date' => '2024-08-17',
                'cover_image' => null,
                'media_count' => 6,
            ],
        ];

        foreach ($albumsData as $albumData) {
            $album = GalleryAlbum::firstOrCreate(
                ['name' => $albumData['name']],
                collect($albumData)->except('media_count')->toArray()
            );

            // Salin gambar cover dummy jika ada
            if (file_exists(storage_path('app/dummy_images/dummy-cover.jpg')) && is_null($album->cover_image)) {
                $path = Storage::disk('public')->putFile('gallery_covers', new \Illuminate\Http\File(storage_path('app/dummy_images/dummy-cover.jpg')));
                $album->update(['cover_image' => $path]);
            }

            // Tambahkan media dummy ke album
            for ($i = 0; $i < $albumData['media_count']; $i++) {
                $mediaType = (rand(0, 5) < 5) ? 'image' : 'video'; // 80% gambar, 20% video
                $dummyFilePath = ($mediaType === 'image') ? 'app/dummy_images/dummy-image-' . ($i % 2 == 0 ? '1.jpg' : '2.jpg') : 'app/dummy_images/dummy-video.mp4'; // Asumsi ada dummy-image-1.jpg, dummy-image-2.jpg, dummy-video.mp4

                if (file_exists(storage_path($dummyFilePath))) {
                    $mediaPath = Storage::disk('public')->putFile(
                        'gallery_media/' . $album->id,
                        new \Illuminate\Http\File(storage_path($dummyFilePath))
                    );

                    Media::firstOrCreate(
                        ['path' => $mediaPath],
                        [
                            'gallery_album_id' => $album->id,
                            'type' => $mediaType,
                            'path' => $mediaPath,
                            'caption' => ($mediaType === 'image' ? 'Foto ' : 'Video ') . ($i + 1) . ' dari ' . $album->name,
                            'mediable_id' => $album->id, // Untuk polymorphic, pointing back to album
                            'mediable_type' => GalleryAlbum::class,
                        ]
                    );
                }
            }
        }
        GalleryAlbum::factory(3)->create(); // Buat 3 album dummy lainnya
    }
}
