<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Siswa') - Media Pembelajaran SMKN 1 Sintuk Toboh Gadang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root { --primary-color: #0D6EFD; --sidebar-width: 260px; }

        body { background: #F8F9FA; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }

        .wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #001f3f 0%, #003366 40%, #004e89 100%);
            color: white;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed { margin-left: calc(-1 * var(--sidebar-width)); }

        .sidebar-header { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h5 { font-weight: 600; font-size: 1rem; margin: 0; }
        .sidebar-header small { opacity: 0.8; font-size: 0.75rem; }

        .sidebar-nav { padding: 0.5rem 0; }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 0.625rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .sidebar-nav .nav-link:hover { color: white; background: rgba(37,99,235,0.15); }
        .sidebar-nav .nav-link.active { color: white; background: linear-gradient(90deg, #2563eb 0%, rgba(37,99,235,0.3) 80%, transparent 100%); font-weight: 500; }
        .sidebar-nav .nav-link i { font-size: 1.1rem; width: 1.25rem; text-align: center; }
        .sidebar-nav .nav-header {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0.75rem 1rem 0.25rem;
            font-weight: 600;
        }

        .main-content { flex: 1; margin-left: var(--sidebar-width); transition: all 0.3s ease; min-height: 100vh; display: flex; flex-direction: column; }
        .main-content.expanded { margin-left: 0; }

        .navbar-top {
            background: white;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-wrapper { padding: 1.5rem; flex: 1; }
        .page-title { font-weight: 600; color: #1a1a2e; margin-bottom: 1.5rem; font-size: 1.5rem; }

        .card { border: none; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .card-header { background: white; border-bottom: 1px solid #eee; padding: 1rem 1.25rem; font-weight: 600; }
        .stat-card { border-radius: 0.75rem; padding: 1.25rem; position: relative; overflow: hidden; }
        .stat-card .stat-icon { font-size: 2rem; opacity: 0.15; position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; }
        .stat-card .stat-label { font-size: 0.85rem; opacity: 0.85; }
        .btn { border-radius: 0.5rem; }

        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; }

        @media (max-width: 768px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show { margin-left: 0; }
            .main-content { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
        }

        .footer { background: white; padding: 1rem 1.5rem; font-size: 0.8rem; color: #6c757d; border-top: 1px solid #eee; }

        .list-item-card {
            transition: all 0.2s;
            border-left: 4px solid #0D6EFD;
        }

        .list-item-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateX(4px);
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header text-center">
                <div class="mb-2">
                    <div class="d-inline-flex align-items-center justify-content-center" style="width:50px;height:50px;background:rgba(255,255,255,0.15);border-radius:12px;">
                        <i class="bi bi-mortarboard-fill" style="font-size:1.75rem;"></i>
                    </div>
                </div>
                <h5 class="fw-bold" style="font-size:0.95rem;">Media Pembelajaran</h5>
                <small style="font-size:0.65rem;opacity:0.8;display:block;line-height:1.2;">SMK Negeri 1<br>Sintuk Toboh Gadang</small>
            </div>
            <div class="sidebar-nav">
                <div class="nav-header">Menu Siswa</div>

                <div class="nav-item">
                    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </div>

                <div class="nav-header">Pembelajaran</div>

                <div class="nav-item">
                    <a href="{{ route('siswa.materi.index') }}" class="nav-link {{ request()->routeIs('siswa.materi.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> Materi
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('siswa.video.index') }}" class="nav-link {{ request()->routeIs('siswa.video.*') ? 'active' : '' }}">
                        <i class="bi bi-play-circle"></i> Video
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('siswa.tugas.index') }}" class="nav-link {{ request()->routeIs('siswa.tugas.*') ? 'active' : '' }}">
                        <i class="bi bi-pencil-square"></i> Tugas
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('siswa.kuis.index') }}" class="nav-link {{ request()->routeIs('siswa.kuis.*') ? 'active' : '' }}">
                        <i class="bi bi-question-circle"></i> Kuis
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('siswa.nilai.index') }}" class="nav-link {{ request()->routeIs('siswa.nilai.*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i> Nilai
                    </a>
                </div>

                <div class="nav-header">Informasi</div>

                <div class="nav-item">
                    <a href="{{ route('siswa.pengumuman.index') }}" class="nav-link {{ request()->routeIs('siswa.pengumuman.*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> Pengumuman
                    </a>
                </div>
            </div>
        </nav>

        <div class="main-content" id="mainContent">
            <nav class="navbar-top d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="text-end me-2">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <small class="text-muted">Siswa</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content-wrapper">
                @yield('content')
            </div>

            <footer class="footer text-center">
                &copy; {{ date('Y') }} Media Pembelajaran Informatika - SMK Negeri 1 Sintuk Toboh Gadang
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    @stack('scripts')

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
            this.classList.remove('show');
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
        @endif
    </script>
</body>
</html>
