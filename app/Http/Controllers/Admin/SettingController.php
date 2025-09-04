<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChurchSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Tampilkan halaman edit setting
    public function edit()
    {
        $setting = ChurchSetting::first();
        return view('admin.settings.edit', compact('setting'));
    }

    // Update setting gereja
    public function update(Request $request)
    {
        $setting = ChurchSetting::first();

        $data = $request->only([
            'nama_gereja',
            'alamat',
            'telepon',
            'email',
            'website',
            'facebook',
            'instagram',
            'youtube',
            'maps_embed',
            'motto',
            'visi',
            'misi',
            'ayat_firman_sumber',
            'ayat_firman',
            'sejarah_singkat',

        ]);

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('church_logo', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('status', 'Pengaturan berhasil diperbarui');
    }
}
