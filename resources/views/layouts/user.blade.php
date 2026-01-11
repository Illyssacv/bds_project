<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>@yield('title','User Profile')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background:#f5f6fa; }

        .profile-cover {
            background: linear-gradient(120deg,#e53935,#ff7043);
            height: 180px;
            border-radius: 0 0 20px 20px;
        }

        .profile-card {
            margin-top: -90px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(0,0,0,.08);
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
        }

        .menu-link {
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .menu-link:hover,
        .menu-link.active {
            background: #fcebea;
            color: #e53935;
        }
    </style>
</head>
<body>

{{-- Header --}}
<div class="profile-cover"></div>

<div class="container">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-lg-3 mb-3">
            <div class="profile-card p-3 text-center">
                <img src="https://i.pravatar.cc/200" class="avatar mb-2">
                <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>

                <hr>

                <a href="{{ route('user.profile') }}"
                   class="menu-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> Hồ sơ cá nhân
                </a>

                <a href="#" class="menu-link">
                    <i class="bi bi-building"></i> Tin đã đăng
                </a>

                <a href="#" class="menu-link">
                    <i class="bi bi-heart"></i> Tin đã lưu
                </a>

                <a href="#" class="menu-link">
                    <i class="bi bi-key"></i> Đổi mật khẩu
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>

        {{-- Content --}}
        <div class="col-lg-9 mb-5">
            <div class="profile-card p-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>

</body>
</html>
