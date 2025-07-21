<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Untuk slug

class EventSeeder extends Seeder
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

        $eventsData = [
            [
                'title' => 'Perayaan Natal Bersama Jemaat',
                'description' => 'Ibadah Natal dan Perjamuan Kasih bersama seluruh jemaat dan keluarga.',
                'location' => 'Gedung Serbaguna Gereja',
                'start_time' => now()->addDays(7)->setTime(18, 0, 0),
                'end_time' => now()->addDays(7)->setTime(21, 0, 0),
                'organizer' => 'Panitia Natal',
                'status' => 'scheduled',
                'is_published' => true,
                'image' => null,
            ],
            [
                'title' => 'Retreat Pemuda Gereja',
                'description' => 'Retreat rohani untuk pemuda dengan tema "Berakar dalam Kristus".',
                'location' => 'Panti Asuhan Sumba', // Contoh lokasi eksternal
                'start_time' => now()->addDays(30)->setTime(9, 0, 0),
                'end_time' => now()->addDays(32)->setTime(17, 0, 0),
                'organizer' => 'Komisi Pelayanan Pemuda',
                'status' => 'scheduled',
                'is_published' => true,
                'image' => null,
            ],
            [
                'title' => 'Ibadah Kebangunan Rohani',
                'description' => 'Ibadah khusus dengan pembicara tamu dari luar kota.',
                'location' => 'Gereja Induk',
                'start_time' => now()->addDays(15)->setTime(19, 0, 0),
                'end_time' => now()->addDays(15)->setTime(21, 30, 0),
                'organizer' => 'Majelis Jemaat',
                'status' => 'scheduled',
                'is_published' => true,
                'image' => null,
            ],
            [
                'title' => 'Bersih-bersih Lingkungan Gereja (Kegiatan Diakonia)',
                'description' => 'Kegiatan gotong royong membersihkan lingkungan sekitar gereja.',
                'location' => 'Area Gereja dan Sekitarnya',
                'start_time' => now()->subDays(5)->setTime(8, 0, 0), // Acara yang sudah selesai
                'end_time' => now()->subDays(5)->setTime(12, 0, 0),
                'organizer' => 'Komisi Diakonia',
                'status' => 'completed',
                'is_published' => true,
                'image' => null,
            ],
        ];

        foreach ($eventsData as $data) {
            $event = Event::firstOrCreate(['title' => $data['title']], array_merge($data, [
                'user_id' => $adminUser->id,
                'slug' => Str::slug($data['title']), // Pastikan slug di-generate
            ]));

            // Salin gambar dummy jika ada
            if (file_exists(storage_path('app/dummy_images/dummy-image.jpg')) && is_null($event->image)) {
                $path = Storage::disk('public')->putFile('event_images', new \Illuminate\Http\File(storage_path('app/dummy_images/dummy-image.jpg')));
                $event->update(['image' => $path]);
            }
        }
        Event::factory(5)->create(['user_id' => $adminUser->id]); // Buat 5 acara dummy lainnya
    }
}
