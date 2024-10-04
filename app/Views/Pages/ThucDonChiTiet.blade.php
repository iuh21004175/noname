@extends('Content')
@section('title', 'Thực đơn chi tiết')
@section('content')
    <div>
        <a href="./thuc-don">Quản lý thực đơn</a>
        <h4 class="text-center">Thực đơn chi tiết</h4>
        <div class="row">
            @if($doAnUong != null)
                <p>Mã: {{$doAnUong['MaDoAnUong']}}</p>
                <p>Tên: {{$doAnUong['Ten']}}</p>
                <p>Giá: {{$doAnUong['Gia']}}</p>
                <p>Loại: {{$doAnUong['Loai']}}</p>
                <p>Mô tả: {{$doAnUong['MoTa'] != null ? $doAnUong['MoTa'] : ''}}</p>
                <p>Trạng thái: {{$doAnUong['TrangThai'] == 1 ? 'đang bán' : 'tạm ngưng'}}</p>
                <p>Người quản lý: {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
            @else
                <p>Món ăn không tồn tại</p>
            @endif
        </div>
       
    </div>
@endsection
