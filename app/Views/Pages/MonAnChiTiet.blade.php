@extends('Content')
@section('title', 'Món ăn chi tiết')
@section('content')
    <div>
        <a href="./mon-an">Quản lý món ăn</a>
        <h4 class="text-center">Món ăn chi tiết</h4>
        <div class="row">
            <p>Mã món ăn: {{$monAn['MaMonAn']}}</p>
            <p>Tên món ăn: {{$monAn['TenMonAn']}}</p>
            <p>Giá: {{$monAn['Gia']}}</p>
            <p>Loại: {{$monAn['TenLoaiMonAn']}}</p>
            <p>Mô tả: {{$monAn['MoTa'] != null ? $monAn['MoTa'] : ''}}</p>

            <p>Người quản lý: {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
        </div>
       
    </div>
@endsection
