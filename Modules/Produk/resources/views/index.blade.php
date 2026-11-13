@extends('layouts.app')

@section('title', 'Data Produk')
@section('page_title', 'Kelola Produk Pasar (CRUD AJAX)')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Data Produk Pasar Cerdas</h4>
        <p class="text-muted small mb-0">
            <span class="badge bg-success me-1">CRUD AJAX</span>
            <span class="badge bg-secondary me-1">FormData Upload</span>
            Operasi tambah, lihat, edit, hapus, validasi, dan pencarian berjalan tanpa reload halaman.
        </p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1" id="btnRefreshData" title="Refresh Data">
            <i class="bi bi-arrow-clockwise"></i> <span class="d-none d-sm-inline">Segarkan</span>
        </button>
        <button type="button" class="btn btn-success d-flex align-items-center gap-2 shadow-sm" id="btnTambahProduk">
            <i class="bi bi-plus-circle-fill"></i> Tambah Produk (AJAX)
        </button>
    </div>
</div>

<!-- Dynamic AJAX Alert Notification Box -->
<div id="ajaxAlertContainer"></div>

<!-- Filter & Search Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-7 col-lg-8">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchProduk" class="form-control border-start-0" 
                           placeholder="Cari realtime berdasarkan nama produk, kategori, atau deskripsi...">
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <select id="filterKategori" class="form-select">
                    <option value="">-- Semua Kategori Komoditas --</option>
                    <option value="Sembako">Sembako</option>
                    <option value="Sayuran">Sayuran</option>
                    <option value="Buah">Buah</option>
                    <option value="Daging">Daging</option>
                    <option value="Bumbu">Bumbu</option>
                    <option value="Ikan">Ikan &amp; Makanan Laut</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Products Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark">
            <i class="bi bi-box-seam-fill text-success me-1"></i> Daftar Komoditas Produk Pasar
        </span>
        <span class="badge bg-light text-dark border" id="badgeTotalProduk">
            Memuat data...
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelProduk">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 100px;">Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Satuan</th>
                        <th>Stok</th>
                        <th>Lihat Berkas</th>
                        <th class="text-center" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyProduk">
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                            Memuat data produk melalui AJAX...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 1: Form Tambah & Edit Produk (AJAX FormData)            -->
<!-- ============================================================== -->
<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukTitle" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold" id="modalProdukTitle">
                    <i class="bi bi-box-seam me-1"></i> Tambah Produk Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formProduk" enctype="multipart/form-data">
                <input type="hidden" id="produk_id" name="produk_id">

                <div class="modal-body p-4">
                    <div class="alert alert-light border small text-muted mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-lightning-charge-fill text-warning fs-5"></i>
                        <div>
                            Form ini diproses menggunakan <strong>AJAX FormData</strong>. Foto akan disimpan di <code>storage/app/public/foto_produk</code> dan dapat dibuka kembali kapan saja.
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Produk -->
                        <div class="col-md-7">
                            <label for="nama_produk" class="form-label fw-semibold small text-secondary">
                                Nama Produk Komoditas <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" 
                                   placeholder="Contoh: Beras Pandan Wangi 5 Kg">
                            <div class="invalid-feedback" id="error-nama_produk"></div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-5">
                            <label for="kategori" class="form-label fw-semibold small text-secondary">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="kategori" name="kategori" list="listKategori" 
                                   placeholder="Pilih atau ketik kategori">
                            <datalist id="listKategori">
                                <option value="Sembako">
                                <option value="Sayuran">
                                <option value="Buah">
                                <option value="Daging">
                                <option value="Bumbu">
                                <option value="Ikan">
                                <option value="Lainnya">
                            </datalist>
                            <div class="invalid-feedback" id="error-kategori"></div>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <label for="harga" class="form-label fw-semibold small text-secondary">
                                Harga Satuan (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">Rp</span>
                                <input type="number" class="form-control" id="harga" name="harga" min="0" step="100" 
                                       placeholder="Contoh: 75000">
                                <div class="invalid-feedback" id="error-harga"></div>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold small text-secondary">
                                Jumlah Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="stok" name="stok" min="0" 
                                   placeholder="Contoh: 50">
                            <div class="invalid-feedback" id="error-stok"></div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold small text-secondary">
                                Deskripsi Produk
                            </label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                                      placeholder="Keterangan singkat produk, asal daerah, kualitas, atau kondisi penyimpanan..."></textarea>
                            <div class="invalid-feedback" id="error-deskripsi"></div>
                        </div>

                        <!-- Upload Foto Berkas -->
                        <div class="col-12">
                            <label for="foto" class="form-label fw-semibold small text-secondary">
                                Berkas Foto Produk / Dokumen (JPG, PNG, WEBP, PDF maks. 2 MB)
                            </label>
                            <input type="file" class="form-control" id="foto" name="foto" 
                                   accept=".jpg,.jpeg,.png,.webp,.pdf">
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                Validasi backend: format JPG, JPEG, PNG, WEBP, atau PDF. Ukuran maksimal 2 MB (2048 KB).
                            </small>
                            <div class="invalid-feedback" id="error-foto"></div>

                            <!-- Preview file saat ini ketika edit -->
                            <div id="currentPhotoContainer" class="mt-2 p-2 bg-light rounded border d-none">
                                <span class="small text-muted d-block mb-1">Berkas Foto Saat Ini:</span>
                                <div class="d-flex align-items-center gap-2">
                                    <div id="currentPhotoThumbnail"></div>
                                    <div class="flex-grow-1">
                                        <a href="#" id="currentPhotoLink" target="_blank" class="fw-semibold text-primary text-decoration-none small">
                                            <i class="bi bi-file-earmark-check me-1"></i> <span id="currentPhotoName"></span>
                                        </a>
                                        <small class="text-muted d-block" style="font-size: 0.72rem;">Biarkan kosong jika tidak ingin mengganti berkas foto.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2" id="btnSimpanProduk">
                        <i class="bi bi-check-lg"></i> <span id="btnSimpanText">Simpan Produk</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 2: Detail Produk (Lihat Detail AJAX)                     -->
<!-- ============================================================== -->
<div class="modal fade" id="modalDetailProduk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-info-circle text-info me-1"></i> Detail Data Produk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3" id="detailFotoBox">
                    <!-- Foto preview -->
                </div>
                <table class="table table-sm table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th class="table-light text-secondary" style="width: 140px;">Nama Produk</th>
                            <td class="fw-bold text-dark" id="detailNama"></td>
                        </tr>
                        <tr>
                            <th class="table-light text-secondary">Kategori</th>
                            <td id="detailKategori"></td>
                        </tr>
                        <tr>
                            <th class="table-light text-secondary">Harga Satuan</th>
                            <td class="fw-bold text-success fs-6" id="detailHarga"></td>
                        </tr>
                        <tr>
                            <th class="table-light text-secondary">Jumlah Stok</th>
                            <td id="detailStok"></td>
                        </tr>
                        <tr>
                            <th class="table-light text-secondary">Deskripsi</th>
                            <td class="small" id="detailDeskripsi"></td>
                        </tr>
                        <tr>
                            <th class="table-light text-secondary">Berkas Foto</th>
                            <td id="detailFileAction"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 3: Lightbox Preview Foto                                 -->
<!-- ============================================================== -->
<div class="modal fade" id="modalPreviewFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold" id="previewFotoTitle">Lihat Berkas Foto Produk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3 bg-dark-subtle" id="previewFotoBody">
                <!-- Image or iframe PDF -->
            </div>
            <div class="modal-footer py-2 justify-content-between">
                <small class="text-muted" id="previewFotoSub"></small>
                <a href="#" id="previewFotoExternal" target="_blank" class="btn btn-sm btn-primary">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka di Tab Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Inisialisasi Instance Bootstrap Modal
    const modalForm = new bootstrap.Modal(document.getElementById('modalProduk'));
    const modalDetail = new bootstrap.Modal(document.getElementById('modalDetailProduk'));
    const modalPreview = new bootstrap.Modal(document.getElementById('modalPreviewFoto'));

    // Cache state data produk
    let listProduk = [];

    // Fungsi menampilkan notifikasi alert interaktif
    function showAjaxAlert(message, type = 'success') {
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        const html = `
            <div class="alert alert-${type} alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi ${icon} fs-5"></i>
                <div>${escapeHtml(message)}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        `;
        $('#ajaxAlertContainer').html(html);
        $('html, body').animate({ scrollTop: $('#ajaxAlertContainer').offset().top - 80 }, 300);
    }

    // Fungsi membersihkan pesan error validasi pada form modal
    function resetValidationErrors() {
        $('#formProduk .form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }

    // Fungsi memuat data produk melalui AJAX GET
    function loadProdukData() {
        $('#tbodyProduk').html(`
            <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                    <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                    Memuat data produk melalui AJAX...
                </td>
            </tr>
        `);

        $.ajax({
            url: "{{ route('produk.data') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    listProduk = response.data;
                    renderTabelProduk();
                } else {
                    showAjaxAlert('Gagal mengambil data produk dari server.', 'danger');
                }
            },
            error: function (xhr) {
                console.error(xhr);
                $('#tbodyProduk').html(`
                    <tr>
                        <td colspan="8" class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-triangle fs-3 d-block mb-1"></i>
                            Gagal memuat data produk. Pastikan server aktif dan coba lagi.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // Fungsi render baris tabel produk dan filter client-side
    function renderTabelProduk() {
        const query = $('#searchProduk').val().trim().toLowerCase();
        const selectedKategori = $('#filterKategori').val().trim().toLowerCase();

        const filtered = listProduk.filter(function (item) {
            const matchQuery = (item.nama_produk || '').toLowerCase().includes(query) ||
                               (item.kategori || '').toLowerCase().includes(query) ||
                               (item.deskripsi || '').toLowerCase().includes(query);
            const matchKategori = selectedKategori === '' || (item.kategori || '').toLowerCase() === selectedKategori;
            return matchQuery && matchKategori;
        });

        $('#badgeTotalProduk').text('Total: ' + filtered.length + ' Produk');

        if (filtered.length === 0) {
            $('#tbodyProduk').html(`
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                        Tidak ada produk yang cocok dengan pencarian atau filter.
                    </td>
                </tr>
            `);
            return;
        }

        let rowsHtml = '';
        filtered.forEach(function (p, index) {
            // Render foto thumbnail / icon
            let fotoThumb = '<span class="badge bg-light text-muted border p-2"><i class="bi bi-image"></i></span>';
            let fotoAction = '<span class="text-muted small">-</span>';

            if (p.foto_url) {
                const isPdf = (p.nama_foto || '').toLowerCase().endsWith('.pdf');
                if (isPdf) {
                    fotoThumb = `
                        <div class="rounded bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-file-earmark-pdf fs-4"></i>
                        </div>
                    `;
                } else {
                    fotoThumb = `
                        <img src="${p.foto_url}" alt="${escapeHtml(p.nama_produk)}" 
                             class="rounded border object-fit-cover btn-preview-img" 
                             data-url="${p.foto_url}" data-title="${escapeHtml(p.nama_produk)}"
                             style="width: 44px; height: 44px; cursor: pointer;" 
                             title="Klik untuk perbesar">
                    `;
                }

                fotoAction = `
                    <button type="button" class="btn btn-sm btn-outline-info btn-lihat-foto py-0 px-2" 
                            data-url="${p.foto_url}" 
                            data-ispdf="${isPdf}" 
                            data-name="${escapeHtml(p.nama_foto || p.nama_produk)}" 
                            data-title="${escapeHtml(p.nama_produk)}">
                        <i class="bi bi-eye-fill me-1"></i> Lihat Foto
                    </button>
                `;
            }

            // Stok badge
            let stokBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle">${p.stok} unit</span>`;
            if (p.stok <= 0) {
                stokBadge = `<span class="badge bg-danger text-white">Habis</span>`;
            } else if (p.stok < 10) {
                stokBadge = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle">${p.stok} unit (Menipis)</span>`;
            }

            rowsHtml += `
                <tr>
                    <td class="text-muted small">${index + 1}</td>
                    <td>${fotoThumb}</td>
                    <td>
                        <strong class="text-dark d-block">${escapeHtml(p.nama_produk)}</strong>
                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                            ${escapeHtml(p.deskripsi || '-')}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">${escapeHtml(p.kategori)}</span>
                    </td>
                    <td class="fw-semibold text-dark">${p.formatted_harga || ('Rp ' + Number(p.harga).toLocaleString('id-ID'))}</td>
                    <td>${stokBadge}</td>
                    <td>${fotoAction}</td>
                    <td class="text-center text-nowrap">
                        <button type="button" class="btn btn-sm btn-outline-info btn-detail" data-id="${p.id}" title="Lihat Detail Produk">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-id="${p.id}" title="Edit Data Produk">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="${p.id}" data-name="${escapeHtml(p.nama_produk)}" title="Hapus Produk">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#tbodyProduk').html(rowsHtml);
    }

    // Event listener: Pencarian realtime & Filter kategori
    $('#searchProduk').on('input', renderTabelProduk);
    $('#filterKategori').on('change', renderTabelProduk);
    $('#btnRefreshData').on('click', function () {
        loadProdukData();
    });

    // -------------------------------------------------------------
    // FITUR 1: Tambah Produk (AJAX POST)
    // -------------------------------------------------------------
    $('#btnTambahProduk').on('click', function () {
        resetValidationErrors();
        $('#formProduk')[0].reset();
        $('#produk_id').val('');
        $('#currentPhotoContainer').addClass('d-none');

        $('#modalProdukTitle').html('<i class="bi bi-plus-circle me-1"></i> Tambah Produk Baru');
        $('#btnSimpanText').text('Simpan Produk');
        modalForm.show();
    });

    // -------------------------------------------------------------
    // FITUR 2: Edit Produk (AJAX GET single data & Open Modal)
    // -------------------------------------------------------------
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        resetValidationErrors();
        $('#formProduk')[0].reset();

        $.ajax({
            url: "{{ url('produk') }}/" + id,
            type: "GET",
            dataType: "json",
            success: function (res) {
                if (res.success && res.data) {
                    const p = res.data;
                    $('#produk_id').val(p.id);
                    $('#nama_produk').val(p.nama_produk);
                    $('#kategori').val(p.kategori);
                    $('#harga').val(p.harga);
                    $('#stok').val(p.stok);
                    $('#deskripsi').val(p.deskripsi || '');

                    // Foto saat ini
                    if (p.foto_url) {
                        $('#currentPhotoContainer').removeClass('d-none');
                        $('#currentPhotoName').text(p.nama_foto || 'Berkas Foto');
                        $('#currentPhotoLink').attr('href', p.foto_url);

                        const isPdf = (p.nama_foto || '').toLowerCase().endsWith('.pdf');
                        if (isPdf) {
                            $('#currentPhotoThumbnail').html('<i class="bi bi-file-earmark-pdf fs-3 text-danger"></i>');
                        } else {
                            $('#currentPhotoThumbnail').html(`<img src="${p.foto_url}" class="rounded border" style="width: 38px; height: 38px; object-fit: cover;">`);
                        }
                    } else {
                        $('#currentPhotoContainer').addClass('d-none');
                    }

                    $('#modalProdukTitle').html('<i class="bi bi-pencil-square me-1"></i> Edit Data Produk');
                    $('#btnSimpanText').text('Perbarui Produk');
                    modalForm.show();
                }
            },
            error: function () {
                showAjaxAlert('Gagal mengambil data produk untuk diedit.', 'danger');
            }
        });
    });

    // -------------------------------------------------------------
    // FITUR 3: Submit Form Simpan / Update Produk (AJAX FormData)
    // -------------------------------------------------------------
    $('#formProduk').on('submit', function (e) {
        e.preventDefault();
        resetValidationErrors();

        const id = $('#produk_id').val();
        const formData = new FormData(this);

        let targetUrl = "{{ route('produk.store') }}";
        if (id) {
            targetUrl = "{{ url('produk') }}/" + id;
            formData.append('_method', 'PUT'); // Method spoofing untuk FormData di Laravel
        }

        // Disable button & loading indicator
        $('#btnSimpanProduk').prop('disabled', true);
        $('#btnSimpanText').html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
            url: targetUrl,
            type: "POST", // FormData dengan upload file dikirim via POST
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                $('#btnSimpanProduk').prop('disabled', false);
                $('#btnSimpanText').text(id ? 'Perbarui Produk' : 'Simpan Produk');

                if (res.success) {
                    modalForm.hide();
                    showAjaxAlert(res.message, 'success');
                    loadProdukData(); // Reload table tanpa reload browser
                }
            },
            error: function (xhr) {
                $('#btnSimpanProduk').prop('disabled', false);
                $('#btnSimpanText').text(id ? 'Perbarui Produk' : 'Simpan Produk');

                if (xhr.status === 422) {
                    // Validasi error dari Form Request
                    const errors = xhr.responseJSON.errors || {};
                    Object.keys(errors).forEach(function (field) {
                        $('#' + field).addClass('is-invalid');
                        $('#error-' + field).text(errors[field][0]);
                    });
                } else if (xhr.status === 403) {
                    showAjaxAlert('Akses ditolak: Anda tidak memiliki izin untuk tindakan ini.', 'danger');
                } else {
                    const msg = xhr.responseJSON?.message || 'Terjadi kesalahan sistem saat menyimpan produk.';
                    showAjaxAlert(msg, 'danger');
                }
            }
        });
    });

    // -------------------------------------------------------------
    // FITUR 4: Lihat Detail Produk (AJAX GET -> Detail Modal)
    // -------------------------------------------------------------
    $(document).on('click', '.btn-detail', function () {
        const id = $(this).data('id');

        $.ajax({
            url: "{{ url('produk') }}/" + id,
            type: "GET",
            dataType: "json",
            success: function (res) {
                if (res.success && res.data) {
                    const p = res.data;
                    $('#detailNama').text(p.nama_produk);
                    $('#detailKategori').html(`<span class="badge bg-light text-dark border">${escapeHtml(p.kategori)}</span>`);
                    $('#detailHarga').text(p.formatted_harga || ('Rp ' + Number(p.harga).toLocaleString('id-ID')));
                    $('#detailStok').html(`<span class="badge bg-success-subtle text-success">${p.stok} unit</span>`);
                    $('#detailDeskripsi').text(p.deskripsi || 'Tidak ada deskripsi.');

                    if (p.foto_url) {
                        const isPdf = (p.nama_foto || '').toLowerCase().endsWith('.pdf');
                        if (isPdf) {
                            $('#detailFotoBox').html(`
                                <div class="p-3 bg-light rounded border text-center">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger d-block mb-1"></i>
                                    <span class="small fw-semibold text-dark">${escapeHtml(p.nama_foto || 'Dokumen PDF')}</span>
                                </div>
                            `);
                        } else {
                            $('#detailFotoBox').html(`
                                <img src="${p.foto_url}" alt="${escapeHtml(p.nama_produk)}" 
                                     class="img-fluid rounded border shadow-sm mb-2" 
                                     style="max-height: 180px; object-fit: contain;">
                            `);
                        }

                        $('#detailFileAction').html(`
                            <a href="${p.foto_url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Berkas (${escapeHtml(p.nama_foto || 'File')})
                            </a>
                        `);
                    } else {
                        $('#detailFotoBox').html(`
                            <div class="p-3 bg-light rounded text-muted small">
                                <i class="bi bi-image fs-3 d-block mb-1 text-secondary"></i>
                                Belum ada berkas foto komoditas.
                            </div>
                        `);
                        $('#detailFileAction').html('<span class="text-muted small">Tidak ada berkas.</span>');
                    }

                    modalDetail.show();
                }
            },
            error: function () {
                showAjaxAlert('Gagal mengambil detail produk.', 'danger');
            }
        });
    });

    // -------------------------------------------------------------
    // FITUR 5: Lihat / Buka Foto Produk (Preview Modal / New Tab)
    // -------------------------------------------------------------
    $(document).on('click', '.btn-lihat-foto, .btn-preview-img', function () {
        const url = $(this).data('url');
        const title = $(this).data('title') || 'Berkas Foto';
        const name = $(this).data('name') || '';
        const isPdf = String($(this).data('ispdf')) === 'true' || url.toLowerCase().endsWith('.pdf');

        $('#previewFotoTitle').text('Foto: ' + title);
        $('#previewFotoSub').text('Nama berkas: ' + name);
        $('#previewFotoExternal').attr('href', url);

        if (isPdf) {
            $('#previewFotoBody').html(`
                <iframe src="${url}" style="width: 100%; height: 500px; border: none;" class="rounded"></iframe>
            `);
        } else {
            $('#previewFotoBody').html(`
                <img src="${url}" alt="${title}" class="img-fluid rounded shadow-sm" style="max-height: 520px; object-fit: contain;">
            `);
        }

        modalPreview.show();
    });

    // -------------------------------------------------------------
    // FITUR 6: Hapus Produk (AJAX DELETE)
    // -------------------------------------------------------------
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');

        if (!confirm(`Apakah Anda yakin ingin menghapus produk '${name}'?\n\nFoto produk juga akan otomatis dihapus dari penyimpanan server.`)) {
            return;
        }

        $.ajax({
            url: "{{ url('produk') }}/" + id,
            type: "DELETE",
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    showAjaxAlert(res.message, 'success');
                    loadProdukData(); // Reload table tanpa reload browser
                } else {
                    showAjaxAlert('Gagal menghapus produk.', 'danger');
                }
            },
            error: function (xhr) {
                if (xhr.status === 403) {
                    showAjaxAlert('Akses ditolak: Anda tidak memiliki izin untuk menghapus produk.', 'danger');
                } else {
                    showAjaxAlert('Terjadi kesalahan saat menghapus data produk.', 'danger');
                }
            }
        });
    });

    // Inisialisasi: Muat data produk saat halaman pertama kali dibuka
    loadProdukData();
});
</script>
@endpush
