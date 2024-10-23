<?php

namespace App\Controllers;

use App\Core\Controller;

class CtrlTrangChu extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->capsule->getConnection()->statement('CALL  CapNhatHoatDongCuoi("'.$_SESSION['user_id'].'")');
    }

    public function index()
    {
        return $this->view('Pages.TrangChu');
    }
    public function layNamDoAnTopTheoNam($nam)
    {
        $doAnS = $this->capsule->table('donhangchitiet as dhct')
            ->join('doanuong as da', 'da.MaDoAnUong', '=', 'dhct.MaDoAnUong')
            ->join('donhang as dh', 'dhct.MaDonHang', '=', 'dh.MaDonHang') // Giả sử bảng donhang chứa thông tin về đơn hàng
            ->select('da.Ten', $this->capsule->getConnection()->raw('SUM(dhct.SoLuong) as TongSoLuong'))
            ->whereYear('dh.NgayLap', $nam) // Lọc theo năm
            ->where('da.Loai', 'Đồ ăn') // Lọc theo loại là "Đồ ăn"
            ->groupBy('da.Ten')
            ->orderByDesc('TongSoLuong')
            ->limit(5)
            ->get();

        return $doAnS;
    }
    public function layNamDoUongTopTheoNam($nam)
    {
        $doUongS = $this->capsule->table('donhangchitiet as dhct')
            ->join('doanuong as da', 'da.MaDoAnUong', '=', 'dhct.MaDoAnUong')
            ->join('donhang as dh', 'dhct.MaDonHang', '=', 'dh.MaDonHang') // Giả sử bảng donhang chứa thông tin về đơn hàng
            ->select('da.Ten', $this->capsule->getConnection()->raw('SUM(dhct.SoLuong) as TongSoLuong'))
            ->whereYear('dh.NgayLap', $nam) // Lọc theo năm
            ->where('da.Loai', 'Đồ uống') // Lọc theo loại là "Đồ uống"
            ->groupBy('da.Ten')
            ->orderByDesc('TongSoLuong')
            ->limit(5)
            ->get();

        return $doUongS;
    }
}