<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChurchSetting;

class ChurchSettingSeeder extends Seeder
{
    public function run()
    {
        ChurchSetting::create([
            'nama_gereja' => 'GKS Jemaat Reda Pada',
            'alamat' => 'Jl.Marokota, Kec. Wewewa Bar., Kabupaten Sumba Barat Daya, Nusa Tenggara Tim.',
            'telepon' => '0361-123456',
            'email' => 'reda@gks.or.id',
            'website' => 'https://gks.or.id/reda',
            'logo_path' => 'church_logo/gks_reda_logo.png',
            'facebook' => 'https://facebook.com/gksreda',
            'instagram' => 'https://instagram.com/gks.reda',
            'youtube' => 'https://youtube.com/@gksreda',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3935.0865717423826!2d119.17945807375837!3d-9.501199799738995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4ac4568fbfcecb%3A0xab2c16df368c38c3!2sGKS%20Reda%20Pada!5e0!3m2!1sid!2sid!4v1756989142111!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'motto' => 'Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan. Berlokasi di Sumba, kami berkomitmen
                    untuk menjadi terang bagi komunitas kami.',
            'visi' => 'Menjadi gereja yang hidup, dinamis, dan relevan, yang memancarkan kasih Kristus kepada semua orang di
                    Sumba dan sekitarnya.',
            'misi' => '1. Memberitakan Injil Yesus Kristus kepada semua orang di Sumba.
                    2. Membangun komunitas iman yang kuat dan saling mendukung.
                    3. Melayani kebutuhan rohani, sosial, dan fisik masyarakat di sekitar gereja.
                    4. Mengembangkan kepemimpinan gereja yang efektif dan berkelanjutan.',
            'ayat_firman_sumber' => 'Yohanes 13:34-35',
            'ayat_firman' => 'Aku memberikan perintah baru kepada kamu, yaitu supaya kamu saling mengasihi; sama seperti Aku telah
                    mengasihi kamu, demikian pula kamu harus saling mengasihi. Dengan demikian semua orang akan tahu bahwa kamu adalah
                    murid-murid-Ku, yaitu jikalau kamu saling mengasihi.',
            'sejarah_singkat' => 'Didirikan pada tahun 1990, GKS Jemaat Reda Pada telah menjadi pilar spiritual bagi banyak keluarga di wilayah ini. Kami terus berkomitmen untuk menjadi terang dan garam di tengah-tengah komunitas kami.',
        ]);
    }
}
