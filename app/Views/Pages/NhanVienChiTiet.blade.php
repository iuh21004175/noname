@extends('Content')
@section('title', 'Nhân viên chi tiết')
@section('content')
    <div>
        <a href="./nhan-vien">Quản lý nhân viên</a>
        <h4 class="text-center">Nhân viên chi tiết</h4>
        <div class="row">
            <p>Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
            <p>Họ và tên: {{$nhanVien['TenNhanVien']}}</p>
            <p>Loại nhân viên: {{$nhanVien['TenLoaiNhanVien']}}</p>
            <p>Ngày sinh: {{$nhanVien['NgaySinh']}}</p>
            <p>Địa chỉ: {{$nhanVien['DiaChi'] != null ? $nhanVien['DiaChi']:''}}</p>
            <p>Số điện thoại: {{$nhanVien['SoDienThoai']}}</p>
            <p>Email: {{$nhanVien['Email'] != null ? $nhanVien['Email']:''}}</p>
            <p>Ghi chú: {{$nhanVien['GhiChu'] != null ? $nhanVien['GhiChu']:''}}</p>
        </div>

    </div>
@endsection

