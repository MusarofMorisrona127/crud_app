#  Daily Habit Tracker

##  Identitas Mahasiswa
- Nama  : (ISI NAMA KAMU)
- NIM   : (ISI NIM KAMU)
- Kelas : (ISI KELAS KAMU)

---

##  Deskripsi Aplikasi
Daily Habit Tracker adalah aplikasi berbasis web yang digunakan untuk mencatat dan mengelola kebiasaan harian pengguna.

Aplikasi ini memungkinkan pengguna untuk:
- Menambahkan kebiasaan baru
- Melihat daftar kebiasaan
- Mengedit kebiasaan
- Menghapus kebiasaan

---

## Tujuan Aplikasi
Aplikasi ini dibuat untuk memenuhi tugas praktik mandiri dengan tujuan:
- Membangun arsitektur aplikasi berbasis web
- Mengimplementasikan sistem autentikasi (login)
- Menggunakan database relasional (MySQL)
- Menerapkan fitur CRUD (Create, Read, Update, Delete)

---

##  Struktur Database

### 1. Tabel `users`
Digunakan untuk menyimpan data akun pengguna.

| Field    | Tipe Data     | Keterangan        |
|----------|--------------|------------------|
| id       | INT          | Primary Key      |
| username | VARCHAR(50)  | Username unik    |
| password | VARCHAR(255) | Password terenkripsi |

---

### 2. Tabel `habits`
Digunakan untuk menyimpan data kebiasaan.

| Field       | Tipe Data     | Keterangan            |
|-------------|--------------|----------------------|
| id          | INT          | Primary Key          |
| user_id     | INT          | Relasi ke users      |
| habit_name  | VARCHAR(100) | Nama kebiasaan       |
| description | TEXT         | Deskripsi kebiasaan  |
| date        | DATE         | Tanggal              |

---

##  Fitur Autentikasi
- Login menggunakan username dan password
- Password disimpan menggunakan enkripsi (`password_hash`)
- Menggunakan **Session PHP** untuk menjaga status login
- Halaman CRUD hanya bisa diakses setelah login

---

##  Fitur Aplikasi
- ✅ Register (daftar akun)
- ✅ Login & Logout
- ✅ Tambah Habit
- ✅ Lihat Data Habit
- ✅ Edit Habit
- ✅ Hapus Habit

---

##  Teknologi yang Digunakan
- PHP Native
- MySQL
- Bootstrap 5
- CSS Custom

---

## Cara Menjalankan Aplikasi

1. Jalankan **Laragon**
2. Import file `database.sql` ke phpMyAdmin
3. Pastikan folder project ada di: