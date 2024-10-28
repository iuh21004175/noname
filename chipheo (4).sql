-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 28, 2024 at 02:34 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chipheo`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `CapNhatHoatDongCuoi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CapNhatHoatDongCuoi` (IN `ma_nhan_vien` VARCHAR(10))   BEGIN
    UPDATE nhanvien_token
    SET HoatDongCuoi = NOW(),
        KetThucPhien = DATE_ADD(NOW(), INTERVAL 30 MINUTE)
    WHERE MaNhanVien = ma_nhan_vien;
END$$

DROP PROCEDURE IF EXISTS `CapNhatTatCaTrangThaiHoatDong`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CapNhatTatCaTrangThaiHoatDong` ()   BEGIN
    -- Khai báo biến current_time kiểu DATETIME
    DECLARE v_current_time DATETIME;

    -- Gán giá trị cho biến v_current_time
    SET v_current_time = NOW();

    -- Cập nhật TrangThaiHoatDong = 'Online' nếu nhân viên có token và hoạt động trong 30 phút qua
    UPDATE nhanvien n
    JOIN nhanvien_token t ON n.MaNhanVien = t.MaNhanVien
    SET n.TrangThaiHoatDong = 'Online'
    WHERE n.TrangThai = 1
    AND TIMESTAMPDIFF(MINUTE, t.HoatDongCuoi, v_current_time) <= 30;

    -- Cập nhật TrangThaiHoatDong = 'Offline' nếu token đã hết hạn (hoạt động cuối hơn 30 phút) hoặc không có token
    UPDATE nhanvien n
    LEFT JOIN nhanvien_token t ON n.MaNhanVien = t.MaNhanVien
    SET n.TrangThaiHoatDong = 'Offline'
    WHERE n.TrangThai = 1
    AND (t.MaNhanVien IS NULL OR TIMESTAMPDIFF(MINUTE, t.HoatDongCuoi, v_current_time) > 30);

END$$

DROP PROCEDURE IF EXISTS `CapNhatTrangThaiDonHangKhoa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CapNhatTrangThaiDonHangKhoa` ()   BEGIN
    -- Cập nhật TrangThai = 1 (đã khóa) cho các đơn hàng có thời gian lập cách hiện tại ít nhất 1 ngày
    UPDATE donhang
    SET TrangThai = 1
    WHERE NgayLap <= NOW() - INTERVAL 1 DAY
    AND TrangThai = 0;
END$$

DROP PROCEDURE IF EXISTS `CapNhatTrangThaiKhachHang`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CapNhatTrangThaiKhachHang` ()   BEGIN
    -- Cập nhật trạng thái khách hàng nếu họ có mua hàng trong tuần trước hoặc tuần này
    UPDATE khachhang kh
    SET kh.TrangThai = 
        CASE 
            WHEN EXISTS (
                SELECT 1
                FROM donhang dh
                WHERE dh.MaKhachHang = kh.MaKhachHang
                AND WEEK(dh.NgayLap, 1) IN (WEEK(CURDATE(), 1), WEEK(CURDATE(), 1) - 1)
            )
            THEN 1
            ELSE 0
        END;
END$$

DROP PROCEDURE IF EXISTS `CapNhatTrangThaiKhuyenMaiHetHan`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CapNhatTrangThaiKhuyenMaiHetHan` ()   BEGIN
    -- Cập nhật TrangThai = 0 (hết hạn) cho những khuyến mãi đã kết thúc
    UPDATE khuyenmai
    SET TrangThai = 0
    WHERE KetThuc < NOW() AND TrangThai = 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `doanuong`
--

