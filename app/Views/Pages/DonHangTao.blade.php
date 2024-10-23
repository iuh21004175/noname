@php
    if(!isset($_SESSION['user_id'])){
        header('Location: ./dang-nhap');
    }
    if(!isset($_COOKIE['token'])){
        header('Location: ./dang-nhap');
    }
@endphp
@extends('MainNoNav')
@section('title', 'Tạo đơn hàng')
@section('content')
    <div>
        <a href="./don-hang">Quản lý đơn hàng</a>
        <div class="row">

            <div class="col-7" id="form-donHang">
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
                    <div>
                        <h5>Danh sách món đã đặt</h5>
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
                    </div>
                    <div id="khuyenMai-tichDiem" class="d-none">
                        <div class="mb-2" id="khuyenMai">
                            <b>Khuyến mãi (nếu có):  </b><input type="text" class="border-0" disabled id="txt-khuyenMai" name="txt-khuyenMai" style="width: 400px">
                        </div>
                        <div class="mb-2" id="tichDiem">
                            <b>Sử dụng tích điểm (tối thiểu 30): </b><input type="text" class="" id="txt-tichDiem" value="0">
                        </div>
                    </div>
                    <div>
                        <h5 >Tổng tiền: <input type="number" class="tongTienDH border-0" value="0" disabled> <i class="fa-solid fa-dong-sign"></i></h5>
                        <h5 class="d-inline-block">Tính tiền thối: <input type="text" id="txt-soTienKhachHang" placeholder="Nhập số tiền"> Tiền thối <input type="text" id="txt-tienThoi" disabled> <i class="fa-solid fa-dong-sign"></i></h5>
                    </div>
                    <input type="button" disabled id="btn-taoDH" value="Tạo đơn hàng">
                </form>

            </div>
            <div class="col-5">
                <h5>Thực đơn</h5>
                <form action="">
                    <input type="search" name="txtTimMon" id="txt-TimMon" class="form-control my-2" placeholder="Nhập tên món">
                </form>
                <div class="overflow-scroll" style="height: 700px">
                    <table class="table table-hover table-bordered" id="danhSachMA">
                        <thead class="table-light sticky-top">
                        <tr>
                            <td>Hình</td>
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
    <script src="./public/assets/js/donhangtao.js"></script>
@endsection

