@extends('Content')
@section('title', 'Thông tin cá nhân')
@section('content')
    <div>
        <a href="./">Trang chủ</a>
        <h4 class="text-center">Thông tin cá nhân</h4>
        <div class="row">
            <p>Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
            <p>Họ và tên: {{$nhanVien['TenNhanVien']}}</p>
            <p>Ngày sinh: {{$nhanVien['NgaySinh']}}</p>
            <p>Địa chỉ: {{$nhanVien['DiaChi'] != null ? $nhanVien['DiaChi']:''}}</p>
            <p>Số điện thoại: {{$nhanVien['SoDienThoai']}}</p>
            <p>Email: {{$nhanVien['Email'] != null ? $nhanVien['Email']:''}}</p>
            <p>Ghi chú: {{$nhanVien['GhiChu'] != null ? $nhanVien['GhiChu']:''}}</p>
        </div>
        <button class="btn btn-outline-primary btn-capNhat" data-bs-toggle="modal" data-bs-target="#form-capNhat">Cập nhật</button>
    </div>
    <div class="modal fade" id="form-capNhat" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật thông tin cá nhân</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid overflow-auto" style="height: 500px;">
                            <div class="row">
                                <p>Mã nhân viên: {{$nhanVien['MaNhanVien']}}</p>
                                <p>Họ và tên: {{$nhanVien['TenNhanVien']}}</p>
                            </div>
                            <div class="row">
                                <label class="form-label">Ngày sinh: <span class="text-danger" id="message-errorCapNhatNgaySinh"></span> </label>
                                <input type="date" class="form-control" id="txt-CapNhatNgaySinh" name="txt-CapNhatNgaySinh" value="{{$nhanVien['NgaySinh']}}">
                            </div>
                            <div class="row">
                                <label class="form-label">Số điện thoại: <span class="text-danger" id="message-errorCapNhatSoDienThoai"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatSoDienThoai" name="txt-CapNhatSoDienThoai" maxlength="10" value="{{$nhanVien['SoDienThoai']}}" {{$_SESSION['role'] != "Quản lý" ? 'disable' : ''}}>
                            </div>
                            <div class="row">
                                <label class="form-label">Email: <span class="text-danger" id="message-errorCapNhatEmail"></span> </label>
                                <input type="email" class="form-control" id="txt-CapNhatEmail" name="txt-CapNhatEmail" value="{{$nhanVien['Email']}}">
                            </div>
                            <div class="row">
                                <label class="form-label">Địa chỉ: </label>
                                <textarea class="form-control" id="txt-CapNhatDiaChi" name="txt-CapNhatDiaChi">{{$nhanVien['DiaChi']}}</textarea>
                            </div>
                            <div class="row">
                                <label class="form-label">Ghi chú: </label>
                                <textarea class="form-control" id="txt-CapNhatGhiChu" name="txt-CapNhatGhiChu">{{$nhanVien['GhiChu']}}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="btn-CapNhat">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/thongtincanhan.js"></script>
@endsection