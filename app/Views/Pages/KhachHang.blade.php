@extends('Main')
@section('title', 'Khách hàng')
@section('content')
    <div class="">
        <nav class="row pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control"  name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="1" selected>Họ và tên</option>
                            <option value="2">Số điện thoại</option>
                        </select>

                    </div>

                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themKhachHang">Thêm khách hàng</button>
            </div>
        </nav>
        <div class="mt-3">
            <h4 class="d-inline-block mb-0">Danh sách khách hàng</h4>
            <select name="combobox-danhSachTuTrangThai" id="combobox-danhSachTuTrangThai">
                <option value="0">Ít hoạt động</option>
                <option value="1" selected>Hoạt động thường xuyên</option>
            </select>
            <div class="mt-3 overflow-scroll" style="height: 500px">
                <table class="table table-bordered table-hover" id="table-khachHang">
                    <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Số điện thoại</th>
                        <th>Tích điểm</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="d-none" id="message-khachHang">
                    Không có khách hàng
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="form-themKhachHang" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Họ và tên: <span class="text-danger" id="message-errorTen"></span> </label>
                                <input type="text" class="form-control" id="txt-hoVaTen" name="txt-hoVaTen">
                            </div>
                            <div class="row">
                                <label class="form-label">Số điện thoại: <span class="text-danger" id="message-errorSoDienThoai"></span></label>
                                <input type="text" class="form-control" id="txt-soDienThoai" name="txt-soDienThoai" maxlength="10">
                            </div>
                            <div class="row">
                                <label class="form-label">Giới tính: </label>
                                <div class="form-check">
                                    <input class="form-check-input radio-gioiTinh" type="radio" name="radio-gioiTinh" id="radio-nam" value="Nam" checked>
                                    <label class="form-check-label" for="radio-nam">
                                        Nam
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-gioiTinh" type="radio" name="radio-gioiTinh" id="radio-nu" value="Nữ">
                                    <label class="form-check-label" for="radio-nu">
                                        Nữ
                                    </label>
                                </div>
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
                        <h5 class="modal-title">Cập nhật khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Họ và tên: <span class="text-danger" id="message-errorTenU"></span> </label>
                                <input type="text" class="form-control" id="txt-hoVaTenU" name="txt-hoVaTenU" disabled>
                            </div>
                            <div class="row">
                                <label class="form-label">Số điện thoại: <span class="text-danger" id="message-errorSoDienThoaiU"></span></label>
                                <input type="text" class="form-control" id="txt-soDienThoaiU" name="txt-soDienThoaiU" maxlength="10">
                            </div>
                            <div class="row">
                                <label class="form-label">Giới tính: </label>
                                <div class="form-check">
                                    <input class="form-check-input radio-gioiTinhU" type="radio" name="radio-gioiTinhU" id="radio-namU" value="Nam">
                                    <label class="form-check-label" for="radio-namU">
                                        Nam
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input radio-gioiTinhU" type="radio" name="radio-gioiTinhU" id="radio-nuU" value="Nữ">
                                    <label class="form-check-label" for="radio-nuU">
                                        Nữ
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <label class="form-label">Địa chỉ: </label>
                                <textarea type="text" class="form-control" id="txt-diaChiU" name="txt-diaChiU"></textarea>
                            </div>
                            <div class="row">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-control" name="combobox-CapNhatTrangThai" id="combobox-CapNhatTrangThai">
                                    <option value="0">Ít hoạt động</option>
                                    <option value="1">Hoạt động thường xuyên</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="btn-xacNhanCapNhat">Cập nhât</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/khachhang.js"></script>
@endsection