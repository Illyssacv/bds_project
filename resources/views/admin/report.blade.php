@extends('layouts.admin')

@section('title', 'Báo cáo')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Báo cáo & Thống kê</h4>
            <div class="text-muted">Tổng quan hoạt động hệ thống theo thời gian</div>
        </div>

        {{-- Filter --}}
        <form class="d-flex flex-wrap align-items-end gap-2" method="GET" action="">
            <div>
                <label class="form-label mb-1 small text-muted">Từ ngày</label>
                <input type="date" name="from" class="form-control"
                       value="{{ request('from') }}">
            </div>
            <div>
                <label class="form-label mb-1 small text-muted">Đến ngày</label>
                <input type="date" name="to" class="form-control"
                       value="{{ request('to') }}">
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-funnel"></i> Lọc
            </button>

            <a class="btn btn-outline-secondary" href="{{ url()->current() }}">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </a>
        </form>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Tổng người dùng</div>
                        <div class="fs-4 fw-bold">{{ $totalUsers ?? 0 }}</div>
                        <div class="small text-muted mt-1">Cập nhật theo dữ liệu hiện tại</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Bài đăng bán</div>
                        <div class="fs-4 fw-bold">{{ $totalSalePosts ?? 0 }}</div>
                        <div class="small text-muted mt-1">Tổng số bài đăng bán</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-house-door fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Bài đăng thuê</div>
                        <div class="fs-4 fw-bold">{{ $totalRentPosts ?? 0 }}</div>
                        <div class="small text-muted mt-1">Tổng số bài đăng thuê</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Liên hệ / Tin nhắn</div>
                        <div class="fs-4 fw-bold">{{ $totalContacts ?? 0 }}</div>
                        <div class="small text-muted mt-1">Số lượt liên hệ</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-chat-left-text fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main content --}}
    <div class="row g-3">
        {{-- Chart placeholder --}}
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-semibold">Biểu đồ hoạt động</div>
                        <div class="text-muted small">Gợi ý: số bài đăng / user mới theo ngày</div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Tuỳ chọn
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Bài đăng theo ngày</a></li>
                            <li><a class="dropdown-item" href="#">User mới theo ngày</a></li>
                            <li><a class="dropdown-item" href="#">Liên hệ theo ngày</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Bạn có thể thay div này bằng Chart.js sau --}}
                    <div class="border rounded-3 p-4 text-center text-muted" style="min-height: 280px;">
                        <div class="mb-2"><i class="bi bi-bar-chart fs-1"></i></div>
                        <div class="fw-semibold">Chưa có biểu đồ</div>
                        <div class="small">Có thể tích hợp Chart.js để hiển thị dữ liệu theo ngày</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick actions + latest --}}
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0">
                    <div class="fw-semibold">Tác vụ nhanh</div>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2"></i> Về Dashboard
                    </a>

                    {{-- Nếu route chưa có thì bạn cứ đổi lại sau --}}
                    <a href="{{ route('admin.posts.index', [], false) ?? '#' }}" class="btn btn-outline-secondary">
                        <i class="bi bi-card-list"></i> Quản lý tin đăng
                    </a>

                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-people"></i> Quản lý người dùng
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                    <div class="fw-semibold">User mới</div>
                    <span class="badge bg-light text-dark">{{ isset($latestUsers) ? count($latestUsers) : 0 }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse(($latestUsers ?? []) as $u)
                            <div class="list-group-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                         style="width:40px;height:40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $u->name ?? 'User' }}</div>
                                        <div class="small text-muted">{{ $u->email ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="small text-muted">
                                    {{ optional($u->created_at)->format('d/m/Y') }}
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">Chưa có dữ liệu.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Top posts table --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-semibold">Top tin đăng nổi bật</div>
                        <div class="text-muted small">Gợi ý: sort theo views / liên hệ / ngày tạo</div>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> In báo cáo
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px;">#</th>
                                    <th>Tiêu đề</th>
                                    <th>Loại</th>
                                    <th>Chủ tin</th>
                                    <th class="text-end">Lượt xem</th>
                                    <th class="text-end">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($topPosts ?? []) as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $p->title ?? '---' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $p->type ?? 'post' }}
                                            </span>
                                        </td>
                                        <td>{{ $p->user->name ?? '---' }}</td>
                                        <td class="text-end">{{ $p->views ?? 0 }}</td>
                                        <td class="text-end">{{ optional($p->created_at)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Chưa có dữ liệu top posts.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
