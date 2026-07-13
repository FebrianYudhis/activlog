# Changelog

Semua perubahan penting pada proyek ini akan didokumentasikan di file ini.

Format ini didasarkan pada [Keep a Changelog](https://keepachangelog.com/id/1.1.0/),
dan proyek ini mematuhi [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.1]
### Fixed
- Menghapus tautan ganda "Ganti Password" dari navbar utama.
- Memperbaiki urutan daftar permintaan hapus data logbook dan logbook belum diperiksa pada panel admin agar menampilkan data terlama terlebih dahulu (ascending).
- Memperbaiki format tampilan tanggal pada detail logbook di panel admin agar tidak menyertakan waktu (00:00:00).
- Memperbaiki urutan daftar aktivitas (task) pada detail logbook agar diurutkan berdasarkan waktu secara *ascending* (dari awal hingga terbaru).

## [2.0.0]
### Added
- Fitur Ganti Password untuk pengguna.
- Integrasi Yajra DataTables (Server-side AJAX) pada Panel Admin untuk skalabilitas jutaan baris data tanpa kehabisan memori.
- Kebijakan Otorisasi (Policies) `DateSchedulePolicy` untuk melindungi hak akses modifikasi logbook.

### Changed
- Menggabungkan tabel `notes` ke dalam tabel `date_schedules` untuk menyederhanakan dan mengoptimasi struktur database.
- Menggunakan `old()` *helpers* pada semua formulir agar isian pengguna tidak hilang saat validasi gagal.

## [1.5.3]
### Added
- Footer watermark untuk unduhan PDF.

## [1.5.2]
### Added
- Kustomisasi halaman peringatan kode 503.

## [1.5.1]
### Changed
- Format unduhan logbook dari Excel menjadi PDF.

## [1.5.0]
### Added
- Form input waktu untuk jam tugas atau kegiatan.

## [1.4.3]
### Fixed
- Bug di mana pengguna dapat melihat logbook pegawai lain.

## [1.4.2]
### Changed
- Sorting pada panel list logbook.

## [1.4.1]
### Added
- Fitur cek logbook.
### Fixed
- Tampilan antarmuka.

## [1.4.0]
### Added
- Kolom cek logbook pada database.
### Changed
- Membatasi unduhan data hanya untuk logbook yang sudah diperiksa.
### Fixed
- Perbaikan struktur route.

## [1.3.1]
### Fixed
- Bug pada route.

## [1.3.0]
### Added
- Penyelesaian fitur unduhan data logbook (Stable Release).

## [1.2.11]
### Added
- Menyiapkan kerangka fitur unduh data logbook.

## [1.2.10]
### Added
- Menambahkan list data logbook.

## [1.2.9]
### Added
- Kolom alasan minta hapus dan implementasi fitur persetujuan penghapusan.

## [1.2.8]
### Changed
- Merapikan struktur kodingan.

## [1.2.7]
### Added
- Menu hapus logbook pada halaman admin.

## [1.2.6]
### Added
- List permintaan hapus data logbook.
- Tampilan detail logbook.

## [1.2.5]
### Added
- Menyiapkan template halaman admin.

## [1.2.4]
### Changed
- Merapikan struktur kodingan.

## [1.2.3]
### Added
- Kerangka dasar halaman admin.

## [1.2.2]
### Removed
- Min date (tanggal minimum) untuk menambahkan tanggal logbook.

## [1.2.1]
### Added
- Data baru ke seeder database.

## [1.2.0]
### Added
- Penyelesaian menu tambah tugas (Stable Release).

## [1.1.6]
### Added
- Informasi pengeditan logbook.

## [1.1.5]
### Changed
- Merapikan routing.

## [1.1.4]
### Security
- Mengunci logika untuk mengedit catatan dan menghapus tugas.

## [1.1.3]
### Security
- Mengunci tampilan untuk mengedit catatan dan menghapus tugas.

## [1.1.2]
### Added
- Task factory untuk seeder.
- List tugas dan fitur hapus tugas.

## [1.1.1]
### Added
- Menampilkan catatan pada isi logbook.

## [1.1.0]
### Added
- Menu tambah tanggal logbook.

## [1.0.20]
### Changed
- Konfigurasi timezone aplikasi.

## [1.0.19]
### Added
- Fitur minta hapus pada tabel DataSchedule.

## [1.0.18]
### Added
- Kolom baru pada tabel DateSchedule.

## [1.0.17]
### Added
- DateSchedule Observer agar tabel Note otomatis terisi apabila ada DateSchedule baru.

## [1.0.16]
### Added
- Notifikasi SweetAlert ketika data terhapus.

## [1.0.15]
### Added
- Parameter pengaturan di file `.env`.
- Dukungan lokalisasi bahasa Indonesia.

## [1.0.14]
### Added
- Integrasi fitur SweetAlert 2 ke sistem.

## [1.0.13]
### Added
- Menginstall package SweetAlert 2.

## [1.0.12]
### Added
- Fitur hapus tanggal logbook.

## [1.0.11]
### Changed
- Memperbarui halaman daftar aplikasi (Register).

## [1.0.10]
### Changed
- Memperbarui halaman masuk aplikasi (Login).

## [1.0.9]
### Added
- Membuat layout dasar aplikasi.

## [1.0.8]
### Changed
- Memperbarui tampilan halaman Home.

## [1.0.7]
### Added
- Menyelesaikan tampilan halaman Home.

## [1.0.6]
### Fixed
- Memperbaiki kodingan.

## [1.0.5]
### Fixed
- Memperbaiki kodingan.

## [1.0.4]
### Fixed
- Memperbaiki halaman masuk aplikasi (Login).

## [1.0.3]
### Fixed
- Memperbaiki halaman daftar aplikasi (Register).

## [1.0.2]
### Added
- Menginstall package Laravel/UI.

## [1.0.1]
### Added
- Membuat relasi antar tabel.

## [1.0.0]
### Added
- Membuat skema basis data awal.
