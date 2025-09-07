<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, email address, and profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Foto Profil --}}
        <div x-data="profilePhotoCrop()">
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />

            <!-- Preview -->
            <div class="mt-2">
                <img id="cropper-image" :src="preview" class="h-24 w-24 rounded-full object-cover border"
                    alt="Preview">
            </div>

            <!-- Input Upload -->
            <input type="file" accept="image/*" @change="loadImage($event)"
                class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
               file:rounded-md file:border-0 file:text-sm file:font-semibold
               file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

            <!-- Hidden input untuk dikirim ke server -->
            <input type="hidden" name="profile_photo_cropped" :value="croppedImage">

            <!-- Checkbox Hapus Foto -->
            @if ($user->profile_photo_path)
                <div class="mt-3 flex items-center space-x-2">
                    <input type="checkbox" id="remove_photo" name="remove_photo" value="1" x-model="remove"
                        class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                    <label for="remove_photo" class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Centang jika ingin menghapus foto profil') }}
                    </label>
                </div>
            @endif
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
