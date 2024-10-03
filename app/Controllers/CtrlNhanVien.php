<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LoaiNhanVien;
use App\Models\NhanVien;

class CtrlNhanVien extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.NhanVien');
        }
        else{
            header('Location: ./nhan-vien');
        }
    }
    public function pageNhanVienChiTiet($maNhanVien)
    {
        $nhanVien = NhanVien::where('MaNhanVien', $maNhanVien)->first();
        $loaiNhanVien = LoaiNhanVien::where('MaLoaiNhanVien', $nhanVien['MaLoaiNhanVien'])->first();
        $nhanVien['TenLoaiNhanVien'] = $loaiNhanVien['TenLoaiNhanVien'];
        return $this->view('Pages.NhanVienChiTiet', ['nhanVien' => $nhanVien]);
    }
    public function layDanhSachNhanVien()
    {
        $nhanVienS = NhanVien::all();
        foreach ($nhanVienS as $nhanVien) {
            $loaiNhanVien = LoaiNhanVien::where('MaLoaiNhanVien', $nhanVien['MaLoaiNhanVien'])->first();
            $nhanVien['TenLoaiNhanVien'] = $loaiNhanVien['TenLoaiNhanVien'];
        }
        return $nhanVienS;
    }
    public function themNhanVien($nhanVien)
    {
        $result = NhanVien::insert([
            'TenNhanVien' => $nhanVien['TenNhanVien'],
            'NgaySinh' => $nhanVien['NgaySinh'],
            'SoDienThoai' => $nhanVien['SoDienThoai'],
            'MatKhau' => md5($nhanVien['MatKhau']),
            'MaLoaiNhanVien' => 2,
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function capNhatNhanVien($nhanVien)
    {
        $result = null;
        if($nhanVien['MatKhau'] == ''){
            $result = NhanVien::where('MaNhanVien', $nhanVien['MaNhanVien'])->update([
                'TenNhanVien' => $nhanVien['TenNhanVien'],
                'NgaySinh' => $nhanVien['NgaySinh'],
                'DiaChi' => $nhanVien['DiaChi'],
                'SoDienThoai' => $nhanVien['SoDienThoai'],
                'Email' => $nhanVien['Email'],
                'GhiChu' => $nhanVien['GhiChu']
            ]);
        }
        else{
            $result = NhanVien::where('MaNhanVien', $nhanVien['MaNhanVien'])->update([
                'TenNhanVien' => $nhanVien['TenNhanVien'],
                'NgaySinh' => $nhanVien['NgaySinh'],
                'DiaChi' => $nhanVien['DiaChi'],
                'SoDienThoai' => $nhanVien['SoDienThoai'],
                'Email' => $nhanVien['Email'],
                'MatKhau' => md5($nhanVien['MatKhau']),
                'GhiChu' => $nhanVien['GhiChu']
            ]);
        }
        
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function xoaNhanVien($maNhanVien)
    {
        $result = NhanVien::where('MaNhanVien', $maNhanVien)->delete();
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
}