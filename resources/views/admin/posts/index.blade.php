@extends('layouts.admin')

@section('title', 'Quản lý tin đăng')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Quản lý tin đăng</h4>
            <div class="text-muted">Danh sách tin đăng bán / thuê trên hệ thống</div>
        </div>

        <div class="d-flex gap-2">
            {{-- đổi route theo bạn --}}
            <!-- <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo tin mới
            </a> -->
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="" class="row g-2 align-items-end">

                <div class="col-12 col-md-4">
                    <label class="form-label mb-1 small text-muted">Tìm kiếm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control"
                               placeholder="Nhập tiêu đề / mã tin / tên chủ tin..."
                               value="{{ request('q') }}">
                    </div>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1 small text-muted">Loại tin</label>
                    <select name="type" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="sale" {{ request('type')=='sale' ? 'selected' : '' }}>Bán</option>
                        <option value="rent" {{ request('type')=='rent' ? 'selected' : '' }}>Thuê</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1 small text-muted">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Đang hiển thị</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="hidden" {{ request('status')=='hidden' ? 'selected' : '' }}>Ẩn</option>
                        <option value="blocked" {{ request('status')=='blocked' ? 'selected' : '' }}>Bị chặn</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1 small text-muted">Từ ngày</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label mb-1 small text-muted">Đến ngày</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ url()->current() }}">
                        Reset
                    </a>

                    {{-- quick export giả (bạn làm sau) --}}
                    <button type="button" class="btn btn-outline-dark ms-auto" onclick="window.print()">
                        <i class="bi bi-printer"></i> In / Xuất PDF
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
            <div class="fw-semibold">
                Danh sách tin
                <span class="badge bg-light text-dark ms-2">
                    {{ isset($posts) ? $posts->total() : 0 }} tin
                </span>
            </div>

            <div class="text-muted small">
                Cập nhật: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Tiêu đề</th>
                            <th style="width:110px;">Loại</th>
                            <th>Chủ tin</th>
                            <th class="text-end" style="width:130px;">Giá</th>
                            <th class="text-center" style="width:120px;">Trạng thái</th>
                            <th class="text-end" style="width:140px;">Ngày tạo</th>
                            <th class="text-end" style="width:160px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse(($posts ?? []) as $p)
                            @php
                                $type = $p->type ?? ($p->post_type ?? null); // tuỳ schema
                                $status = $p->status ?? ($p->is_active ?? null);

                                // badge status
                                $statusText = '---';
                                $statusClass = 'bg-light text-dark';

                                // Nếu bạn dùng status dạng string
                                if (is_string($status)) {
                                    if ($status === 'active') { $statusText = 'Hiển thị'; $statusClass = 'bg-success'; }
                                    elseif ($status === 'pending') { $statusText = 'Chờ duyệt'; $statusClass = 'bg-warning text-dark'; }
                                    elseif ($status === 'hidden') { $statusText = 'Ẩn'; $statusClass = 'bg-secondary'; }
                                    elseif ($status === 'blocked') { $statusText = 'Bị chặn'; $statusClass = 'bg-danger'; }
                                }

                                // Nếu bạn dùng is_active boolean
                                if (is_bool($status) || $status === 0 || $status === 1) {
                                    if ((int)$status === 1) { $statusText = 'Hiển thị'; $statusClass = 'bg-success'; }
                                    else { $statusText = 'Ẩn'; $statusClass = 'bg-secondary'; }
                                }

                                // badge type
                                $typeText = $type === 'sale' ? 'Bán' : ($type === 'rent' ? 'Thuê' : ($type ?? '---'));
                                $typeClass = $type === 'sale' ? 'bg-primary' : ($type === 'rent' ? 'bg-info text-dark' : 'bg-light text-dark');

                                // price format
                                $price = $p->price ?? null;
                            @endphp

                            <tr>
                                <td class="fw-semibold">#{{ $p->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $p->title ?? '---' }}</div>
                                    <div class="small text-muted">
                                        {{ $p->address ?? $p->location ?? '' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge {{ $typeClass }}">{{ $typeText }}</span>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $p->user->name ?? $p->owner_name ?? '---' }}</div>
                                    <div class="small text-muted">{{ $p->user->email ?? '' }}</div>
                                </td>

                                <td class="text-end">
                                    @if(!is_null($price))
                                        <span class="fw-semibold">{{ number_format((float)$price, 0, ',', '.') }}</span>
                                        <div class="small text-muted">VNĐ</div>
                                    @else
                                        ---
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>

                                <td class="text-end">
                                    {{ optional($p->created_at)->format('d/m/Y') }}
                                    <div class="small text-muted">{{ optional($p->created_at)->format('H:i') }}</div>
                                </td>

                                <td class="text-end">
                                    <div class="btn-group">
                                        {{-- đổi route theo bạn --}}
                                        <a href="{{ route('admin.posts.show', $p->id) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Xem">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.posts.edit', $p->id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.posts.destroy', $p->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Xoá tin #{{ $p->id }} ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Xoá">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <div class="mb-2"><i class="bi bi-inboxes fs-1"></i></div>
                                    Chưa có tin đăng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white border-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="text-muted small">
                    @if(isset($posts) && method_exists($posts, 'firstItem'))
                        Hiển thị {{ $posts->firstItem() }} - {{ $posts->lastItem() }} / {{ $posts->total() }} bản ghi
                    @endif
                </div>

                <div>
                    @if(isset($posts) && method_exists($posts, 'links'))
                        {{ $posts->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
