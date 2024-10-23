<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;
use App\Models\NhanVienToken;

class CtrlDangXuat extends Controller
{
    public function dangXuat()
    {
        $result = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->update([
            'TrangThaiHoatDong' => 'Offline'
        ]);
        if($result){
            session_destroy();
            setcookie('token', '', time() - 3600, "/");  // Đặt thời gian hết hạn là 1 giờ trước
            NhanVienToken::where('MaNhanVien', $_SESSION['user_id'])->delete();
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail', 'message' => 'Đăng xuất không thành công: ');
        }
    }
}