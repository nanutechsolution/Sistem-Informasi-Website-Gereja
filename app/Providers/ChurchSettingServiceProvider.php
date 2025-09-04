<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ChurchSetting;

class ChurchSettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Ambil data pengaturan gereja pertama
        $settings = ChurchSetting::first();

        // Inject ke semua view
        View::composer('*', function ($view) use ($settings) {
            $view->with([
                'churchName'  => $settings?->nama_gereja ?? 'GKS Reda',
                'alamat'      => $settings?->alamat ?? '',
                'telepon'     => $settings?->telepon ?? '',
                'email'       => $settings?->email ?? '',
                'website'     => $settings?->website ?? '',
                'logo_path'   => $settings?->logo_path ?? '',
                'facebook'    => $settings?->facebook ?? '',
                'instagram'   => $settings?->instagram ?? '',
                'youtube'     => $settings?->youtube ?? '',
                'maps_embed'  => $settings?->maps_embed ?? '',
                'motto'       => $settings?->motto ?? 'Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan.',
                'visi'        => $settings?->visi ?? '',
                'sejarah_singkat' => $settings?->sejarah_singkat ?? 'Didirikan pada tahun [Tahun Pendirian], Gereja Kristen Sumba Jemaat Reda Pada telah menjadi pilar spiritual
                    bagi banyak keluarga di wilayah ini. Kami terus berkomitmen untuk menjadi terang dan garam di tengah-tengah
                    komunitas kami.',
                'misi'        => $settings?->misi ?? '',
                'ayat_firman_sumber' => $settings?->ayat_firman_sumber ??
                    'Yohanes 13:34-35',
                'ayat_firman' => $settings?->ayat_firman ??
                    'Aku memberikan perintah baru kepada kamu, yaitu supaya kamu saling mengasihi; sama seperti Aku telah
                    mengasihi kamu, demikian pula kamu harus saling mengasihi. Dengan demikian semua orang akan tahu bahwa kamu adalah
                    murid-murid-Ku, yaitu jikalau kamu saling mengasihi.”',
            ]);
        });
    }
}
