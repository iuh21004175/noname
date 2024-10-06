<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;

class CtrlDangNhap extends Controller
{
    public function index(){
        return $this->view('Pages.DangNhap');
    }

    public function dangNhap($tendn, $matkhau){
        $md5mk = md5($matkhau);
        $nhanVien = NhanVien::where('SoDienThoai', $tendn)
                                        ->where('MatKhau', $md5mk)
                                        ->first();
        if ($nhanVien != null) {
            if($nhanVien['TrangThaiHoatDong'] == 'Offline'){
                // Đăng nhập thành công
                $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                $_SESSION['username'] = $nhanVien['TenNhanVien'];
                $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                $_SESSION['image_user'] = $nhanVien['HinhAnh'];
                NhanVien::where('MaNhanVien', $nhanVien['MaNhanVien'])->update([
                    'TrangThaiHoatDong' => 'Online'
                ]);
                return array('status' => 'success');
            }
            else{
                return array('status' => 'fail', 'message' => 'Tài khoản này đã được đăng nhập');
            }

        } else {
            // Đăng nhập thất bại
            return array('status' => 'fail', 'message' => 'Sai tên đăng nhập hoặc mật khẩu.');
        }
    }
}