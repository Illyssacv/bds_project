@extends('layouts.user')

@section('title','Hồ sơ cá nhân')

@section('content')
<h4 class="mb-3">Thông tin cá nhân</h4>

<form class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Họ tên</label>
        <input type="text" class="form-control" value="{{ auth()->user()->name }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
    </div>

    <div class="col-md-6">
        <label class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" placeholder="Chưa cập nhật">
    </div>

    <div class="col-md-6">
        <label class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" placeholder="Chưa cập nhật">
    </div>

    <div class="col-12">
        <label class="form-label">Giới thiệu</label>
        <textarea class="form-control" rows="4" placeholder="Giới thiệu về bạn"></textarea>
    </div>

    <div class="col-12">
        <button class="btn btn-danger">
            <i class="bi bi-save"></i> Cập nhật hồ sơ
        </button>
    </div>
</form>
@endsection
