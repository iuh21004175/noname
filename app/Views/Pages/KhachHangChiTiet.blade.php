@extends('Content')
@section('title', 'Khách hàng chi tiết')
@section('content')
    <div>
        <a href="./khach-hang">Quản lý khách hàng</a>
        <h4 class="text-center">Khách hàng chi tiết</h4>
        <div class="row">
            <p>Mã khách hàng: {{$khachHang['MaKhachHang']}}</p>
            <p>Họ và tên: {{$khachHang['TenKhachHang']}}</p>
            <p>Giới tính: {{$khachHang['GioiTinh']}}</p>
            <p>Số điện thoại: {{$khachHang['SoDienThoai']}}</p>
            <p>Tích điểm: {{$khachHang['TichDiem']}}</p>
            <p>Địa chỉ: {{$khachHang['DiaChi'] != null ? $khachHang['DiaChi'] : ''}}</p>
            <p>Người quản lý: {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>

        </div>
        <div>
            <h5>Danh sách đơn hàng</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <td>STT</td>
                    <td>Mã đơn hàng</td>
                    <td>Ngày lập</td>
                    <td>Tổng tiền</td>
                    <td>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @php $stt = 1; @endphp
                @foreach($donHangS as $donHang)
                    <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$donHang['MaDonHang']}}</td>
                        <td>{{$donHang['NgayLap']}}</td>
                        <td>{{$donHang['TongTien']}}</td>
                        <td><a href="./don-hang-chi-tiet-{{$donHang['MaDonHang']}}" class="btn btn-light">Xem</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
