<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DoAnUong;
use App\Models\DonHang;
use App\Models\DonHangChiTiet;
use App\Models\KhachHang;
use App\Models\KhuyenMai;
use App\Models\NhanVien;
use Illuminate\Support\Facades\DB;

class CtrlDonHang extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->capsule->getConnection()->statement('CALL  CapNhatTrangThaiDonHangKhoa()');
    }

    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view("Pages.DonHang");
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function pageDatHang()
    {
        return $this->view("Pages.DonHangTao");
    }
    public function pageDonHangChiTiet($maDonHang)
    {
        $donHang = DonHang::where('MaDonHang', $maDonHang)->first();
        $danhSachDAU = DonHangChiTiet::where('MaDonHang', $maDonHang)->get();
        $doAnUongs = array();
        foreach ($danhSachDAU as $row){
            $doAnUong = DoAnUong::where('MaDoAnUong', $row['MaDoAnUong'])->first();
            $doAnUongs[] = array('MaDoAnUong'=> $doAnUong['MaDoAnUong'], 'Ten'=> $doAnUong['Ten'], 'SoLuong' => $row['SoLuong'], 'GhiChu' => $row['GhiChu']);
        }
        $khachHang = KhachHang::where('MaKhachHang', $donHang['MaKhachHang'])->first();
        $khuyenMai = KhuyenMai::where('MaKhuyenMai', $donHang['MaKhuyenMai'])->first();
        $nhanVien = NhanVien::where('MaNhanVien', $donHang['MaNhanVien'])->first();
        return $this->view("Pages.DonHangChiTiet", ['donHang' => $donHang, 'doAnUongs' => $doAnUongs,  'khachHang' => $khachHang, 'nhanVien' => $nhanVien, 'khuyenMai' => $khuyenMai]);
    }
    public function layDanhSachDonHangTheoThoiGian($start, $end)
    {

        $donHang = DonHang::where('NgayLap', '>=', $start)
                            ->where('NgayLap', '<=', $end)
                            ->orderBy('NgayLap', 'desc')
                            ->get();
        foreach ($donHang as $dh) {
            $khachHang = KhachHang::where('MaKhachHang', $dh['MaKhachHang'])->first();
            $dh['SoDienThoai'] = $khachHang != null ? $khachHang['SoDienThoai'] : '';
        }
        return $donHang;
    }
    public function layKhachHangTuSDT($soDienThoai){
        return KhachHang::where('SoDienThoai',$soDienThoai)->first();
    }
    public function layDanhSachDoAnUong()
    {
        return DoAnUong::where('TrangThai', 1)->orderBy('MaDoAnUong', 'desc')->get();
    }
    public function layKhuyenMaiTuDK($dieuKien)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        return KhuyenMai::where('BatDau', '<=', $currentDateTime)
            ->where('KetThuc', '>=', $currentDateTime)
            ->where('DieuKien', $dieuKien)
            ->first();
    }
    public function themDonHang($objDH)
    {   
        $lastOrder = DonHang::orderBy('MaDonHang', 'desc')->first();

        // Nếu không có đơn hàng nào, bắt đầu với DH00000001
        if (!$lastOrder) {
            $newMaDonHang = 'DH00000001';
            $donHang['MaDonHang'] = $newMaDonHang;
        } else {
            // Lấy mã đơn hàng cuối cùng và tăng thêm 1
            $lastMaDonHang = $lastOrder->MaDonHang;
            $numericPart = intval(substr($lastMaDonHang, 2)); // Lấy phần số của mã
            $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Tăng thêm 1 và bổ sung số 0 vào đầu
            $newMaDonHang = 'DH' . $newNumericPart; // Ghép lại thành mã mới
            $donHang['MaDonHang'] = $newMaDonHang;
        }
        
    
        $khachHang = KhachHang::where('SoDienThoai',$objDH['SoDienThoai'])->first();

        $result = DonHang::insert([
            'MaDonHang' => $donHang['MaDonHang'],
            'MaKhachHang' => $khachHang !== null ? $khachHang['MaKhachHang'] : null,
            'TichDiemSuDung' => $objDH['TichDiem'],
            'MaNhanVien' => $_SESSION['user_id'],
            'MaKhuyenMai' => $objDH['MaKhuyenMai'],
            'TongTien' => $objDH['TongTien']
        ]);
        if($khachHang != null){
            KhachHang::where('SoDienThoai',$objDH['SoDienThoai'])->update(['TichDiem'=>$khachHang['TichDiem'] - $objDH['TichDiem']]);
            KhachHang::where('SoDienThoai',$objDH['SoDienThoai'])->update(['TichDiem'=>$khachHang['TichDiem'] + ($objDH['TongTien']/1000)]);
        }
        if($result){
            foreach ($objDH['DanhSachDAU'] as $doAnUong){
                DonHangChiTiet::insert([
                    'MaDonHang'=>$donHang['MaDonHang'],
                    'MaDoAnUong'=>$doAnUong['MaDoAnUong'],
                    'SoLuong'=>$doAnUong['SoLuong'],
                    'GhiChu'=>$doAnUong['GhiChu']
                ]);
            }
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }

    }
    public function xoaDonHang($maDonHang)
    {
        // Find the order by its 'MaDonHang'
        $donHang = DonHang::where('MaDonHang', $maDonHang)->first();
        if($donHang['TrangThai'] == 0){
            // If the order exists and 'MaKhachHang' is not null, proceed to update loyalty points
            if ($donHang['MaKhachHang'] != null) {
                // Find the customer associated with the order
                $khachHang = KhachHang::where('MaKhachHang', $donHang['MaKhachHang'])->first();

                if ($khachHang) {
                    // Update the customer's loyalty points
                    $khachHang->TichDiem += $donHang->TichDiemSuDung;
                    $khachHang->TichDiem -= $donHang->TongTien/1000;
                    $khachHang->save();
                }
            }

            // Try to delete the order
            $result = DonHang::where('MaDonHang', $maDonHang)->delete();
            if ($donHang && $result) {
                return array('status' => 'success');
            } else {
                return array('status' => 'fail', 'message' => 'Xóa đơn hàng không thành công');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Đơn hàng đã khóa không được phép xóa');
        }

    }
}