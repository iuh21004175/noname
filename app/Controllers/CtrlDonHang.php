<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DonHang;
use App\Models\DonHangChiTiet;
use App\Models\KhachHang;
use App\Models\KhuyenMai;
use App\Models\MonAn;
use App\Models\NhanVien;

class CtrlDonHang extends Controller
{
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
        $danhSachMA = DonHangChiTiet::where('MaDonHang', $maDonHang)->get();
        $monAns = array();
        foreach ($danhSachMA as $maMA){
            $monAn = MonAn::where('MaMonAn', $maMA['MaMonAn'])->first();
            $monAns[] = array('MaMonAn'=> $maMA['MaMonAn'], 'TenMonAn'=> $monAn['TenMonAn'], 'SoLuong' => $maMA['SoLuong']);
        }
        $khachHang = KhachHang::where('MaKhachHang', $donHang['MaKhachHang'])->first();
        $khuyenMai = KhuyenMai::where('MaKhuyenMai', $donHang['MaKhuyenMai'])->first();
        $nhanVien = NhanVien::where('MaNhanVien', $donHang['MaNhanVien'])->first();
        return $this->view("Pages.DonHangChiTiet", ['donHang' => $donHang, 'monAns' => $monAns,  'khachHang' => $khachHang, 'nhanVien' => $nhanVien, 'khuyenMai' => $khuyenMai]);
    }
    public function layDanhSachDonHang()
    {
        $donHang = DonHang::all();
        foreach ($donHang as $dh) {
            $khachHang = KhachHang::where('MaKhachHang', $dh['MaKhachHang'])->first();
            $dh['SoDienThoai'] = $khachHang != null ? $khachHang['SoDienThoai'] : '';
        }
        return $donHang;
    }
    public function layKhachHangTuSDT($soDienThoai){
        return KhachHang::where('SoDienThoai',$soDienThoai)->first();
    }
    public function layDanhSachMonAn()
    {
        return MonAn::all();
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
        $khachHang = KhachHang::where('SoDienThoai',$objDH['SoDienThoai'])->first();

        $id = DonHang::insertGetId([
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
        if($id){
            foreach ($objDH['DanhSachMA'] as $monAn){
                DonHangChiTiet::insert([
                    'MaDonHang'=>$id,
                    'MaMonAn'=>$monAn['MaMonAn'],
                    'SoLuong'=>$monAn['SoLuong']
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

        // If the order exists and 'MaKhachHang' is not null, proceed to update loyalty points
        if ($donHang && $donHang->MaKhachHang != null) {
            // Find the customer associated with the order
            $khachHang = KhachHang::where('MaKhachHang', $donHang->MaKhachHang)->first();

            if ($khachHang) {
                // Update the customer's loyalty points
                $khachHang->TichDiem += $donHang->TichDiemSuDung;
                $khachHang->TichDiem -= $donHang->TongTien/1000;
                $khachHang->save();
            }
        }

        // Try to delete the order
        if ($donHang && $donHang->delete()) {
            return array('status' => 'success');
        } else {
            return array('status' => 'fail');
        }
    }
}