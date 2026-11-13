@extends('layouts.guest')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="mb-4 text-center">
    <h5 class="fw-bold text-dark mb-1">Registrasi Akun Baru</h5>
    <p class="text-muted small">Daftarkan akun pedagang Pasar Cerdas Anda dalam hitungan detik.</p>
</div>

<form action="{{ route('register.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="budi@pasarcerdas.test" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label small fw-bold text-secondary">Konfirmasi Kata Sandi</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-check"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi di atas" required>
        </div>
    </div>

    <div class="alert alert-light border small text-muted mb-4">
        <i class="bi bi-info-circle me-1 text-primary"></i> Akun baru yang didaftarkan otomatis mendapatkan role <strong>User (Pedagang)</strong> dengan hak akses pengelolaan produk.
    </div>

    <button type="submit" class="btn btn-pascer w-100 py-2 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-person-plus-fill"></i> Buat Akun Sekarang
    </button>
</form>

<div class="text-center mt-4 pt-3 border-top">
    <p class="small text-muted mb-0">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="fw-bold text-success text-decoration-none">Masuk di Sini</a>
    </p>
</div>
@endsection
