@extends('MainNoNav')
@section('title', 'Thông tin cá nhân')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg p-4 border-0 rounded-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0">Thông tin cá nhân</h4>
                <a href="./" class="btn btn-outline-dark">Trang chủ</a>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><strong>Mã nhân viên:</strong> {{$nhanVien['MaNhanVien']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Họ và tên:</strong> {{$nhanVien['TenNhanVien']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Ngày sinh:</strong> {{$nhanVien['NgaySinh']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Địa chỉ:</strong> {{$nhanVien['DiaChi'] != null ? $nhanVien['DiaChi'] : 'Chưa có thông tin'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Số điện thoại:</strong> {{$nhanVien['SoDienThoai']}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Email:</strong> {{$nhanVien['Email'] != null ? $nhanVien['Email'] : 'Chưa có thông tin'}}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Ghi chú:</strong> {{$nhanVien['GhiChu'] != null ? $nhanVien['GhiChu'] : 'Chưa có thông tin'}}</p>
                </div>
            </div>

            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#form-capNhat">Cập nhật</button>
        </div>
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
                                <input type="text" class="form-control" id="txt-CapNhatSoDienThoai" name="txt-CapNhatSoDienThoai" maxlength="10" value="{{$nhanVien['SoDienThoai']}}" disabled>
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