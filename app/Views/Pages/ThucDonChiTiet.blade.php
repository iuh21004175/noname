@extends('MainNoNav')
@section('title', 'Thực đơn chi tiết')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Thực đơn chi tiết</h4>
                <a href="./thuc-don" class="btn btn-outline-dark">Quản lý thực đơn</a>
            </div>

            <div class="row">
                @if($doAnUong != null)
                    <div class="col-md-4 text-center mb-3">
                        <img src="./public/assets/image/{{$doAnUong['HinhAnh']}}" alt="{{$doAnUong['Ten']}}" class="img-fluid rounded shadow" style="max-height: 250px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p><strong>Mã:</strong> {{$doAnUong['MaDoAnUong']}}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Tên:</strong> {{$doAnUong['Ten']}}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Giá:</strong> {{number_format($doAnUong['Gia'], 0, ',', '.')}} <i class="fa-solid fa-dong-sign"></i></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Loại:</strong> {{$doAnUong['Loai']}}</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p><strong>Mô tả:</strong> {{$doAnUong['MoTa'] != null ? $doAnUong['MoTa'] : 'Không có mô tả'}}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Trạng thái:</strong> {{$doAnUong['TrangThai'] == 1 ? 'Đang bán' : 'Tạm ngưng'}}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Người quản lý:</strong> {{$nhanVien['TenNhanVien']}} | Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <p class="text-danger">Món ăn không tồn tại</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
