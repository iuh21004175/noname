@extends('MainNoNav')
@section('title', 'Tạo đơn hàng')
@section('link')
    <link rel="stylesheet" href="./public/assets/css/donhangtao.css">
@endsection
@section('content')
    <div>
        <div class="row">
            <div class="col-7" id="form-donHang">
                <form>
                    <h3 class="text-center mt-2 text-uppercase">Đơn hàng</h3>
                    <div class="row mb-2" style="height: 170px">
                        <div class="col-5 border">
                            <div class="">
                                <h5 class="text-uppercase mt-2">Thông tin khách hàng</h5>
                                <input type="text" class="form-control border-0 border-bottom" maxlength="10" name="txt-soDT" id="txt-soDT" placeholder="Nhập số điện thoại" style="border-color: #000000 !important; border-radius: 0;">
                            </div>
                            <div class="" id="thongTinKH">

                            </div>
                        </div>
                        <div class="col-7 border" >
                            <h5 class="text-uppercase mt-2">Khuyến mãi và tích điểm</h5>
                            <div id="khuyenMai-tichDiem" class="d-none">
                                <div class="mb-2">
                                    <b>Khuyến mãi (nếu có): </b><span id="khuyenMai"></span>
                                </div>
                                <div class="mb-2" id="khuyenMai">
                                    <b>Giá trị khuyến mãi: </b><input type="text" class="border-0 text-end fw-bold" style="background-color: transparent" disabled id="txt-tiLeKhuyenMai" name="txt-khuyenMai">
                                </div>
                                <div class="mb-2" id="tichDiem">
                                    <b>Tích điểm (tối thiểu 30): </b><input type="text" class="border-0 border-bottom text-end" style="background-color: transparent; outline: none" id="txt-tichDiem"  value="0">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div>
                        <h5>Danh sách món đã đặt</h5>
                        <div class="overflow-scroll mb-2" style="height: 370px">
                            <table class="table table-hover table-bordered" id="danhSachMAnDH">
                                <thead class="table-light sticky-top">
                                    <th>STT</th>
                                    <th>Tên món ăn</th>
                                    <th>Số lượng</th>
                                    <th>Đơn vị</th>
                                    <th>Giá</th>
                                    <th>Ghi chú</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-end">Tổng tiền: <input type="text" class="tongTienDH border-0 text-end fw-bold" value="0" disabled style="background-color: transparent; "><i class="fa-solid fa-dong-sign"></i></h5>
                        <h5 class="text-end">Tiền thối: <input class="text-end border-0 fw-bold" type="text" id="txt-tienThoi" disabled style="background-color: transparent;"><i class="fa-solid fa-dong-sign"></i></h5>
                        <input type="text" class="form-control border-0 border-bottom" id="txt-soTienKhachHang" placeholder="Nhập số tiền của khách hàng" style="border-color: #000000 !important; border-radius: 0;">
                    </div>
                    <input type="button" class="btn btn-success mt-3" disabled id="btn-taoDH" value="Tạo đơn hàng">
                </form>

            </div>
            <div class="col-5 border p-3" style="border-color: #000000 !important;">
                <div class="text-end">
                    <a href="./don-hang" class="btn btn-outline-dark">Quản lý đơn hàng</a>
                </div>
                <h5 class="text-uppercase">Thực đơn</h5>
                <form action="">
                    <input type="search" name="txtTimMon" id="txt-TimMon" class="form-control my-2" placeholder="Nhập tên món">
                </form>
                <div class="overflow-scroll" style="height: 650px">
                    <table class="table table-hover table-bordered" id="danhSachMA">
                        <thead class="table-light sticky-top">
                        <tr>
                            <th class="text-center">Hình</th>
                            <th class="text-center">Tên món</th>
                            <th class="text-center">Giá</th>

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
    <script src="./public/assets/js/donhangtao.js"></script>
@endsection

