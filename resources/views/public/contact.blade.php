@extends('layouts.app')

@section('title', '| Kontak Kami')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">Kontak Kami</h1>
        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            <p class="text-lg text-gray-700 leading-relaxed mb-6">
                Kami senang mendengar kabar dari Anda! Jika Anda memiliki pertanyaan, saran, atau ingin bergabung dengan
                kami, jangan ragu untuk menghubungi kami melalui informasi di bawah ini.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Informasi Gereja</h2>
                    <p class="text-gray-700 mb-2"><strong>Alamat:</strong> Jl. Contoh Gereja No. 123, Desa Reda Pada, Kec.
                        Contoh, Kab. Sumba, NTT</p>
                    <p class="text-gray-700 mb-2"><strong>Telepon:</strong> (021) 123-4567</p>
                    <p class="text-gray-700 mb-2"><strong>Email:</strong> info@gerejaredapada.org</p>
                    <p class="text-gray-700 mb-2"><strong>Jam Kantor:</strong> Senin - Jumat, 09:00 - 17:00 WIB</p>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-6 mb-3">Media Sosial</h2>
                    <div class="flex space-x-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-3xl"><i
                                class="fab fa-facebook-square"></i></a>
                        <a href="#" class="text-pink-600 hover:text-pink-800 text-3xl"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-green-600 hover:text-green-800 text-3xl"><i
                                class="fab fa-whatsapp"></i></a>
                        {{-- Anda bisa tambahkan ikon Font Awesome jika sudah diintegrasikan --}}
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Kirim Pesan</h2>

                    {{-- Pesan Sukses/Error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Validasi Gagal!</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('public.contact.submit') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Anda</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Anda</label>
                            <input type="email" id="email" name="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="message_content" class="block text-sm font-medium text-gray-700">Pesan Anda</label>
                            <textarea id="message_content" name="message_content" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>{{ old('message_content') }}</textarea>
                            @error('message_content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ReCAPTCHA Placeholder (jika diaktifkan nanti) --}}
                        {{-- <div class="mb-4">
                            <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                            @error('g-recaptcha-response') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div> --}}

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Kirim
                            Pesan</button>
                    </form>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-3">Lokasi Kami</h2>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15730.082725458025!2d120.30607995!3d-9.68962285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da493ae4d1d94f3%3A0x6b19d5c2e1f440a7!2sSumba!5e0!3m2!1sen!2sid!4v1721580838186!5m2!1sen!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    {{-- Ganti URL embed Google Maps dengan lokasi Gereja Kristen Sumba Jemaat Reda Pada yang sebenarnya --}}
                </div>
                <p class="text-center text-gray-600 text-sm mt-2">Gereja Kristen Sumba Jemaat Reda Pada (Lokasi Placeholder)
                </p>
            </div>
        </div>
    </div>
@endsection
