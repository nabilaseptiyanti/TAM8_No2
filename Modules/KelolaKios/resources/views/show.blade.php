@extends('layouts.app')

@section('title', 'Detail Kios')
@section('page_title', 'Detail Data Kios')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark">
                    <i class="bi bi-info-circle-fill text-info me-1"></i> Informasi Lengkap Kios
                </span>
                <a href="{{ route('kelola-kios.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #059669, #10b981);">
                        <i class="bi bi-shop fs-2"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary mb-1">{{ $kios->kode_kios }}</span>
                        <h4 class="fw-bold text-dark mb-0">{{ $kios->nama_kios }}</h4>
                        <small class="text-muted"><i class="bi bi-geo-alt text-danger"></i> {{ $kios->lokasi }}</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th class="table-light text-secondary" style="width: 200px;">Kode Kios</th>
                                <td><span class="font-monospace fw-bold text-dark">{{ $kios->kode_kios }}</span></td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Nama Kios / Usaha</th>
                                <td class="fw-semibold text-dark">{{ $kios->nama_kios }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Nama Pemilik</th>
                                <td>{{ $kios->nama_pemilik }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Nomor Telepon / WA</th>
                                <td>
                                    <a href="tel:{{ $kios->no_telp }}" class="btn btn-sm btn-light border text-decoration-none">
                                        <i class="bi bi-telephone-fill text-primary me-1"></i> {{ $kios->no_telp }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Lokasi Kios</th>
                                <td>{{ $kios->lokasi }}</td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Terdaftar Pada</th>
                                <td class="small text-muted">{{ $kios->created_at ? $kios->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB</td>
                            </tr>
                            <tr>
                                <th class="table-light text-secondary">Terakhir Diperbarui</th>
                                <td class="small text-muted">{{ $kios->updated_at ? $kios->updated_at->translatedFormat('d F Y, H:i') : '-' }} WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="{{ route('kelola-kios.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('kelola-kios.edit', $kios) }}" class="btn btn-primary-pascer">
                            <i class="bi bi-pencil-square me-1"></i> Edit Kios
                        </a>
                        <form action="{{ route('kelola-kios.destroy', $kios) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kios {{ $kios->nama_kios }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Hapus Kios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
