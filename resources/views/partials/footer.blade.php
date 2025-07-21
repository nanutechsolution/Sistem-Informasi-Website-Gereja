<footer class="bg-blue-800 text-white py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Kolom 1: Tentang Gereja --}}
            <div>
                <h3 class="text-xl font-bold mb-4">GKS Jemaat Reda Pada</h3>
                <p class="text-gray-300 text-sm">
                    Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan. Berlokasi di Sumba, kami berkomitmen
                    untuk menjadi terang bagi komunitas kami.
                </p>
                <p class="text-gray-300 text-sm mt-2">
                    Jl. Contoh No. 123, Reda Pada, Sumba, NTT
                </p>
            </div>

            {{-- Kolom 2: Tautan Cepat --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Beranda</a></li>
                    <li><a href="{{ route('public.schedules.index') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Jadwal Ibadah</a>
                    </li>
                    <li><a href="{{ route('public.posts.index') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Berita &
                            Artikel</a></li>
                    <li><a href="{{ route('public.events.index') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Acara</a></li>
                    <li><a href="{{ route('public.gallery.index') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Galeri</a></li>
                    <li><a href="{{ route('public.contact') }}"
                            class="text-gray-300 hover:text-white transition duration-300 ease-in-out">Kontak Kami</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Media Sosial & Kontak --}}
            <div>
                <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4 mb-4">
                    <a href="#" class="text-gray-300 hover:text-white transition duration-300 ease-in-out">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/facebook-new.png" alt="Facebook"
                            class="h-6 w-6 inline-block" />
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition duration-300 ease-in-out">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png" alt="Instagram"
                            class="h-6 w-6 inline-block" />
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition duration-300 ease-in-out">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/whatsapp--v1.png" alt="WhatsApp"
                            class="h-6 w-6 inline-block" />
                    </a>
                </div>
                <h3 class="text-xl font-bold mb-2">Hubungi Kami</h3>
                <p class="text-gray-300 text-sm">Email: info@gerejareda.org</p>
                <p class="text-gray-300 text-sm">Telp: (021) 123-4567</p>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Gereja Kristen Sumba Jemaat Reda Pada. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>
