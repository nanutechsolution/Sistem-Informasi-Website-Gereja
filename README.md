# ⛪ Sistem Informasi & Website Gereja

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

---

## ✨ Pendahuluan

Sistem Informasi & Website Gereja adalah sebuah aplikasi web komprehensif dan dapat dikonfigurasi, dirancang untuk mengelola berbagai aspek operasional dan komunikasi gereja manapun. Dari administrasi jemaat hingga pengelolaan keuangan dan publikasi konten, sistem ini bertujuan untuk mempermudah tugas-tugas harian gereja serta meningkatkan interaksi dengan jemaat dan masyarakat umum.

Dibangun dengan framework modern Laravel 12 dan *styling* menggunakan Tailwind CSS, aplikasi ini menawarkan antarmuka yang responsif, intuitif, dan *powerful*. **Sistem ini sepenuhnya generik, memungkinkan Anda untuk mengubah nama gereja, alamat, kontak, dan banyak pengaturan lainnya langsung dari panel admin.**

## 🚀 Fitur Utama

Aplikasi ini dibagi menjadi dua bagian besar: **Panel Admin** untuk pengurus gereja dan **Website Publik** untuk jemaat dan pengunjung.

### 🖥️ Panel Admin (Untuk Pengurus Gereja)

Sebuah dashboard yang lengkap untuk mengelola seluruh data dan fungsionalitas gereja.

* **Dashboard Utama Dinamis:**
    * Ringkasan statistik penting (total jemaat, pengumuman aktif, acara mendatang, saldo keuangan bulan ini).
    * Akses cepat ke modul-modul utama.
* **Manajemen Pengguna & Peran:**
    * CRUD (Create, Read, Update, Delete) pengguna admin.
    * Sistem peran dan hak akses berbasis role (`admin`, `sekretaris`, `bendahara`, `editor_konten`) menggunakan `spatie/laravel-permission`.
* **Manajemen Anggota Jemaat:**
    * CRUD data jemaat yang detail (informasi pribadi, kontak, status keanggotaan, tanggal baptis/sidi, dll.).
* **Manajemen Keluarga Jemaat:**
    * CRUD unit keluarga dan penetapan kepala keluarga.
    * Pengelolaan hubungan antar anggota dalam satu unit keluarga.
* **Manajemen Pelayanan & Komisi Gereja:**
    * CRUD daftar pelayanan/komisi gereja.
    * Pengelolaan anggota yang tergabung dalam setiap pelayanan.
* **Manajemen Konten Website:**
    * **Berita & Artikel:** CRUD berita/artikel dengan judul, konten rich-text, gambar unggulan, slug otomatis, dan status publikasi.
    * **Jadwal Ibadah Umum:** CRUD jadwal ibadah rutin (tanggal, waktu, lokasi, deskripsi).
    * **Jadwal PKS (Persekutuan Keluarga):** CRUD jadwal ibadah di rumah tangga (nama kegiatan, hari, waktu, lokasi rumah, nama pemimpin, daftar anggota terlibat).
    * **Manajemen Acara:** CRUD acara gereja dengan detail (judul, lokasi, waktu mulai/selesai, penyelenggara, gambar banner, status publikasi).
    * **Manajemen Galeri Foto & Video:** CRUD album galeri dengan gambar cover, serta upload dan pengelolaan banyak foto/video di setiap album.
    * **Pesan Kontak:** Melihat pesan yang dikirim dari formulir kontak publik dan menghapusnya.
* **Manajemen Keuangan:**
    * **Pemasukan:** CRUD pencatatan persembahan, perpuluhan, donasi, dll., lengkap dengan kategori, jumlah, tanggal, sumber, dan bukti transaksi.
    * **Pengeluaran:** CRUD pencatatan pengeluaran operasional, dll., lengkap dengan kategori, jumlah, tanggal, penerima, dan bukti transaksi.
    * **Kategori Keuangan:** CRUD kategori pemasukan dan pengeluaran.
    * **Laporan Keuangan Dinamis:** Ringkasan total keuangan, detail transaksi, ringkasan per kategori, serta **visualisasi grafik interaktif** (Pie Chart, Line Chart) menggunakan Chart.js.
* **Sistem Notifikasi Internal:**
    * Notifikasi real-time di dashboard admin saat ada aksi penting (e.g., pengumuman/berita baru, pesan kontak baru).
    * Jumlah notifikasi belum dibaca di sidebar.
    * Fungsionalitas "tandai sudah dibaca".
* **Pengaturan Sistem (Generik):**
    * Modul khusus untuk mengelola **nama gereja, alamat, kontak, tagline, judul halaman beranda, URL logo**, dan informasi dasar lainnya yang membuat sistem ini dapat digunakan oleh gereja mana pun.
* **Penyempurnaan UI/UX Admin:**
    * Navigasi sidebar yang dapat dibuka/ditutup (collapsible) untuk modul.
    * **Toggle Dark/Light Mode** untuk pengalaman visual yang lebih personal.

### 🌐 Website Publik (Untuk Jemaat & Umum)

Antarmuka yang bersih dan informatif untuk jemaat dan pengunjung.

* **Halaman Beranda Dinamis:** Menampilkan berita/pengumuman terbaru, acara mendatang, jadwal ibadah rutin, dan album galeri terbaru, dengan konten yang dapat dikonfigurasi.
* **Halaman Konten:**
    * **Berita & Artikel:** Daftar semua postingan yang dipublikasi dan halaman detail postingan.
    * **Jadwal Ibadah Umum:** Daftar jadwal ibadah rutin gereja.
    * **Jadwal PKS (Ibadah di Rumah):** Daftar jadwal persekutuan keluarga/ibadah di rumah tangga.
    * **Acara Gereja:** Daftar acara mendatang/terkini dan halaman detail acara.
    * **Galeri Foto & Video:** Daftar album dan halaman detail setiap album dengan media di dalamnya.
