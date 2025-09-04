@extends('layouts.admin.app')

@section('title', '| Edit User')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <script>
        function profilePhotoCrop() {
            return {
                preview: '{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : '' }}',
                cropper: null,
                croppedImage: null,

                loadImage(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    this.preview = URL.createObjectURL(file);

                    this.$nextTick(() => {
                        const image = document.getElementById('cropper-image');
                        if (this.cropper) this.cropper.destroy();

                        this.cropper = new Cropper(image, {
                            aspectRatio: 1, // kotak / bulat
                            viewMode: 1,
                            autoCropArea: 0.8,
                            background: false,
                            movable: true,
                            zoomable: true,
                            rotatable: false,
                            scalable: false,
                            crop: () => {
                                // update hidden input setiap user geser crop
                                const canvas = this.cropper.getCroppedCanvas({
                                    width: 200,
                                    height: 200,
                                });
                                this.croppedImage = canvas.toDataURL('image/jpeg');
                            }
                        });
                    });
                }
            }
        }
    </script>



@endsection
