@extends('Main')
@section('title', 'Quản lý đơn hàng')
@section('content')
    <div class="">
        <nav class="row pe-0">
            <div class="col-10">
                <form id="form-timKiem">
                    <div class="input-group" style="width: 500px">
                        <input type="text" class="form-control" name="txt-timKiem" id="txt-timKiem" placeholder="Tìm kiếm">
                        <select id="combobox-timKiem" style="border-color: #ced4da">
                            <option value="1" selected>Mã đơn hàng</option>
                            <option value="2">Số điện thoại</option>
                        </select>

                    </div>

                </form>
            </div>
            <div class="col-2">
                <a href="./tao-don-hang" class="btn btn-outline-success w-auto">Tạo đơn hàng</a>
            </div>
        </nav>
        <div class="mt-3">
            <h4 class="d-inline-block mb-0">Danh sách đơn hàng</h4>
            từ <input type="date" id="txt-MocNgayBatDau"> đến <input type="date" id="txt-MocNgayKetThuc">
            <div class="mt-3 overflow-scroll" style="height: 500px">
                <table class="table table-striped table-hover table-bordered" id="table-donHang">
                    <thead class="table-light sticky-top">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Ngày lập</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Thêm các hàng dữ liệu ở đây -->
                    </tbody>
                </table>
                <div class="d-none" id="message-donHang">
                    Không có đơn hàng
                </div>
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
@endsection
@section('script')
    <script src="./public/assets/js/donhang.js"></script>
@endsection