<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
        }

        body {
            background: #f6f7fb;
        }

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            position: sticky;
            top: 0;
            background: #0b1220;
            color: rgba(255, 255, 255, .85);
        }

        .sidebar a {
            color: rgba(255, 255, 255, .78);
            text-decoration: none;
        }

        .sidebar a:hover {
            color: #fff;
        }

        .brand {
            padding: 18px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand .logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .12);
            display: grid;
            place-items: center;
        }

        .nav-section-title {
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45);
            margin: 18px 18px 8px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 10px;
            margin: 4px 10px;
        }

        .side-link.active,
        .side-link:hover {
            background: rgba(255, 255, 255, .10);
        }

        .content-wrap {
            width: 100%;
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
        }

        .page-card {
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .04);
        }

        .stat-card {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, .06);
            background: #fff;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #f1f3f9;
            display: grid;
            place-items: center;
        }

        /* mobile: sidebar offcanvas */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                z-index: 1050;
                transition: .25s;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .45);
                z-index: 1040;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">

        {{-- Sidebar --}}
        <aside id="sidebar" class="sidebar">
            <div class="brand">
                <div class="logo"><i class="bi bi-house-heart-fill"></i></div>
                <div>
                    <div class="fw-bold">BĐS Admin</div>
                    <div class="small text-white-50">Quản trị hệ thống</div>
                </div>
            </div>

            <div class="nav-section-title">Tổng quan</div>
            <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-section-title">Quản lý</div>

            <a class="side-link {{ request()->routeIs('admin.posts.approve') ? 'active' : '' }}"
                href="{{ route('admin.posts.approve') }}">
                <i class="bi bi-building"></i>
                <span>Duyệt tin đăng</span>
            </a>
            <a class="side-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                href="{{ route('admin.posts.index') }}">
                <i class="bi bi-building"></i>
                <span>Tin đăng</span>
            </a>

            <a class="side-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                href="{{ route('admin.report') }}">
                <i class="bi bi-flag"></i>
                <span>Báo cáo vi phạm</span>
            </a>

            <div class="nav-section-title">Hệ thống</div>
            <a class="side-link" href="#">
                <i class="bi bi-gear"></i>
                <span>Cài đặt</span>
            </a>

            <div class="mt-auto p-3">
                <div class="small text-white-50 mb-2">
                    Đăng nhập: <span class="text-white">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>

                {{-- logout --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </aside>

        {{-- mobile backdrop --}}
        <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar(false)"></div>

        {{-- Main content --}}
        <div class="content-wrap">

            {{-- Topbar --}}
            <nav class="topbar px-3 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary d-lg-none" onclick="toggleSidebar(true)">
                            <i class="bi bi-list"></i>
                        </button>
                        <div>
                            <div class="fw-bold">@yield('page_title','Dashboard')</div>
                            <div class="small text-muted">@yield('page_subtitle','Tổng quan hệ thống')</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="input-group d-none d-md-flex" style="width: 320px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Tìm kiếm...">
                        </div>

                        <button class="btn btn-outline-secondary position-relative">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </button>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="px-2">
                                        @csrf
                                        <button class="btn btn-danger w-100">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Page content --}}
            <main class="p-3 p-lg-4">
                @yield('content')

                <div class="text-center text-muted small mt-4">
                    © {{ date('Y') }} BĐS Admin — Built with Bootstrap
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar(show) {
            const sb = document.getElementById('sidebar');
            const bd = document.getElementById('sidebarBackdrop');
            if (!sb || !bd) return;

            if (show) {
                sb.classList.add('show');
                bd.classList.add('show');
            } else {
                sb.classList.remove('show');
                bd.classList.remove('show');
            }
        }
    </script>
</body>

</html>