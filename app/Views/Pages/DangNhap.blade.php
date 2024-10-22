@extends('MainNoNav')
@section('title', 'Đăng nhập')
@section('link')
    <link rel="stylesheet" href="./public/assets/css/dangnhap.css">
@endsection
@section('content')
    <div class="container">
        <h2 class="text-center">Đăng Nhập</h2>
        <form id="form-dn">
            <div class="mb-3">
                <label for="username" class="form-label">Tên Đăng Nhập <span class="user-error text-danger"></span></label>
                <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật Khẩu <span class="password-error text-danger"></span></label>
                <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
            </div>
            <div class="d-grid">
                <input type="submit" class="btn btn-primary" value="Đăng Nhập">
            </div>
        </form>
    </div>
@endsection
<script src="./public/assets/js/popper.min.js"></script>
<script src="./public/assets/js/bootstrap.min.js"></script>
@section('script')
    <script src="./public/assets/js/dangnhap.js"></script>
@endsection