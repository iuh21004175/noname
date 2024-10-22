@php
    if(!isset($_SESSION['user_id'])){
        header('Location: ./dang-nhap');
    }
@endphp
@extends('MainNoNav')
@section('title', 'Trang chủ')
@section('link')
    <link rel="stylesheet" href="./public/assets/css/trangchu.css">
@section('content')
    <div class="row">
        <div class="wrapper d-flex justify-content-center align-items-center">
            <div class="overlay text-center">
                <h1 class="mb-4">Hệ Thống Quản Lý Quán Cơm Chí Phèo</h1>
                <h5 class="mb-4">Chào mừng {{$_SESSION['username']}} đến với hệ thống quản lý thông tin của quán cơm. Hãy lựa chọn các chức năng dưới đây:</h5>
                <a href="./don-hang" class="btn btn-custom text-white">Quản Lý Đơn Hàng</a>
                <a href="./khach-hang" class="btn btn-custom text-white ms-3">Quản Lý Khách Hàng</a>
                <a href="./khuyen-mai" class="btn btn-custom text-white ms-3">Quản Lý Khuyến Mãi</a>
                <a href="./thuc-don" class="btn btn-custom text-white ms-3">Quản Lý Thực Đơn</a>
                @if($_SESSION['role'] == 'LNV0000001')
                    <a href="./nhan-vien" class="btn btn-custom text-white ms-3">Quản Lý Nhân Viên</a>
                @endif
                <br>
                <a href="./thong-tin-ca-nhan" class="btn btn-custom text-white">Thông tin cá nhân</a>
                <a href="#" id="btn-dangXuat" class="btn btn-custom text-white ms-3">Đăng xuất</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/dangxuat.js"></script>
    <script src="./public/assets/js/trangchu.js"></script>

@endsection