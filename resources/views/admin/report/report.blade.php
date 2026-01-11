@extends('layouts.admin')

@section('title', 'Báo cáo vi phạm')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Báo cáo vi phạm</h4>
            <div class="text-muted">Quản lý các báo cáo vi phạm từ người dùng</div>
        </div>

        <form method="GET" action="" class="d-flex flex-wrap align-items-end gap-2">
            <div>
                <label class="form-label mb-1 small text-muted">Từ khoá</label>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}"
                       placeholder="Lý do, mô tả, user, tiêu đề tin...">
            </div>

            <div>
                <label class="form-label mb-1 small text-muted">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="{{ request('q') }}" {{ (string)$status==='0' ? 'selected' : '' }}>Mới</option>
                    <option value="{{ request('q') }}" {{ (string)$status==='1' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="{{ request('q') }}" {{ (string)$status==='2' ? 'selected' : '' }}>Đã xử lý</option>
                    <option value="{{ request('q') }}" {{ (string)$status==='3' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>

            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Lọc</button>
            <a class="btn btn-outline-secondary" href="{{ url()->current() }}">Reset</a>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2">
            <i class="bi bi-check-circle"></i><div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Mới</div>
                        <div class="fs-4 fw-bold">{{ $countNew ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light"><i class="bi bi-flag fs-3"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Đang xử lý</div>
                        <div class="fs-4 fw-bold">{{ $countProcessing ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light"><i class="bi bi-hourglass-split fs-3"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Đã xử lý</div>
                        <div class="fs-4 fw-bold">{{ $countDone ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light"><i class="bi bi-patch-check fs-3"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Từ chối</div>
                        <div class="fs-4 fw-bold">{{ $countRejected ?? 0 }}</div>
                    </div>
                    <div class="rounded-3 p-3 bg-light"><i class="bi bi-x-octagon fs-3"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
            <div class="fw-semibold">Danh sách báo cáo</div>
            <div class="text-muted small">Nhấp “Xem” để mở chi tiết</div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Lý do</th>
                            <th>Tin bị báo cáo</th>
                            <th>Người báo cáo</th>
                            <th class="text-center" style="width:140px;">Trạng thái</th>
                            <th class="text-end" style="width:190px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $r)
                            @php
                                $badge = match((int)$r->status) {
                                    0 => 'bg-warning text-dark',
                                    1 => 'bg-info text-dark',
                                    2 => 'bg-success',
                                    3 => 'bg-secondary',
                                    default => 'bg-light text-dark',
                                };
                                $statusText = match((int)$r->status) {
                                    0 => 'Mới',
                                    1 => 'Đang xử lý',
                                    2 => 'Đã xử lý',
                                    3 => 'Từ chối',
                                    default => '---',
                                };
                            @endphp

                            <tr>
                                <td class="fw-semibold">#{{ $r->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $r->reason }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 420px;">
                                        {{ $r->detail }}
                                    </div>
                                    <div class="small text-muted mt-1">
                                        {{ optional($r->created_at)->format('d/m/Y H:i') }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $r->salePost->title ?? '---' }}</div>
                                    <div class="small text-muted">{{ $r->salePost->address ?? '' }}</div>
                                    <div class="small text-muted mt-1">
                                        Chủ tin: <span class="text-dark">{{ $r->salePost->user->name ?? '---' }}</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $r->reporter->name ?? '---' }}</div>
                                    <div class="small text-muted">{{ $r->reporter->email ?? '' }}</div>
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $badge }}">{{ $statusText }}</span>
                                </td>

                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reportModal-{{ $r->id }}">
                                        <i class="bi bi-eye"></i> Xem
                                    </button>

                                    @if((int)$r->status === 0)
                                        <form class="d-inline" method="POST" action="{{ route('admin.report.processing', $r->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-primary">
                                                Nhận xử lý
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Modal --}}
                                    <div class="modal fade" id="reportModal-{{ $r->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title mb-1">Report #{{ $r->id }}</h5>
                                                        <div class="text-muted small">{{ $r->reason }}</div>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <div class="p-3 border rounded-3 bg-light">
                                                                <div class="fw-semibold mb-1">Mô tả vi phạm</div>
                                                                <div class="text-muted" style="white-space: pre-line;">
                                                                    {{ $r->detail ?? '---' }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="p-3 border rounded-3">
                                                                <div class="fw-semibold mb-2">Tin bị báo cáo</div>
                                                                <div class="small text-muted">Tiêu đề:
                                                                    <span class="text-dark">{{ $r->salePost->title ?? '---' }}</span>
                                                                </div>
                                                                <div class="small text-muted">Địa chỉ:
                                                                    <span class="text-dark">{{ $r->salePost->address ?? '---' }}</span>
                                                                </div>
                                                                <div class="small text-muted">Giá:
                                                                    <span class="text-dark">
                                                                        {{ isset($r->salePost->price) ? number_format((float)$r->salePost->price, 0, ',', '.') . ' VNĐ' : '---' }}
                                                                    </span>
                                                                </div>
                                                                <div class="small text-muted">Trạng thái tin:
                                                                    <span class="text-dark">{{ ($r->salePost->status ?? 0) ? 'Đang hiển thị' : 'Đang ẩn/chờ duyệt' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="p-3 border rounded-3">
                                                                <div class="fw-semibold mb-2">Người báo cáo</div>
                                                                <div class="small text-muted">Tên:
                                                                    <span class="text-dark">{{ $r->reporter->name ?? '---' }}</span>
                                                                </div>
                                                                <div class="small text-muted">Email:
                                                                    <span class="text-dark">{{ $r->reporter->email ?? '---' }}</span>
                                                                </div>
                                                                <div class="small text-muted">SĐT:
                                                                    <span class="text-dark">{{ $r->reporter->phone_number ?? '---' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">Ghi chú admin</label>
                                                            <textarea form="resolveForm-{{ $r->id }}" name="admin_note" rows="3"
                                                                      class="form-control"
                                                                      placeholder="Ghi chú xử lý...">{{ old('admin_note', $r->admin_note) }}</textarea>
                                                            <div class="form-text">Ghi chú sẽ lưu vào report.</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>

                                                    <form id="resolveForm-{{ $r->id }}" method="POST" action="{{ route('admin.report.resolve', $r->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-success">
                                                            <i class="bi bi-check2"></i> Đánh dấu đã xử lý
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.report.hide_post', $r->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-danger"
                                                                onclick="return confirm('Ẩn tin này và đánh dấu report đã xử lý?')">
                                                            <i class="bi bi-eye-slash"></i> Ẩn tin
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.report.reject', $r->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="admin_note" value="{{ $r->admin_note }}">
                                                        <button class="btn btn-outline-dark"
                                                                onclick="return confirm('Từ chối report này?')">
                                                            Từ chối report
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
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="mb-2"><i class="bi bi-flag fs-1"></i></div>
                                    Chưa có báo cáo vi phạm.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0">
            {{ $reports->links() }}
        </div>
    </div>

</div>
@endsection
