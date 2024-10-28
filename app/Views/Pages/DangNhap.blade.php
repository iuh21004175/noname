@extends('MainNoNav')
@section('title', 'Đăng nhập')
@section('link')
    <link rel="stylesheet" href="./public/assets/css/dangnhap.css">
@endsection
@section('content')
    <div id="spinner" class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="wrapper d-flex justify-content-center align-items-center" id="login-form">
        <div class="overlay text-center">
            <h2 class="text-white">Đăng Nhập</h2>
            <form id="form-dn">
                <div class="mb-3 text-start">
                    <label for="username" class="form-label text-white">Tên Đăng Nhập <span class="user-error text-danger"></span></label>
                    <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập">
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label text-white">Mật Khẩu <span class="password-error text-danger"></span></label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="d-grid">
                    <input type="submit" class="btn btn-secondary" value="Đăng Nhập">
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="./public/assets/js/popper.min.js"></script>
<script src="./public/assets/js/bootstrap.min.js"></script>
@section('script')
    <script src="./public/assets/js/dangnhap.js"></script>
@endsection
