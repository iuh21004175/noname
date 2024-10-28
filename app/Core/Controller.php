<?php

namespace App\Core;

use App\Models\NhanVien;
use App\Models\NhanVienToken;
use eftec\bladeone\BladeOne;
use Illuminate\Database\Capsule\Manager as Capsule;

class Controller
{
    protected $capsule;

    public function __construct()
    {
        // Khởi tạo Capsule (Eloquent ORM)
        $this->capsule = new Capsule;

        // Cấu hình kết nối cơ sở dữ liệu
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'chipheo',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_0900_ai_ci',
            'prefix'    => '',
        ]);

        // Thiết lập Eloquent ORM
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    protected function view($page, $data = [])
    {
        $dirView = "./app/Views";
        $dirCache = "./app/Cache";
        $blade = new BladeOne($dirView, $dirCache, BladeOne::MODE_AUTO);
        return $blade->run($page, $data);
    }
    protected function kiemTraToken(){
        $uri = $_SERVER['REQUEST_URI'];
        $urlChuyenHuong = strpos($uri, 'fetch') ? '../dang-nhap' : './dang-nhap';
        if(isset($_COOKIE['token'])){
            $nhanVienToken = NhanVienToken::where('Token', md5($_COOKIE['token']))->first();
            if($nhanVienToken == null){
                header('Location: '.$urlChuyenHuong);
            }
            else{
                $nhanVien = NhanVien::where('MaNhanVien', $nhanVienToken->MaNhanVien)->first();
                if($nhanVien['TrangThai'] == 0){
                    header('Location: '.$urlChuyenHuong);
                }
                $hienTai = new \DateTime();
                $ketThucPhien = new \DateTime($nhanVienToken['KetThucPhien']);
                $hoatDongCuoi = new \DateTime($nhanVienToken['HoatDongCuoi']);
                if($hienTai <= $ketThucPhien && $hienTai > $hoatDongCuoi && isset($_SESSION['user_id'])){
                    $this->capsule->getConnection()->statement('CALL  CapNhatHoatDongCuoi("'.$_SESSION['user_id'].'")');
                    setcookie('token', $_SESSION['token'], time() + 1800, "/", "", false, true);
                }
                else{
                    header('Location: '.$urlChuyenHuong);
                }
            }
        }
        else{
            header('Location: '.$urlChuyenHuong);
        }
    }
}
