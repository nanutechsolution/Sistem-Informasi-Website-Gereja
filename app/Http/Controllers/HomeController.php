<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;    // Untuk berita/pengumuman
use App\Models\Event;   // Untuk acara
use App\Models\Schedule; // Untuk jadwal ibadah rutin (jika ada data yang berbeda dari Event)
use App\Models\GalleryAlbum; // Untuk galeri
use Carbon\Carbon; // Untuk filter tanggal

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

        // Ambil jadwal ibadah rutin (misal, yang berulang mingguan)
        // Untuk jadwal mingguan, biasanya kita tidak simpan di tabel schedules per tanggal,
        // melainkan jadwal berulang. Namun, jika Anda mencatat schedules seperti "ibadah minggu",
        // kita bisa tampilkan yang terdekat.
        // Untuk demo, kita ambil 3 schedules yang tanggalnya belum lewat
        $upcomingSchedules = Schedule::where('date', '>=', Carbon::now()->toDateString())
            ->orderBy('date')
            ->orderBy('time')
            ->take(3)
            ->get();

        // Ambil 3 album galeri terbaru
        $latestAlbums = GalleryAlbum::latest('event_date')->take(3)->get();


        return view('welcome', compact('latestPosts', 'upcomingEvents', 'upcomingSchedules', 'latestAlbums'));
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
}