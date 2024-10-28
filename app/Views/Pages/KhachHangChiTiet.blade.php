@extends('MainNoNav')
@section('title', 'Khách hàng chi tiết')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Khách hàng chi tiết</h4>
                <a href="./khach-hang" class="btn btn-outline-dark">Quản lý khách hàng</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><strong>Mã khách hàng:</strong> {{$khachHang['MaKhachHang']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Họ và tên:</strong> {{$khachHang['TenKhachHang']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Giới tính:</strong> {{$khachHang['GioiTinh']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Số điện thoại:</strong> {{$khachHang['SoDienThoai']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Tích điểm:</strong> {{$khachHang['TichDiem']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Địa chỉ:</strong> {{$khachHang['DiaChi'] != null ? $khachHang['DiaChi'] : 'Chưa cập nhật'}}</p>
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
                            <td>{{number_format($donHang['TongTien'], 0, ',', '.')}} <i class="fa-solid fa-dong-sign"></i></td>
                            <td><a href="./don-hang-chi-tiet-{{$donHang['MaDonHang']}}" class="btn btn-info btn-sm">Xem</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
