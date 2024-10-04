-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 04, 2024 at 12:11 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `doanuong`
--

DROP TABLE IF EXISTS `doanuong`;
CREATE TABLE IF NOT EXISTS `doanuong` (
  `MaDoAnUong` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Ten` varchar(100) DEFAULT NULL,
  `Gia` decimal(10,2) DEFAULT NULL,
  `DonVi` enum('đĩa','bát','lon','chai','ly') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MoTa` text,
  `Loai` enum('Đồ ăn','Đồ uống') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `MaNhanVien` varchar(10) NOT NULL,
  `TrangThai` int DEFAULT '1',
  PRIMARY KEY (`MaDoAnUong`),
  KEY `MaNhanVien` (`MaNhanVien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doanuong`
--

INSERT INTO `doanuong` (`MaDoAnUong`, `Ten`, `Gia`, `DonVi`, `MoTa`, `Loai`, `MaNhanVien`, `TrangThai`) VALUES
('AU00000001', 'Cơm sườn nướng', 50000.00, 'đĩa', 'Cơm tấm sườn nướng thơm ngon', 'Đồ ăn', 'NV00000001', 1),
('AU00000002', 'Cơm gà xối mỡ', 45000.00, 'đĩa', 'Cơm gà xối mỡ giòn rụm', 'Đồ ăn', 'NV00000001', 1),
('AU00000003', 'Cơm rang dưa bò', 40000.00, 'đĩa', 'Cơm rang với dưa chua và thịt bò mềm', 'Đồ ăn', 'NV00000001', 1),
('AU00000004', 'Cơm chiên hải sản', 60000.00, 'đĩa', 'Cơm chiên kết hợp hải sản tươi ngon', 'Đồ ăn', 'NV00000001', 1),
('AU00000005', 'Canh chua cá', 30000.00, 'bát', 'Canh chua cá lóc đậm đà vị miền Nam', 'Đồ ăn', 'NV00000001', 1),
('AU00000006', 'Cơm đùi gà chiên giòn', 55000.00, 'đĩa', 'Đùi gà chiên giòn kèm cơm trắng', 'Đồ ăn', 'NV00000001', 1),
('AU00000007', 'Cơm cá kho tộ', 50000.00, 'đĩa', 'Cơm kèm cá kho tộ đặc trưng', 'Đồ ăn', 'NV00000001', 1),
('AU00000008', 'Cơm thịt kho trứng', 45000.00, 'đĩa', 'Thịt kho trứng cùng cơm trắng', 'Đồ ăn', 'NV00000001', 1),
('AU00000009', 'Cơm gà xé phay', 48000.00, 'đĩa', 'Gà xé phay trộn gỏi kèm cơm', 'Đồ ăn', 'NV00000001', 1),
('AU00000010', 'Canh bí đỏ nấu tôm', 25000.00, 'bát', 'Canh bí đỏ bổ dưỡng nấu tôm', 'Đồ ăn', 'NV00000001', 1),
('AU00000011', 'Cơm chiên trứng', 35000.00, 'đĩa', 'Cơm chiên với trứng gà vàng ươm', 'Đồ ăn', 'NV00000001', 1),
('AU00000012', 'Cơm gà luộc', 48000.00, 'đĩa', 'Gà luộc kèm cơm trắng và nước chấm', 'Đồ ăn', 'NV00000001', 1),
('AU00000013', 'Canh rau ngót thịt băm', 20000.00, 'bát', 'Canh rau ngót nấu thịt băm', 'Đồ ăn', 'NV00000001', 1),
('AU00000014', 'Cơm rang thập cẩm', 50000.00, 'đĩa', 'Cơm rang kết hợp nhiều loại nguyên liệu', 'Đồ ăn', 'NV00000001', 1),
('AU00000015', 'Cơm cá chiên', 45000.00, 'đĩa', 'Cơm cá chiên giòn rụm', 'Đồ ăn', 'NV00000001', 1),
('AU00000016', 'Cơm sườn cốt lết', 55000.00, 'đĩa', 'Sườn cốt lết nướng kèm cơm trắng', 'Đồ ăn', 'NV00000001', 1),
('AU00000017', 'Canh bầu nấu tôm', 25000.00, 'bát', 'Canh bầu thanh mát nấu với tôm', 'Đồ ăn', 'NV00000001', 1),
('AU00000018', 'Cơm bò xào sả ớt', 50000.00, 'đĩa', 'Cơm bò xào sả ớt đậm đà', 'Đồ ăn', 'NV00000001', 1),
('AU00000019', 'Cơm chay rau củ', 40000.00, 'đĩa', 'Cơm chay với rau củ tươi ngon', 'Đồ ăn', 'NV00000001', 1),
('AU00000020', 'Canh cải nấu thịt', 20000.00, 'bát', 'Canh cải thanh mát nấu thịt bằm', 'Đồ ăn', 'NV00000001', 1),
('AU00000021', 'Trà đá', 5000.00, 'ly', 'Trà đá mát lạnh', 'Đồ uống', 'NV00000001', 1),
('AU00000022', 'Nước ngọt Coca-Cola', 15000.00, 'lon', 'Coca-Cola giải khát', 'Đồ uống', 'NV00000001', 1),
('AU00000023', 'Nước ngọt Pepsi', 15000.00, 'lon', 'Pepsi tươi mát', 'Đồ uống', 'NV00000001', 1),
('AU00000024', 'Nước cam ép', 30000.00, 'ly', 'Nước cam tươi mát giàu vitamin C', 'Đồ uống', 'NV00000001', 1),
('AU00000025', 'Cà phê đen', 20000.00, 'ly', 'Cà phê đen đậm đà', 'Đồ uống', 'NV00000001', 1),
('AU00000026', 'Cà phê sữa', 25000.00, 'ly', 'Cà phê sữa ngọt béo', 'Đồ uống', 'NV00000001', 1),
('AU00000027', 'Sinh tố xoài', 35000.00, 'ly', 'Sinh tố xoài tươi mát', 'Đồ uống', 'NV00000001', 1),
('AU00000028', 'Sinh tố bơ', 35000.00, 'ly', 'Sinh tố bơ thơm ngon, béo ngậy', 'Đồ uống', 'NV00000001', 1),
('AU00000029', 'Nước chanh', 20000.00, 'ly', 'Nước chanh tươi mát', 'Đồ uống', 'NV00000001', 1),
('AU00000030', 'Trà sữa trân châu', 30000.00, 'ly', 'Trà sữa với trân châu đen', 'Đồ uống', 'NV00000001', 1),
('AU00000031', 'Nước táo ép', 30000.00, 'ly', '', 'Đồ uống', 'NV00000001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `MaDonHang` varchar(10) NOT NULL,
  `NgayLap` datetime DEFAULT CURRENT_TIMESTAMP,
  `MaKhachHang` varchar(10) DEFAULT NULL,
  `TichDiemSuDung` int DEFAULT NULL,
  `MaNhanVien` varchar(10) DEFAULT NULL,
  `MaKhuyenMai` varchar(10) DEFAULT NULL,
  `TongTien` decimal(12,0) DEFAULT NULL,
  `TrangThai` int DEFAULT '1',
  PRIMARY KEY (`MaDonHang`),
  KEY `MaKhuyenMai` (`MaKhuyenMai`),
  KEY `MaNhanVien` (`MaNhanVien`),
  KEY `MaKhachHang` (`MaKhachHang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `NgayLap`, `MaKhachHang`, `TichDiemSuDung`, `MaNhanVien`, `MaKhuyenMai`, `TongTien`, `TrangThai`) VALUES
('DH00000002', '2024-10-03 22:56:38', 'KH00000001', 0, 'NV00000001', NULL, 70000, 1);

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
('DH00000002', 'AU00000031', 1, ''),
('DH00000002', 'AU00000019', 1, '');

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
('KH00000001', 'Nguyễn Văn Minh', 'Nam', NULL, '0901234561', 70, 'NV00000001', 1),
('KH00000002', 'Trần Thị Hoa', 'Nữ', NULL, '0901234562', 0, 'NV00000001', 1),
('KH00000003', 'Lê Hoàng Phát', 'Nam', NULL, '0901234563', 0, 'NV00000001', 1),
('KH00000004', 'Phạm Thị Lan', 'Nữ', NULL, '0901234564', 0, 'NV00000001', 1),
('KH00000005', 'Đoàn Văn Tâm', 'Nam', NULL, '0901234565', 0, 'NV00000001', 1),
('KH00000006', 'Bùi Thị Mai', 'Nữ', NULL, '0901234566', 0, 'NV00000001', 1),
('KH00000007', 'Phan Văn Thành', 'Nam', NULL, '0901234567', 0, 'NV00000001', 1),
('KH00000008', 'Ngô Thị Hà', 'Nữ', NULL, '0901234568', 0, 'NV00000001', 1),
('KH00000009', 'Vũ Văn Nam', 'Nam', NULL, '0901234569', 0, 'NV00000001', 1),
('KH00000010', 'Nguyễn Thị Kim', 'Nữ', NULL, '0901234570', 0, 'NV00000001', 1),
('KH00000011', 'Lê Văn Bảo', 'Nam', NULL, '0901234571', 0, 'NV00000001', 1),
('KH00000012', 'Phạm Thị Cúc', 'Nữ', NULL, '0901234572', 0, 'NV00000001', 1),
('KH00000013', 'Hoàng Văn Dũng', 'Nam', NULL, '0901234573', 0, 'NV00000001', 1),
('KH00000014', 'Đặng Thị Hương', 'Nữ', NULL, '0901234574', 0, 'NV00000001', 1),
('KH00000015', 'Nguyễn Văn Hùng', 'Nam', NULL, '0901234575', 0, 'NV00000001', 1),
('KH00000016', 'Lê Thị Ngọc', 'Nữ', NULL, '0901234576', 0, 'NV00000001', 1),
('KH00000017', 'Phạm Văn Khánh', 'Nam', NULL, '0901234577', 0, 'NV00000001', 1),
('KH00000018', 'Trần Thị Thu', 'Nữ', NULL, '0901234578', 0, 'NV00000001', 1),
('KH00000019', 'Nguyễn Văn An', 'Nam', NULL, '0901234579', 0, 'NV00000001', 1),
('KH00000020', 'Lê Thị Thảo', 'Nữ', NULL, '0901234580', 0, 'NV00000001', 0);

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
('', 'Khuyến mãi 20% cho 4 món', NULL, 0.2, 4, '2024-10-04 18:13:00', '2024-10-05 18:13:00', 'NV00000001', 1);

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
  `GhiChu` text,
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
('NV00000001', 'Nguyễn Trọng Nam', '2003-06-27', NULL, '0902599450', NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, 'LNV0000001', 1, 'Online');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
