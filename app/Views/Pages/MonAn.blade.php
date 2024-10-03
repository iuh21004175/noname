@extends('Main')
@section('title', 'Món ăn')
@section('content')
    <div class="">
        <nav class="row pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control"  name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="0" selected>Tên món ăn</option>
                        </select>

                    </div>
                </form>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-success w-auto" data-bs-toggle="modal" data-bs-target="#form-themMonAn">Thêm món ăn</button>
            </div>
        </nav>
        <div class="mt-3 overflow-scroll" style="height: 500px">
            <table class="table table-bordered table-hover" id="table-monAn">
                <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên món ăn</th>
                    <th>Giá</th>
                    <th>Loại món ăn</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="d-none" id="message-monAn">
                Không có món ăn
            </div>
        </div>
    </div>
    <div class="modal fade" id="form-themMonAn" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm món ăn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên món ăn: <span class="text-danger" id="message-errorThemTen"></span> </label>
                                <input type="text" class="form-control" id="txt-ThemTen" name="txt-ThemTen">
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorThemGia"></span></label>
                                <input type="text" class="form-control" id="txt-ThemGia" name="txt-ThemGia">
                            </div>
                            <div class="row">
                                <label class="form-label">Loại món ăn: </label>
                                <select id="combobox-ThemLoaiMonAn" class="form-control ">
                                    <option value="1">Đồ ăn</option>
                                    <option value="2">Đồ uống</option>

                                </select>
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
                        <h5 class="modal-title">Cập nhật món ăn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <label class="form-label">Tên món ăn: <span class="text-danger" id="message-errorCapNhatTen"></span> </label>
                                <input type="text" class="form-control" id="txt-CapNhatTen" name="txt-CapNhatTen">
                            </div>
                            <div class="row">
                                <label class="form-label">Giá: <span class="text-danger" id="message-errorCapNhatGia"></span></label>
                                <input type="text" class="form-control" id="txt-CapNhatGia" name="txt-CapNhatGia">
                            </div>
                            <div class="row">
                                <label class="form-label">Loại món ăn: </label>
                                <select id="combobox-CapNhatLoaiMonAn" class="form-control ">
                                    <option value="1">Đồ ăn</option>
                                    <option value="2">Đồ uống</option>

                                </select>
                            </div>
                            <div class="row">
                                <label class="form-label">Mô tả: </label>
                                <textarea id="txt-CapNhatMoTa" name="txt-CapNhatMoTa" class="form-control"></textarea>
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
    <script src="./public/assets/js/monan.js"></script>
@endsection