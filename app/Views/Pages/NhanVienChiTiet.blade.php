@php
    if($_SESSION['role'] != 'LNV0000001'){
        header('Location: ./');
    }
@endphp
@extends('MainNoNav')
@section('title', 'Nhân viên chi tiết')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Nhân viên chi tiết</h4>
                <a href="./nhan-vien" class="btn btn-outline-dark">Quản lý nhân viên</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><strong>Mã nhân viên:</strong> {{$nhanVien['MaNhanVien']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Họ và tên:</strong> {{$nhanVien['TenNhanVien']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Loại nhân viên:</strong> {{$nhanVien['TenLoaiNhanVien']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Ngày sinh:</strong> {{$nhanVien['NgaySinh']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Địa chỉ:</strong> {{$nhanVien['DiaChi'] != null ? $nhanVien['DiaChi'] : 'Chưa cập nhật'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Số điện thoại:</strong> {{$nhanVien['SoDienThoai']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Email:</strong> {{$nhanVien['Email'] != null ? $nhanVien['Email'] : 'Chưa cập nhật'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Ghi chú:</strong> {{$nhanVien['GhiChu'] != null ? $nhanVien['GhiChu'] : 'Không có ghi chú'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Trạng thái:</strong> {{$nhanVien['TrangThai'] == 1 ? 'Hoạt động' : 'Tạm ngưng'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Trạng thái hoạt động:</strong> {{$nhanVien['TrangThaiHoatDong']}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

