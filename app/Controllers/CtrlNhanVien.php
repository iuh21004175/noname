<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DoAnUong;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\KhuyenMai;
use App\Models\LoaiNhanVien;
use App\Models\NhanVien;

class CtrlNhanVien extends Controller
{
    public function index(){
        return $this->view('Pages.NhanVien');
    }
    public function pageNhanVienChiTiet($maNhanVien)
    {
        $nhanVien = NhanVien::where('MaNhanVien', $maNhanVien)->first();
        $loaiNhanVien = LoaiNhanVien::where('MaLoaiNhanVien', $nhanVien['MaLoaiNhanVien'])->first();
        $nhanVien['TenLoaiNhanVien'] = $loaiNhanVien['TenLoaiNhanVien'];
        return $this->view('Pages.NhanVienChiTiet', ['nhanVien' => $nhanVien]);
    }
    public function layDanhSachNhanVienTheoTrangThai($trangThai)
    {
        $nhanVienS = NhanVien::where('TrangThai', $trangThai)->orderBy('MaNhanVien', 'desc')->get();
        foreach ($nhanVienS as $nhanVien) {
            $loaiNhanVien = LoaiNhanVien::where('MaLoaiNhanVien', $nhanVien['MaLoaiNhanVien'])->first();
            $nhanVien['TenLoaiNhanVien'] = $loaiNhanVien['TenLoaiNhanVien'];
        }
        return $nhanVienS;
    }
    public function themNhanVien($nhanVien)
    {
        $lastOrder = NhanVien::orderBy('MaNhanVien', 'desc')->first();

        // Nếu không có đơn hàng nào, bắt đầu với DH00000001
        if (!$lastOrder) {
            $newMaNhanVien = 'NV00000001';
            $nhanVien['MaNhanVien'] = $newMaNhanVien;
        } else {
            // Lấy mã đơn hàng cuối cùng và tăng thêm 1
            $lastMaNhanVien = $lastOrder->MaNhanVien;
            $numericPart = intval(substr($lastMaNhanVien, 2)); // Lấy phần số của mã
            $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Tăng thêm 1 và bổ sung số 0 vào đầu
            $newMaNhanVien = 'NV' . $newNumericPart; // Ghép lại thành mã mới
            $nhanVien['MaNhanVien'] = $newMaNhanVien;
        }
        $result = NhanVien::insert([
            'MaNhanVien' => $nhanVien['MaNhanVien'],
            'TenNhanVien' => $nhanVien['TenNhanVien'],
            'NgaySinh' => $nhanVien['NgaySinh'],
            'SoDienThoai' => $nhanVien['SoDienThoai'],
            'MatKhau' => md5($nhanVien['MatKhau']),
            'MaLoaiNhanVien' => 'LNV0000002',
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
        $nhanVienDB = NhanVien::where('MaNhanVien', $nhanVien['MaNhanVien'])->first();
        $trangThaiHoatDong = $nhanVienDB['TrangThaiHoatDong'];
        $trangThai = $nhanVienDB['TrangThai'];
        $soDienThoai = $nhanVienDB['SoDienThoai'];
        $tenNhanVien = $nhanVienDB['TenNhanVien'];
        if($nhanVien['MatKhau'] == ''){
            $result = $nhanVienDB->update([
                'TenNhanVien' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['TenNhanVien'] : $nhanVien['TenNhanVien'],
                'NgaySinh' => $nhanVien['NgaySinh'],
                'DiaChi' => $nhanVien['DiaChi'],
                'SoDienThoai' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['SoDienThoai'] : $nhanVien['SoDienThoai'],
                'Email' => $nhanVien['Email'],
                'GhiChu' => $nhanVien['GhiChu'],
                'TrangThai' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['TrangThai'] : $nhanVien['TrangThai']
            ]);

        }
        else{
            $result = $nhanVienDB->update([
                'TenNhanVien' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['TenNhanVien'] : $nhanVien['TenNhanVien'],
                'NgaySinh' => $nhanVien['NgaySinh'],
                'DiaChi' => $nhanVien['DiaChi'],
                'SoDienThoai' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['SoDienThoai'] : $nhanVien['SoDienThoai'],
                'Email' => $nhanVien['Email'],
                'MatKhau' => md5($nhanVien['MatKhau']),
                'GhiChu' => $nhanVien['GhiChu'],
                'TrangThai' => $trangThaiHoatDong == 'Online' ? $nhanVienDB['TrangThai'] : $nhanVien['TrangThai']
            ]);

        }
        
        if($result){
            if($nhanVienDB['TrangThaiHoatDong'] == 'Online' && $trangThai != $nhanVien['TrangThai']){
                return array('status' => 'success', 'message' => 'Không thể cập nhật trang thái khi nhân viên đang online');
            }
            if($nhanVienDB['TrangThaiHoatDong'] == 'Online' && $soDienThoai != $nhanVien['SoDienThoai']){
                return array('status' => 'success', 'message' => 'Không thể cập nhật số điện thoại khi nhân viên đang online');
            }
            if($nhanVienDB['TrangThaiHoatDong'] == 'Online' && $tenNhanVien != $nhanVien['TenNhanVien']){
                return array('status' => 'success', 'message' => 'Không thể cập nhật tên nhân viên khi nhân viên đang online');
            }
            return array('status' => 'success');
        }
        else{
            return array('status' => 'fail', 'message' => 'Cập nhật nhân viên không thành công');
        }
    }
    public function xoaNhanVien($maNhanVien)
    {
        $ktNhanVienVSKhachHang = KhachHang::where('MaNhanVien', $maNhanVien)->first()   ;
        $ktNhanVienVSKhuyenMai = KhuyenMai::where('MaNhanVien', $maNhanVien)->first();
        $ktNhanVienVSDonHang = DonHang::where('MaNhanVien', $maNhanVien)->first();
        $ktNhanVienVSDoAnUong = DoAnUong::where('MaNhanVien', $maNhanVien)->first();
        if($ktNhanVienVSKhachHang == null && $ktNhanVienVSKhuyenMai == null && $ktNhanVienVSDonHang == null && $ktNhanVienVSDoAnUong == null){
            $nhanVien = NhanVien::where('MaNhanVien', $maNhanVien)->first();
            if($nhanVien->delete()){
                return array('status' => 'success');
            }
            else{
                return array('status' => 'fail', 'message' => 'Xóa nhân viên không thành công');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Nhân viên vẫn còn quản lý các đối tượng của hệ thống');
        }
    }
}