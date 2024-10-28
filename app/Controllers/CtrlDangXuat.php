<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;
use App\Models\NhanVienToken;

class CtrlDangXuat extends Controller
{
    public function dangXuat()
    {

        session_destroy();
        setcookie('token', '', time() - 3600, "/");  // Đặt thời gian hết hạn là 1 giờ trước
        NhanVienToken::where('MaNhanVien', $_SESSION['user_id'])->delete();
        $this->capsule->getConnection()->statement('CALL  CapNhatHoatDongCuoi("'.$_SESSION['user_id'].'")');
        return array('status' => 'success');
    }
}