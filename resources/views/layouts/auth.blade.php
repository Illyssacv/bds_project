<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            min-height: 100vh;
        }
        .auth-card {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card auth-card">
                <div class="card-body p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
