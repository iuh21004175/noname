@extends('Content')
@section('title', 'Khuyến mãi chi tiết')
@section('content')
    <div>
        <a href="./khuyen-mai">Quản lý khuyến mãi</a>
        <h4 class="text-center">Khuyến mãi chi tiết</h4>
        <div class="row">
            <p>Mã khuyến mãi: {{$khuyenMai['MaKhuyenMai']}}</p>
            <p>Chủ đề: {{$khuyenMai['ChuDe']}}</p>
            <p>Mô tả: {{$khuyenMai['MoTa'] != null ? $khuyenMai['MoTa'] : ''}}</p>
            <p>Phần trăm khuyến mãi: {{$khuyenMai['PhanTram']}}</p>
            <p>Điều kiện khuyến mãi: mua {{$khuyenMai['DieuKien']}} món ăn</p>
            <p>Thời gian bắt đầu: {{$khuyenMai['BatDau']}}</p>
            <p>Thời gian kết thúc: {{$khuyenMai['KetThuc']}}</p>
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
