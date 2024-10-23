<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\NhanVien;
use App\Models\NhanVienToken;

class CtrlDangNhap extends Controller
{

    public function index(){
        return $this->view('Pages.DangNhap');
    }
    function kiemTraPhienDangNhap()
    {
        if(isset($_COOKIE['token'])){
            $nhanVienToken = NhanVienToken::where('Token',$_COOKIE['token'])->first();
            if($nhanVienToken){
                // Lấy thời gian hoạt động cuối cùng từ cơ sở dữ liệu
                $hoatDongCuoi = new \DateTime($nhanVienToken['HoatDongCuoi'], new \DateTimeZone('Asia/Ho_Chi_Minh'));

                // Lấy thời gian hiện tại với cùng múi giờ
                $hienTai = new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));

                // Tính khoảng cách thời gian giữa hoạt động cuối và hiện tại
                $khoangThoiGian = $hienTai->diff($hoatDongCuoi);

                // Chuyển đổi khoảng cách thành phút
                $phutKhacBiet = ($khoangThoiGian->h * 60) + $khoangThoiGian->i;

                // Kiểm tra nếu khoảng cách thời gian nhỏ hơn 30 phút
                if ($phutKhacBiet <= 30) {
                    $nhanVien = NhanVien::where('MaNhanVien',$nhanVienToken['MaNhanVien'])->first();
                    $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                    $_SESSION['username'] = $nhanVien['TenNhanVien'];
                    $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                    $_SESSION['image_user'] = $nhanVien['HinhAnh'];
                    $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                    return ['status'=>'success'];
                } else {
                    setcookie('token', '', time() - 3600, "/");  // Đặt thời gian hết hạn là 1 giờ trước
                    return ['status'=>'fail', 'message' => 'Phiên đăng nhập đã hết hạn'.$phutKhacBiet];
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
            ->where('TrangThai', 1)
            ->first();

        if ($nhanVien != null) {
            $nhanVienToken = NhanVienToken::where('MaNhanVien', $nhanVien['MaNhanVien'])->first();
            if ($nhanVienToken == null) {
                // Đăng nhập thành công
                $token = $this->generateUniqueToken();

                // Tạo token trong bảng NhanVienToken
                NhanVienToken::create([
                    'MaNhanVien' => $nhanVien['MaNhanVien'],
                    'Token' => $token,
                    'HoatDongCuoi' => date('Y-m-d H:i:s')
                ]);

                // Lưu thông tin đăng nhập vào session
                $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                $_SESSION['username'] = $nhanVien['TenNhanVien'];
                $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                $_SESSION['image_user'] = $nhanVien['HinhAnh'];

                // Lưu token vào cookie với thời gian sống 30 phút
                setcookie('token', $token, time() + 1800, "/", "", false, true);  // HTTP Only cookie
                $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                return array('status' => 'success');

            } else {
                $hoatDongCuoi = new \DateTime($nhanVienToken['HoatDongCuoi']);
                $hienTai = new \DateTime();
                $khoangThoiGian = $hienTai->diff($hoatDongCuoi);
                $phutKhacBiet = ($khoangThoiGian->h * 60) + $khoangThoiGian->i;

                if ($phutKhacBiet > 30) {
                    // Xóa token cũ và tạo token mới
                    $token = $this->generateUniqueToken();
                    $nhanVienToken->delete();

                    NhanVienToken::create([
                        'MaNhanVien' => $nhanVien['MaNhanVien'],
                        'Token' => $token,
                        'HoatDongCuoi' => date('Y-m-d H:i:s')
                    ]);

                    // Cập nhật session và cookie
                    $_SESSION['user_id'] = $nhanVien['MaNhanVien'];
                    $_SESSION['username'] = $nhanVien['TenNhanVien'];
                    $_SESSION['role'] = $nhanVien['MaLoaiNhanVien'];
                    $_SESSION['image_user'] = $nhanVien['HinhAnh'];

                    setcookie('token', $token, time() + 1800, "/", "", false, true);
                    $this->capsule->getConnection()->statement('CALL CapNhatTatCaTrangThaiHoatDong()');
                    return array('status' => 'success');
                } else {
                    return array('status' => 'fail', 'message' => 'Tài khoản này đã đăng nhập');
                }
            }
        } else {
            // Đăng nhập thất bại
            return array('status' => 'fail', 'message' => 'Sai tên đăng nhập hoặc mật khẩu hoặc tài khoản đã tạm ngưng.');
        }
    }

    private function generateUniqueToken() {
        do {
            // Tạo token ngẫu nhiên
            $token = bin2hex(random_bytes(32));

            // Kiểm tra xem token có trùng không
            $existingToken = NhanVienToken::where('Token', $token)->first();
        } while ($existingToken != null);

        return $token;
    }
}