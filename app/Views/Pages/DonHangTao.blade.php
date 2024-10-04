@extends('Content')
@section('title', 'Tạo đơn hàng')
@section('content')
    <div>
        <a href="./don-hang">Quản lý đơn hàng</a>
        <div class="row">

            <div class="col-8" id="form-donHang">
                <form>
                    <h4 class="text-center">Đơn hàng</h4>
                    <div class="row mb-2">
                        <div class="col-5">
                            <label class="form-label fw-bold" for="txt-soDT">Khách hàng</label>
                            <input type="text" class="form-control" maxlength="10" name="txt-soDT" id="txt-soDT" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="col-7" id="thongTinKH">

                        </div>
                    </div>
                    <div class="overflow-scroll mb-2" style="min-height: 400px">
                        <table class="table table-bordered" id="danhSachMAnDH">
                            <thead class="table-light">
                            <th>STT</th>
                            <th>Tên món ăn</th>
                            <th>Số lượng</th>
                            <th>Đơn vị</th>
                            <th>Giá</th>
                            <th>Ghi chú</th>
                            <th>Bỏ</th>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <div id="khuyenMai-tichDiem" class="d-none">
                        <div class="mb-2" id="khuyenMai">
                            <b>Khuyến mãi (nếu có):  </b><input type="text" class="border-0" disabled id="txt-khuyenMai" name="txt-khuyenMai" style="width: 400px"> <input type="button" id="btn-apKM" value="Áp dụng">
                        </div>
                        <div class="mb-2" id="tichDiem">
                            <b>Sử dụng tích điểm (tối đa 100): </b><input type="text" class="" id="txt-tichDiem" value="0">
                        </div>
                    </div>
                    <div>
                        <h3>Tổng tiền: <input type="number" class="tongTienDH border-0" value="0" disabled></h3>
                    </div>
                    <input type="button" disabled id="btn-taoDH" value="Tạo đơn hàng">
                </form>

            </div>
            <div class="col-4">
                <h5>Danh sách món ăn</h5>
                <div class="overflow-scroll" style="height: 600px">
                    <table class="table table-hover table-bordered" id="danhSachMA">
                        <thead class="table-light sticky-top">
                        <tr>
                            <td>Tên món</td>
                            <td>Giá</td>
                            <td>Thêm</td>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/dathang.js"></script>
@endsection