DROP TABLE IF EXISTS `doanuong`;
CREATE TABLE IF NOT EXISTS `doanuong` (
  `MaDoAnUong` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Ten` varchar(100) DEFAULT NULL,
  `Gia` decimal(10,0) NOT NULL,
  `DonVi` enum('đĩa','bát','lon','chai','ly') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MoTa` text,
  `Loai` enum('Đồ ăn','Đồ uống') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `MaNhanVien` varchar(10) NOT NULL,
  `TrangThai` int DEFAULT '0',
  `HinhAnh` text NOT NULL,
  PRIMARY KEY (`MaDoAnUong`),
  KEY `MaNhanVien` (`MaNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doanuong`
--

INSERT INTO `doanuong` (`MaDoAnUong`, `Ten`, `Gia`, `DonVi`, `MoTa`, `Loai`, `MaNhanVien`, `TrangThai`, `HinhAnh`) VALUES
('AU00000001', 'Cơm sườn nướng', 50000, 'đĩa', 'Cơm tấm sườn nướng thơm ngon', 'Đồ ăn', 'NV00000001', 1, 'AU00000001-Cơm sườn nướng-2024-10-20-11-12-25.jpg'),
('AU00000002', 'Cơm gà xối mỡ', 45000, 'đĩa', 'Cơm gà xối mỡ giòn rụm', 'Đồ ăn', 'NV00000001', 1, 'AU00000002-Cơm gà xối mỡ-2024-10-20-11-11-43.jpg'),
('AU00000003', 'Cơm rang dưa bò', 40000, 'đĩa', 'Cơm rang với dưa chua và thịt bò mềm', 'Đồ ăn', 'NV00000001', 1, 'AU00000003-Cơm rang dưa bò-2024-10-20-11-10-57.jpg'),
('AU00000004', 'Cơm chiên hải sản', 60000, 'đĩa', 'Cơm chiên kết hợp hải sản tươi ngon', 'Đồ ăn', 'NV00000001', 1, 'AU00000004-Cơm chiên hải sản-2024-10-20-11-10-01.jpg'),
('AU00000005', 'Canh chua cá', 30000, 'bát', 'Canh chua cá lóc đậm đà vị miền Nam', 'Đồ ăn', 'NV00000001', 1, 'AU00000005-Canh chua cá-2024-10-20-11-09-03.jpg'),
('AU00000006', 'Cơm đùi gà chiên giòn', 55000, 'đĩa', 'Đùi gà chiên giòn kèm cơm trắng', 'Đồ ăn', 'NV00000001', 1, 'AU00000006-Cơm đùi gà chiên giòn-2024-10-20-11-07-26.jpg'),
('AU00000007', 'Cơm cá kho tộ', 50000, 'đĩa', 'Cơm kèm cá kho tộ đặc trưng', 'Đồ ăn', 'NV00000001', 1, 'AU00000007-Cơm cá kho tộ-2024-10-20-11-06-50.jpg'),
('AU00000008', 'Cơm thịt kho trứng', 45000, 'đĩa', 'Thịt kho trứng cùng cơm trắng', 'Đồ ăn', 'NV00000001', 1, 'AU00000008-Cơm thịt kho trứng-2024-10-20-11-06-03.jpg'),
('AU00000009', 'Cơm gà xé phay', 48000, 'đĩa', 'Gà xé phay trộn gỏi kèm cơm', 'Đồ ăn', 'NV00000001', 1, 'AU00000009-Cơm gà xé phay-2024-10-20-11-04-46.jpg'),
('AU00000010', 'Canh bí đỏ nấu tôm', 25000, 'bát', 'Canh bí đỏ bổ dưỡng nấu tôm', 'Đồ ăn', 'NV00000001', 1, 'AU00000010-Canh bí đỏ nấu tôm-2024-10-20-11-04-07.jpg'),
('AU00000011', 'Cơm chiên trứng', 35000, 'đĩa', 'Cơm chiên với trứng gà vàng ươm', 'Đồ ăn', 'NV00000001', 1, 'AU00000011-Cơm chiên trứng-2024-10-20-11-03-32.jpg'),
('AU00000012', 'Cơm gà luộc', 48000, 'đĩa', 'Gà luộc kèm cơm trắng và nước chấm', 'Đồ ăn', 'NV00000001', 1, 'AU00000012-Cơm gà luộc-2024-10-20-11-02-46.jpg'),
('AU00000013', 'Canh rau ngót thịt băm', 20000, 'bát', 'Canh rau ngót nấu thịt băm', 'Đồ ăn', 'NV00000001', 1, 'AU00000013-Canh rau ngót thịt băm-2024-10-20-11-01-51.jpg'),
('AU00000014', 'Cơm rang thập cẩm', 50000, 'đĩa', 'Cơm rang kết hợp nhiều loại nguyên liệu', 'Đồ ăn', 'NV00000001', 1, 'AU00000014-Cơm rang thập cẩm-2024-10-20-11-00-42.jpg'),
('AU00000015', 'Cơm cá chiên', 45000, 'đĩa', 'Cơm cá chiên giòn rụm', 'Đồ ăn', 'NV00000001', 1, 'AU00000015-Cơm cá chiên-2024-10-20-11-00-05.jpg'),
('AU00000016', 'Cơm sườn cốt lết', 55000, 'đĩa', 'Sườn cốt lết nướng kèm cơm trắng', 'Đồ ăn', 'NV00000001', 1, 'AU00000016-Cơm sườn cốt lết-2024-10-20-10-54-09.jpg'),
('AU00000017', 'Canh bầu nấu tôm', 25000, 'bát', 'Canh bầu thanh mát nấu với tôm', 'Đồ ăn', 'NV00000001', 1, 'AU00000017-Canh bầu nấu tôm-2024-10-20-10-53-21.jpg'),
('AU00000018', 'Cơm bò xào sả ớt', 50000, 'đĩa', 'Cơm bò xào sả ớt đậm đà ngon', 'Đồ ăn', 'NV00000001', 1, 'AU00000018-Cơm bò xào sả ớt-2024-10-20-10-51-55.jpg'),
('AU00000019', 'Cơm chay rau củ', 40000, 'đĩa', 'Cơm chay với rau củ tươi ngon', 'Đồ ăn', 'NV00000001', 1, 'AU00000019-Cơm chay rau củ-2024-10-20-10-49-38.jpg'),
('AU00000020', 'Canh cải nấu thịt', 20000, 'bát', 'Canh cải thanh mát nấu thịt bằm', 'Đồ ăn', 'NV00000001', 1, 'AU00000020-Canh cải nấu thịt-2024-10-20-03-20-17.jpg'),
('AU00000021', 'Trà đá', 5000, 'ly', 'Trà đá mát lạnh', 'Đồ uống', 'NV00000001', 1, 'AU00000021-Trà đá-2024-10-20-10-48-12.jpg'),
('AU00000022', 'Nước ngọt Coca-Cola', 15000, 'lon', 'Coca-Cola giải khát', 'Đồ uống', 'NV00000001', 1, 'AU00000022-Nước ngọt Coca-Cola-2024-10-20-10-47-31.webp'),
('AU00000023', 'Nước ngọt Pepsi', 15000, 'lon', 'Pepsi tươi mát', 'Đồ uống', 'NV00000001', 1, 'AU00000023-Nước ngọt Pepsi-2024-10-20-10-42-51.webp'),
('AU00000024', 'Nước cam ép', 30000, 'ly', 'Nước cam tươi mát giàu vitamin C', 'Đồ uống', 'NV00000001', 1, 'AU00000024-Nước cam ép-2024-10-20-10-42-00.png'),
('AU00000025', 'Cà phê đen', 20000, 'ly', 'Cà phê đen đậm đà', 'Đồ uống', 'NV00000001', 1, 'AU00000025-Cà phê đen-2024-10-20-10-40-13.png'),
('AU00000026', 'Cà phê sữa', 25000, 'ly', 'Cà phê sữa ngọt béo', 'Đồ uống', 'NV00000001', 1, 'AU00000026-Cà phê sữa-2024-10-20-10-39-09.jpg'),
('AU00000027', 'Sinh tố xoài', 35000, 'ly', 'Sinh tố xoài tươi mát', 'Đồ uống', 'NV00000001', 1, 'AU00000027-Sinh tố xoài-2024-10-20-10-37-52.jpg'),
('AU00000028', 'Sinh tố bơ', 35000, 'ly', 'Sinh tố bơ thơm ngon, béo ngậy', 'Đồ uống', 'NV00000001', 1, 'AU00000028-Sinh tố bơ-2024-10-20-10-33-59.png'),
('AU00000029', 'Nước chanh', 20000, 'ly', 'Nước chanh tươi mát', 'Đồ uống', 'NV00000001', 1, 'AU00000029-Nước chanh-2024-10-20-10-31-43.webp'),
('AU00000030', 'Trà sữa trân châu', 30000, 'ly', 'Trà sữa trân châu đen', 'Đồ uống', 'NV00000001', 1, 'AU00000030-Trà sữa trân châu-2024-10-20-11-13-48.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `MaDonHang` varchar(10) NOT NULL,
  `NgayLap` datetime DEFAULT CURRENT_TIMESTAMP,
  `MaKhachHang` varchar(10) DEFAULT NULL,
  `TichDiemSuDung` int DEFAULT '0',
  `MaNhanVien` varchar(10) DEFAULT NULL,
  `MaKhuyenMai` varchar(10) DEFAULT NULL,
  `TongTien` decimal(12,0) DEFAULT NULL,
  `TrangThai` int DEFAULT '0',
  PRIMARY KEY (`MaDonHang`),
  KEY `MaKhuyenMai` (`MaKhuyenMai`),
  KEY `MaNhanVien` (`MaNhanVien`),
  KEY `MaKhachHang` (`MaKhachHang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `NgayLap`, `MaKhachHang`, `TichDiemSuDung`, `MaNhanVien`, `MaKhuyenMai`, `TongTien`, `TrangThai`) VALUES
('DH00000001', '2024-10-20 22:01:38', NULL, 0, 'NV00000001', NULL, 85000, 1),
('DH00000002', '2024-10-26 17:07:33', 'KH00000001', 45, 'NV00000001', 'KM00000004', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donhangchitiet`
--

DROP TABLE IF EXISTS `donhangchitiet`;
CREATE TABLE IF NOT EXISTS `donhangchitiet` (
  `MaDonHang` varchar(10) NOT NULL,
  `MaDoAnUong` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `SoLuong` int DEFAULT NULL,
  `GhiChu` text,
  UNIQUE KEY `MaDonHang` (`MaDonHang`,`MaDoAnUong`),
  KEY `MaDoAnUong` (`MaDoAnUong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donhangchitiet`
--

INSERT INTO `donhangchitiet` (`MaDonHang`, `MaDoAnUong`, `SoLuong`, `GhiChu`) VALUES
('DH00000001', 'AU00000030', 1, ''),
('DH00000001', 'AU00000029', 1, ''),
('DH00000001', 'AU00000028', 1, ''),
('DH00000002', 'AU00000030', 1, ''),
('DH00000002', 'AU00000029', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `MaKhachHang` varchar(10) NOT NULL,
  `TenKhachHang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `GioiTinh` enum('Nam','Nữ') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `DiaChi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `SoDienThoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `TichDiem` int NOT NULL DEFAULT '0',
  `MaNhanVien` varchar(10) DEFAULT NULL,
  `TrangThai` int DEFAULT '1',
  PRIMARY KEY (`MaKhachHang`),
  KEY `MaNhanVien` (`MaNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKhachHang`, `TenKhachHang`, `GioiTinh`, `DiaChi`, `SoDienThoai`, `TichDiem`, `MaNhanVien`, `TrangThai`) VALUES
('KH00000001', 'Nguyễn Văn Minh', 'Nam', NULL, '0901234561', 102, 'NV00000001', 1),
('KH00000003', 'Lê Hoàng Phát', 'Nam', NULL, '0901234563', 0, 'NV00000001', 0),
('KH00000004', 'Phạm Thị Lan', 'Nữ', NULL, '0901234564', 0, 'NV00000001', 0),
('KH00000005', 'Đoàn Văn Tâm', 'Nam', NULL, '0901234565', 0, 'NV00000001', 0),
('KH00000006', 'Bùi Thị Mai', 'Nữ', NULL, '0901234566', 0, 'NV00000001', 0),
('KH00000007', 'Phan Văn Thành', 'Nam', NULL, '0901234567', 0, 'NV00000001', 0),
('KH00000008', 'Ngô Thị Hà', 'Nữ', NULL, '0901234568', 0, 'NV00000001', 0),
('KH00000009', 'Vũ Văn Nam', 'Nam', NULL, '0901234569', 0, 'NV00000001', 0),
('KH00000010', 'Nguyễn Thị Kim', 'Nữ', NULL, '0901234570', 0, 'NV00000001', 0),
('KH00000011', 'Lê Văn Bảo', 'Nam', NULL, '0901234571', 0, 'NV00000001', 0),
('KH00000012', 'Phạm Thị Cúc', 'Nữ', NULL, '0901234572', 0, 'NV00000001', 0),
('KH00000013', 'Hoàng Văn Dũng', 'Nam', NULL, '0901234573', 0, 'NV00000001', 0),
('KH00000014', 'Đặng Thị Hương', 'Nữ', NULL, '0901234574', 0, 'NV00000001', 0),
('KH00000015', 'Nguyễn Văn Hùng', 'Nam', NULL, '0901234575', 0, 'NV00000001', 0),
('KH00000016', 'Lê Thị Ngọc', 'Nữ', NULL, '0901234576', 0, 'NV00000001', 0),
('KH00000017', 'Phạm Văn Khánh', 'Nam', NULL, '0901234577', 0, 'NV00000001', 0),
('KH00000019', 'Nguyễn Văn An', 'Nam', NULL, '0901234579', 0, 'NV00000001', 0),
('KH00000020', 'Lê Thị Thảo', 'Nữ', NULL, '0901234580', 0, 'NV00000001', 0),
('KH00000021', 'Nguyễn Thế Tâm', 'Nữ', NULL, '0965036046', 0, 'NV00000002', 0),
('KH00000022', 'Trần Văn Vân', 'Nam', NULL, '0941382061', 0, 'NV00000002', 0),
('KH00000023', 'Phạm Quang', 'Nam', NULL, '0974736303', 0, 'NV00000001', 0),
('KH00000024', 'Trịnh Ánh', 'Nam', NULL, '0944682922', 0, 'NV00000002', 0),
('KH00000025', 'Nguyễn Quốc Bảo', 'Nam', NULL, '0970106002', 0, 'NV00000001', 0),
('KH00000026', 'Vũ Ánh', 'Nam', NULL, '0918711018', 0, 'NV00000002', 0),
('KH00000027', 'Đặng Tâm', 'Nữ', NULL, '0907451517', 0, 'NV00000001', 0),
('KH00000028', 'Trịnh Tiến', 'Nam', NULL, '0981751284', 0, 'NV00000001', 0),
('KH00000029', 'Nguyễn Văn Chiến', 'Nữ', NULL, '0965303403', 0, 'NV00000002', 0),
('KH00000030', 'Đoàn Bình', 'Nam', NULL, '0969230853', 0, 'NV00000001', 0),
('KH00000031', 'Trịnh Quang', 'Nữ', NULL, '0902484338', 0, 'NV00000002', 0),
('KH00000032', 'Lê Văn Quý', 'Nam', NULL, '0989341035', 0, 'NV00000002', 0),
('KH00000033', 'Nguyễn Tú', 'Nữ', NULL, '0945064413', 0, 'NV00000001', 0),
('KH00000034', 'Trịnh Phú', 'Nam', NULL, '0926998494', 0, 'NV00000002', 0),
('KH00000035', 'Đỗ Đạt', 'Nam', NULL, '0972861793', 0, 'NV00000001', 0),
('KH00000036', 'Nguyễn Minh Tâm', 'Nam', NULL, '0923907731', 0, 'NV00000001', 0),
('KH00000037', 'Nguyễn Tiến Thảo', 'Nữ', NULL, '0955871281', 0, 'NV00000002', 0),
('KH00000038', 'Phạm Tùng', 'Nam', NULL, '0944221194', 0, 'NV00000001', 0),
('KH00000039', 'Trần Thảo', 'Nam', NULL, '0930937112', 0, 'NV00000002', 0),
('KH00000040', 'Đinh Nhân', 'Nam', NULL, '0977355427', 0, 'NV00000002', 0),
('KH00000041', 'Nguyễn Hạnh Phượng', 'Nữ', NULL, '0993952739', 0, 'NV00000002', 0),
('KH00000042', 'Lý Nam', 'Nữ', NULL, '0956110293', 0, 'NV00000001', 0),
('KH00000043', 'Bùi Tùng', 'Nữ', NULL, '0947128239', 0, 'NV00000002', 0),
('KH00000044', 'Trần Nam', 'Nam', NULL, '0926208019', 0, 'NV00000001', 0),
('KH00000045', 'Ngô Bình', 'Nữ', NULL, '0947882754', 0, 'NV00000001', 0),
('KH00000046', 'Nguyễn Thế Linh', 'Nam', NULL, '0996183631', 0, 'NV00000002', 0),
('KH00000047', 'Nguyễn Quốc Chiến', 'Nam', NULL, '0927757206', 0, 'NV00000001', 0),
('KH00000048', 'Lý Yến', 'Nữ', NULL, '0996976680', 0, 'NV00000001', 0),
('KH00000049', 'Nguyễn Văn Khánh', 'Nữ', NULL, '0919031185', 0, 'NV00000002', 0),
('KH00000050', 'Trần Quốc An', 'Nam', NULL, '0946519152', 0, 'NV00000002', 0),
('KH00000051', 'Đào Phúc', 'Nữ', NULL, '0927997366', 0, 'NV00000002', 0),
('KH00000052', 'Đoàn Bình', 'Nữ', NULL, '0917522603', 0, 'NV00000002', 0),
('KH00000053', 'Nguyễn Thế Đạt', 'Nữ', NULL, '0941578608', 0, 'NV00000001', 0),
('KH00000054', 'Nguyễn Văn Bình', 'Nữ', NULL, '0943510168', 0, 'NV00000001', 0),
('KH00000055', 'Ngô Xuân', 'Nam', NULL, '0980498870', 0, 'NV00000001', 0),
('KH00000056', 'Bùi An', 'Nam', NULL, '0953657124', 0, 'NV00000002', 0),
('KH00000057', 'Nguyễn Văn Cường', 'Nữ', NULL, '0918922329', 0, 'NV00000002', 0),
('KH00000058', 'Nguyễn Văn Liên', 'Nữ', NULL, '0982346502', 0, 'NV00000002', 0),
('KH00000059', 'Nguyễn Thế Thủy', 'Nam', NULL, '0931855793', 0, 'NV00000002', 0),
('KH00000060', 'Đặng Minh', 'Nữ', NULL, '0976949186', 0, 'NV00000002', 0),
('KH00000061', 'Nguyễn Hoàng Mai', 'Nam', NULL, '0907040806', 0, 'NV00000001', 0),
('KH00000062', 'Đặng Quỳnh', 'Nữ', NULL, '0924465577', 0, 'NV00000001', 0),
('KH00000063', 'Trần Quốc Trí', 'Nữ', NULL, '0911433239', 0, 'NV00000001', 0),
('KH00000064', 'Vũ Mai', 'Nam', NULL, '0970964914', 0, 'NV00000001', 0),
('KH00000065', 'Bùi Tú', 'Nam', NULL, '0945250636', 0, 'NV00000001', 0),
('KH00000066', 'Nguyễn Hữu Thảo', 'Nữ', NULL, '0994517240', 0, 'NV00000002', 0),
('KH00000067', 'Nguyễn Thế Chiến', 'Nữ', NULL, '0944658115', 0, 'NV00000001', 0),
('KH00000068', 'Nguyễn Nhất Thành', 'Nữ', NULL, '0931853501', 0, 'NV00000002', 0),
('KH00000069', 'Nguyễn Hữu Linh', 'Nữ', NULL, '0957307154', 0, 'NV00000001', 0),
('KH00000070', 'Vương Cát', 'Nam', NULL, '0967845027', 0, 'NV00000002', 0),
('KH00000071', 'Nguyễn Quốc Hòa', 'Nam', NULL, '0988161926', 0, 'NV00000002', 0),
('KH00000072', 'Đỗ Tú', 'Nam', NULL, '0914798448', 0, 'NV00000002', 0),
('KH00000073', 'Phạm Sơn', 'Nam', NULL, '0985477941', 0, 'NV00000001', 0),
('KH00000074', 'Đinh Văn Nhân', 'Nam', NULL, '0955117891', 0, 'NV00000001', 0),
('KH00000075', 'Vương Quý', 'Nữ', NULL, '0988857842', 0, 'NV00000002', 0),
('KH00000076', 'Lê Nhân', 'Nữ', NULL, '0957848291', 0, 'NV00000001', 0),
('KH00000077', 'Phạm Bảo', 'Nữ', NULL, '0955617371', 0, 'NV00000001', 0),
('KH00000078', 'Đặng Xuân', 'Nam', NULL, '0967040354', 0, 'NV00000002', 0),
('KH00000079', 'Đinh Lan', 'Nữ', NULL, '0952081738', 0, 'NV00000002', 0),
('KH00000080', 'Đặng Ánh', 'Nam', NULL, '0968395776', 0, 'NV00000002', 0),
('KH00000081', 'Nguyễn Hoàng Thành', 'Nữ', NULL, '0975156671', 0, 'NV00000002', 0),
('KH00000082', 'Lê Đức', 'Nữ', NULL, '0949662149', 0, 'NV00000001', 0),
('KH00000083', 'Nguyễn Minh Đức', 'Nam', NULL, '0994387707', 0, 'NV00000001', 0),
('KH00000084', 'Lê Đạt', 'Nam', NULL, '0969106068', 0, 'NV00000002', 0),
('KH00000085', 'Trương Chiến', 'Nam', NULL, '0909668835', 0, 'NV00000001', 0),
('KH00000086', 'Nguyễn Minh Chiến', 'Nữ', NULL, '0951113835', 0, 'NV00000001', 0),
('KH00000087', 'Trương Hòa', 'Nữ', NULL, '0954374197', 0, 'NV00000002', 0),
('KH00000088', 'Bùi Nam', 'Nam', NULL, '0943848370', 0, 'NV00000002', 0),
('KH00000089', 'Nguyễn Nhất Cường', 'Nam', NULL, '0930432422', 0, 'NV00000001', 0),
('KH00000090', 'Trịnh Hưng', 'Nữ', NULL, '0957610404', 0, 'NV00000002', 0),
('KH00000091', 'Bùi Tú', 'Nữ', NULL, '0959164036', 0, 'NV00000001', 0),
('KH00000092', 'Nguyễn Minh Cát', 'Nữ', NULL, '0966317314', 0, 'NV00000001', 0),
('KH00000093', 'Lê Văn Đạt', 'Nam', NULL, '0966334592', 0, 'NV00000002', 0),
('KH00000094', 'Đào Hải', 'Nữ', NULL, '0903968186', 0, 'NV00000001', 0),
('KH00000095', 'Nguyễn Tiến Hương', 'Nam', NULL, '0994280460', 0, 'NV00000002', 0),
('KH00000096', 'Huỳnh Chiến', 'Nam', NULL, '0987008677', 0, 'NV00000001', 0),
('KH00000097', 'Nguyễn Hoàng Hưng', 'Nữ', NULL, '0933074255', 0, 'NV00000002', 0),
('KH00000098', 'Trương Sơn', 'Nam', NULL, '0900077351', 0, 'NV00000001', 0),
('KH00000099', 'Đinh Văn Cường', 'Nam', NULL, '0937352203', 0, 'NV00000002', 0),
('KH00000100', 'Trương An', 'Nữ', NULL, '0930574553', 0, 'NV00000002', 0),
('KH00000101', 'Nguyễn Quốc Quỳnh', 'Nữ', NULL, '0941679193', 0, 'NV00000001', 0),
('KH00000102', 'Trương Thành', 'Nữ', NULL, '0906920337', 0, 'NV00000001', 0),
('KH00000103', 'Đỗ Thủy', 'Nữ', NULL, '0980450363', 0, 'NV00000002', 0),
('KH00000104', 'Lê Cát', 'Nữ', NULL, '0904911392', 0, 'NV00000002', 0),
('KH00000105', 'Nguyễn Tiến Trí', 'Nữ', NULL, '0957549500', 0, 'NV00000002', 0),
('KH00000106', 'Vương Chiến', 'Nam', NULL, '0936074899', 0, 'NV00000002', 0),
('KH00000107', 'Nguyễn Hạnh Phúc', 'Nữ', NULL, '0984304521', 0, 'NV00000002', 0),
('KH00000108', 'Đỗ Ngọc', 'Nữ', NULL, '0924135389', 0, 'NV00000002', 0),
('KH00000109', 'Đỗ Ngọc', 'Nữ', NULL, '0951813324', 0, 'NV00000002', 0),
('KH00000110', 'Lê Văn Khánh', 'Nữ', NULL, '0963196074', 0, 'NV00000001', 0),
('KH00000111', 'Phạm Thủy', 'Nam', NULL, '0984971136', 0, 'NV00000002', 0),
('KH00000112', 'Ngô Yến', 'Nữ', NULL, '0910694470', 0, 'NV00000002', 0),
('KH00000113', 'Trần Quốc Oanh', 'Nữ', NULL, '0984538859', 0, 'NV00000001', 0),
('KH00000114', 'Nguyễn Minh Ninh', 'Nam', NULL, '0979092251', 0, 'NV00000001', 0),
('KH00000115', 'Vũ Vân', 'Nữ', NULL, '0973646522', 0, 'NV00000002', 0),
('KH00000116', 'Trương Tâm', 'Nữ', NULL, '0988374847', 0, 'NV00000001', 0),
('KH00000117', 'Nguyễn Hoàng Lan', 'Nam', NULL, '0999441204', 0, 'NV00000002', 0),
('KH00000118', 'Ngô Lan', 'Nam', NULL, '0961709180', 0, 'NV00000002', 0),
('KH00000119', 'Nguyễn Hữu Ánh', 'Nữ', NULL, '0957181269', 0, 'NV00000002', 0),
('KH00000120', 'Trịnh Tâm', 'Nữ', NULL, '0960347309', 0, 'NV00000002', 0),
('KH00000121', 'Trương Bảo', 'Nam', NULL, '0931056183', 0, 'NV00000002', 0),
('KH00000122', 'Trần Quốc Quý', 'Nam', NULL, '0923467380', 0, 'NV00000001', 0),
('KH00000123', 'Nguyễn Phú', 'Nữ', NULL, '0975647108', 0, 'NV00000001', 0),
('KH00000124', 'Nguyễn Hòa', 'Nam', NULL, '0947219604', 0, 'NV00000001', 0),
('KH00000125', 'Nguyễn Thế Dũng', 'Nữ', NULL, '0904622910', 0, 'NV00000002', 0),
('KH00000126', 'Trịnh Mai', 'Nam', NULL, '0969601218', 0, 'NV00000001', 0),
('KH00000127', 'Nguyễn Hạnh Nam', 'Nữ', NULL, '0961140334', 0, 'NV00000002', 0),
('KH00000128', 'Đỗ Thành', 'Nam', NULL, '0906168102', 0, 'NV00000002', 0),
('KH00000129', 'Đinh Văn Xuân', 'Nữ', NULL, '0946880999', 0, 'NV00000001', 0),
('KH00000130', 'Vũ Liên', 'Nữ', NULL, '0904179090', 0, 'NV00000001', 0),
('KH00000131', 'Trần Văn Linh', 'Nữ', NULL, '0996758198', 0, 'NV00000001', 0),
('KH00000132', 'Nguyễn Hưng', 'Nam', NULL, '0967871468', 0, 'NV00000001', 0),
('KH00000133', 'Đỗ Hải', 'Nữ', NULL, '0908665547', 0, 'NV00000001', 0),
('KH00000134', 'Lý Trí', 'Nam', NULL, '0964538438', 0, 'NV00000001', 0),
('KH00000135', 'Trần Quốc Mai', 'Nữ', NULL, '0962623446', 0, 'NV00000001', 0),
('KH00000136', 'Huỳnh Xuân', 'Nam', NULL, '0927033974', 0, 'NV00000002', 0),
('KH00000137', 'Nguyễn Thị Mai', 'Nam', NULL, '0964536044', 0, 'NV00000001', 0),
('KH00000138', 'Nguyễn Hữu Đức', 'Nam', NULL, '0915420422', 0, 'NV00000002', 0),
('KH00000139', 'Vương Cường', 'Nam', NULL, '0980518357', 0, 'NV00000002', 0),
('KH00000140', 'Nguyễn Hoàng Hải', 'Nữ', NULL, '0985007916', 0, 'NV00000001', 0),
('KH00000141', 'Ngô Đạt', 'Nữ', NULL, '0908675110', 0, 'NV00000001', 0),
('KH00000142', 'Nguyễn Trí', 'Nữ', NULL, '0917830267', 0, 'NV00000002', 0),
('KH00000143', 'Nguyễn Chiến', 'Nữ', NULL, '0942896023', 0, 'NV00000002', 0),
('KH00000144', 'Nguyễn Hữu Khánh', 'Nam', NULL, '0987022329', 0, 'NV00000002', 0),
('KH00000145', 'Lê Đức', 'Nam', NULL, '0976354250', 0, 'NV00000001', 0),
('KH00000146', 'Nguyễn Nhất Cát', 'Nữ', NULL, '0918893149', 0, 'NV00000002', 0),
('KH00000147', 'Vương Hải', 'Nữ', NULL, '0978056202', 0, 'NV00000001', 0),
('KH00000148', 'Nguyễn Hoàng Vũ', 'Nam', NULL, '0940341175', 0, 'NV00000002', 0),
('KH00000149', 'Đào Quý', 'Nam', NULL, '0906619928', 0, 'NV00000002', 0),
('KH00000150', 'Nguyễn Quốc Quý', 'Nữ', NULL, '0987317625', 0, 'NV00000001', 0),
('KH00000151', 'Nguyễn Tiến Ánh', 'Nam', NULL, '0982090061', 0, 'NV00000001', 0),
('KH00000152', 'Lý Tú', 'Nữ', NULL, '0921129035', 0, 'NV00000002', 0),
('KH00000153', 'Trương Quý', 'Nam', NULL, '0939894865', 0, 'NV00000002', 0),
('KH00000154', 'Nguyễn Hoàng Nhân', 'Nữ', NULL, '0999531587', 0, 'NV00000002', 0),
('KH00000155', 'Trương Linh', 'Nam', NULL, '0971038655', 0, 'NV00000001', 0),
('KH00000156', 'Nguyễn Thị Phú', 'Nữ', NULL, '0960828205', 0, 'NV00000002', 0),
('KH00000157', 'Nguyễn Thế Liên', 'Nam', NULL, '0999325963', 0, 'NV00000002', 0),
('KH00000158', 'Nguyễn Quốc Phúc', 'Nam', NULL, '0974903494', 0, 'NV00000002', 0),
('KH00000159', 'Đinh Ninh', 'Nam', NULL, '0997119514', 0, 'NV00000001', 0),
('KH00000160', 'Lý Minh', 'Nam', NULL, '0930218682', 0, 'NV00000001', 0),
('KH00000161', 'Nguyễn Hạnh Tâm', 'Nữ', NULL, '0906474892', 0, 'NV00000001', 0),
('KH00000162', 'Đặng Dũng', 'Nữ', NULL, '0954245209', 0, 'NV00000001', 0),
('KH00000163', 'Lê Văn Thủy', 'Nữ', NULL, '0917526697', 0, 'NV00000002', 0),
('KH00000164', 'Đinh Văn An', 'Nữ', NULL, '0958628246', 0, 'NV00000002', 0),
('KH00000165', 'Nguyễn Hạnh Đức', 'Nữ', NULL, '0973286895', 0, 'NV00000002', 0),
('KH00000166', 'Vương Ngọc', 'Nam', NULL, '0981376884', 0, 'NV00000002', 0),
('KH00000167', 'Nguyễn Hạnh Hòa', 'Nam', NULL, '0984033674', 0, 'NV00000001', 0),
('KH00000168', 'Phạm Yến', 'Nam', NULL, '0946698308', 0, 'NV00000002', 0),
('KH00000169', 'Trần Văn Mai', 'Nam', NULL, '0904004596', 0, 'NV00000001', 0),
('KH00000170', 'Lý Lan', 'Nữ', NULL, '0904577863', 0, 'NV00000002', 0),
('KH00000171', 'Lý Xuân', 'Nữ', NULL, '0939657433', 0, 'NV00000001', 0),
('KH00000172', 'Đinh Văn Tâm', 'Nam', NULL, '0991684145', 0, 'NV00000002', 0),
('KH00000173', 'Nguyễn Quốc Liên', 'Nữ', NULL, '0903802366', 0, 'NV00000002', 0),
('KH00000174', 'Nguyễn Hạnh Tùng', 'Nữ', NULL, '0913329580', 0, 'NV00000001', 0),
('KH00000175', 'Nguyễn Quốc Lan', 'Nữ', NULL, '0924278999', 0, 'NV00000002', 0),
('KH00000176', 'Nguyễn Tiến Ánh', 'Nam', NULL, '0948051193', 0, 'NV00000001', 0),
('KH00000177', 'Lê Văn Mai', 'Nữ', NULL, '0980069969', 0, 'NV00000002', 0),
('KH00000178', 'Nguyễn Hoàng Linh', 'Nam', NULL, '0914511110', 0, 'NV00000002', 0),
('KH00000179', 'Nguyễn Thị Phú', 'Nữ', NULL, '0941633894', 0, 'NV00000001', 0),
('KH00000180', 'Phạm Quỳnh', 'Nam', NULL, '0920025142', 0, 'NV00000002', 0),
('KH00000181', 'Nguyễn Tiến Ánh', 'Nữ', NULL, '0905617831', 0, 'NV00000002', 0),
('KH00000182', 'Huỳnh Thành', 'Nam', NULL, '0941784698', 0, 'NV00000001', 0),
('KH00000183', 'Nguyễn Hạnh Tùng', 'Nam', NULL, '0953667045', 0, 'NV00000002', 0),
('KH00000184', 'Nguyễn Tiến Quý', 'Nam', NULL, '0955644825', 0, 'NV00000002', 0),
('KH00000185', 'Trương Vũ', 'Nam', NULL, '0906559081', 0, 'NV00000002', 0),
('KH00000186', 'Trần Cường', 'Nam', NULL, '0983110799', 0, 'NV00000001', 0),
('KH00000187', 'Lý Hưng', 'Nữ', NULL, '0961805486', 0, 'NV00000002', 0),
('KH00000188', 'Trần An', 'Nữ', NULL, '0974676846', 0, 'NV00000001', 0),
('KH00000189', 'Vương Cát', 'Nam', NULL, '0971018188', 0, 'NV00000002', 0),
('KH00000190', 'Trịnh Hương', 'Nữ', NULL, '0921557304', 0, 'NV00000002', 0),
('KH00000191', 'Nguyễn Hạnh Vân', 'Nữ', NULL, '0946782720', 0, 'NV00000001', 0),
('KH00000192', 'Nguyễn Thị Phú', 'Nữ', NULL, '0930149828', 0, 'NV00000001', 0),
('KH00000193', 'Nguyễn Linh', 'Nữ', NULL, '0953958206', 0, 'NV00000002', 0),
('KH00000194', 'Đinh Cát', 'Nữ', NULL, '0951253682', 0, 'NV00000002', 0),
('KH00000195', 'Nguyễn Thế Linh', 'Nữ', NULL, '0983366030', 0, 'NV00000002', 0),
('KH00000196', 'Phan Chiến', 'Nam', NULL, '0970290901', 0, 'NV00000001', 0),
('KH00000197', 'Phạm Đạt', 'Nữ', NULL, '0973700073', 0, 'NV00000001', 0),
('KH00000198', 'Đào Khoa', 'Nữ', NULL, '0951299438', 0, 'NV00000002', 0),
('KH00000199', 'Trương Trí', 'Nữ', NULL, '0980550800', 0, 'NV00000001', 0),
('KH00000200', 'Nguyễn Hạnh Thành', 'Nam', NULL, '0935786362', 0, 'NV00000001', 0),
('KH00000201', 'Phan Trí', 'Nam', NULL, '0926891956', 0, 'NV00000001', 0),
('KH00000202', 'Bùi An', 'Nam', NULL, '0991768866', 0, 'NV00000001', 0),
('KH00000203', 'Đỗ Phú', 'Nam', NULL, '0995619594', 0, 'NV00000001', 0),
('KH00000204', 'Nguyễn Văn Linh', 'Nữ', NULL, '0915010115', 0, 'NV00000002', 0),
('KH00000205', 'Nguyễn Hạnh An', 'Nam', NULL, '0956528784', 0, 'NV00000001', 0),
('KH00000206', 'Nguyễn Tiến Hòa', 'Nữ', NULL, '0984110900', 0, 'NV00000001', 0),
('KH00000207', 'Bùi Trí', 'Nữ', NULL, '0944164291', 0, 'NV00000002', 0),
('KH00000208', 'Nguyễn Văn Hòa', 'Nữ', NULL, '0948054554', 0, 'NV00000002', 0),
('KH00000209', 'Đoàn Cường', 'Nữ', NULL, '0938505538', 0, 'NV00000001', 0),
('KH00000210', 'Trương Ngọc', 'Nữ', NULL, '0921619986', 0, 'NV00000002', 0),
('KH00000211', 'Lê Văn Quỳnh', 'Nam', NULL, '0956990125', 0, 'NV00000001', 0),
('KH00000212', 'Nguyễn Hạnh Đức', 'Nam', NULL, '0970790068', 0, 'NV00000001', 0),
('KH00000213', 'Trần Xuân', 'Nam', NULL, '0938960734', 0, 'NV00000002', 0),
('KH00000214', 'Nguyễn Quốc Bình', 'Nữ', NULL, '0989078315', 0, 'NV00000001', 0),
('KH00000215', 'Lê Văn Bình', 'Nữ', NULL, '0996543502', 0, 'NV00000002', 0),
('KH00000216', 'Trịnh Tùng', 'Nam', NULL, '0946141566', 0, 'NV00000001', 0),
('KH00000217', 'Bùi Quỳnh', 'Nữ', NULL, '0984077633', 0, 'NV00000002', 0),
('KH00000218', 'Bùi Hương', 'Nữ', NULL, '0909859475', 0, 'NV00000002', 0),
('KH00000219', 'Trần Văn Tâm', 'Nữ', NULL, '0943181839', 0, 'NV00000002', 0),
('KH00000220', 'Nguyễn Văn Phú', 'Nam', 'Hồ Chí Minh', '0982665977', 0, 'NV00000001', 0);

-- --------------------------------------------------------

--
-- Table structure for table `khuyenmai`
--

DROP TABLE IF EXISTS `khuyenmai`;
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `MaKhuyenMai` varchar(10) NOT NULL,
  `ChuDe` text,
  `MoTa` text,
  `PhanTram` double DEFAULT NULL,
  `DieuKien` int DEFAULT NULL,
  `BatDau` datetime DEFAULT NULL,
  `KetThuc` datetime DEFAULT NULL,
  `MaNhanVien` varchar(10) DEFAULT NULL,
  `TrangThai` int DEFAULT '1',
  PRIMARY KEY (`MaKhuyenMai`),
  KEY `MaNhanVien` (`MaNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKhuyenMai`, `ChuDe`, `MoTa`, `PhanTram`, `DieuKien`, `BatDau`, `KetThuc`, `MaNhanVien`, `TrangThai`) VALUES
('KM00000001', 'Khuyến mãi 20% cho 4 món', NULL, 0.2, 4, '2024-10-05 07:49:00', '2024-10-06 07:49:00', 'NV00000001', 0),
('KM00000002', 'Khuyến mãi 10% cho 2 món', 'Nhân ngày buồn', 0.1, 2, '2024-10-07 07:50:00', '2024-10-09 07:50:00', 'NV00000001', 0),
('KM00000003', 'Khuyến mãi 20% cho 1 món', NULL, 0.1, 1, '2024-10-05 10:49:00', '2024-10-06 10:48:00', 'NV00000001', 0),
('KM00000004', 'Khuyến mãi 10% cho 2 món', NULL, 0.1, 2, '2024-10-26 16:33:00', '2024-11-01 16:32:00', 'NV00000001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loainhanvien`
--

DROP TABLE IF EXISTS `loainhanvien`;
CREATE TABLE IF NOT EXISTS `loainhanvien` (
  `MaLoaiNhanVien` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `TenLoaiNhanVien` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`MaLoaiNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loainhanvien`
--

INSERT INTO `loainhanvien` (`MaLoaiNhanVien`, `TenLoaiNhanVien`) VALUES
('LNV0000001', 'Quản lý'),
('LNV0000002', 'Bình thường');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `MaNhanVien` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `TenNhanVien` varchar(100) DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `DiaChi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `SoDienThoai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `MatKhau` text,
  `GhiChu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `HinhAnh` text,
  `MaLoaiNhanVien` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `TrangThai` int DEFAULT '1',
  `TrangThaiHoatDong` enum('Online','Offline') NOT NULL DEFAULT 'Offline',
  PRIMARY KEY (`MaNhanVien`),
  KEY `MaLoaiNhanVien` (`MaLoaiNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNhanVien`, `TenNhanVien`, `NgaySinh`, `DiaChi`, `SoDienThoai`, `Email`, `MatKhau`, `GhiChu`, `HinhAnh`, `MaLoaiNhanVien`, `TrangThai`, `TrangThaiHoatDong`) VALUES
('NV00000001', 'Nguyễn Trọng Nam', '2003-06-27', 'Quảng Ngãi', '0902599450', 'nam@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, 'LNV0000001', 1, 'Online'),
('NV00000002', 'Phạm Minh Thông', '2003-03-02', '', '0799316511', '', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, 'LNV0000002', 0, 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien_token`
--

DROP TABLE IF EXISTS `nhanvien_token`;
CREATE TABLE IF NOT EXISTS `nhanvien_token` (
  `MaNhanVien` varchar(10) NOT NULL,
  `Token` varchar(64) NOT NULL,
  `HoatDongCuoi` datetime NOT NULL,
  `KetThucPhien` datetime NOT NULL,
  PRIMARY KEY (`MaNhanVien`),
  UNIQUE KEY `Token` (`Token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nhanvien_token`
--

INSERT INTO `nhanvien_token` (`MaNhanVien`, `Token`, `HoatDongCuoi`, `KetThucPhien`) VALUES
('NV00000001', '08d301455c73b7c798a072aee14c22c7', '2024-10-28 21:31:39', '2024-10-28 22:01:39');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doanuong`
--
ALTER TABLE `doanuong`
  ADD CONSTRAINT `doanuong_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKhuyenMai`) REFERENCES `khuyenmai` (`MaKhuyenMai`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`MaKhachHang`) REFERENCES `khachhang` (`MaKhachHang`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  ADD CONSTRAINT `donhangchitiet_ibfk_1` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `donhangchitiet_ibfk_2` FOREIGN KEY (`MaDoAnUong`) REFERENCES `doanuong` (`MaDoAnUong`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD CONSTRAINT `khuyenmai_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`MaLoaiNhanVien`) REFERENCES `loainhanvien` (`MaLoaiNhanVien`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `nhanvien_token`
--
ALTER TABLE `nhanvien_token`
  ADD CONSTRAINT `nhanvien_token_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
