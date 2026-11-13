# PASCER (Pasar Cerdas) &mdash; Tugas Akhir Pemrograman Web (Modul 8)

Aplikasi **Pasar Cerdas (PASCER)** adalah platform manajemen pasar modern berbasis web yang dibangun dengan framework **Laravel 12** menggunakan arsitektur **HMVC (Hierarchical Model-View-Controller)** melalui package `nwidart/laravel-modules` versi 12.

Project ini mengimplementasikan seluruh materi Modul 8:
1. **Arsitektur HMVC**: Pemisahan modul mandiri (Controller, Model, View, Request, Migration, Provider).
2. **Otorisasi Berbasis Role**: Pembagian hak akses `Admin` dan `User`.
3. **Route Middleware**: Penegakan hak akses pada level backend dan routing.
4. **CRUD Synchronous**: Pada modul `KelolaKios` dengan validasi Form Request dan pencarian.
5. **CRUD Asynchronous (AJAX)**: Pada modul `Produk` dengan jQuery, respon JSON, dan manipulasi DOM tanpa memuat ulang (*reload*) halaman.
6. **Upload Berkas Multi-format**: Upload foto komoditas (JPG, JPEG, PNG, WEBP, PDF maks. 2 MB) via `FormData` yang dapat dibuka kembali di browser.

---

## 🛠️ Teknologi yang Digunakan

- **Backend Framework**: Laravel 12 (`laravel/framework: ^12.0`)
- **PHP**: PHP >= 8.2 (dengan extension cURL, PDO MySQL, OpenSSL, Mbstring, Fileinfo)
- **HMVC Package**: `nwidart/laravel-modules: ^12.0`
- **Database**: MySQL / MariaDB (Database: `tam8_pascer`)
- **Frontend & Styling**: 
  - Bootstrap 5.3.3
  - Bootstrap Icons 1.11.3
  - Google Font (Plus Jakarta Sans)
- **AJAX Engine**: jQuery 3.7.1
- **Testing**: PHPUnit 11 & Laravel Test Suite

---

## 📁 Struktur Folder HMVC

Arsitektur aplikasi memisahkan modul ke dalam folder `Modules/`, di mana tiap modul memiliki tanggung jawab penuh:

```text
TAM8_Pascer/
├── app/
│   ├── Enums/
│   │   └── UserRole.php                    # Enum Role: Admin & User
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php     # Otentikasi masuk & keluar
│   │   │   │   └── RegisterController.php  # Registrasi akun user
│   │   │   └── DashboardController.php     # Ringkasan data & metrik
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php          # Penjaga otorisasi role (role:admin,user)
│   │   └── Requests/
│   │       └── Auth/                       # Validasi input login & register
│   └── Models/
│       └── User.php                        # Model User dengan relasi & helper role
├── bootstrap/
│   ├── app.php                             # Registrasi middleware role & redirect
│   └── providers.php
├── config/
│   └── modules.php                         # Konfigurasi nwidart/laravel-modules
├── database/
│   ├── migrations/                         # Migrasi users dan role
│   └── seeders/
│       └── DatabaseSeeder.php              # Akun demo Admin & User + sample data
├── Modules/
│   ├── KelolaKios/                         # MODUL 1: CRUD Synchronous (Admin Only)
│   │   ├── app/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   │   └── KelolaKiosController.php
│   │   │   │   └── Requests/
│   │   │   │       └── KiosRequest.php     # Validasi 5 field kios
│   │   │   ├── Models/
│   │   │   │   └── Kios.php
│   │   │   └── Providers/
│   │   │       ├── KelolaKiosServiceProvider.php
│   │   │       └── RouteServiceProvider.php
│   │   ├── database/
│   │   │   └── migrations/
│   │   │       └── 2026_01_01_000001_create_kios_table.php
│   │   ├── resources/
│   │   │   └── views/
│   │   │       ├── index.blade.php         # Tabel kios, pencarian, pagination
│   │   │       ├── create.blade.php        # Form tambah kios
│   │   │       ├── edit.blade.php          # Form edit kios
│   │   │       └── show.blade.php          # Detail kios (Fitur Lihat)
│   │   ├── routes/
│   │   │   └── web.php                     # Route prefix: /kelola-kios
│   │   └── module.json
│   └── Produk/                             # MODUL 2: CRUD AJAX (Admin & User)
│       ├── app/
│       │   ├── Http/
│       │   │   ├── Controllers/
│       │   │   │   └── ProdukController.php # Respon JSON untuk AJAX
│       │   │   └── Requests/
│       │   │       └── ProdukRequest.php   # Validasi data & ukuran/jenis foto
│       │   ├── Models/
│       │   │   └── Produk.php              # Model produk & accessors URL foto
│       │   └── Providers/
│       │       ├── ProdukServiceProvider.php
│       │       └── RouteServiceProvider.php
│       ├── database/
│       │   └── migrations/
│       │       └── 2026_01_01_000002_create_produks_table.php
│       ├── resources/
│       │   └── views/
│       │       └── index.blade.php         # UI AJAX CRUD, modal, live filter
│       ├── routes/
│       │   └── web.php                     # Route prefix: /produk
│       └── module.json
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php             # Form login dengan tombol cepat demo
│       │   └── register.blade.php          # Form registrasi pedagang
│       ├── layouts/
│       │   ├── app.blade.php               # Layout utama dengan sidebar & navbar
│       │   └── guest.blade.php             # Layout khusus halaman otentikasi
│       └── dashboard.blade.php             # Dashboard ringkasan metrik & hak akses
├── public/
│   └── storage                             # Symlink ke storage/app/public
├── storage/
│   └── app/
│       └── public/
│           └── foto_produk/                # Lokasi penyimpanan file upload
└── tests/
    └── Feature/
        └── PascerSystemTest.php            # Automated test suite (11 test case)
```

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### 1. Prasyarat Sistem
- Web server Apache / Nginx dan MySQL (dapat menggunakan **XAMPP** atau **Laragon**).
- PHP versi 8.2 atau lebih baru.
- Composer terpasang di sistem.

