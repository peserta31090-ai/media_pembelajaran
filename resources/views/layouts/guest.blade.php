<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - SMKN 1 Sintuk Toboh Gadang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
        body {
            background: linear-gradient(135deg, #0a1628 0%, #1a3a6b 40%, #2563eb 70%, #60a5fa 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }

        .login-header {
            background: linear-gradient(135deg, #0a1628, #1a3a6b 50%, #2563eb);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            color: white;
        }

        .login-header .logo-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .login-header .logo-icon i {
            font-size: 2rem;
        }

        .login-header h4 {
            font-weight: 700;
            margin-bottom: 0.15rem;
            font-size: 1.15rem;
        }

        .login-header p {
            opacity: 0.85;
            font-size: 0.8rem;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .login-body {
            padding: 2rem;
        }

        .login-body .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #495057;
        }

        .login-body .form-control {
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.2s;
        }

        .login-body .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        }

        .login-body .form-control.is-invalid {
            border-color: #dc3545;
        }

        .login-body .btn-login {
            background: linear-gradient(135deg, #2563eb, #1a3a6b);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }

        .login-body .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        .login-body .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            background: #f8f9fa;
            padding: 1rem 2rem;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .login-footer small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .form-check-input:checked {
            background-color: #0D6EFD;
            border-color: #0D6EFD;
        }

        .input-group-text {
            background: white;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 0.5rem 0 0 0.5rem;
            color: #6c757d;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0 !important;
        }

        .input-group:focus-within .input-group-text {
            border-color: #0D6EFD;
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 1.5rem 1.5rem 1rem;
            }
            .login-body {
                padding: 1.5rem;
            }
            .login-body .btn-login {
                font-size: 0.9rem;
                padding: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h4>Media Pembelajaran</h4>
                <p>SMK Negeri 1 Sintuk Toboh Gadang</p>
            </div>

            <div class="login-body">
                {{ $slot }}
            </div>

            <div class="login-footer">
                <small>&copy; {{ date('Y') }} Media Pembelajaran Informatika</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
