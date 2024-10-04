<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DonHang;
use App\Models\KhuyenMai;
use App\Models\NhanVien;

use Illuminate\Support\Facades\DB;

class CtrlKhuyenMai extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->capsule->getConnection()->statement('CALL CapNhatTrangThaiKhuyenMaiHetHan()');
    }
    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.KhuyenMai');
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function layDanhSachKhuyenMaiTheoTrangThai($trangThai){
        return KhuyenMai::where('TrangThai', $trangThai)->orderBy('MaKhuyenMai', 'desc')->get();
    }
    public function pageKhuyenMaiChiTiet($maKhuyenMai)
    {
        $donHangS = DonHang::where('MaKhuyenMai', $maKhuyenMai)->get();
        $khuyenMai= KhuyenMai::where('MaKhuyenMai', $maKhuyenMai)->first();
        $nhanVien = NhanVien::where('MaNhanVien', $khuyenMai['MaNhanVien'])->first();
        return $this->view('Pages.KhuyenMaiChiTiet', ['donHangS'=>$donHangS, 'khuyenMai'=>$khuyenMai, 'nhanVien'=>$nhanVien]);
    }
    public function themKhuyenMai($khuyenMai)
    {   
        $lastOrder = KhuyenMai::orderBy('MaKhuyenMai', 'desc')->first();

        // Nếu không có đơn hàng nào, bắt đầu với DH00000001
        if (!$lastOrder) {
            $newMaKhuyenMai = 'KM00000001';
            $khuyenMai['MaKhuyenMai'] = $newMaKhuyenMai;
        } else {
            // Lấy mã đơn hàng cuối cùng và tăng thêm 1
            $lastMaKhuyenMai = $lastOrder->MaKhuyenMai;
            $numericPart = intval(substr($lastMaKhuyenMai, 2)); // Lấy phần số của mã
            $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Tăng thêm 1 và bổ sung số 0 vào đầu
            $newMaKhuyenMai = 'KM' . $newNumericPart; // Ghép lại thành mã mới
            $khuyenMai['MaKhuyenMai'] = $newMaKhuyenMai;
        }
        
        
        $result = KhuyenMai::insert([
            'MaKhuyenMai' => $khuyenMai['MaKhuyenMai'],
            'ChuDe' => $khuyenMai['ChuDe'],
            'PhanTram' => $khuyenMai['PhanTram'],
            'DieuKien' => $khuyenMai['DieuKien'],
            'BatDau' => $khuyenMai['BatDau'],
            'KetThuc' => $khuyenMai['KetThuc'],
            'MaNhanVien' => $_SESSION['user_id'],
        ]);
        if($result){
            return array('status'=>'success');
        }
        else{
            return array('status'=>'fail');
        }
    }
    public function xoaKhuyenMai($maKhuyenMai){
        $khuyenMai = KhuyenMai::where('MaKhuyenMai', $maKhuyenMai)->first();
        $kiemTraKhuyenMai = DonHang::where('MaKhuyenMai', $maKhuyenMai)->first();
        if($kiemTraKhuyenMai == null){
            if($khuyenMai->delete()){
                return array('status'=>'success');
            }
            else{
                return array('status'=>'fail', 'message' => 'Xóa khuyến mãi không thành công');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Khuyến mãi đã thêm vào đơn hàng không thể xóa');
        }

    }
    public function capNhatKhuyenMai($khuyenMai)
    {
        $ngayBatDau = new \DateTime($khuyenMai['BatDau']);
        $ngayHienTai = new \DateTime();
        if($ngayHienTai < $ngayBatDau){
            $result = KhuyenMai::where('MaKhuyenMai', $khuyenMai['MaKhuyenMai'])->update([
                'ChuDe' => $khuyenMai['ChuDe'],
                'PhanTram' => $khuyenMai['PhanTram'],
                'BatDau' => $khuyenMai['BatDau'],
                'KetThuc' => $khuyenMai['KetThuc'],
                'MoTa' => $khuyenMai['MoTa']
            ]);
            if($result){
                return array('status'=>'success');
            }
            else{
                return array('status'=>'fail', 'message' => 'Cập nhật khuyến mãi không thành công');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Không thể cập nhật khuyến mãi đang trong kì hạn hoặc hết hạn');
        }

    }
}