### 2. Konfigurasi Database MySQL
Pastikan service MySQL aktif, kemudian buat database bernama `tam8_pascer`:
```sql
CREATE DATABASE IF NOT EXISTS tam8_pascer CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Konfigurasi Environment (`.env`)
Salin atau pastikan file `.env` memiliki pengaturan berikut:
```env
APP_NAME="Pasar Cerdas (PASCER)"
APP_ENV=local
APP_KEY=base64:MjiZsiuoSMw1k59vnb2G5EDga644CUgGnyLBGI+LbXQ=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tam8_pascer
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

### 4. Menjalankan Migrasi dan Seeder
Jalankan perintah berikut di terminal pada folder project:
```bash
# Generate autoload Composer
composer dump-autoload

# Jalankan migrasi tabel beserta akun demo dan data awal
php artisan migrate --seed

# Hubungkan symlink storage agar file foto dapat diakses publik
php artisan storage:link
```

### 5. Menjalankan Web Server
Jalankan server pengembangan Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui peramban web pada alamat: **http://127.0.0.1:8000** atau **http://localhost:8000**.

---

## 🔑 Akun Demo untuk Pengujian

Telah disediakan dua akun demo yang dapat langsung digunakan untuk menguji batasan hak akses:

| Peran (Role) | Alamat Email | Kata Sandi | Hak Akses Fitur |
|---|---|---|---|
| **Administrator** | `admin@pasarcerdas.test` | `password` | Mengakses Dashboard, mengelola Modul **KelolaKios** (CRUD Sync), dan mengelola Modul **Produk** (CRUD AJAX). |
| **User (Pedagang)** | `user@pasarcerdas.test` | `password` | Mengakses Dashboard dan mengelola Modul **Produk** (CRUD AJAX). Akses ke Kelola Kios diblokir dengan **HTTP 403 Forbidden**. |

> *Catatan: Pada halaman Login, tersedia tombol pintas "Admin" dan "User" untuk mengisi form secara otomatis.*

---

## 📦 Penjelasan Dua Modul HMVC

### 1. Modul KelolaKios (`Modules/KelolaKios`)
- **Tipe CRUD**: **Synchronous** (server-side rendering standar dengan reload halaman).
- **Otorisasi**: Dibatasi hanya untuk role **Admin** melalui route middleware `role:admin`.
- **Field Data (5 Field)**:
  1. `kode_kios`: Kode unik pengenal kios (contoh: `KIOS-A01`).
  2. `nama_kios`: Nama kios atau nama usaha dagang.
  3. `nama_pemilik`: Nama pemilik atau penanggung jawab kios.
  4. `no_telp`: Nomor kontak telepon / WhatsApp.
  5. `lokasi`: Posisi kios di dalam area pasar (blok, lantai, nomor).
- **Fitur Lengkap**:
  - **Tambah Kios**: Menggunakan `KiosRequest` dengan validasi keunikan kode kios.
  - **Lihat Detail Kios**: Halaman khusus (`kelola-kios.show`) yang menyajikan rincian lengkap kios.
  - **Edit Kios**: Form perubahan data yang mempertahankan keunikan kode kios milik sendiri.
  - **Hapus Kios**: Konfirmasi penghapusan data kios.
  - **Pencarian Realtime Server-side**: Pencarian multi-kolom (`kode_kios`, `nama_kios`, `nama_pemilik`, `no_telp`, `lokasi`).
  - **Pagination**: Navigasi halaman tabel menggunakan Bootstrap 5 pagination.

