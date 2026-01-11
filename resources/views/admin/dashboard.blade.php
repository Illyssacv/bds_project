@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Tổng quan nhanh')

@section('content')
<div class="row g-3 mb-3">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted small">Người dùng</div>
                <div class="fs-4 fw-bold">1,240</div>
                <div class="small text-success">+12% tuần này</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people"></i></div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted small">Tin đăng</div>
                <div class="fs-4 fw-bold">5,802</div>
                <div class="small text-success">+3% hôm nay</div>
            </div>
            <div class="stat-icon"><i class="bi bi-building"></i></div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted small">Báo cáo</div>
                <div class="fs-4 fw-bold">18</div>
                <div class="small text-danger">+4 mới</div>
            </div>
            <div class="stat-icon"><i class="bi bi-flag"></i></div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted small">Doanh thu</div>
                <div class="fs-4 fw-bold">32.5M</div>
                <div class="small text-muted">tháng này</div>
            </div>
            <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
        </div>
    </div>
</div>

<div class="page-card p-3 p-lg-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="fw-bold">Hoạt động gần đây</div>
        <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-repeat me-1"></i>Làm mới</button>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Hành động</th>
                <th>Người thực hiện</th>
                <th>Thời gian</th>
                <th class="text-end">Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Duyệt tin đăng #1024</td>
                <td>Admin</td>
                <td class="text-muted">5 phút trước</td>
                <td class="text-end"><span class="badge bg-success">Thành công</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Khoá user #88</td>
                <td>Admin</td>
                <td class="text-muted">25 phút trước</td>
                <td class="text-end"><span class="badge bg-warning text-dark">Cảnh báo</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Xoá tin vi phạm #991</td>
                <td>Admin</td>
                <td class="text-muted">1 giờ trước</td>
                <td class="text-end"><span class="badge bg-danger">Xoá</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
