<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;

class CtrlDangXuat extends Controller
{
    public function dangXuat()
    {
        $result = NhanVien::where('MaNhanVien', $_SESSION['user_id'])->update([
            'TrangThaiHoatDong' => 'Offline'
        ]);
        if($result){
            session_destroy();
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail', 'message' => 'Đăng xuất không thành công: '.$result);
        }

    }
}