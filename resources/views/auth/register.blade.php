<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        .auth-overlay {
            min-height: 100vh;
            background: rgba(0,0,0,.55);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-modal {
            width: min(980px, 100%);
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            position: relative;
        }

        .auth-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,.08);
            background: #fff;
            display: grid;
            place-items: center;
            cursor: pointer;
            z-index: 2;
        }

        .auth-left {
            background: #fdeced;
            padding: 28px;
            height: 100%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: #e53935;
        }
        .brand small {
            display: block;
            font-weight: 600;
            color: rgba(0,0,0,.55);
        }

        .auth-illustration {
            margin-top: 22px;
            border-radius: 12px;
            height: 420px;
            background:
                radial-gradient(circle at 70% 30%, rgba(229,57,53,.12), transparent 55%),
                linear-gradient(135deg, rgba(229,57,53,.10), rgba(255,255,255,.0));
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(0,0,0,.55);
            text-align: center;
            padding: 18px;
        }

        .auth-right { padding: 34px 34px 26px; }
        .hello { font-size: 18px; color: rgba(0,0,0,.65); margin-bottom: 4px; }
        .title { font-size: 34px; font-weight: 800; line-height: 1.05; margin-bottom: 18px; }

        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 14px;
            color: rgba(0,0,0,.45);
        }
        .input-end {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 14px;
            color: rgba(0,0,0,.45);
            cursor: pointer;
        }

        .form-control.with-icon {
            padding-left: 42px;
            height: 52px;
            border-radius: 10px;
        }
        .form-control.with-icon.end-icon { padding-right: 44px; }

        .btn-register {
            height: 52px;
            border-radius: 10px;
            background: #e53935;
            border-color: #e53935;
            font-weight: 700;
        }
        .btn-register:hover { background: #d32f2f; border-color: #d32f2f; }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(0,0,0,.45);
            margin: 18px 0;
        }
        .divider:before, .divider:after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(0,0,0,.10);
        }

        .btn-social {
            height: 52px;
            border-radius: 10px;
            font-weight: 600;
        }

        .legal {
            font-size: 12px;
            color: rgba(0,0,0,.50);
            margin-top: 12px;
        }
        .legal a { color: #e53935; text-decoration: none; }
        .legal a:hover { text-decoration: underline; }

        @media (max-width: 992px) {
            .auth-left { display: none; }
            .auth-right { padding: 28px; }
        }
    </style>
</head>

<body>
<div class="auth-overlay">
    <div class="auth-modal">

        {{-- nút đóng --}}
        <button type="button" class="auth-close" onclick="history.back()" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="row g-0">
            {{-- LEFT --}}
            <div class="col-lg-5">
                <div class="auth-left">
                    <div class="brand">
                        <i class="bi bi-house-heart-fill fs-3"></i>
                       
                    </div>

                    <div class="auth-illustration">
                        <div>
                            <div class="fw-bold fs-4 text-dark">Tham gia ngay</div>
                            <div class="mt-2">Tạo tài khoản để đăng tin & quản lý tin</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-7">
                <div class="auth-right">
                    <div class="hello">Xin chào bạn</div>
                    <div class="title">Đăng ký tài khoản</div>

                    {{-- lỗi validate --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $err)
                                <div>{{ $err }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Họ tên --}}
                        <div class="mb-3 position-relative">
                            <i class="bi bi-person-badge input-icon"></i>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control with-icon"
                                placeholder="Họ và tên"
                                autocomplete="name"
                            >
                        </div>

                        {{-- Email / SĐT --}}
                        <div class="mb-3 position-relative">
                            <i class="bi bi-envelope input-icon"></i>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control with-icon"
                                placeholder="Email"
                                autocomplete="email"
                            >
                        </div>

                        {{-- Mật khẩu --}}
                        <div class="mb-3 position-relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control with-icon end-icon"
                                placeholder="Mật khẩu"
                                autocomplete="new-password"
                            >
                            <i class="bi bi-eye-slash input-end" id="togglePwd" title="Hiện/ẩn mật khẩu"></i>
                        </div>

                        {{-- Nhập lại mật khẩu --}}
                        <div class="mb-3 position-relative">
                            <i class="bi bi-shield-lock input-icon"></i>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="form-control with-icon end-icon"
                                placeholder="Nhập lại mật khẩu"
                                autocomplete="new-password"
                            >
                            <i class="bi bi-eye-slash input-end" id="togglePwd2" title="Hiện/ẩn mật khẩu"></i>
                        </div>

                        {{-- đồng ý điều khoản --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" required>
                            <label class="form-check-label" for="agree">
                                Tôi đồng ý với <a class="text-danger text-decoration-none fw-semibold" href="#">Điều khoản</a> và
                                <a class="text-danger text-decoration-none fw-semibold" href="#">Chính sách</a>
                            </label>
                        </div>

                        <button class="btn btn-danger w-100 btn-register">Đăng ký</button>

                        <div class="divider">Hoặc</div>

                        <button type="button" class="btn btn-outline-dark w-100 btn-social mb-2">
                            <i class="bi bi-apple me-2"></i> Đăng ký với Apple
                        </button>

                        <button type="button" class="btn btn-outline-secondary w-100 btn-social">
                            <i class="bi bi-google me-2"></i> Đăng ký với Google
                        </button>

                        <div class="legal">
                            Bằng việc tiếp tục, bạn đồng ý với
                            <a href="#">Điều khoản sử dụng</a>, <a href="#">Chính sách bảo mật</a>, <a href="#">Quy chế</a>.
                        </div>

                        <div class="text-center mt-4">
                            Đã có tài khoản?
                            <a class="text-danger fw-bold text-decoration-none" href="{{ route('login') }}">Đăng nhập</a> tại đây
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Toggle password show/hide (2 field)
    function bindToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);

        if (!toggle || !input) return;

        toggle.addEventListener('click', () => {
            const isHidden = input.getAttribute('type') === 'password';
            input.setAttribute('type', isHidden ? 'text' : 'password');
            toggle.classList.toggle('bi-eye');
            toggle.classList.toggle('bi-eye-slash');
        });
    }

    bindToggle('togglePwd', 'password');
    bindToggle('togglePwd2', 'password_confirmation');
</script>
</body>
</html>
