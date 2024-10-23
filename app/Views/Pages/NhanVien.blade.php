@php
    if(!isset($_SESSION['user_id'])){
        header('Location: ./dang-nhap');
    }
    if($_SESSION['role'] != 'LNV0000001'){
        header('Location: ./');
    }
@endphp
@extends('Main')
@section('title', 'Quản lý nhân viên')
@section('content')
    <div class="mt-3">
        <nav class="row pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control"  name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="1" selected>Mã nhân viên</option>
                            <option value="2">Họ và tên</option>
                        </select>

                    </div>

                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themNhanVien">Thêm nhân viên</button>
            </div>
        </nav>
        <div class="mt-3">
            <h4 class="d-inline-block mb-0">Danh sách nhân viên</h4>
            <select name="combobox-danhSachTuTrangThai" id="combobox-danhSachTuTrangThai">
                <option value="0">Tạm ngưng</option>
                <option value="1" selected>Hoạt động</option>
            </select>
            <div class="mt-3 overflow-scroll" style="height: 600px">
                <table class="table table-bordered table-hover" id="table-nhanVien">
                    <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã nhân viên</th>
                        <th>Họ và tên</th>
                        <th>Loại nhân viên</th>
                        <th>Trạng thái hoạt động</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="d-none" id="message-nhanVien">
                    Không có nhân viên
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-themNhanVien" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nhân viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên nhân viên: <span class="text-danger" id="message-errorThemTen"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemTen" name="txt-ThemTen">
                            </div>
                            <div class="row">
                                <label class="form-label">Ngày sinh: <span class="text-danger" id="message-errorThemNgaySinh"></span> </label>
                                <input type="date" class="form-control" id="txt-ThemNgaySinh" name="txt-ThemNgaySinh">
                            </div>
                            <div class="row">
                                <label class="form-label">Số điện thoại: <span class="text-danger" id="message-errorThemSoDienThoai"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemSoDienThoai" name="txt-ThemSoDienThoai" maxlength="10">
                            </div>
                        
                            <div class="row">
                                <label class="form-label">Mật khẩu: <span class="text-danger" id="message-errorThemMatKhau"></span> </label>
                                <input type="password" class="form-control" id="txt-ThemMatKhau" name="txt-ThemMatKhau">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="btn-them">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="message-xoa" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="btn-xacNhanXoa">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-capNhat" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật nhân viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid overflow-auto" style="height: 500px;">
                            <div class="row">
                                <label class="form-label">Tên nhân viên: <span class="text-danger" id="message-errorCapNhatTen"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatTen" name="txt-CapNhatTen" disabled>
                            </div>
                            <div class="row">
                                <label class="form-label">Ngày sinh: <span class="text-danger" id="message-errorCapNhatNgaySinh"></span> </label>
                                <input type="date" class="form-control" id="txt-CapNhatNgaySinh" name="txt-CapNhatNgaySinh">
                            </div>
                            <div class="row">
                                <label class="form-label">Số điện thoại: <span class="text-danger" id="message-errorCapNhatSoDienThoai"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatSoDienThoai" name="txt-CapNhatSoDienThoai" maxlength="10">
                            </div>
                            <div class="row">
                                <label class="form-label">Email: <span class="text-danger" id="message-errorCapNhatEmail"></span> </label>
                                <input type="email" class="form-control" id="txt-CapNhatEmail" name="txt-CapNhatEmail">
                            </div>
                            <div class="row">
                                <label class="form-label">Địa chỉ: </label>
                                <textarea class="form-control" id="txt-CapNhatDiaChi" name="txt-CapNhatDiaChi"></textarea>
                            </div>
                            <div class="row">
                                <label class="form-label">Ghi chú: </label>
                                <textarea class="form-control" id="txt-CapNhatGhiChu" name="txt-CapNhatGhiChu"></textarea>
                            </div>
                            <div class="row">
                                <label class="form-label">Trạng thái</label>
                                <select id="combobox-CapNhatTrangThai" class="form-control">
                                    <option value="0">Tạm ngưng</option>
                                    <option value="1" selected>Hoạt động</option>
                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Mật khẩu: <span class="text-danger" id="message-errorCapNhatMatKhau"></span> </label>
                                <input type="password" class="form-control" id="txt-CapNhatMatKhau" name="txt-CapNhatMatKhau">
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
    <script src="./public/assets/js/nhanvien.js"></script>
@endsection