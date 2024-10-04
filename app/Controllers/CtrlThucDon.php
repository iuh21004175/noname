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
        if(isset($_SESSION['user_id'])){
            return $this->view('Pages.ThucDon');
        }
        else{
            header('Location: /dang-nhap');
        }    
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

    public function themDoAnUong($doAnUong){
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
        
        $result = DoAnUong::insert([
            'MaDoAnUong' => $doAnUong['MaDoAnUong'],
            'Ten' => $doAnUong['Ten'],
            'Gia' => $doAnUong['Gia'],
            'Loai' => $doAnUong['Loai'],
            'DonVi' => $doAnUong['DonVi'],
            'MaNhanVien' => $_SESSION['user_id']
        ]);
        if($result){
            return [ 'status' => 'success'];
        }
        else{
            return ['status' => 'fail'];
        }
    }
    public function xoaDoAnUong($maDoAnUong)
    {   $doAnUong = DoAnUong::where('MaDoAnUong', $maDoAnUong)->first();
        if($doAnUong['TrangThai']==0){
            $kiemTraDoAnUong = DonHangChiTiet::where('MaDoAnUong', $maDoAnUong)->first();
            if($kiemTraDoAnUong == null){
                $result = DoAnUong::where('MaDoAnUong',$maDoAnUong)->delete();
                if($result){
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
    public function capNhatDoAnUong($doAnUong)
    {
        $doAnUongDB = DoAnUong::where('MaDoAnUong', $doAnUong['MaDoAnUong'])->first();
        if($doAnUongDB['TrangThai']==0){
            $kiemTraDoAnUong = DonHangChiTiet::where('MaDoAnUong', $doAnUong['MaDoAnUong'])->first();
            if($kiemTraDoAnUong == null){
                $result = $doAnUongDB->update([
                    'Gia' => $doAnUong['Gia'],
                    'DonVi' => $doAnUong['DonVi'],
                    'MoTa' => $doAnUong['MoTa'],
                    'TrangThai' => $doAnUong['TrangThai']
                ]);
                if($result){
                    return array('status' => 'success');
                }
                else{
                    return array('status' => 'fail', 'message' => 'Cập nhật đồ ăn uống không thành công');
                }
            }
            else{
                $result = $doAnUongDB->update([
                    'DonVi' => $doAnUong['DonVi'],
                    'MoTa' => $doAnUong['MoTa'],
                    'TrangThai' => $doAnUong['TrangThai']
                ]);
                if($result){
                    if($doAnUongDB['Gia'] != $doAnUong['Gia']){
                        return array('status' => 'success', 'message' => 'Đồ ăn uống đã bán không thể cập nhật giá');
                    }
                    return array('status' => 'success');
                }
                else{
                    return array('status' => 'fail', 'message' => 'Cập nhật đồ ăn uống không thành công');
                }
            }
        }
        else{
            $result = $doAnUongDB->update([
                'DonVi' => $doAnUong['DonVi'],
                'MoTa' => $doAnUong['MoTa'],
                'TrangThai' => $doAnUong['TrangThai']
            ]);
            if($result){
                return array('status' => 'success');
            }
            else{
                return array('status' => 'fail', 'message' => 'Cập nhật đồ ăn uống không thành công');
            }
        }

    }

}