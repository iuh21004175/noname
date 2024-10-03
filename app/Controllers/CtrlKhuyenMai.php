<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DonHang;
use App\Models\KhuyenMai;
use App\Models\NhanVien;

class CtrlKhuyenMai extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.KhuyenMai');
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function layDanhSachKhuyenMai(){
        return KhuyenMai::all();
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
        $result = KhuyenMai::insert([
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
        $result = KhuyenMai::where('MaKhuyenMai', $maKhuyenMai)->delete();
        if($result){
            return array('status'=>'success');
        }
        else{
            return array('status'=>'fail');
        }
    }
    public function capNhatKhuyenMai($khuyenMai)
    {
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
            return array('status'=>'fail');
        }
    }
}