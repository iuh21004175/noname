@extends('Main')
@section('title', 'Quản lý khuyến mãi')
@section('content')
    <div class="mt-3">
        <nav class="row pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control"  name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="1" selected>Mã khuyễn mãi</option>
                            <option value="2">Chủ đề</option>
                        </select>

                    </div>

                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themKhuyenMai">Thêm khuyến mãi</button>
            </div>
        </nav>
        <div class="mt-3">
        <h4 class="d-inline-block mb-0">Danh sách khuyến mãi</h4>
            <select name="combobox-danhSachTuTrangThai" id="combobox-danhSachTuTrangThai">
                <option value="0">Hết hạn</option>
                <option value="1" selected>Chưa tới hạn</option>
            </select>
            <div class="mt-3 overflow-scroll" style="height: 600px">
                <table class="table table-bordered table-hover" id="table-khuyenMai">
                    <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã khuyễn mãi</th>
                        <th>Chủ đề</th>
                        <th>Phần trăm</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="d-none" id="message-khuyenMai">
                    Không có khuyến mãi
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-themKhuyenMai" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm khuyến mãi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Chủ để: <span class="text-danger" id="message-errorThemChuDe"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemChuDe" name="txt-ThemChuDe">
                            </div>
                            <div class="row">
                                <label class="form-label">Phần trăm: </label>
                                <select id="combobox-ThemPhanTram" class="form-control ">
                                    <option value="0.1">10 %</option>
                                    <option value="0.2">20 %</option>
                                    <option value="0.3">30 %</option>
                                    <option value="0.4">40 %</option>
                                    <option value="0.5">50 %</option>
                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Điều kiện khuyến mãi: <span class="text-danger" id="message-errorThemDieuKien"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemDieuKien" name="txt-ThemDieuKien" placeholder="Nhập số lượng món ăn">
                            </div>
                            <div class="row">
                                <label class="form-label">Thời gian bắt đầu: <span class="text-danger" id="message-errorThemBatDau"></span></label>
                                <input type="datetime-local" class="form-control" id="txt-ThemBatDau" name="txt-ThemBatDau">
                            </div>
                            <div class="row">
                                <label class="form-label">Thời gian kết thúc: <span class="text-danger" id="message-errorThemKetThuc"></span></label>
                                <input type="datetime-local" class="form-control" id="txt-ThemKetThuc" name="txt-ThemKetThuc">
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
                        <h5 class="modal-title">Cập nhật khuyến mãi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Chủ để: <span class="text-danger" id="message-errorCapNhatChuDe"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatChuDe" name="txt-CapNhatChuDe" disabled>
                            </div>
                            <div class="row">
                                <label class="form-label">Phần trăm: </label>
                                <select id="combobox-CapNhatPhanTram" class="form-control ">
                                    <option value="0.1">10 %</option>
                                    <option value="0.2">20 %</option>
                                    <option value="0.3">30 %</option>
                                    <option value="0.4">40 %</option>
                                    <option value="0.5">50 %</option>
                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Điều kiện khuyến mãi: <span class="text-danger" id="message-errorCapNhatDieuKien"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatDieuKien" name="txt-CapNhatDieuKien" placeholder="Nhập số lượng món ăn">
                            </div>
                            <div class="row">
                                <label class="form-label">Thời gian bắt đầu: <span class="text-danger" id="message-errorCapNhatBatDau"></span></label>
                                <input type="datetime-local" class="form-control" id="txt-CapNhatBatDau" name="txt-CapNhatBatDau">
                            </div>
                            <div class="row">
                                <label class="form-label">Thời gian kết thúc: <span class="text-danger" id="message-errorCapNhatKetThuc"></span></label>
                                <input type="datetime-local" class="form-control" id="txt-CapNhatKetThuc" name="txt-CapNhatKetThuc">
                            </div>
                            <div class="row">

                                <label class="form-label">Mô tả: </label>
                                <textarea class="form-control" id="txt-CapNhatMoTa" name="txt-CapNhatMoTa"></textarea>

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
    <script src="./public/assets/js/khuyenmai.js"></script>
@endsection