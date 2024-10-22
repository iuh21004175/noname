<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\DoAnUong;
use App\Models\DonHangChiTiet;
use App\Models\NhanVien;

class CtrlThucDon extends Controller
{
    public function index()
    {
        return $this->view('Pages.ThucDon');
    }
    public function pageThucDonChiTiet($maDoAnUong)
    {
        $doAnUong = DoAnUong::where('MaDoAnUong', $maDoAnUong)->first();
        $nhaVien = null;
        if($doAnUong != null){
            $nhaVien = NhanVien::where('MaNhanVien', $doAnUong['MaNhanVien'])->first();
        }
        return $this->view('Pages.ThucDonChiTiet', ['doAnUong'=> $doAnUong, 'nhanVien' => $nhaVien]);
    }
    public function layDanhSachDoAnUongTheoTrangThai($trangThai)
    {
        return DoAnUong::where('TrangThai',$trangThai)->orderBy('MaDoAnUong', 'desc')->get();
    }

    public function themDoAnUong($doAnUong, $hinhAnh){
        $lastOrder = DoAnUong::orderBy('MaDoAnUong', 'desc')->first();

        // Nếu không có đơn hàng nào, bắt đầu với DH00000001
        if (!$lastOrder) {
            $newMaDoAnUong = 'AU00000001';
            $doAnUong['MaDoAnUong'] = $newMaDoAnUong;
        } else {
            // Lấy mã đơn hàng cuối cùng và tăng thêm 1
            $lastMaDoAnUong = $lastOrder->MaDoAnUong;
            $numericPart = intval(substr($lastMaDoAnUong, 2)); // Lấy phần số của mã
            $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Tăng thêm 1 và bổ sung số 0 vào đầu
            $newMaDoAnUong = 'AU' . $newNumericPart; // Ghép lại thành mã mới
            $doAnUong['MaDoAnUong'] = $newMaDoAnUong;
        }
        $fileName = '';
        $dirUpload = '../public/assets/image/';
        if($hinhAnh != null && $hinhAnh['error'] == 0){
            $type = pathinfo($hinhAnh['name'], PATHINFO_EXTENSION);
            $fileName = $doAnUong['MaDoAnUong'] . '-' .$doAnUong['Ten']. '-' . date("Y-m-d-H-i-s") .'.' . $type;
            if(!move_uploaded_file($hinhAnh['tmp_name'], $dirUpload . $fileName)){
                return ['status' => 'fail', 'message'=>'Upload hình ảnh không thành công '];
            }
        }

        $result = DoAnUong::insert([
            'MaDoAnUong' => $doAnUong['MaDoAnUong'],
            'Ten' => $doAnUong['Ten'],
            'Gia' => $doAnUong['Gia'],
            'Loai' => $doAnUong['Loai'],
            'DonVi' => $doAnUong['DonVi'],
            'MaNhanVien' => $_SESSION['user_id'],
            'HinhAnh' => $fileName,
        ]);
        if($result){
            return ['status' => 'success'];
        }
        else{
            if($hinhAnh != null && $hinhAnh['error'] == 0){
                unlink($dirUpload.$fileName);
            }
            return ['status' => 'fail', 'message' => 'Thêm món không thành công'];
        }
    }
    public function xoaDoAnUong($maDoAnUong)
    {
        $doAnUong = DoAnUong::where('MaDoAnUong', $maDoAnUong)->first();
        $fileName = $doAnUong['HinhAnh'];
        $dirUpload = '../public/assets/image/';
        if($doAnUong['TrangThai']==0){
            $kiemTraDoAnUong = DonHangChiTiet::where('MaDoAnUong', $maDoAnUong)->first();
            if($kiemTraDoAnUong == null){
                $result = DoAnUong::where('MaDoAnUong',$maDoAnUong)->delete();
                if($result){
                    if($fileName != '' && file_exists($dirUpload.$fileName)){
                        unlink($dirUpload.$fileName);
                    }
                    return array('status' => 'success');
                }
                else{
                    return array('status' => 'fail', 'message' => 'Xóa đồ ăn uống không thành công');
                }
            }
            else{
                return array('status' => 'fail', 'message' => 'Đồ ăn uống đã bán không thể xóa');
            }
        }
        else{
            return array('status' => 'fail', 'message' => 'Đồ ăn uống đang bán không thể xóa');
        }


    }
    public function capNhatDoAnUong($doAnUong, $hinhAnh)
    {
        $doAnUongDB = DoAnUong::where('MaDoAnUong', $doAnUong['MaDoAnUong'])->first();
        $fileName = $doAnUongDB['HinhAnh'];
        $fileNameOld = $doAnUongDB['HinhAnh'];
        $dirUpload = '../public/assets/image/';
        if($hinhAnh != null && $hinhAnh['error'] == 0){
            $type = pathinfo($hinhAnh['name'], PATHINFO_EXTENSION);
            $fileName = $doAnUongDB['MaDoAnUong'] . '-' .$doAnUongDB['Ten']. '-' . date("Y-m-d-H-i-s") .'.' . $type;
            if(!move_uploaded_file($hinhAnh['tmp_name'], $dirUpload . $fileName)){
                return ['status' => 'fail', 'message'=>'Upload hình ảnh không thành công'];
            }
        }
        $kiemTraDoAnUong = DonHangChiTiet::where('MaDoAnUong', $doAnUong['MaDoAnUong'])->first();
        if($kiemTraDoAnUong == null){
            $result = $doAnUongDB->update([
                'Gia' => $doAnUong['Gia'],
                'DonVi' => $doAnUong['DonVi'],
                'MoTa' => $doAnUong['MoTa'],
                'TrangThai' => $doAnUong['TrangThai'],
                'HinhAnh' => $fileName
            ]);
            if($result){
                if($hinhAnh != null && $hinhAnh['error'] == 0 && $doAnUongDB['HinhAnh'] != '') {
                    if(file_exists($dirUpload . $fileNameOld) && $fileNameOld != ''){
                        unlink($dirUpload . $fileNameOld);
                    }

                }
                return array('status' => 'success');
            }
            else{
                if($hinhAnh != null && $hinhAnh['error'] == 0) {
                    unlink($dirUpload . $fileName);
                }
                return array('status' => 'fail', 'message' => 'Cập nhật đồ ăn uống không thành công');
            }
        }
        else{
            $result = $doAnUongDB->update([
                'DonVi' => $doAnUong['DonVi'],
                'MoTa' => $doAnUong['MoTa'],
                'TrangThai' => $doAnUong['TrangThai'],
                'HinhAnh' => $fileName
            ]);
            if($result){
                if($hinhAnh != null && $hinhAnh['error'] == 0 && $doAnUongDB['HinhAnh'] != '') {
                    if(file_exists($dirUpload . $fileNameOld) && $fileNameOld != ''){
                        unlink($dirUpload . $fileNameOld);
                    }
                }
                if($doAnUongDB['Gia'] != $doAnUong['Gia']){
                    return array('status' => 'success', 'message' => 'Đồ ăn uống đã bán không thể cập nhật giá');
                }
                return array('status' => 'success');
            }
            else{
                if($hinhAnh != null && $hinhAnh['error'] == 0) {
                    unlink($dirUpload . $fileName);
                }
                return array('status' => 'fail', 'message' => 'Cập nhật đồ ăn uống không thành công');
            }
        }

    }

}