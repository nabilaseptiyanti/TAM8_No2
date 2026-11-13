@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Pasar Cerdas')

@section('content')
<!-- Welcome Banner -->
<div class="card border-0 mb-4 text-white overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-success px-3 py-2 fw-bold text-uppercase mb-3 shadow-sm">
                    <i class="bi bi-patch-check-fill me-1"></i> Modul 8 HMVC &bull; Laravel 12
                </span>
                <h2 class="fw-bold mb-2 text-white">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-white-50 mb-3 fs-6">
                    Aplikasi Pasar Cerdas (PASCER) mengintegrasikan arsitektur HMVC (Hierarchical Model-View-Controller), otorisasi berbasis Role, CRUD Synchronous pada modul Kios, dan CRUD AJAX interaktif dengan upload berkas pada modul Produk.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('kelola-kios.index') }}" class="btn btn-light text-success fw-bold px-3">
                            <i class="bi bi-buildings-fill me-1"></i> Buka Kelola Kios (Sync)
                        </a>
                    @endif
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-light fw-bold px-3">
                        <i class="bi bi-box-seam-fill me-1"></i> Buka Data Produk (AJAX)
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0 d-none d-lg-block">
                <i class="bi bi-shop-window text-white-50" style="font-size: 7rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Total Kios -->
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #059669, #10b981);">
                    <i class="bi bi-buildings fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Kios</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalKios }}</h3>
                    <small class="text-success"><i class="bi bi-check-circle"></i> Terdaftar di pasar</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Produk -->
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #0284c7, #38bdf8);">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Produk</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalProduk }}</h3>
                    <small class="text-info"><i class="bi bi-lightning-charge"></i> CRUD AJAX realtime</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Stok Komoditas -->
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #d97706, #fbbf24);">
                    <i class="bi bi-layers-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Stok</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalStok, 0, ',', '.') }}</h3>
                    <small class="text-warning text-dark"><i class="bi bi-arrow-up-right"></i> Unit komoditas</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pengguna -->
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #7c3aed, #a78bfa);">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Pengguna Aktif</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalUsers }}</h3>
                    <small class="text-secondary"><i class="bi bi-shield-lock"></i> Role Admin &amp; User</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Hak Akses & Matriks Modul -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="text-dark"><i class="bi bi-diagram-3-fill text-success me-2"></i>Arsitektur Modul HMVC</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">nwidart/laravel-modules v12</span>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Aplikasi ini membagi fitur ke dalam modul independen sesuai struktur Hierarchical MVC:
                </p>

                <div class="list-group list-group-flush small">
                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-folder2-open text-primary me-1"></i> Modul 1: KelolaKios</h6>
                            <span class="badge bg-danger">Hanya Admin</span>
                        </div>
                        <p class="text-muted mb-1" style="font-size: 0.82rem;">
                            Menerapkan <strong>CRUD Synchronous</strong> standar Laravel dengan form request validation, pencarian, dan pagination. Mengelola 5 field utama: <code>kode_kios</code>, <code>nama_kios</code>, <code>nama_pemilik</code>, <code>no_telp</code>, <code>lokasi</code>.
                        </p>
                        <span class="badge bg-light text-dark border">Middleware: auth, role:admin</span>
                    </div>

                    <div class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-folder2-open text-success me-1"></i> Modul 2: Produk</h6>
                            <span class="badge bg-success">Admin &amp; User</span>
                        </div>
                        <p class="text-muted mb-1" style="font-size: 0.82rem;">
                            Menerapkan <strong>CRUD AJAX</strong> tanpa reload halaman (jQuery + JSON API), modal interaktif, pencarian realtime, validasi error 422, dan upload berkas foto (JPG, PNG, PDF maks. 2MB) dengan FormData yang dapat dibuka kembali.
                        </p>
                        <span class="badge bg-light text-dark border">Middleware: auth, role:admin,user</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matriks Hak Akses Role -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="text-dark"><i class="bi bi-shield-shaded text-primary me-2"></i>Matriks Otorisasi Berbasis Role</span>
                <span class="badge {{ auth()->user()->role === \App\Enums\UserRole::Admin ? 'bg-danger' : 'bg-primary' }}">
                    Akun Anda: {{ auth()->user()->role->label() }}
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle text-center small mb-3">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Fitur / Halaman</th>
                                <th>Admin</th>
                                <th>User</th>
                                <th>Anda Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start fw-semibold">Dashboard Utama</td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><span class="badge bg-success">Diizinkan</span></td>
                            </tr>
                            <tr>
                                <td class="text-start fw-semibold">Kelola Kios (CRUD Sync)</td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><i class="bi bi-x-circle-fill text-danger"></i> (403)</td>
                                <td>
                                    @if(auth()->user()->isAdmin())
                                        <span class="badge bg-success">Diizinkan</span>
                                    @else
                                        <span class="badge bg-danger">Diblokir (403)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start fw-semibold">Kelola Produk (CRUD AJAX)</td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><span class="badge bg-success">Diizinkan</span></td>
                            </tr>
                            <tr>
                                <td class="text-start fw-semibold">Upload Foto &amp; Dokumen Produk</td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></td>
                                <td><span class="badge bg-success">Diizinkan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert {{ auth()->user()->isAdmin() ? 'alert-danger' : 'alert-primary' }} mb-0 small py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock-fill fs-5"></i>
                    <div>
                        Otorisasi dikunci pada level <strong>Route Middleware</strong> (<code>RoleMiddleware</code>) dan Controller backend, bukan sekadar menyembunyikan tombol navigasi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Data Terkini -->
