@php
    if(!isset($_SESSION['user_id'])){
        header('Location: ./dang-nhap');
    }
@endphp
@extends('MainNoNav')
@section('title', 'Đơn hàng chi tiết')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Đơn hàng chi tiết</h4>
                <a href="./don-hang" class="btn btn-outline-dark">Quản lý đơn hàng</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><strong>Mã đơn hàng:</strong> {{$donHang['MaDonHang']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Khách hàng:</strong>
                        @if($khachHang != null)
                            <a href="./khach-hang-chi-tiet-{{$khachHang['MaKhachHang']}}" class="text-decoration-none text-primary fw-bold">{{$khachHang['TenKhachHang']}}</a>
                        @else
                            <span>Không có</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Khuyến mãi:</strong> {{$khuyenMai != null ? $khuyenMai['ChuDe'] : 'Không có'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Tích điểm sử dụng:</strong> {{$donHang['TichDiemSuDung']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Tổng tiền:</strong> {{$donHang['TongTien']}} VND</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Người quản lý:</strong> {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
                </div>
            </div>

            <div class="table-responsive">
                <h5 class="mb-3">Danh sách món ăn</h5>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Món ăn</th>
                        <th>Số lượng</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $stt = 1; @endphp
                    @foreach($doAnUongs as $doAnUong)
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$doAnUong['Ten']}}</td>
                            <td>{{$doAnUong['SoLuong']}}</td>
                            <td>{{$doAnUong['GhiChu']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection