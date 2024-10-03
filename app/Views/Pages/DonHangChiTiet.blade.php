@extends('Content')
@section('title', 'Đơn hàng chi tiết')
@section('content')
    <div>
        <a href="./don-hang">Quản lý đơn hàng</a>
        <h4 class="text-center">Đơn hàng chi tiết</h4>
        <div class="row">
            <p>Mã đơn hàng: {{$donHang['MaDonHang']}}</p>
            <p>Khách hàng:
                @if($khachHang != null)
                    <a href="./khach-hang-chi-tiet-{{$khachHang['MaKhachHang']}}">{{$khachHang['TenKhachHang']}}</a>
                @endif
            </p>
            <p>Khuyến mãi: {{$khuyenMai != null ? $khuyenMai['ChuDe'] : ''}}</p>
            <p>Tích điểm sử dụng: {{$donHang['TichDiemSuDung']}}</p>
            <p>Người quản lý: {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
        </div>
        <div>
            <h5>Danh sách món ăn</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>STT</td>
                        <td>Món ăn</td>
                        <td>Số lượng</td>
                    </tr>
                </thead>
                <tbody>
                    @php $stt = 1; @endphp
                    @foreach($monAns as $monAn)
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$monAn['TenMonAn']}}</td>
                            <td>{{$monAn['SoLuong']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection