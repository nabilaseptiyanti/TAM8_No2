<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') - PASCER (Pasar Cerdas)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #09261d 0%, #061812 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .auth-card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
        }

        .auth-header {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            padding: 2.25rem 2rem 1.75rem;
            text-align: center;
        }

        .auth-icon {
            width: 58px;
            height: 58px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 0.85rem;
        }

        .auth-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.65rem 0.95rem;
            border: 1px solid #cbd5e1;
            font-size: 0.92rem;
        }

        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .btn-pascer {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
            transition: all 0.2s ease;
        }

        .btn-pascer:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .demo-box {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
        }

        .demo-pill {
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            background: #e2e8f0;
            font-weight: 600;
            display: inline-block;
            margin: 0.15rem 0;
            transition: all 0.2s;
        }

        .demo-pill:hover {
            background: #cbd5e1;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-shop"></i>
            </div>
            <h4 class="fw-bold mb-1">PASCER</h4>
            <p class="mb-0 text-white-50 small">Pasar Cerdas &bull; Solusi Manajemen Pasar Modern</p>
        </div>

        <div class="auth-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show small" role="alert">
                    <i class="bi bi-info-circle me-1"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
