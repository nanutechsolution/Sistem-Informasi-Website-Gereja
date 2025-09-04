<footer class="bg-blue-900 text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- Kolom 1: Tentang Gereja --}}
            <div>
                <h3 class="text-2xl font-bold mb-4">{{ $churchName }}</h3>
                <p class="text-gray-300 mb-2 italic">"{{ $motto }}"</p>
                <p class="text-gray-400 text-sm">{{ $alamat }}</p>
            </div>

            {{-- Kolom 2: Tautan Cepat --}}
            <div>
                <h3 class="text-2xl font-bold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Beranda</a></li>
                    <li><a href="{{ route('public.schedules.index') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Jadwal Ibadah</a></li>
                    <li><a href="{{ route('public.posts.index') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Berita & Artikel</a></li>
                    <li><a href="{{ route('public.events.index') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Acara</a></li>
                    <li><a href="{{ route('public.gallery.index') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Galeri</a></li>
                    <li><a href="{{ route('public.contact') }}"
                            class="hover:text-yellow-300 transition-colors duration-300">Kontak Kami</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Media Sosial & Kontak --}}
            <div>
                <h3 class="text-2xl font-bold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4 text-3xl mb-4">
                    @if ($facebook)
                        <a href="{{ $facebook }}" target="_blank"
                            class="text-blue-600 hover:text-yellow-300 transition-colors"><i
                                class="fab fa-facebook-square"></i></a>
                    @endif
                    @if ($instagram)
                        <a href="{{ $instagram }}" target="_blank"
                            class="text-pink-500 hover:text-yellow-300 transition-colors"><i
                                class="fab fa-instagram"></i></a>
                    @endif
                    @if ($youtube)
                        <a href="{{ $youtube }}" target="_blank"
                            class="text-red-600 hover:text-yellow-300 transition-colors"><i
                                class="fab fa-youtube"></i></a>
                    @endif
                </div>
                <h3 class="text-xl font-semibold mb-2">Hubungi Kami</h3>
                <p class="text-gray-400 text-sm">Email: <a href="mailto:{{ $email }}"
                        class="hover:text-yellow-300">{{ $email }}</a></p>
                <p class="text-gray-400 text-sm">Telp: <a href="tel:{{ $telepon }}"
                        class="hover:text-yellow-300">{{ $telepon }}</a></p>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} {{ $churchName }}. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>
