<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;

class CtrlDangNhap extends Controller
{
    public function index(){
        return $this->view('Pages.DangNhap');
    }
    public function pageThongTinCaNhan()
    {
        if(isset($_SESSION['user_id'])){
            $nhanVien = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->first();
            return $this->view('Pages.ThongTinCaNhan', ['nhanVien' => $nhanVien]);
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function dangNhap($tendn, $matkhau){
        $md5mk = md5($matkhau);
        $nhanVien = NhanVien::where('SoDienThoai', $tendn)
                                        ->where('MatKhau', $md5mk)
                                        ->where('TrangThai', 1)
                                        ->first();
        if ($nhanVien) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
            $_SESSION['username'] = $nhanVien['TenNhanVien'];
            $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
            $_SESSION['image_user'] = $nhanVien['HinhAnh'];
            NhanVien::where('MaNhanVien', $nhanVien['MaNhanVien'])->update([
                'TrangThaiHoatDong' => 'Online'
            ]);
            return array('status' => 'success');
        } else {
            // Đăng nhập thất bại
            return array('status' => 'fail');
        }
    }

    public function capNhatThongTinCaNhan($caNhan)
    {
        $result = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->update([
            'NgaySinh' => $caNhan['NgaySinh'],
            'Email' => $caNhan['Email'],
            'DiaChi' => $caNhan['DiaChi'],
            'GhiChu' => $caNhan['GhiChu']
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function dangXuat()
    {
        NhanVien::where('MaNhanVien', $_SESSION['user_id'])->update([
            'TrangThaiHoatDong' => 'Offline'
        ]);
        session_destroy();
        return array('status' => 'success');
    }
}