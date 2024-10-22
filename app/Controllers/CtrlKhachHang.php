<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\NhanVien;

class CtrlKhachHang extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->capsule->getConnection()->statement('CALL CapNhatTrangThaiKhachHang()');
    }
    public function index(){
        return $this->view('Pages.KhachHang');
    }
    public function pageKhachHangChiTiet($maKhachHang)
    {
        $donHangS = DonHang::where('MaKhachHang', $maKhachHang)->get();
        $khachHang = KhachHang::where('MaKhachHang', $maKhachHang)->first();
        $nhanVien = NhanVien::where('MaNhanVien', $khachHang['MaNhanVien'])->first();
        return $this->view('Pages.KhachHangChiTiet', ['donHangS'=>$donHangS, 'khachHang'=>$khachHang, 'nhanVien'=>$nhanVien]);
    }
    public function layDanhSachKhachHangBI()
    {
        return KhachHang::all();
    }
    public function layDanhSachKhachHangTheoTrangThai($trangThai){
        return KhachHang::where('TrangThai', $trangThai)->orderBy('MaKhachHang', 'desc')->get();
    }
    public function themKhachHang($khachHang)
    {   
        $lastOrder = KhachHang::orderBy('MaKhachHang', 'desc')->first();

        // Nếu không có đơn hàng nào, bắt đầu với DH00000001
        if (!$lastOrder) {
            $newMaKhachHang = 'KH00000001';
            $khachHang['MaKhachHang'] = $newMaKhachHang;
        } else {
            // Lấy mã đơn hàng cuối cùng và tăng thêm 1
            $lastMaKhachHang = $lastOrder->MaKhachHang;
            $numericPart = intval(substr($lastMaKhachHang, 2)); // Lấy phần số của mã
            $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Tăng thêm 1 và bổ sung số 0 vào đầu
            $newMaKhachHang = 'KH' . $newNumericPart; // Ghép lại thành mã mới
            $khachHang['MaKhachHang'] = $newMaKhachHang;
        }
        $result = KhachHang::insert([
            'MaKhachHang' => $khachHang['MaKhachHang'],
            'TenKhachHang' => $khachHang['TenKhachHang'],
            'SoDienThoai' => $khachHang['SoDienThoai'],
            'GioiTinh' => $khachHang['GioiTinh'],
            'MaNhanVien' => $_SESSION['user_id']
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function xoaKhachHang($maKhachHang)
    {
        $kiemTraKhachHang = DonHang::where('MaKhachHang', $maKhachHang)->first();
        if($kiemTraKhachHang == null){
            $result = KhachHang::where('MaKhachHang', $maKhachHang)->delete();
            if($result){
                return array('status' => 'success');
            }
            else{
                return array('status' => 'fail', 'message' => 'Xóa khách hàng không thành công');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Khách hàng đã có đơn hàng không thể xóa');
        }

    }
    public function capNhatKhachHang($khachHang)
    {
        $result = KhachHang::where('MaKhachHang', $khachHang['MaKhachHang'])->update([
            'TenKhachHang' => $khachHang['TenKhachHang'],
            'SoDienThoai' => $khachHang['SoDienThoai'],
            'GioiTinh' => $khachHang['GioiTinh'],
            'DiaChi' => $khachHang['DiaChi']
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
}