@extends('layouts.guest')

@section('title', 'Masuk (Login)')

@section('content')
<div class="mb-4 text-center">
    <h5 class="fw-bold text-dark mb-1">Selamat Datang Kembali</h5>
    <p class="text-muted small">Silakan masuk menggunakan akun Anda untuk mengelola pasar.</p>
</div>

<!-- Quick Demo Account Helper -->
<div class="demo-box">
    <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-1">
        <i class="bi bi-key-fill text-warning"></i> Akun Demo Cepat (Klik untuk isi):
    </div>
    <div class="d-flex flex-wrap gap-2 mt-2">
        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" id="fillAdmin">
            <i class="bi bi-shield-lock me-1"></i> Admin (Akses Semua)
        </button>
        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" id="fillUser">
            <i class="bi bi-person me-1"></i> User (Produk Saja)
        </button>
    </div>
    <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">
        Password default: <code>password</code>
    </small>
</div>

<form action="{{ route('login.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@pasarcerdas.test" required autofocus>
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label small text-secondary" for="remember">
                Ingat Saya
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-pascer w-100 py-2 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
    </button>
</form>

<div class="text-center mt-4 pt-3 border-top">
    <p class="small text-muted mb-0">
        Belum punya akun pedagang?
        <a href="{{ route('register') }}" class="fw-bold text-success text-decoration-none">Daftar Akun Baru</a>
    </p>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('fillAdmin')?.addEventListener('click', function() {
        document.getElementById('email').value = 'admin@pasarcerdas.test';
        document.getElementById('password').value = 'password';
    });

    document.getElementById('fillUser')?.addEventListener('click', function() {
        document.getElementById('email').value = 'user@pasarcerdas.test';
        document.getElementById('password').value = 'password';
    });
</script>
@endpush
