<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khung Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section-placeholder {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            padding: 50px 0;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">LOGO</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Nhà Đất Cho Thuê</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Nhà Đất Bán</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Tin Tức</a></li>
                    </ul>

                    <div class="navbar-nav">
                        <a class="btn btn-primary" href="#">Login</a>
                        <a class="btn btn-success ms-2" href="#">Register</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
    @yield('content')
        <div class="row">
            <div class="col-12">
                <div class="section-placeholder">
                    <h3>KHU VỰC TIN TỨC</h3>
                    <p>(Danh sách bài viết mới nhất)</p>
                </div>
            </div>
        </div>

    </main>
    <footer class="bg-light text-center py-4 mt-4">
        <p class="mb-0">&copy; 2024 Công ty Cổ phần Bất động sản. All rights reserved.</p>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>