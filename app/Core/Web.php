<?php
namespace App\Core;

use App\Controllers\CtrlDangNhap;
use App\Controllers\CtrlDonHang;
use App\Controllers\CtrlKhachHang;
use App\Controllers\CtrlKhuyenMai;
use App\Controllers\CtrlMonAn;
use App\Controllers\CtrlNhanVien;
use App\Controllers\CtrlTrangChu;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Web
{
    public function __construct()
    {
        new Database();
        $dispatcher = simpleDispatcher(function(RouteCollector $r) {
            $r->addRoute('GET', '/dang-nhap', function () {
                $ctrl = new CtrlDangNhap();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/', function () {
                $ctrl = new CtrlTrangChu();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/don-hang', function () {
                $ctrl = new CtrlDonHang();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/don-hang-chi-tiet-{maDonHang}', function ($maDonHang) {
                $ctrl = new CtrlDonHang();
                return $ctrl->pageDonHangChiTiet($maDonHang);
            });
            $r->addRoute('GET', '/tao-don-hang', function () {
                $ctrl = new CtrlDonHang();
                return $ctrl->pageDatHang();
            });
            $r->addRoute('GET', '/khach-hang', function () {
                $ctrl = new CtrlKhachHang();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/khach-hang-chi-tiet-{maKhachHang}', function ($maKhachHang) {
                $ctrl = new CtrlKhachHang();
                return $ctrl->pageKhachHangChiTiet($maKhachHang);
            });
            $r->addRoute('GET', '/khuyen-mai', function () {
                $ctrl = new CtrlKhuyenMai();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/khuyen-mai-chi-tiet-{maKhuyenMai}', function ($maKhuyenMai) {
                $ctrl = new CtrlKhuyenMai();
                return $ctrl->pageKhuyenMaiChiTiet($maKhuyenMai);
            });
            $r->addRoute('GET', '/thuc-don', function () {
                $ctrl = new CtrlMonAn();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/mon-an-chi-tiet-{maMonAn}', function ($maMonAn) {
                $ctrl = new CtrlMonAn();
                return $ctrl->pageMonAnChiTiet($maMonAn);
            });
            $r->addRoute('GET', '/nhan-vien', function () {
                $ctrl = new CtrlNhanVien();
                return $ctrl->index();
            });
            $r->addRoute('GET', '/nhan-vien-chi-tiet-{maNhanVien}', function ($maNhanVien) {
                $ctrl = new CtrlNhanVien();
                return $ctrl->pageNhanVienChiTiet($maNhanVien);
            });
            $r->addRoute('GET', '/thong-tin-ca-nhan', function () {
                $ctrl = new CtrlDangNhap();
                return $ctrl->pageThongTinCaNhan();
            });
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $basePath = '/cp';
        $uri = str_replace($basePath, '', $uri);

// Strip query string (?foo=bar) from URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

// Dispatch the route
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                if (is_callable($handler)) {
                    echo call_user_func_array($handler, $vars);
                }
                break;
        }
    }
}
?>