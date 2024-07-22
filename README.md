# A2_Kel-Hydra_Study-Tracer
Uas Matakuliah Pemograman Web
# Tracer Study
kelompok hydra

Wildan Miladji

Muhammad Alif Rizqie

Thoriq Faraj N

# Daftar Isi

Pendahuluan

Fitur

Teknologi yang Digunakan

Instalasi

Penggunaan

Struktur Basis Data

Lisensi

# Pendahuluan

Proyek ini adalah aplikasi web yang mengelola otentikasi pengguna dan daftar pekerjaan, serta mencakup sistem untuk menampilkan evaluasi alumni. Aplikasi ini dibangun menggunakan PHP untuk backend dan Tailwind CSS untuk styling.
Fitur

Otentikasi Pengguna: Daftar, login, dan kelola akun pengguna.

Daftar Pekerjaan: Pengguna dapat melihat dan melamar pekerjaan.

Evaluasi Alumni: Bagi kaprodi bisa menilai kinerja alumni dengan penilaian 1 - 5.

Kuesioner: Pengguna dapat mengisi dan mengirimkan kuesioner.

Admin : Dapat mengelola backend.

Kelola Entri: Pengguna dapat menghapus entri kuesioner mereka sendiri untuk menghindari pengiriman duplikat.

# Teknologi yang Digunakan
Backend: PHP

Frontend: HTML, Tailwind CSS

Basis Data: MySQL

# Instalasi

Klon repositori:

bash

git clone https://github.com/usernameanda/proyekanda.git
cd proyekanda

Instal dependensi:
Pastikan Anda telah menginstal PHP dan MySQL di mesin Anda.

Siapkan basis data:

Impor file SQL yang disediakan untuk menyiapkan skema dan tabel basis data.
Perbarui konfigurasi basis data di file koneksi.php.

Jalankan aplikasi:

Mulai server PHP Anda:

bash

        php -S localhost:8000

        Buka browser web Anda dan navigasikan ke http://localhost:8000.

# Penggunaan

Daftar/Login:
Navigasikan ke halaman pendaftaran atau login untuk membuat akun atau masuk.

untuk login menjadi admin.
username : admin

password : admin#1234

untuk login menjadi kaprodi:

nidn : 0118342833

password : 1234

untuk login menjadi alumni:

nim : 2113191095

password : 1234

# Halaman Alumni:
Setelah masuk sebagai alumni maka akan ada navigasi yang dapat mempermudah alumni untuk mengisi kuesioner, lalu jika alumni ingin menghapus jawaban kuesioner sudah ada button yang di sediakan agar alumni bisa mengisi jawabannya lagi.
# Halaman Alumni:
Setelah masuk sebagai kaprodi maka akan ada navigasi yang dapat mempermudah kaprodi untuk mengisi feedback terhadap kinerja alumni.
# Halaman Admin:
Halaman ini menampilkan beberapa menu pilihan diantaranya:

Memanage alumni

Memanage kaprodi

Memanage lowongan kerja

Melihat umpan balik lowongan pekerjaan

Melihat hasil kuesioner dalam bentuk pie chart dan bisa mengexport data alumni yang sudah mengisi kuesioner dan yang sudah di nilai kaprodi dalam bentuk csv,pdf,excel.

# Struktur Basis Data
Tabel

alumni: Menyimpan informasi alumni.

admin : Menyimpan informadi admin.

jobs : Untuk nantinya menampilkan lowongan kerja di interface alumni.

apply_jobs: Menyimpan detail lamaran pekerjaan.

kuesioner : Untuk para alumni memberikan jawaban kuesioner yang nantinya di simpan di database ini.

kaprodi : menyimpan informasi kaprodi.

penilaian: Menyimpan evaluasi alumni.
