<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@gereja.com')->first();
        if (!$adminUser) {
            $adminUser = User::factory()->create(['email' => 'admin@gereja.com']);
        }

        $postsData = [
            [
                'title' => 'Ucapan Selamat Paskah dari Majelis Jemaat',
                'content' => 'Segenap Majelis Jemaat mengucapkan Selamat Hari Raya Paskah kepada seluruh jemaat. Kiranya kebangkitan Kristus membawa sukacita dan pengharapan baru bagi kita semua. Mari terus bertumbuh dalam iman dan pelayanan.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Laporan Kegiatan Bakti Sosial Komisi Diakonia',
                'content' => 'Pada tanggal 15 Mei 2025, Komisi Diakonia gereja kita telah sukses menyelenggarakan bakti sosial di desa [Nama Desa]. Kegiatan ini meliputi pembagian sembako, pemeriksaan kesehatan gratis, dan penyuluhan sanitasi. Kami mengucapkan terima kasih atas partisipasi dan dukungan seluruh jemaat. Lebih dari 100 kepala keluarga terbantu.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Panggilan Pelayan Liturgi Baru',
                'content' => 'Gereja membutuhkan pelayan liturgi baru untuk periode pelayanan 2025-2028. Bagi jemaat yang terpanggil dan memiliki kerinduan untuk melayani, silakan mendaftarkan diri kepada sekretariat gereja paling lambat tanggal 30 Juli 2025. Persyaratan dapat dilihat di papan pengumuman gereja.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Renungan Harian: Pentingnya Doa dalam Kehidupan',
                'content' => 'Doa adalah nafas kehidupan orang percaya. Melalui doa, kita bersekutu dengan Tuhan, mencurahkan isi hati, dan menerima kekuatan. Janganlah jemu-jemu berdoa, sebab Tuhan selalu setia mendengarkan setiap seruan anak-anak-Nya. Dalam Mazmur 42:8 dikatakan, "Pada siang hari TUHAN memerintahkan kasih setia-Nya, dan pada malam hari nyanyianku kepada-Nya, suatu doa kepada Allah kehidupanku." Marilah kita jadikan doa sebagai prioritas utama dalam setiap aspek hidup kita.',
                'image' => null,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Perubahan Jadwal Ibadah Minggu Ini',
                'content' => 'Diberitahukan kepada seluruh jemaat, sehubungan dengan adanya kegiatan khusus, jadwal ibadah Minggu tanggal [Tanggal Minggu] akan dilaksanakan pada pukul 08.00 WITA dan 10.00 WITA. Tidak ada perubahan untuk ibadah sore. Mohon perhatian seluruh jemaat. Tuhan memberkati.',
                'image' => null,
                'is_published' => true,
                'published_at' => now(), // Hari ini
            ],
        ];

        foreach ($postsData as $data) {
            $post = Post::firstOrCreate(['title' => $data['title']], array_merge($data, [
                'user_id' => $adminUser->id,
                'slug' => Str::slug($data['title']),
            ]));

            // Salin gambar dummy jika ada
            if (file_exists(storage_path('app/dummy_images/dummy-post.jpg')) && is_null($post->image)) {
                $path = Storage::disk('public')->putFile('post_images', new \Illuminate\Http\File(storage_path('app/dummy_images/dummy-post.jpg')));
                $post->update(['image' => $path]);
            }
        }
        Post::factory(10)->create(['user_id' => $adminUser->id]); // Buat 10 postingan dummy lainnya
    }
}
