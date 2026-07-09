# Activlog

Activlog adalah aplikasi **Manajemen Logbook dan Tugas Pegawai** (Buku Catatan Kegiatan), dibangun menggunakan framework Laravel. Aplikasi ini memudahkan pegawai dalam mencatat kegiatan atau tugas harian mereka, dan memudahkan admin/manajemen untuk memeriksa serta mengekspor data logbook tersebut.

## Fitur Utama

- **Manajemen Autentikasi**: Fitur masuk (login) dan daftar aplikasi yang aman.
- **Pencatatan Logbook Harian**: Pegawai dapat menambahkan tanggal logbook dan mencatat tugas atau kegiatan harian beserta alokasi waktunya.
- **Manajemen Tugas**: Menambahkan, mengedit catatan, dan menghapus tugas dalam logbook.
- **Admin Panel**: Akses dasbor khusus untuk admin mengelola sistem.
- **Fitur Permintaan Hapus**: Pegawai dapat meminta penghapusan logbook dengan menyertakan alasan penghapusan, yang nantinya dikelola oleh admin.
- **Validasi (Cek) Logbook**: Admin dapat memeriksa dan memvalidasi logbook pegawai (hanya logbook yang terverifikasi yang dapat diunduh).
- **Ekspor PDF**: Mengunduh laporan data logbook dalam format PDF (dilengkapi watermark).
- **Notifikasi Interaktif**: Dilengkapi dengan SweetAlert 2 untuk notifikasi aksi yang interaktif.

## Kebutuhan Sistem (Tech Stack)

- **PHP**: ^8.2
- **Framework**: Laravel 12.x
- **Frontend**: Bootstrap 5 (Custom Template)
- **PDF Generator**: barryvdh/laravel-dompdf
- **DataTables**: yajra/laravel-datatables-oracle

## Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal:

1. **Buka terminal dan masuk ke direktori proyek**:

    ```bash
    cd activlog
    ```

2. **Install dependensi PHP (Composer)**:

    ```bash
    composer install
    ```

3. **Konfigurasi Environment**:
   Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Lalu sesuaikan konfigurasi koneksi database Anda di dalam file `.env`.

4. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

5. **Jalankan Migrasi Database dan Seeder**:

    ```bash
    php artisan migrate --seed
    ```

6. **Jalankan Development Server**:
    ```bash
    php artisan serve
    ```

Aplikasi sekarang dapat diakses melalui browser pada `http://localhost:8000`.
