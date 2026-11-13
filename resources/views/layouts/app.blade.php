<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - PASCER (Pasar Cerdas)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --pascer-primary: #059669;
            --pascer-primary-dark: #047857;
            --pascer-primary-light: #d1fae5;
            --pascer-accent: #0284c7;
            --pascer-dark: #0f172a;
            --pascer-sidebar: #0f231c;
            --pascer-sidebar-hover: #16382c;
            --pascer-sidebar-active: #10b981;
            --pascer-bg: #f8fafc;
            --pascer-card-border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--pascer-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* Layout Architecture */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        .app-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0b1f18 0%, #061510 100%);
            color: #e2e8f0;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s ease;
            box-shadow: 4px 0 16px rgba(0, 0, 0, 0.08);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            color: #ffffff;
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .sidebar-brand-text {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar-brand-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .sidebar-menu {
            padding: 1.25rem 0.85rem;
            flex: 1;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            padding: 0.75rem 0.75rem 0.35rem 0.75rem;
            letter-spacing: 0.08em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            color: #94a3b8;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .sidebar-link:hover i {
            color: #34d399;
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.22) 0%, rgba(16, 185, 129, 0.08) 100%);
            color: #34d399;
            border-left: 3px solid #10b981;
        }

        .sidebar-link.active i {
            color: #10b981;
        }

        .sidebar-user {
            padding: 1.1rem 1.25rem;
            background: rgba(0, 0, 0, 0.25);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.95rem;
        }

        .user-info {
            flex: 1;
            overflow: hidden;
        }

        .user-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-badge {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            display: inline-block;
            text-transform: uppercase;
        }

        /* Main Content Styling */
        .app-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .app-navbar {
            height: 68px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--pascer-card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .content-body {
            padding: 1.75rem;
            flex: 1;
        }

        /* Modern Card Styling */
        .card {
            border: 1px solid var(--pascer-card-border);
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--pascer-card-border);
            padding: 1.1rem 1.4rem;
            font-weight: 700;
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
        }

        .card-body {
            padding: 1.4rem;
        }

        /* Buttons & Forms */
        .btn {
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.88rem;
            transition: all 0.2s ease;
        }

        .btn-success, .btn-primary-pascer {
            background-color: var(--pascer-primary);
            border-color: var(--pascer-primary);
            color: #ffffff;
        }

        .btn-success:hover, .btn-primary-pascer:hover {
            background-color: var(--pascer-primary-dark);
            border-color: var(--pascer-primary-dark);
            color: #ffffff;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        /* Table Styling */
        .table {
            vertical-align: middle;
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1rem;
        }

        .table tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.89rem;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Responsive Mobile Sidebar */
        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
            }
            .app-sidebar.show {
                transform: translateX(0);
            }
            .app-main {
                margin-left: 0;
            }
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(15, 23, 42, 0.5);
                z-index: 1030;
                display: none;
            }
            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar Backdrop for Mobile -->
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- Sidebar Navigation -->
        <aside class="app-sidebar" id="appSidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <div>
                    <div class="sidebar-brand-text">PASCER</div>
                    <div class="sidebar-brand-sub">Pasar Cerdas HMVC</div>
                </div>
            </a>

            <div class="sidebar-menu">
                <div class="menu-header">Menu Utama</div>

                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>

                <div class="menu-header mt-3">Modul HMVC (Modul 8)</div>

                {{-- Modul KelolaKios: Hanya Admin --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('kelola-kios.index') }}" class="sidebar-link {{ request()->is('kelola-kios*') ? 'active' : '' }}">
                    <i class="bi bi-buildings-fill"></i>
                    <span>Kelola Kios</span>
                    <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;">Admin</span>
                </a>
                @endif

                {{-- Modul Produk: Admin & User --}}
                <a href="{{ route('produk.index') }}" class="sidebar-link {{ request()->is('produk*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Data Produk (AJAX)</span>
                    <span class="badge bg-success ms-auto" style="font-size: 0.65rem;">AJAX</span>
                </a>

                <div class="menu-header mt-3">Panduan & Informasi</div>
                <div class="p-3 my-2 rounded-3" style="background: rgba(255, 255, 255, 0.05); font-size: 0.78rem; color: #94a3b8; line-height: 1.5;">
                    <strong class="d-block text-white mb-1"><i class="bi bi-info-circle me-1 text-emerald"></i> Info Hak Akses</strong>
                    Role: <span class="badge {{ auth()->user()->role === \App\Enums\UserRole::Admin ? 'bg-danger' : 'bg-primary' }}">{{ auth()->user()->role->label() }}</span><br>
                    @if(auth()->user()->isAdmin())
                        Akses penuh: Kelola Kios (Sync) & Produk (AJAX).
                    @else
                        Akses terbatas: Produk (AJAX) saja. Kios diblokir (403).
                    @endif
                </div>
            </div>

            <!-- User Footer in Sidebar -->
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</div>
                    <span class="user-role-badge {{ auth()->user()->role === \App\Enums\UserRole::Admin ? 'bg-danger text-white' : 'bg-primary text-white' }}">
                        {{ auth()->user()->role->label() }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light p-1 px-2" title="Keluar">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="app-main">
            <!-- Top Navbar -->
            <header class="app-navbar">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-light border d-lg-none" id="sidebarToggle" type="button">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Pasar Cerdas')</h5>
                        <small class="text-muted d-none d-sm-inline">Tugas Akhir Pemrograman Web - Modul 8 HMVC</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="badge d-none d-md-inline-block py-2 px-3 {{ auth()->user()->role === \App\Enums\UserRole::Admin ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-primary-subtle text-primary border border-primary-subtle' }}">
                        <i class="bi bi-shield-check me-1"></i> Role: <strong>{{ auth()->user()->role->label() }}</strong>
                    </span>

                    <div class="dropdown">
                        <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle text-muted"></i>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li class="dropdown-header">
                                <span class="d-block fw-bold text-dark">{{ auth()->user()->name }}</span>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Body Content -->
            <main class="content-body">
                <!-- Flash Notification Alerts (Synchronous) -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="text-center py-3 border-top bg-white text-muted small">
                &copy; {{ date('Y') }} <strong>PASCER (Pasar Cerdas)</strong> &mdash; Implementasi HMVC Laravel 12 Modul 8
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Setup CSRF Token secara otomatis untuk semua request AJAX jQuery
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('appSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', function () {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
            });
        }

        // Helper fungsi escape HTML untuk pencegahan XSS pada render AJAX
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
    </script>

    @stack('scripts')
</body>
</html>
