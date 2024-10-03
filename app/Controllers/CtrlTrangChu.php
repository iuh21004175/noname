<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;

class CtrlTrangChu extends Controller
{
    public function index()
    {
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.TrangChu');
        }
        else{
            header('Location: ./dang-nhap');
        }
    }

}