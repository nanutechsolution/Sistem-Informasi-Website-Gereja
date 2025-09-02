<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;    // Untuk berita/pengumuman
use App\Models\Event;   // Untuk acara
use App\Models\Schedule; // Untuk jadwal ibadah rutin (jika ada data yang berbeda dari Event)
use App\Models\GalleryAlbum; // Untuk galeri
use App\Models\PksSchedule;
use App\Services\UnsplashService;
use Carbon\Carbon; // Untuk filter tanggal
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     */
    public function index()
    {
        // Ambil 3 berita/pengumuman terbaru yang sudah dipublikasi
        $latestPosts = Post::where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Ambil 3 acara mendatang yang sudah dipublikasi
        $upcomingEvents = Event::where('is_published', true)
            ->where('start_time', '>=', Carbon::now())
            ->orderBy('start_time')
            ->take(3)
            ->get();
        $upcomingSchedules = Schedule::where('date', '>=', Carbon::now()->toDateString())
            ->orderBy('date')
            ->orderBy('time')
            ->take(3)
            ->get();

        // Ambil 3 album galeri terbaru
        $latestAlbums = GalleryAlbum::latest('event_date')->take(3)->get();

        $churchImage = $this->getUnsplashChurchImage();
        $unsplashImage = UnsplashService::getChurchImage();

        return view('welcome', compact(
            'latestPosts',
            'upcomingEvents',
            'upcomingSchedules',
            'latestAlbums',
            'churchImage',
            'unsplashImage'
        ));
    }
    public function getUnsplashChurchImage()
    {
        $response = Http::get('https://api.unsplash.com/photos/random', [
            'query' => 'church',
            'client_id' => env('UNSPLASH_ACCESS_KEY'),
            'orientation' => 'landscape',
        ]);
        if ($response->successful()) {
            $data = $response->json();
            return $data['urls']['regular'] ?? null;
        }
        return "https://images.unsplash.com/photo-1491396023581-4344e51fec5c?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";
    }
    /**
     * Tampilkan halaman Berita/Artikel (Public Posts Index).
     */
    public function postsIndex()
    {
        $posts = Post::where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(9); // 9 postingan per halaman
        return view('public.posts.index', compact('posts'));
    }

    /**
     * Tampilkan detail Berita/Artikel (Public Post Show).
     */
    public function postShow(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->firstOrFail();
        return view('public.posts.show', compact('post'));
    }

    /**
     * Tampilkan halaman Jadwal Ibadah (Public Schedules Index).
     */
    public function schedulesIndex()
    {
        $schedules = Schedule::orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(10);
        return view('public.schedules.index', compact('schedules'));
    }

    /**
     * Tampilkan halaman Acara (Public Events Index).
     */
    public function eventsIndex()
    {
        $events = Event::where('is_published', true)
            ->where('start_time', '>=', Carbon::now()->subDays(7)) // Tampilkan acara 7 hari ke belakang juga
            ->orderBy('start_time', 'asc')
            ->paginate(10);
        return view('public.events.index', compact('events'));
    }

    /**
     * Tampilkan halaman detail Acara (Public Event Show).
     */
    public function eventShow(string $slug)
    {
        $event = Event::where('slug', $slug) // Pastikan Model Event punya kolom slug
            ->where('is_published', true)
            ->firstOrFail();
        return view('public.events.show', compact('event'));
    }

    /**
     * Tampilkan halaman Galeri Album (Public Gallery Index).
     */
    public function galleryIndex()
    {
        $albums = GalleryAlbum::latest('event_date')->paginate(12);
        return view('public.gallery.index', compact('albums'));
    }

    /**
     * Tampilkan detail Album Galeri (Public Gallery Show).
     */
    public function galleryShow(GalleryAlbum $album)
    {
        $album->load('media'); // Load media di dalam album
        return view('public.gallery.show', compact('album'));
    }

    /**
     * Tampilkan halaman Tentang Kami.
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Tampilkan halaman Kontak.
     */
    public function contact()
    {
        return view('public.contact');
    }


    public function calendar()
    {
        return view('public.pks_calendar');
    }

    public function calendarData(Request $request)
    {
        $query = PksSchedule::where('is_active', 1);

        // Filter optional
        if ($request->leader) {
            $query->where('leader_name', $request->leader);
        }
        if ($request->location) {
            $query->where('location', $request->location);
        }

        $events = $query->get()->map(fn($s) => [
            'id'    => $s->id,
            'title' => $s->activity_name,
            'start' => $s->start_date_time->toDateTimeString(),
            'end'   => $s->end_date_time->toDateTimeString(),
            'url'   => null, // optional, publik biasanya nggak link ke admin
            'extendedProps' => [
                'location' => $s->location,
                'leader'   => $s->leader_name,
                'desc'     => $s->description,
            ],
            'color' => '#3788d8',
        ]);

        return response()->json($events);
    }
}