* **Halaman Informasi:**
    * **Tentang Kami:** Sejarah, visi, misi gereja (dengan informasi yang dapat dikonfigurasi).
    * **Kontak Kami:** Informasi kontak, lokasi, dan **formulir kontak aktif** untuk mengirim pesan ke gereja (dengan detail kontak yang dapat dikonfigurasi).
* **Sistem Pencarian Universal:** Memungkinkan pencarian di seluruh konten publik (berita, acara, jadwal, galeri).
* **Desain & UI/UX:**
    * **Responsif:** Tampilan optimal di perangkat desktop, tablet, dan mobile.
    * **Modern:** Animasi *fade-in*, efek *hover*, dan transisi halus menggunakan Tailwind CSS.
    * **Notifikasi Toast:** Pesan sukses/error muncul sebagai notifikasi pop-up yang elegan.

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.2+ dengan Laravel 12.x
* **Database:** MySQL
* **Frontend:** HTML, Tailwind CSS 3.x, Alpine.js
* **Visualisasi Data:** Chart.js
* **Manajemen Peran:** Spatie/Laravel-Permission
* **Lingkungan Pengembangan:** Composer, NPM, Vite

## ⚙️ Instalasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/your-username/nama-repo-gereja.git](https://github.com/your-username/nama-repo-gereja.git) # Ganti dengan URL repository Anda
    cd nama-repo-gereja
    ```

2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Salin File `.env`:**
    ```bash
    cp .env.example .env
    ```

4.  **Konfigurasi `.env`:**
    Buka file `.env` dan sesuaikan pengaturan database (MySQL direkomendasikan):
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_gereja # Pastikan database ini sudah Anda buat
    DB_USERNAME=root
    DB_PASSWORD=

    # Konfigurasi Mailtrap/SMTP untuk Testing Email (Opsional, tapi disarankan untuk form kontak)
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io   # Contoh: Host Mailtrap atau smtp.gmail.com
    MAIL_PORT=2525               # Contoh: Port Mailtrap atau 587/465
    MAIL_USERNAME=null           # Contoh: Username Mailtrap Anda
    MAIL_PASSWORD=null           # Contoh: Password Mailtrap Anda
    MAIL_ENCRYPTION=null         # Contoh: tls atau ssl
    MAIL_FROM_ADDRESS="no-reply@yourdomain.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Database & Seeder:**
    Ini akan membuat semua tabel dan mengisi data dummy termasuk pengaturan dasar yang dapat Anda ubah.
    ```bash
    php artisan migrate:fresh --seed
    ```
    *Catatan: `--seed` akan menjalankan `DatabaseSeeder` yang membersihkan data lama dan mengisi data dummy. Hati-hati di lingkungan produksi.*

7.  **Buat Symbolic Link untuk Storage:**
    Ini penting agar gambar yang diunggah dapat diakses dari web.
    ```bash
    php artisan storage:link
    ```

8.  **Instal Dependensi NPM & Kompilasi Aset Frontend:**
    ```bash
    npm install
    npm run dev
    ```
    *Pastikan `npm run dev` terus berjalan di terminal terpisah selama pengembangan agar perubahan CSS/JS otomatis terkompilasi.*

9.  **Jalankan Server Pengembangan Laravel:**
    ```bash
    php artisan serve
    ```

## 🛠️ Konfigurasi Awal Sistem

Setelah instalasi dan seeding, Anda dapat langsung mengkustomisasi detail gereja Anda:

1.  Akses **Dashboard Admin:** `http://127.0.0.1:8000/login`
2.  Login dengan kredensial default:
    * **Email:** `admin@gereja.com`
    * **Password:** `password`
3.  Navigasi ke **Pengaturan > Pengaturan Sistem**. Di sana Anda dapat mengubah:
    * Nama Lengkap Gereja
    * Nama Pendek Gereja
    * Alamat Gereja
    * Nomor Telepon
    * Email
    * Tagline, Judul Utama Beranda, Subtitle Beranda
    * URL Logo (gunakan URL gambar Anda)
    * Jam Kantor
4.  Setelah disimpan, perubahan akan langsung tercermin di seluruh website publik.

## 🚀 Penggunaan

Setelah konfigurasi awal, Anda dapat mulai menggunakan sistem:

* **Website Publik:** `http://127.0.0.1:8000/` (akan menampilkan detail gereja yang sudah Anda atur).
* **Dashboard Admin:** Jelajahi modul-modul yang tersedia untuk mengelola data gereja Anda.

### Kredensial Admin (Default)

* **Email:** `admin@gereja.com`
* **Password:** `password` (Sangat disarankan untuk segera mengubahnya setelah login pertama kali di lingkungan produksi!)

## 🖼️ Tangkapan Layar / Demo

*(Di sini Anda bisa menambahkan beberapa tangkapan layar (screenshots) dari dashboard admin dan halaman publik yang paling menarik. Misalnya: Halaman Dashboard Admin, Daftar Jemaat, Laporan Keuangan dengan Grafik, Halaman Beranda Publik, Halaman Berita, Halaman Galeri.)*

## 🤝 Kontribusi

Kontribusi dalam bentuk *bug reports*, *feature requests*, atau *pull requests* sangat kami hargai. Silakan buka *issue* di repository ini atau kirim *pull request*.

## 📄 Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).

## 📧 Kontak

Jika Anda memiliki pertanyaan atau ingin menghubungi, silakan kirim email ke:
[your-email@example.com](mailto:your-email@example.com)

---
