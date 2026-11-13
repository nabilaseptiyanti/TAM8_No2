@extends('layouts.app')

@section('title', 'Kelola Kios')
@section('page_title', 'Kelola Kios Pasar')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Data Kios Pasar Cerdas</h4>
        <p class="text-muted small mb-0">
            <span class="badge bg-danger me-1">Role: Admin</span>
            Modul HMVC dengan <strong>CRUD Synchronous</strong>, validasi Form Request, dan pencarian server-side.
        </p>
    </div>
    <a href="{{ route('kelola-kios.create') }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kios Baru
    </a>
</div>

<!-- Search & Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('kelola-kios.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-9 col-lg-10">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" class="form-control border-start-0" 
                           placeholder="Cari berdasarkan kode kios, nama kios, pemilik, no telepon, atau lokasi..." 
                           value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3 col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary-pascer w-100">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('kelola-kios.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Kios Data Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <span class="fw-bold text-dark">
            <i class="bi bi-buildings-fill text-success me-1"></i> Daftar Kios Terdaftar
        </span>
        <span class="badge bg-light text-dark border">
            Total: {{ $kios->total() }} Kios
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kode Kios</th>
                        <th>Nama Kios</th>
                        <th>Nama Pemilik</th>
                        <th>Nomor Telepon</th>
                        <th>Lokasi Kios</th>
                        <th class="text-center" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kios as $index => $item)
                        <tr>
                            <td class="text-muted small">{{ $kios->firstItem() + $index }}</td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark border px-2 py-1 font-monospace fw-bold">
                                    {{ $item->kode_kios }}
                                </span>
                            </td>
                            <td>
                                <strong class="text-dark">{{ $item->nama_kios }}</strong>
                            </td>
                            <td>{{ $item->nama_pemilik }}</td>
                            <td>
                                <a href="tel:{{ $item->no_telp }}" class="text-decoration-none text-muted small">
                                    <i class="bi bi-telephone text-primary me-1"></i> {{ $item->no_telp }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $item->lokasi }}
                                </span>
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('kelola-kios.show', $item) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('kelola-kios.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit Kios">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('kelola-kios.destroy', $item) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kios {{ $item->nama_kios }} ({{ $item->kode_kios }})?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kios">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                @if(request('q'))
                                    Tidak ada data kios yang cocok dengan kata kunci "<strong>{{ request('q') }}</strong>".
                                    <div class="mt-2">
                                        <a href="{{ route('kelola-kios.index') }}" class="btn btn-sm btn-outline-secondary">
                                            Reset Pencarian
                                        </a>
                                    </div>
                                @else
                                    Belum ada data kios. Silakan klik tombol <strong>Tambah Kios Baru</strong>.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($kios->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $kios->firstItem() }} - {{ $kios->lastItem() }} dari {{ $kios->total() }} kios
                </small>
                <div>
                    {{ $kios->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
