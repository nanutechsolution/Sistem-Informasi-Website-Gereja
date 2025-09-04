@extends('layouts.admin.app')

@section('title', '| Pengaturan Gereja')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Pengaturan Gereja</h1>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200 p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            {{-- Nama Gereja --}}
            <div>
                <label for="nama_gereja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                    Gereja</label>
                <input type="text" name="nama_gereja" id="nama_gereja"
                    value="{{ old('nama_gereja', $setting->nama_gereja) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>
            {{-- Motto --}}
            <div>
                <label for="motto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motto</label>
                <input type="text" name="motto" id="motto" value="{{ old('motto', $setting->motto) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>

            {{-- visi --}}
            <div>
                <label for="visi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visi</label>
                <textarea name="visi" id="visi" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('visi', $setting->visi) }}</textarea>
            </div>
            {{-- misi use textarea --}}
            <div>
                <label for="misi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Misi (pisahkan
                    dengan
                    baris baru)</label>
                <textarea name="misi" id="misi" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('misi', $setting->misi) }}</textarea>
            </div>
            {{-- Ayat Firman --}}
            <div>
                <label for="ayat_firman" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ayat
                    Firman</label>
                <textarea name="ayat_firman" id="ayat_firman" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('ayat_firman', $setting->ayat_firman) }}</textarea>
            </div>
            {{-- Sumber Ayat Firman --}}
            <div>
                <label for="ayat_firman_sumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber
                    Ayat Firman</label>
                <input type="text" name="ayat_firman_sumber" id="ayat_firman_sumber"
                    value="{{ old('ayat_firman_sumber', $setting->ayat_firman_sumber) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>

            {{-- sejarah --}}
            <div>
                <label for="sejarah_singkat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sejarah
                    Singkat</label>
                <textarea name="sejarah_singkat" id="sejarah_singkat" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">{{ old('sejarah_singkat', $setting->sejarah_singkat) }}</textarea>
                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $setting->alamat) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                </div>
                {{-- Telepon & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="telepon"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $setting->telepon) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $setting->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    </div>
                </div>

                {{-- Logo --}}
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo
                        Gereja</label>
                    <input type="file" name="logo" id="logo"
                        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0 file:text-sm file:font-semibold
                   file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        accept="image/*" onchange="previewLogo(event)">
                    <div class="mt-3">
                        <img id="logo-preview" src="{{ $setting->logo_path ? Storage::url($setting->logo_path) : '' }}"
                            alt="Logo" class="h-24 w-24 object-cover rounded-full border">
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="facebook"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook</label>
                        <input type="url" name="facebook" id="facebook"
                            value="{{ old('facebook', $setting->facebook) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="instagram"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram</label>
                        <input type="url" name="instagram" id="instagram"
                            value="{{ old('instagram', $setting->instagram) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="youtube"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Youtube</label>
                        <input type="url" name="youtube" id="youtube"
                            value="{{ old('youtube', $setting->youtube) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    </div>
                </div>

                {{-- Embed Maps --}}
                <div>
                    <label for="maps_embed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Embed
                        Google
                        Maps</label>
                    <textarea name="maps_embed" id="maps_embed" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 p-2"
                        placeholder="Paste iframe Google Maps">{{ old('maps_embed', $setting->maps_embed) }}</textarea>
                    <div class="mt-2">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview:</h3>
                        <div id="maps-preview" class="mt-2 border rounded overflow-hidden">
                            {!! $setting->maps_embed !!}
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Simpan</button>
        </form>
    </div>

    <script>
        function previewLogo(event) {
            const preview = document.getElementById('logo-preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
        }

        // Live preview maps
        const mapsTextarea = document.getElementById('maps_embed');
        const mapsPreview = document.getElementById('maps-preview');
        mapsTextarea.addEventListener('input', () => {
            mapsPreview.innerHTML = mapsTextarea.value;
        });
    </script>
    {{-- 
    <script>
        var quill = new Quill('#misi-editor', {
            theme: 'snow', // default, tapi kita ganti style background
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Submit: ambil HTML Quill ke input hidden
        document.querySelector('form').onsubmit = function() {
            document.querySelector('#misi').value = quill.root.innerHTML;
        };
    </script> --}}

@endsection
