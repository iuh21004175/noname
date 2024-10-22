@php
    if(!isset($_SESSION['user_id'])){
        header('Location: ./dang-nhap');
    }
@endphp
@extends('MainNoNav')
@section('title', 'Khuyến mãi chi tiết')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Khuyến mãi chi tiết</h4>
                <a href="./khuyen-mai" class="btn btn-outline-dark">Quản lý khuyến mãi</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><strong>Mã khuyến mãi:</strong> {{$khuyenMai['MaKhuyenMai']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Chủ đề:</strong> {{$khuyenMai['ChuDe']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Mô tả:</strong> {{$khuyenMai['MoTa'] != null ? $khuyenMai['MoTa'] : 'Không có'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Phần trăm khuyến mãi:</strong> {{$khuyenMai['PhanTram']}}%</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Điều kiện khuyến mãi:</strong> Mua {{$khuyenMai['DieuKien']}} món ăn</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Thời gian bắt đầu:</strong> {{$khuyenMai['BatDau']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Thời gian kết thúc:</strong> {{$khuyenMai['KetThuc']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Người quản lý:</strong> {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
                </div>
            </div>

            <div class="table-responsive">
                <h5 class="mb-3">Danh sách đơn hàng</h5>
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày lập</th>
                        <th>Tổng tiền</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $stt = 1; @endphp
                    @foreach($donHangS as $donHang)
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$donHang['MaDonHang']}}</td>
                            <td>{{$donHang['NgayLap']}}</td>
                            <td>{{$donHang['TongTien']}} VND</td>
                            <td><a href="./don-hang-chi-tiet-{{$donHang['MaDonHang']}}" class="btn btn-info btn-sm">Xem</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
