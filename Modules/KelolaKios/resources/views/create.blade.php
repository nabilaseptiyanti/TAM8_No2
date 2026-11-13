@extends('layouts.app')

@section('title', 'Tambah Kios')
@section('page_title', 'Tambah Kios Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark">
                    <i class="bi bi-plus-circle text-success me-1"></i> Form Tambah Kios Baru
                </span>
                <a href="{{ route('kelola-kios.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kelola-kios.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Kode Kios -->
                        <div class="col-md-6">
                            <label for="kode_kios" class="form-label fw-semibold small text-secondary">
                                Kode Kios <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_kios" id="kode_kios" 
                                   class="form-control @error('kode_kios') is-invalid @enderror" 
                                   placeholder="Contoh: KIOS-A01" 
                                   value="{{ old('kode_kios') }}" required autofocus>
                            <small class="text-muted" style="font-size: 0.75rem;">Kode unik identitas kios pasar.</small>
                            @error('kode_kios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Kios -->
                        <div class="col-md-6">
                            <label for="nama_kios" class="form-label fw-semibold small text-secondary">
                                Nama Kios / Usaha <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_kios" id="nama_kios" 
                                   class="form-control @error('nama_kios') is-invalid @enderror" 
                                   placeholder="Contoh: Toko Sayur Berkah Segar" 
                                   value="{{ old('nama_kios') }}" required>
                            @error('nama_kios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Pemilik -->
                        <div class="col-md-6">
                            <label for="nama_pemilik" class="form-label fw-semibold small text-secondary">
                                Nama Pemilik Kios <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pemilik" id="nama_pemilik" 
                                   class="form-control @error('nama_pemilik') is-invalid @enderror" 
                                   placeholder="Contoh: H. Ahmad Fauzi" 
                                   value="{{ old('nama_pemilik') }}" required>
                            @error('nama_pemilik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telp -->
                        <div class="col-md-6">
                            <label for="no_telp" class="form-label fw-semibold small text-secondary">
                                Nomor Telepon / WhatsApp <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="no_telp" id="no_telp" 
                                   class="form-control @error('no_telp') is-invalid @enderror" 
                                   placeholder="Contoh: 081234567890" 
                                   value="{{ old('no_telp') }}" required>
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div class="col-12">
                            <label for="lokasi" class="form-label fw-semibold small text-secondary">
                                Lokasi / Blok Kios <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" id="lokasi" 
                                   class="form-control @error('lokasi') is-invalid @enderror" 
                                   placeholder="Contoh: Blok A No. 12 Lantai Dasar (Area Sayur & Buah)" 
                                   value="{{ old('lokasi') }}" required>
                            <small class="text-muted" style="font-size: 0.75rem;">Deskripsi lokasi fisik kios di dalam area pasar.</small>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kelola-kios.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-4 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i> Simpan Data Kios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
