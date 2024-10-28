<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;
use App\Models\NhanVienToken;
use DateTime;

class CtrlDangNhap extends Controller
{

    public function index(){
        return $this->view('Pages.DangNhap');
    }
    function kiemTraPhienDangNhap()
    {
        if(isset($_COOKIE['token'])){
            $nhanVienToken = NhanVienToken::where('Token', md5($_COOKIE['token']))->first();
            if($nhanVienToken != null){
                $nhanVien = NhanVien::where('MaNhanVien', $nhanVienToken->MaNhanVien)->first();
                if($nhanVien['TrangThai'] == 0){
                    $nhanVienToken->delete();
                    setcookie('token', '', time() - 3600, "/");
                    return ['status' => 'fail', 'message' => 'Tài khoản này đã ngưng hoạt động'];
                }
                // Lấy thời gian hiện tại với cùng múi giờ
                $hienTai = new \DateTime();
                $ketThucPhien = new DateTime($nhanVienToken['KetThucPhien']);
                $hoatDongCuoi = new \DateTime($nhanVienToken['HoatDongCuoi']);

                // Kiểm tra nếu khoảng cách thời gian nhỏ hơn 30 phút
                if ($hienTai <= $ketThucPhien && $hienTai > $hoatDongCuoi) {
                    $nhanVien = NhanVien::where('MaNhanVien',$nhanVienToken['MaNhanVien'])->first();
                    $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                    $_SESSION['username'] = $nhanVien['TenNhanVien'];
                    $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                    $_SESSION['image_user'] = $nhanVien['HinhAnh'];
                    $_SESSION['token'] = $_COOKIE['token'];
                    setcookie('token', $_SESSION['token'], time() + 1800, "/", "", false, true);  // HTTP Only cookie
                    $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                    return ['status'=>'success'];
                } else {
                    $nhanVienToken->delete();
                    setcookie('token', '', time() - 3600, "/");  // Đặt thời gian hết hạn là 1 giờ trước
                    return ['status'=>'fail', 'message' => 'Phiên đăng nhập đã hết hạn'.$ketThucPhien];
                }
            }
            else{
                setcookie('token', '', time() - 3600, "/");  // Đặt thời gian hết hạn là 1 giờ trước
                return ['status'=> 'fail', 'message' => 'Phiên đăng nhập không đúng'];
            }
        }
        else{
            session_destroy();
            return ['status' => 'fail'];
        }
    }
    public function dangNhap($tendn, $matkhau) {
        $md5mk = md5($matkhau);
        $nhanVien = NhanVien::where('SoDienThoai', $tendn)
            ->where('MatKhau', $md5mk)
            ->first();

        if ($nhanVien != null) {
            if($nhanVien['TrangThai'] == 1){
                $nhanVienToken = NhanVienToken::where('MaNhanVien', $nhanVien['MaNhanVien'])->first();
                if ($nhanVienToken == null) {
                    // Đăng nhập thành công
                    $token = $this->generateUniqueToken();

                    // Tạo token trong bảng NhanVienToken
                    NhanVienToken::create([
                        'MaNhanVien' => $nhanVien['MaNhanVien'],
                        'Token' => md5($token),
                        'HoatDongCuoi' => date('Y-m-d H:i:s'),
                        'KetThucPhien' => date('Y-m-d H:i:s', strtotime('+30 minutes'))
                    ]);

                    // Lưu thông tin đăng nhập vào session
                    $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                    $_SESSION['username'] = $nhanVien['TenNhanVien'];
                    $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                    $_SESSION['image_user'] = $nhanVien['HinhAnh'];
                    $_SESSION['token'] = $token;
                    // Lưu token vào cookie với thời gian sống 30 phút
                    setcookie('token', $token, time() + 1800, "/", "", false, true);  // HTTP Only cookie
                    $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                    return array('status' => 'success');

                }
                else {
                    // Lấy thời gian hiện tại với cùng múi giờ
                    $hienTai = new \DateTime();
                    $ketThucPhien = new DateTime($nhanVienToken['KetThucPhien']);
                    if ($hienTai > $ketThucPhien) { //Kiểm tra phiên hết hạn tạo phiên mới
                        // Xóa token cũ và tạo token mới
                        $token = $this->generateUniqueToken();
                        $nhanVienToken->delete();

                        NhanVienToken::create([
                            'MaNhanVien' => $nhanVien['MaNhanVien'],
                            'Token' => md5($token),
                            'HoatDongCuoi' => date('Y-m-d H:i:s'),
                            'KetThucPhien' => date('Y-m-d H:i:s', strtotime('+30 minutes'))
                        ]);
                        // Cập nhật session và cookie
                        $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                        $_SESSION['username'] = $nhanVien['TenNhanVien'];
                        $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                        $_SESSION['image_user'] = $nhanVien['HinhAnh'];
                        $_SESSION['token'] = $token;
                        setcookie('token', $token, time() + 1800, "/", "", false, true);
                        $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                        return array('status' => 'success');
                    } else {
                        return array('status' => 'fail', 'message' => 'Tài khoản này đã đăng nhập');
                    }
                }
            }
            else{
                return ['status' => 'fail', 'message' => 'Tài khoản này đã ngưng hoạt động'];
            }

        } else {
            // Đăng nhập thất bại
            return array('status' => 'fail', 'message' => 'Sai tên đăng nhập hoặc mật khẩu.');
        }
    }

    private function generateUniqueToken() {
        do {
            // Tạo token ngẫu nhiên
            $token = bin2hex(random_bytes(32));

            // Kiểm tra xem token có trùng không
            $existingToken = NhanVienToken::where('Token', md5($token))->first();
        } while ($existingToken != null);

        return $token;
    }
}