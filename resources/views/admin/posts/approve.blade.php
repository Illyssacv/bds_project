@extends('layouts.admin')

@section('title', 'Duyệt tin đăng')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Duyệt tin đăng (Bán)</h4>
            <div class="text-muted">Danh sách tin đang chờ duyệt</div>
        </div>

        <form class="d-flex gap-2" method="GET" action="">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control"
                    placeholder="Tìm theo tiêu đề, địa chỉ, user..."
                    value="{{ $q ?? '' }}">
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-funnel"></i> Lọc
            </button>
            <a class="btn btn-outline-secondary" href="{{ url()->current() }}">Reset</a>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    {{-- Quick stats --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Tin chờ duyệt</div>
                        <div class="fs-4 fw-bold">{{ $pendingCount ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Tin đã duyệt</div>
                        <div class="fs-4 fw-bold">{{ $approvedCount ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light">
                        <i class="bi bi-patch-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
            <div class="fw-semibold">Danh sách chờ duyệt</div>
            <div class="text-muted small">Chọn “Duyệt” để hiển thị tin</div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Thông tin tin</th>
                            <th>Chủ tin</th>
                            <th class="text-end" style="width:140px;">Giá</th>
                            <th class="text-end" style="width:120px;">Diện tích</th>
                            <th class="text-center" style="width:140px;">Trạng thái</th>
                            <th class="text-end" style="width:190px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $p)
                        <tr>
                            <td class="fw-semibold">#{{ $p->id }}</td>

                            <td>
                                <div class="fw-semibold">{{ $p->title }}</div>
                                <div class="small text-muted">{{ $p->address }}</div>

                                <div class="small text-muted mt-1">
                                    <span class="me-2"><i class="bi bi-door-open"></i> {{ $p->bedrooms }} PN</span>
                                    <span class="me-2"><i class="bi bi-droplet"></i> {{ $p->bathrooms }} WC</span>
                                    <span>
                                        <i class="bi bi-lamp"></i>
                                        {{ $p->is_furnished ? 'Nội thất' : 'Không nội thất' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $p->user->name ?? '---' }}</div>
                                <div class="small text-muted">{{ $p->user->email ?? '' }}</div>
                                <div class="small text-muted">{{ $p->user->phone_number ?? '' }}</div>
                            </td>

                            <td class="text-end">
                                <div class="fw-semibold">{{ number_format((float)$p->price, 0, ',', '.') }}</div>
                                <div class="small text-muted">VNĐ</div>
                            </td>

                            <td class="text-end">
                                <div class="fw-semibold">{{ $p->area }}</div>
                                <div class="small text-muted">m²</div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                            </td>

                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal-{{ $p->id }}">
                                        <i class="bi bi-eye"></i> Xem
                                    </button>

                                    <form method="POST" action="{{ route('admin.posts.approve.approve', $p->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Duyệt tin #{{ $p->id }} ?')">
                                            <i class="bi bi-check2"></i> Duyệt
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.posts.approve.reject', $p->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Từ chối/ẩn tin #{{ $p->id }} ?')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Modal --}}
                                <div class="modal fade" id="detailModal-{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div>
                                                    <h5 class="modal-title mb-1">Chi tiết tin #{{ $p->id }}</h5>
                                                    <div class="text-muted small">{{ $p->title }}</div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-light">
                                                            <div class="fw-semibold mb-1">Mô tả</div>
                                                            <div class="text-muted" style="white-space: pre-line;">
                                                                {{ $p->description }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="p-3 border rounded-3">
                                                            <div class="fw-semibold mb-2">Thông tin bất động sản</div>
                                                            <div class="small text-muted">Địa chỉ: <span class="text-dark">{{ $p->address }}</span></div>
                                                            <div class="small text-muted">Giá: <span class="text-dark">{{ number_format((float)$p->price, 0, ',', '.') }} VNĐ</span></div>
                                                            <div class="small text-muted">Diện tích: <span class="text-dark">{{ $p->area }} m²</span></div>
                                                            <div class="small text-muted">Phòng ngủ: <span class="text-dark">{{ $p->bedrooms }}</span></div>
                                                            <div class="small text-muted">Phòng tắm: <span class="text-dark">{{ $p->bathrooms }}</span></div>
                                                            <div class="small text-muted">Nội thất: <span class="text-dark">{{ $p->is_furnished ? 'Có' : 'Không' }}</span></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="p-3 border rounded-3">
                                                            <div class="fw-semibold mb-2">Chủ tin</div>
                                                            <div class="small text-muted">Tên: <span class="text-dark">{{ $p->user->name ?? '---' }}</span></div>
                                                            <div class="small text-muted">Email: <span class="text-dark">{{ $p->user->email ?? '---' }}</span></div>
                                                            <div class="small text-muted">SĐT: <span class="text-dark">{{ $p->user->phone_number ?? '---' }}</span></div>
                                                            <div class="small text-muted">Role: <span class="text-dark">{{ $p->user->role ?? 'user' }}</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <form method="POST" action="{{ route('admin.posts.approve.approve', $p->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-success">
                                                        <i class="bi bi-check2"></i> Duyệt tin
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End modal --}}

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="mb-2"><i class="bi bi-inboxes fs-1"></i></div>
                                Không có tin nào đang chờ duyệt.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0">
            {{ $pending->links() }}
        </div>
    </div>

</div>
@endsection