<div class="row g-4">
    <!-- Ringkasan Produk Terkini -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="text-dark"><i class="bi bi-box-seam me-1 text-primary"></i> Produk Terkini</span>
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary py-0 px-2 small">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProduk as $p)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $p->nama_produk }}</td>
                                    <td><span class="badge bg-light text-secondary border">{{ $p->kategori }}</span></td>
                                    <td>{{ $p->formatted_harga }}</td>
                                    <td>
                                        <span class="badge {{ $p->stok > 20 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                            {{ $p->stok }} unit
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Kios Terkini (Admin) atau Informasi Pasar (User) -->
    <div class="col-lg-6">
        @if(auth()->user()->isAdmin())
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="text-dark"><i class="bi bi-buildings me-1 text-success"></i> Kios Terkini (Admin Only)</span>
                <a href="{{ route('kelola-kios.index') }}" class="btn btn-sm btn-outline-success py-0 px-2 small">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Kios</th>
                                <th>Pemilik</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentKios as $k)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $k->kode_kios }}</span></td>
                                    <td class="fw-semibold text-dark">{{ $k->nama_kios }}</td>
                                    <td>{{ $k->nama_pemilik }}</td>
                                    <td class="small text-muted">{{ $k->lokasi }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data kios.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <span class="text-dark"><i class="bi bi-info-circle me-1 text-primary"></i> Panduan Pedagang (User)</span>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    Sebagai pengguna dengan role <strong>User (Pedagang)</strong>, Anda dapat:
                </p>
                <ul class="small text-muted ps-3 mb-3">
                    <li>Melihat daftar seluruh produk komoditas pasar secara realtime.</li>
                    <li>Menambah produk baru menggunakan modal interaktif AJAX.</li>
                    <li>Mengunggah foto atau dokumen komoditas (format JPG, PNG, atau PDF).</li>
                    <li>Mengubah data produk dan mengganti foto komoditas.</li>
                    <li>Membuka berkas foto produk langsung di browser.</li>
                    <li>Menghapus produk tanpa perlu memuat ulang halaman browser.</li>
                </ul>
                <a href="{{ route('produk.index') }}" class="btn btn-primary-pascer btn-sm">
                    <i class="bi bi-arrow-right-circle me-1"></i> Mulai Kelola Produk Sekarang
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
