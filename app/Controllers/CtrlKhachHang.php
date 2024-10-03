<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\NhanVien;

class CtrlKhachHang extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.KhachHang');
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function pageKhachHangChiTiet($maKhachHang)
    {
        $donHangS = DonHang::where('MaKhachHang', $maKhachHang)->get();
        $khachHang = KhachHang::where('MaKhachHang', $maKhachHang)->first();
        $nhanVien = NhanVien::where('MaNhanVien', $khachHang['MaNhanVien'])->first();
        return $this->view('Pages.KhachHangChiTiet', ['donHangS'=>$donHangS, 'khachHang'=>$khachHang, 'nhanVien'=>$nhanVien]);
    }
    public function layDanhSachKhachHang(){
        return KhachHang::all();
    }
    public function themKhachHang($khachHang)
    {
        $result = KhachHang::insert([
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
        $result = KhachHang::where('MaKhachHang', $maKhachHang)->delete();
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function capNhatKhachHang($khachHang)
    {
        $result = KhachHang::where('MaKhachHang', $khachHang['MaKhachHang'])->update([
            'TenKhachHang' => $khachHang['TenKhachHang'],
            'SoDienThoai' => $khachHang['SoDienThoai'],
            'GioiTinh' => $khachHang['GioiTinh'],
            'DiaChi' => $khachHang['DiaChi'],
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
}