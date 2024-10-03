<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LoaiMonAn;
use App\Models\MonAn;
use App\Models\NhanVien;

class CtrlMonAn extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.MonAn');
        }
        else{
            header('Location: ./dang-mhap');
        }

    }
    public function pageMonAnChiTiet($maMonAn)
    {
        $monAn = MonAn::where('MaMonAn', $maMonAn)->first();
        $loaiMonAn = LoaiMonAn::where('MaLoaiMonAn', $monAn['MaLoaiMonAn'])->first();
        $monAn['TenLoaiMonAn'] = $loaiMonAn['TenLoaiMonAn'];
        $nhanVien = NhanVien::where('MaNhanVien', $monAn['MaNhanVien'])->first();
        return $this->view('Pages.MonAnChiTiet', ['monAn' => $monAn, 'nhanVien' => $nhanVien]);
    }
    public function layDanhSachMonAn()
    {
        $listMonAn = MonAn::all();
        foreach ($listMonAn as $monAn) {
            $loaiMonaAn = LoaiMonAn::where('MaLoaiMonAn',$monAn['MaLoaiMonAn'])->first();
            $monAn['TenLoaiMonAn'] = $loaiMonaAn['TenLoaiMonAn'];
        }
        return $listMonAn;
    }
    public function themMonAn($monAn)
    {
        $result = MonAn::insert([
            'TenMonAn' => $monAn['TenMonAn'],
            'Gia' => $monAn['Gia'],
            'MaLoaiMonAn' => $monAn['MaLoaiMonAn'],
            'MaNhanVien' => $_SESSION['user_id']
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function xoaMonAn($maMonAn)
    {
        $result = MonAn::where('MaMonAn', $maMonAn)->delete();
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
    public function capNhatMonAn($monAn){
        $result = MonAn::where('MaMonAn', $monAn['MaMonAn'])->update([
            'TenMonAn' => $monAn['TenMonAn'],
            'Gia' => $monAn['Gia'],
            'MoTa' => $monAn['MoTa'],
            'MaLoaiMonAn' => $monAn['MaLoaiMonAn'],
            'MaNhanVien' => $_SESSION['user_id']
        ]);
        if($result){
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail');
        }
    }
}