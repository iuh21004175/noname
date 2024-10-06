<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;

class CtrlCapNhatThongTinCaNhan extends Controller
{
    public function index()
    {
        if(isset($_SESSION['user_id'])){
            $nhanVien = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->first();
            return $this->view('Pages.ThongTinCaNhan', ['nhanVien' => $nhanVien]);
        }
        else{
            header('Location: ./dang-nhap');
        }

    }
    public function capNhatThongTinCaNhan($caNhan)
    {
        $nhanVien = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->first();

        // Kiểm tra nếu dữ liệu đầu vào khác với dữ liệu hiện tại
        if (
            $nhanVien->NgaySinh == $caNhan['NgaySinh'] &&
            $nhanVien->Email == $caNhan['Email'] &&
            $nhanVien->DiaChi == $caNhan['DiaChi'] &&
            $nhanVien->GhiChu == $caNhan['GhiChu']
        ) {
            // Dữ liệu không thay đổi, không cần cập nhật
            return array('status' => 'success');
        }

        // Thực hiện cập nhật nếu có thay đổi
        $result = $nhanVien->update([
            'NgaySinh' => $caNhan['NgaySinh'],
            'Email' => $caNhan['Email'],
            'DiaChi' => $caNhan['DiaChi'],
            'GhiChu' => $caNhan['GhiChu']
        ]);

        if ($result) {
            return array('status' => 'success');
        } else {
            return array('status' => 'fail');
        }
    }
}