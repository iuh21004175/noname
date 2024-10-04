@extends('Main')
@section('title', 'Thực đơn')
@section('content')
    <div class="">
        <nav class="d-flex pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control"  name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="0" selected>Tên</option>
                        </select>

                    </div>
                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themDoAn">Thêm đồ ăn</button>
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themDoUong">Thêm đồ uống</button>
            </div>
        </nav>
        <div class="mt-3">
            <h4 class="d-inline-block mb-0">Danh sách đồ ăn và đồ uống</h4>
            <select name="combobox-danhSachTuTrangThai" id="combobox-danhSachTuTrangThai">
                <option value="0">Tạm ngưng</option>
                <option value="1" selected>Đang bán</option>
            </select>
            <div class="mt-3 overflow-scroll" style="height: 500px">
                <table class="table table-bordered table-hover" id="table-doAnUong">
                    <thead class="table-light sticky-top">
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Loại</th>
                        <th>Đơn vị</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="d-none" id="message-doAnUong">
                    Không có
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="form-themDoAn" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm đồ ăn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên đồ ăn: <span class="text-danger" id="message-errorThemTenDoAn"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemTenDoAn" name="txt-ThemTenDoAn">
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorThemGiaDoAn"></span></label>
                                <input type="text" class="form-control" id="txt-ThemGiaDoAn" name="txt-ThemGiaDoAn">
                            </div>
                            <div class="row">
                                <label class="form-label">Đơn vi: </label>
                                <select id="combobox-ThemDonViDoAn" class="form-control ">
                                    <option value="đĩa">đĩa</option>
                                    <option value="bát">bát</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="btn-themDoAn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-themDoUong" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm đồ uống</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên đồ uống: <span class="text-danger" id="message-errorThemTenDoUong"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemTenDoUong" name="txt-ThemTenDoUong">
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorThemGiaDoUong"></span></label>
                                <input type="text" class="form-control" id="txt-ThemGiaDoUong" name="txt-ThemGiaDoUong">
                            </div>
                            <div class="row">
                                <label class="form-label">Đơn vi: </label>
                                <select id="combobox-ThemDonViDoUong" class="form-control ">
                                    <option value="lon">lon</option>
                                    <option value="chai">chai</option>
                                    <option value="ly">ly</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="btn-themDoUong">Thêm</button>
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
    <div class="modal fade" id="form-capNhatDoAn" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật đồ ăn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên đồ ăn: <span class="text-danger" id="message-errorCapNhatTenDoAn"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatTenDoAn" name="txt-CapNhatTenDoAn" disabled>
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorCapNhatGiaDoAn"></span></label>
                                <input type="text" class="form-control" id="txt-CapNhatGiaDoAn" name="txt-CapNhatGiaDoAn">
                            </div>
                            <div class="row">
                                <label class="form-label">Đơn vi: </label>
                                <select id="combobox-CapNhatDonViDoAn" class="form-control ">
                                    <option value="đĩa">đĩa</option>
                                    <option value="bát">bát</option>

                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Mô tả: </label>
                                <textarea class="form-control" name="txt-CapNhatMoTaDoAn" id="txt-CapNhatMoTaDoAn"></textarea>
                            </div>
                            <div class="row">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-control" name="combobox-CapNhatTrangThaiDoAn" id="combobox-CapNhatTrangThaiDoAn">
                                    <option value="0">Tạm ngưng</option>
                                    <option value="1">Đang bán</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="btn-CapNhatDoAn">Cập nhât</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-capNhatDoUong" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật đồ uống</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên đồ uống: <span class="text-danger" id="message-errorCapNhatTenDoUong"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatTenDoUong" name="txt-CapNhatTenDoUong" disabled>
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorCapNhatGiaDoUong"></span></label>
                                <input type="text" class="form-control" id="txt-CapNhatGiaDoUong" name="txt-CapNhatGiaDoUong">
                            </div>
                            <div class="row">
                                <label class="form-label">Đơn vi: </label>
                                <select id="combobox-CapNhatDonViDoUong" class="form-control ">
                                    <option value="lon">lon</option>
                                    <option value="chai">chai</option>
                                    <option value="ly">ly</option>
                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Mô tả: </label>
                                <textarea class="form-control" name="txt-CapNhatMoTaDoUong" id="txt-CapNhatMoTaDoUong"></textarea>
                            </div>
                            <div class="row">
                            <label class="form-label">Trạng thái: </label>
                                <select class="form-control" name="combobox-CapNhatTrangThaiDoUong" id="combobox-CapNhatTrangThaiDoUong">
                                    <option value="0">Tạm ngưng</option>
                                    <option value="1">Đang bán</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="btn-CapNhatDoUong">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/thucdon.js"></script>
@endsection