### 2. Modul Produk (`Modules/Produk`)
- **Tipe CRUD**: **AJAX (Asynchronous JavaScript and XML)** menggunakan jQuery dan endpoint JSON.
- **Otorisasi**: Dapat diakses oleh **Admin** maupun **User** melalui route middleware `role:admin,user`.
- **Field Data (6 Field)**:
  1. `nama_produk`: Nama komoditas produk pasar.
  2. `kategori`: Kategori produk (Sembako, Sayuran, Buah, Daging, Bumbu, dll).
  3. `harga`: Harga satuan produk (Rp).
  4. `stok`: Jumlah stok unit komoditas yang tersedia.
  5. `deskripsi`: Informasi tambahan / penjelasan produk.
  6. `foto`: Berkas foto atau dokumen spesifikasi komoditas.
- **Fitur Lengkap**:
  - **CRUD Tanpa Reload**: Operasi Tambah, Tampil, Edit, dan Hapus dilakukan melalui modal bootstrap dan AJAX tanpa me-refresh browser.
  - **Upload Foto dengan `FormData`**: Mendukung berkas gambar (`JPG, JPEG, PNG, WEBP`) serta dokumen `PDF`.
  - **Validasi File**: Maksimal ukuran 2 MB (2048 KB). Pesan error HTTP 422 ditampilkan langsung di bawah input form tanpa reload.
  - **Lihat Foto**: Tombol dan tautan **Lihat Foto** membuka berkas foto di tab baru atau lightbox modal.
  - **Pencarian & Filter Realtime**: Live search pada input form dan filter berdasarkan kategori komoditas.
  - **Manajemen File Otomatis**: Menghapus atau mengganti foto lama dari disk penyimpanan saat data produk diperbarui atau dihapus.

---

## 🛡️ Penjelasan Middleware & AJAX

### 1. Middleware Otorisasi (`App\Http\Middleware\RoleMiddleware`)
Middleware didaftarkan dengan alias `role` pada `bootstrap/app.php`:
```php
$middleware->alias([
    'role' => RoleMiddleware::class,
]);
```
- **Cara Kerja**:
  - Memeriksa apakah pengguna sudah login (`$request->user()`). Jika belum, pengguna dialihkan ke halaman login.
  - Memeriksa apakah peran pengguna cocok dengan argumen rute:
    - `->middleware('role:admin')`: Hanya mengizinkan Admin.
    - `->middleware('role:admin,user')`: Mengizinkan Admin dan User.
  - Jika peran tidak sesuai, sistem mengembalikan respon **403 Forbidden** (atau JSON 403 jika request berupa AJAX).
- **Pengamanan Berlapis**: Proteksi diterapkan langsung pada rute backend (`routes/web.php` modul), sehingga pengguna biasa tidak dapat memanipulasi URL untuk mengakses resource yang dilarang.

### 2. Alur Kerja AJAX (jQuery + JSON + CSRF)
- **Token CSRF Otomatis**:
  Token CSRF disuntikkan pada meta tag HTML dan dikonfigurasikan global melalui:
  ```javascript
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  ```
- **Pengiriman Berkas via FormData**:
  Pada penyimpanan atau pembaruan produk, JavaScript membuat objek `new FormData(this)` dengan opsi `processData: false` dan `contentType: false`. Pada metode PUT/Update, diterapkan spoofing parameter `formData.append('_method', 'PUT')` agar file multipart terbaca sempurna oleh framework Laravel.
- **Penanganan Error Validasi (422)**:
  Jika terjadi kegagalan validasi di backend, AJAX `error` handler menangkap `xhr.status === 422`, membaca objek `xhr.responseJSON.errors`, lalu menandai input dengan class `.is-invalid` serta mencantumkan pesan error secara dinamis.

---

## 🧪 Hasil Pengujian Sistem (Automated Test Suite)

Aplikasi dilengkapi dengan rangkaian automated test lengkap (`tests/Feature/PascerSystemTest.php`).

Jalankan pengujian dengan perintah:
```bash
php artisan test
```

**Hasil Pengujian:**
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\ExampleTest
  ✓ root route redirects to dashboard
  ✓ login page is accessible

   PASS  Tests\Feature\PascerSystemTest
  ✓ guest is redirected to login
  ✓ role authorization for kelola kios
  ✓ both admin and user can access produk
  ✓ user registration assigns user role
  ✓ kelolakios synchronous crud operations
  ✓ kelolakios validation rejects duplicate kode
  ✓ produk ajax crud and file upload
  ✓ produk validation rejects invalid file type

  Tests:    11 passed (60 assertions)
  Duration: 0.76s
```
Semua 11 test case lulus 100% tanpa error!
