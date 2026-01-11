@extends('layouts.admin')

@section('title', 'Tạo tin bán')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Tạo tin bán</h4>
            <div class="text-muted">Nhập thông tin để tạo tin bán mới</div>
        </div>

        <a href="{{ route('admin.posts.approve') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại duyệt tin
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Có lỗi dữ liệu:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.sale_posts.store') }}">
        @csrf

        <div class="row g-3">
            {{-- Left --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <div class="fw-semibold">Thông tin chính</div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title"
                                   class="form-control"
                                   maxlength="200"
                                   value="{{ old('title') }}"
                                   placeholder="VD: Bán nhà 2 tầng gần trung tâm...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <textarea name="description" rows="6"
                                      class="form-control"
                                      placeholder="Mô tả chi tiết...">{{ old('description') }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" step="0.01" min="0"
                                       class="form-control"
                                       value="{{ old('price') }}"
                                       placeholder="VD: 2500000000">
                                <div class="form-text">Schema: decimal(12,2)</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Diện tích (m²) <span class="text-danger">*</span></label>
                                <input type="number" name="area" step="0.01" min="0"
                                       class="form-control"
                                       value="{{ old('area') }}"
                                       placeholder="VD: 75">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" name="address"
                                       class="form-control"
                                       value="{{ old('address') }}"
                                       placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành...">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Phòng ngủ <span class="text-danger">*</span></label>
                                <input type="number" name="bedrooms" min="0"
                                       class="form-control"
                                       value="{{ old('bedrooms', 0) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Phòng tắm <span class="text-danger">*</span></label>
                                <input type="number" name="bathrooms" min="0"
                                       class="form-control"
                                       value="{{ old('bathrooms', 0) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right --}}
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white border-0">
                        <div class="fw-semibold">Chủ tin</div>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Chọn user <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select">
                            <option value="">-- Chọn --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Tin sẽ thuộc user này (sale_posts.user_id)</div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white border-0">
                        <div class="fw-semibold">Trạng thái</div>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Nội thất</label>
                        <select name="is_furnished" class="form-select">
                            <option value="0" {{ old('is_furnished') === "0" ? 'selected' : '' }}>Không</option>
                            <option value="1" {{ old('is_furnished') === "1" ? 'selected' : '' }}>Có</option>
                        </select>

                        <div class="mt-3">
                            <label class="form-label">Duyệt tin</label>
                            <select name="status" class="form-select">
                                <option value="0" {{ old('status', "0") === "0" ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="1" {{ old('status') === "1" ? 'selected' : '' }}>Duyệt & hiển thị</option>
                            </select>
                            <div class="form-text">status boolean: 0 chờ duyệt, 1 đã duyệt</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-check2-circle"></i> Tạo tin
                        </button>

                        <a href="{{ route('admin.posts.approve') }}" class="btn btn-outline-secondary">
                            Huỷ
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
