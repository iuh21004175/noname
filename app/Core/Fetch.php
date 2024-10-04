<?php

namespace App\Core;

use App\Controllers\CtrlDangNhap;
use App\Controllers\CtrlDonHang;
use App\Controllers\CtrlKhachHang;
use App\Controllers\CtrlKhuyenMai;
use App\Controllers\CtrlNhanVien;
use App\Controllers\CtrlThucDon;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Fetch
{
    public function __construct()
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $r) {
            $r->addRoute('POST', '/dang-nhap', function () {
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);
                $ctrl = new CtrlDangNhap();
                echo json_encode($ctrl->dangNhap($data['username'], $data['password']));
            });
            if(isset($_SESSION['user_id'])){
                $r->addRoute('GET', '/dat-hang', function () {
                    $ctrl = new CtrlDonHang();
                    echo json_encode($ctrl->layDanhSachDoAnUong());
                });
                $r->addRoute('GET', '/so-dien-thoai-khach-hang-{soDienThoai}', function ($soDienThoai) {
                    $ctrl = new CtrlDonHang();
                    echo json_encode($ctrl->layKhachHangTuSDT($soDienThoai));
                });
                $r->addRoute('GET', '/dieu-kien-khuyen-mai-{dieuKien}', function ($dieuKien) {
                    $ctrl = new CtrlDonHang();
                    echo json_encode($ctrl->layKhuyenMaiTuDK($dieuKien));
                });
                $r->addRoute('POST', '/them-don-hang', function () {
                    $ctrl = new CtrlDonHang();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->themDonHang($data));
                });
                $r->addRoute('POST', '/xoa-don-hang', function () {
                    $ctrl = new CtrlDonHang();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->xoaDonHang($data['MaDonHang']));
                });
                $r->addRoute('GET', '/danh-sach-don-hang-theo-thoi-gian-tu-{start}-den-{end}', function ($start, $end) {
                    $ctrl = new CtrlDonHang();
                    echo json_encode($ctrl->layDanhSachDonHangTheoThoiGian($start, $end));
                });
                $r->addRoute('GET', '/danh-sach-khach-hang-theo-trang-thai-{trangThai}', function ($trangThai) {
                    $ctrl = new CtrlKhachHang();
                    echo json_encode($ctrl->layDanhSachKhachHangTheoTrangThai($trangThai));
                });
                $r->addRoute('POST', '/them-khach-hang', function () {
                    $ctrl = new CtrlKhachHang();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->themKhachHang($data));
                });
                $r->addRoute('POST', '/xoa-khach-hang', function () {
                    $ctrl = new CtrlKhachHang();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->xoaKhachHang($data['MaKhachHang']));
                });
                $r->addRoute('POST', '/cap-nhat-khach-hang', function () {
                    $ctrl = new CtrlKhachHang();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->capNhatKhachHang($data));
                });
                $r->addRoute('GET', '/danh-sach-khuyen-mai-theo-trang-thai-{trangThai}', function ($trangThai) {
                    $ctrl = new CtrlKhuyenMai();
                    echo json_encode($ctrl->layDanhSachKhuyenMaiTheoTrangThai($trangThai));
                });
                $r->addRoute('POST', '/them-khuyen-mai', function () {
                    $ctrl = new CtrlKhuyenMai();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->themKhuyenMai($data));
                });
                $r->addRoute('POST', '/xoa-khuyen-mai', function () {
                    $ctrl = new CtrlKhuyenMai();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->xoaKhuyenMai($data['MaKhuyenMai']));
                });
                $r->addRoute('POST', '/cap-nhat-khuyen-mai', function () {
                    $ctrl = new CtrlKhuyenMai();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->capNhatKhuyenMai($data));
                });
                $r->addRoute('GET', '/danh-sach-nhan-vien-theo-trang-thai-{trangThai}', function ($trangThai) {
                    $ctrl = new CtrlNhanVien();
                    echo json_encode($ctrl->layDanhSachNhanVienTheoTrangThai($trangThai));
                });
                $r->addRoute('POST', '/them-nhan-vien', function () {
                    $ctrl = new CtrlNhanVien();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->themNhanVien($data));
                });
                $r->addRoute('POST', '/xoa-nhan-vien', function () {
                    $ctrl = new CtrlNhanVien();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->xoaNhanVien($data['MaNhanVien']));
                });
                $r->addRoute('POST', '/cap-nhat-nhan-vien', function () {
                    $ctrl = new CtrlNhanVien();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->capNhatNhanVien($data));
                });
                $r->addRoute('POST', '/cap-nhat-thong-tin-ca-nhan', function () {
                    $ctrl = new CtrlDangNhap();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->capNhatThongTinCaNhan($data));
                });
                $r->addRoute('POST', '/dang-xuat', function () {
                    $ctrl = new CtrlDangNhap();
                    echo json_encode($ctrl->dangXuat());
                });
                $r->addRoute('GET', '/danh-sach-do-an-uong-theo-trang-thai-{trangThai}', function ($trangThai) {
                    $ctrl = new CtrlThucDon();
                    echo json_encode($ctrl->layDanhSachDoAnUongTheoTrangThai($trangThai));
                });
                $r->addRoute('POST', '/them-do-an-uong', function () {
                    $ctrl = new CtrlThucDon();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->themDoAnUong($data));
                });
                $r->addRoute('POST', '/xoa-do-an-uong', function () {
                    $ctrl = new CtrlThucDon();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->xoaDoAnUong($data['MaDoAnUong']));
                });
                $r->addRoute('POST', '/cap-nhat-do-an-uong', function () {
                    $ctrl = new CtrlThucDon();
                    $json = file_get_contents('php://input');
                    $data = json_decode($json, true);
                    echo json_encode($ctrl->capNhatDoAnUong($data));
                });
            }
        });
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $basePath = '/cp/fetch';
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