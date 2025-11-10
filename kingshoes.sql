-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2025 at 03:40 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kingshoes`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresscustomer`
--

DROP TABLE IF EXISTS `addresscustomer`;
CREATE TABLE IF NOT EXISTS `addresscustomer` (
  `idAddress` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCustomer` int UNSIGNED NOT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PhoneNumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CustomerName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAddress`),
  KEY `idCustomer` (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresscustomer`
--

INSERT INTO `addresscustomer` (`idAddress`, `idCustomer`, `Address`, `Email`, `PhoneNumber`, `CustomerName`, `created_at`, `updated_at`) VALUES
(28, 41, '180 Cao Lỗ,P4, Q8,TP.HCM', '', '0907164502', 'Nguyên', '2025-07-21 12:38:08', '2025-07-21 12:38:33'),
(29, 41, '47 cao lo, p4 ,q8, tp hcm', '', '0903633152', 'Đức Nguyên', '2025-08-04 09:07:08', '2025-08-04 09:07:08'),
(33, 46, 'C19/11 đường số 9, Khu dân cư Trung Sơn', '', '0707035451', 'NGUYEN VAN A', '2025-11-01 05:48:28', '2025-11-01 05:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idAdmin` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `AdminName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AdminUser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AdminPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NumberPhone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmin`, `AdminName`, `AdminUser`, `AdminPass`, `Position`, `Address`, `NumberPhone`, `Email`, `Avatar`, `created_at`, `updated_at`) VALUES
(5, 'Trần Đình Khoa', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Quản Lý', '480 Cao Lỗ, P4, Q8, TP.HCM', '0707035451', 't.khoa0912@gmail.com', NULL, '2025-02-10 02:37:48', '2025-10-14 21:31:25'),
(7, 'nhanvien1', 'nhanvien1', 'e9f43faa08c00e9bb178fe5bc66d9c46', 'Nhân Viên', '180 cao lo ,p4 q,8', '0971707422', 'nv1@gmail.com', NULL, '2025-07-22 05:53:28', '2025-07-22 05:53:28');

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE IF NOT EXISTS `attribute` (
  `idAttribute` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `AttributeName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAttribute`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`idAttribute`, `AttributeName`, `created_at`, `updated_at`) VALUES
(6, 'Kích cỡ', '2025-02-10 04:37:11', '2025-06-19 08:15:35'),
(7, 'Màu sắc', '2025-06-19 08:15:24', '2025-06-19 08:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_value`
--

DROP TABLE IF EXISTS `attribute_value`;
CREATE TABLE IF NOT EXISTS `attribute_value` (
  `idAttrValue` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idAttribute` int UNSIGNED NOT NULL,
  `AttrValName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAttrValue`),
  KEY `idAttribute` (`idAttribute`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_value`
--

INSERT INTO `attribute_value` (`idAttrValue`, `idAttribute`, `AttrValName`, `created_at`, `updated_at`) VALUES
(55, 6, '35', '2025-02-10 04:37:35', '2025-06-26 04:11:04'),
(56, 6, '36', '2025-02-10 04:38:16', '2025-06-26 04:11:10'),
(57, 6, '37', '2025-02-10 04:38:25', '2025-06-26 04:11:15'),
(58, 7, 'Màu đỏ', '2025-06-19 08:16:30', '2025-06-19 08:16:30'),
(59, 7, 'Màu đen', '2025-06-23 12:49:57', '2025-06-23 12:49:57'),
(60, 7, 'Màu trắng', '2025-06-23 12:50:08', '2025-06-23 12:50:08'),
(61, 6, '38', '2025-06-26 04:11:31', '2025-06-26 04:11:31'),
(62, 6, '39', '2025-06-26 04:11:44', '2025-06-26 04:11:44'),
(63, 6, '40', '2025-06-26 04:11:51', '2025-06-26 04:11:51'),
(64, 6, '41', '2025-06-26 04:11:57', '2025-06-26 04:11:57'),
(65, 6, '42', '2025-06-26 04:12:03', '2025-06-26 04:12:03'),
(66, 7, 'Màu trắng đen', '2025-06-26 05:48:35', '2025-06-26 05:52:04'),
(67, 7, 'Màu xám', '2025-06-26 05:49:04', '2025-06-26 05:52:13'),
(68, 7, 'Màu hồng', '2025-06-26 05:49:11', '2025-06-26 05:52:23'),
(69, 7, 'Màu xanh lá', '2025-06-26 05:49:47', '2025-06-26 05:52:35'),
(70, 7, 'Màu xanh', '2025-06-26 07:17:48', '2025-06-26 07:17:48'),
(71, 6, '26', '2025-06-26 07:29:29', '2025-06-26 07:29:29'),
(72, 6, '27', '2025-06-26 07:29:35', '2025-06-26 07:29:35'),
(73, 6, '28', '2025-06-26 07:29:41', '2025-06-26 07:29:41'),
(74, 7, 'Màu nâu', '2025-06-26 07:33:36', '2025-06-26 07:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `idBill` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCustomer` int UNSIGNED NOT NULL,
  `Payment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `Voucher` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PhoneNumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CustomerName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReceiveDate` datetime DEFAULT NULL,
  `Status` tinyint NOT NULL DEFAULT '0',
  `TotalBill` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idBill`),
  KEY `idCustomer` (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`idBill`, `idCustomer`, `Payment`, `Voucher`, `Address`, `PhoneNumber`, `CustomerName`, `ReceiveDate`, `Status`, `TotalBill`, `created_at`, `updated_at`) VALUES
(96, 41, 'vnpay', '', '47 Cao lỗ, P4,Q8,TP.HCM', '0907164502', 'Nguyên', '2025-07-19 17:21:05', 2, 1615000, '2025-07-18 11:32:49', '2025-07-19 10:21:05'),
(97, 41, 'cash', NULL, '180 Cao Lỗ,P4, Q8,TP.HCM', '0907164502', 'Nguyên', NULL, 99, 1290000, '2025-07-21 12:38:43', '2025-07-21 12:39:02'),
(99, 41, 'vnpay', '10-1-20', '180 Cao Lỗ,P4, Q8,TP.HCM', '0907164502', 'Nguyên', '2025-07-21 21:01:17', 2, 1032000, '2025-07-21 13:54:38', '2025-07-21 14:01:17'),
(100, 41, 'cash', NULL, '180 Cao Lỗ,P4, Q8,TP.HCM', '0907164502', 'Nguyên', '2025-07-22 14:17:11', 2, 3230000, '2025-07-22 07:16:18', '2025-07-22 07:17:11'),
(101, 41, 'vnpay', '9-2-30000', '47 cao lo, p4 ,q8, tp hcm', '0903633152', 'Đức Nguyên', '2025-08-04 16:41:30', 2, 750000, '2025-08-04 09:36:49', '2025-08-04 09:41:30'),
(102, 41, 'cash', NULL, '180 Cao Lỗ,P4, Q8,TP.HCM', '0907164502', 'Nguyên', '2025-08-04 17:43:49', 2, 2810000, '2025-08-04 09:42:59', '2025-08-04 10:43:49'),
(103, 45, 'vnpay', '8-2-100000', '34/2b Hưng Thạnh TPHCM', '0707035451', 'Trần Đình Khoa', '2025-10-15 09:07:00', 2, 3569000, '2025-10-15 02:06:23', '2025-10-15 02:07:00'),
(105, 45, 'cash', NULL, '34/2b Hưng Thạnh TPHCM', '0707035451', 'Trần Đình Khoa', '2025-10-22 08:30:48', 2, 1615000, '2025-10-22 01:29:49', '2025-10-22 01:30:48'),
(106, 45, 'cash', NULL, '34/2b Hưng Thạnh TPHCM', '0707035451', 'Trần Đình Khoa', NULL, 1, 1615000, '2025-10-22 01:42:33', '2025-11-09 09:11:54'),
(107, 46, 'cash', NULL, 'C19/11 đường số 9, Khu dân cư Trung Sơn', '0707035451', 'NGUYEN VAN A', '2025-11-01 12:49:55', 2, 780000, '2025-11-01 05:48:53', '2025-11-01 05:49:55'),
(114, 45, 'cash', NULL, '34/2b Hưng Thạnh TPHCM', '12034422313', 'Trần Đình Khoa', NULL, 0, 1290000, '2025-11-09 15:00:56', '2025-11-09 15:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `billhistory`
--

DROP TABLE IF EXISTS `billhistory`;
CREATE TABLE IF NOT EXISTS `billhistory` (
  `idBill` int UNSIGNED NOT NULL,
  `AdminName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `idBill` (`idBill`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billhistory`
--

INSERT INTO `billhistory` (`idBill`, `AdminName`, `Status`, `created_at`, `updated_at`) VALUES
(96, 'System', 1, '2025-07-18 11:32:49', '2025-07-18 11:32:49'),
(97, 'Nguyễn Đức Nguyên', 99, '2025-07-21 12:39:02', '2025-07-21 12:39:02'),
(99, 'System', 1, '2025-07-21 13:54:38', '2025-07-21 13:54:38'),
(100, 'Nguyễn Đức Nguyên', 1, '2025-07-22 07:16:46', '2025-07-22 07:16:46'),
(101, 'System', 1, '2025-08-04 09:36:49', '2025-08-04 09:36:49'),
(102, 'Nguyễn Đức Nguyên', 1, '2025-08-04 09:43:39', '2025-08-04 09:43:39'),
(103, 'System', 1, '2025-10-15 02:06:23', '2025-10-15 02:06:23'),
(105, 'Trần Đình Khoa', 1, '2025-10-22 01:30:31', '2025-10-22 01:30:31'),
(107, 'Trần Đình Khoa', 1, '2025-11-01 05:49:20', '2025-11-01 05:49:20'),
(106, 'Trần Đình Khoa', 1, '2025-11-09 09:11:55', '2025-11-09 09:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `billinfo`
--

DROP TABLE IF EXISTS `billinfo`;
CREATE TABLE IF NOT EXISTS `billinfo` (
  `idBill` int UNSIGNED NOT NULL,
  `idProduct` int UNSIGNED NOT NULL,
  `AttributeProduct` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Price` int NOT NULL,
  `QuantityBuy` int NOT NULL,
  `idProAttr` int DEFAULT NULL,
  `proAttr` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `idBill` (`idBill`),
  KEY `idProduct` (`idProduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billinfo`
--

INSERT INTO `billinfo` (`idBill`, `idProduct`, `AttributeProduct`, `Price`, `QuantityBuy`, `idProAttr`, `proAttr`, `created_at`, `updated_at`) VALUES
(96, 100, 'undefined: undefined', 1615000, 1, 501, 501, '2025-07-18 11:32:49', '2025-07-18 11:32:49'),
(99, 123, 'undefined: undefined', 1290000, 1, 576, 576, '2025-07-21 13:54:38', '2025-07-21 13:54:38'),
(100, 100, 'undefined: undefined', 1615000, 2, NULL, 501, '2025-07-22 07:16:18', '2025-07-22 07:16:18'),
(105, 100, 'undefined: undefined', 1615000, 1, NULL, 503, '2025-10-22 01:29:49', '2025-10-22 01:29:49'),
(106, 100, 'undefined: undefined', 1615000, 1, NULL, 501, '2025-10-22 01:42:33', '2025-10-22 01:42:33'),
(114, 123, 'undefined: undefined', 1290000, 1, NULL, 575, '2025-11-09 15:00:56', '2025-11-09 15:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `idBlog` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `BlogContent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` tinyint NOT NULL DEFAULT '1',
  `BlogDesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BlogTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BlogSlug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BlogImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idBlog`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`idBlog`, `BlogContent`, `Status`, `BlogDesc`, `BlogTitle`, `BlogSlug`, `BlogImage`, `created_at`, `updated_at`) VALUES
(8, '<h2 dir=\"ltr\"><strong>Kh&aacute;m ph&aacute; sự mới lạ trong phong c&aacute;ch Cyberpunk&nbsp;</strong></h2>\r\n\r\n<p dir=\"ltr\">Như đ&atilde; nhắc ở tr&ecirc;n,&nbsp;<a href=\"https://drake.vn/converse/converse-chuck-taylor-all-star-future-utility-a05552c\">Converse Chuck Taylor All Star Future Utility</a>&nbsp;được lấy &yacute; tưởng từ phong c&aacute;ch Cyberpunk. Phong c&aacute;ch Cyberpunk lấy bối cảnh từ một tương lai đen tối, nơi c&ocirc;ng nghệ ti&ecirc;n tiến đan xen với sự suy đồi đạo đức v&agrave; tầng lớp x&atilde; hội bị ph&acirc;n h&oacute;a r&otilde; rệt. N&oacute; thường thể hiện sự phản kh&aacute;ng chống lại sự &aacute;p bức của c&aacute;c tập đo&agrave;n lớn v&agrave; ch&iacute;nh phủ, đồng thời đề cao chủ nghĩa c&aacute; nh&acirc;n v&agrave; sự tự do. Biểu hiện của văn h&oacute;a x&atilde; hội, phản &aacute;nh mối quan hệ phức tạp giữa con người v&agrave; c&ocirc;ng nghệ trong tương lai.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-09.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Với sự kết hợp giữa c&ocirc;ng nghệ v&agrave; xu hướng tương lai, phong c&aacute;ch Cyberpunk thể hiện sự c&aacute; t&iacute;nh v&agrave; phản &aacute;nh r&otilde; n&eacute;t những gi&aacute; trị x&atilde; hội. Phong c&aacute;ch n&agrave;y xuất hiện từ thập ni&ecirc;n 1980 v&agrave; 1990, xuất ph&aacute;t từ c&aacute;c t&aacute;c phẩm văn học, tiểu thuyết, tr&ograve; chơi điện tử thuộc thể loại khoa học viễn tưởng v&agrave; phim truyền h&igrave;nh như &quot;Neuromancer&quot; của William Gibson v&agrave; &quot;Snow Crash&quot; của Neal Stephenson, cũng như c&aacute;c bộ phim như &quot;Blade Runner&quot; v&agrave; &quot;The Matrix&quot;.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-10.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Phong c&aacute;ch Cyberpunk đem lại l&agrave;n gi&oacute; mới mẻ v&agrave; đầy s&aacute;ng tạo th&ocirc;ng qua sự giao thoa giữa c&ocirc;ng nghệ cao v&agrave; thế giới viễn tưởng. Với những gam m&agrave;u tương phản mạnh mẽ v&agrave; c&aacute;c thiết kế ph&aacute; c&aacute;ch, phong c&aacute;ch n&agrave;y t&ocirc;n vinh c&aacute; t&iacute;nh ri&ecirc;ng biệt v&agrave; đem đến g&oacute;c nh&igrave;n s&acirc;u sắc về x&atilde; hội hiện đại. B&ecirc;n cạnh đ&oacute; c&ograve;n thể hiện sự t&aacute;o bạo v&agrave; sẵn s&agrave;ng th&aacute;ch thức c&aacute;c chuẩn mực thời trang b&igrave;nh thường, mang đến cho người mang cơ hội được bộc lộ bản th&acirc;n một c&aacute;ch mạnh mẽ v&agrave; kh&aacute;c biệt.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-11.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<h2 dir=\"ltr\"><strong>Converse Chuck Taylor All Star Future Utility kho&aacute;c tr&ecirc;n m&igrave;nh tấm &aacute;o độc đ&aacute;o v&agrave; mới lạ</strong></h2>\r\n\r\n<p dir=\"ltr\">Converse Chuck Taylor All Star Future Utility sử dụng phối m&agrave;u Engine Smoke/Black/Magic Flame đ&uacute;ng với tinh thần Cyberpunk mang đến một diện mạo nổi bật v&agrave; cuốn h&uacute;t, ho&agrave;n hảo cho những ai đam m&ecirc; phong c&aacute;ch c&aacute; t&iacute;nh mạnh mẽ. Phối m&agrave;u gợi l&ecirc;n h&igrave;nh ảnh của động cơ v&agrave; m&aacute;y m&oacute;c c&ocirc;ng nghiệp, mang đến cảm gi&aacute;c mạnh mẽ v&agrave; bền bỉ, thể hiện sức mạnh v&agrave; sự ki&ecirc;n cường.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-02.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Điểm nhấn l&agrave; chiếc logo tr&ograve;n b&ecirc;n h&ocirc;ng th&acirc;n gi&agrave;y được điểm xuyết tone m&agrave;u cam nổi bật l&ecirc;n từng chi tiết. Tone m&agrave;u gợi l&ecirc;n ngọn lửa ma thuật, biểu trưng cho sự s&aacute;ng tạo v&agrave; niềm đam m&ecirc; m&atilde;nh liệt. Th&ecirc;m một chi tiết nhỏ chắc hẳn kh&ocirc;ng phải ai cũng nh&igrave;n thấy, đ&oacute; ch&iacute;nh l&agrave; khoen xỏ d&acirc;y v&agrave; d&acirc;y gi&agrave;y đều đồng m&agrave;u với upper gi&agrave;y nhưng ở lỗ xỏ d&acirc;y cuối c&ugrave;ng lại mang tone m&agrave;u đen kh&aacute;c biệt. B&ecirc;n h&ocirc;ng th&acirc;n gi&agrave;y được bố tr&iacute; th&ecirc;m hai lỗ nhỏ tho&aacute;ng kh&iacute;, gi&uacute;p cho đ&ocirc;i ch&acirc;n của bạn thoải m&aacute;i suốt ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng lo bị hầm b&iacute;, kh&oacute; chịu.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-05.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">B&ecirc;n cạnh đ&oacute;, đối xứng với Patch Logo tr&ograve;n l&agrave; miếng tape được d&aacute;n chắc chắn b&ecirc;n h&ocirc;ng gi&agrave;y. Bạn c&oacute; thể thấy tr&ecirc;n miếng tape đ&oacute; l&agrave; tọa độ của n&uacute;i - h&igrave;nh ảnh quen thuộc được khắc họa tr&ecirc;n c&aacute;c sản phẩm của&nbsp;<a href=\"https://drake.vn/converse\">Converse</a>.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-01.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Vẫn giữ vững kiểu d&aacute;ng cổ cao đặc trưng của d&ograve;ng gi&agrave;y Converse v&agrave; ho&agrave;n thiện với chất liệu canvas bền bỉ. Chất liệu n&agrave;y được nh&agrave; Converse rất ưu &aacute;i khi lu&ocirc;n sử dụng cho những sản phẩm của m&igrave;nh. Bởi t&iacute;nh ứng dụng cao trong mặt h&agrave;ng gi&agrave;y d&eacute;p v&agrave; t&iacute;nh thẩm mỹ cao. B&ecirc;n trong vẫn được thiết kế với lớp l&oacute;t Ortholite d&agrave;y dặn v&agrave; &ecirc;m &aacute;i, đem đến cho bạn những bước đi cực kỳ linh hoạt.&nbsp;</p>\r\n\r\n<h2 dir=\"ltr\"><strong>Chứa đựng th&ocirc;ng điệp &yacute; nghĩa m&agrave; Converse Chuck Taylor All Star Future Utility mang lại</strong></h2>\r\n\r\n<p dir=\"ltr\">Đ&ocirc;i gi&agrave;y Converse Chuck Taylor All Star Future Utility kh&ocirc;ng chỉ thu h&uacute;t với c&aacute;c họa tiết đồ họa độc đ&aacute;o m&agrave; c&ograve;n mang đến một th&ocirc;ng điệp s&acirc;u sắc trong bối cảnh hậu tận thế. Họa tiết đồ họa kh&ocirc;ng chỉ đơn thuần l&agrave; yếu tố trang tr&iacute;, m&agrave; c&ograve;n phản &aacute;nh tinh thần duy lợi v&agrave; sự t&aacute;o bạo, gợi l&ecirc;n h&igrave;nh ảnh của một thế giới tương lai nơi con người phải đối mặt với những th&aacute;ch thức khắc nghiệt.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-08.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Th&ocirc;ng điệp lạc quan của Converse Chuck Taylor All Star Future Utility l&agrave; lời khuyến kh&iacute;ch mạnh mẽ. Như đang nhắc nhở bạn rằng d&ugrave; cuộc sống c&oacute; đầy th&aacute;ch thức v&agrave; trở ngại, lu&ocirc;n c&oacute; một con đường để vượt qua v&agrave; tiến l&ecirc;n. H&atilde;y tự tin đối mặt với những kh&oacute; khăn, kh&ocirc;ng ngừng kh&aacute;m ph&aacute; v&agrave; ph&aacute;t triển bản th&acirc;n v&agrave; h&atilde;y lu&ocirc;n nhớ rằng mỗi bước đi đều mang bạn gần hơn đến mục ti&ecirc;u của m&igrave;nh.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-04.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Converse Chuck Taylor All Star Future Utility kh&ocirc;ng chỉ l&agrave; một đ&ocirc;i gi&agrave;y thời trang m&agrave; c&ograve;n l&agrave; biểu tượng của sự ki&ecirc;n cường v&agrave; kh&aacute;t vọng chinh phục, th&uacute;c giục người mang tự tin đối mặt với mọi thử th&aacute;ch trong cuộc sống đầy biến động v&agrave; kh&ocirc;ng ngừng thay đổi.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20future%20utility/converse-future-utility-06.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><br />\r\nConverse Chuck Taylor All Star Future Utility với thiết kế đậm chất Cyberpunk, mang đến cho bạn vẻ ngo&agrave;i độc đ&aacute;o v&agrave; c&aacute; t&iacute;nh, đồng thời truyền tải th&ocirc;ng điệp lạc quan về sự ki&ecirc;n cường v&agrave; dũng cảm. H&atilde;y để item đồng h&agrave;nh c&ugrave;ng bạn tr&ecirc;n con đường chinh phục những mục ti&ecirc;u mới, kh&aacute;m ph&aacute; những miền đất mới v&agrave; thể hiện phong c&aacute;ch kh&ocirc;ng giới hạn của ri&ecirc;ng bạn. V&agrave; đừng qu&ecirc;n tại&nbsp;<a href=\"https://drake.vn/\">Drake VN</a>&nbsp;đ&atilde; cho l&ecirc;n kệ mẫu gi&agrave;y độc đ&aacute;o n&agrave;y v&agrave; đang đợi bạn đến để trải nghiệm đấy nh&eacute;.</p>', 1, '<p><strong><em>Lu&ocirc;n đem đến cho người mang những điều độc đ&aacute;o nhất, Converse kh&ocirc;ng ngừng đổi mới những sản phẩm của m&igrave;nh để đến gần với người h&acirc;m mộ hơn. Mỗi sản phẩm đều mang một &yacute; nghĩa ri&ecirc;ng v&agrave; Converse Chuck Taylor All Star Future Utility cũng kh&ocirc;ng nằm ngoại lệ. Lấy &yacute; tưởng từ phong c&aacute;ch Cyberpunk độc đ&aacute;o mang bạn đến một tương lai đậm chất khoa học viễn tưởng c&ugrave;ng phối m&agrave;u độc đ&aacute;o. B&ecirc;n cạnh đ&oacute;, item c&ograve;n thể hiện những điều ấn tượng g&igrave; nữa th&igrave; bạn h&atilde;y c&ugrave;ng Drake VN kh&aacute;m ph&aacute; ngay qua b&agrave;i viết dưới đ&acirc;y nh&eacute;.</em></strong></p>', 'Hòa mình vào không gian viễn tưởng với Converse Chuck Taylor All Star Future Utility', 'hoa-minh-vao-khong-gian-vien-tuong-voi-converse-chuck-taylor-all-star-future-utility', 'blog-15019.jpg', '2025-06-26 07:10:20', '2025-08-04 09:30:32'),
(9, '<h2 dir=\"ltr\"><strong>Vẽ gi&agrave;y Vans l&agrave; g&igrave;?</strong></h2>\r\n\r\n<p dir=\"ltr\">Việc vẽ l&ecirc;n gi&agrave;y kh&ocirc;ng c&ograve;n qu&aacute; xa lạ với giới trẻ ng&agrave;y nay bởi điều n&agrave;y cho ph&eacute;p bạn thể hiện sự s&aacute;ng tạo v&agrave; l&agrave; c&aacute;ch nhanh nhất để sở hữu cho m&igrave;nh đ&ocirc;i gi&agrave;y ấn tượng v&agrave; độc đ&aacute;o. Vẽ gi&agrave;y Vans đơn giản l&agrave; việc bạn tự tay thay đổi diện mạo của đ&ocirc;i gi&agrave;y theo &yacute; th&iacute;ch, từ việc vẽ h&igrave;nh đến thay đổi m&agrave;u sắc. Qu&aacute; tr&igrave;nh n&agrave;y biến đổi một đ&ocirc;i gi&agrave;y cũ th&agrave;nh một phi&ecirc;n bản mới, v&agrave; đồng thời phản &aacute;nh c&aacute; t&iacute;nh của bạn. Nhiều người y&ecirc;u gi&agrave;y gọi việc n&agrave;y l&agrave; &quot;độ gi&agrave;y&quot;, tương tự như c&aacute;ch c&aacute;c phượt thủ đam m&ecirc; độ xe.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-09.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Mỗi người sẽ c&oacute; những &yacute; tưởng ri&ecirc;ng để vẽ l&ecirc;n đ&ocirc;i gi&agrave;y, c&oacute; thể l&agrave; nh&acirc;n vật hoạt h&igrave;nh y&ecirc;u th&iacute;ch, thần tượng của bạn, c&aacute;c họa tiết nhỏ xinh hoặc kết hợp logo của c&aacute;c thương hiệu,...Bạn c&oacute; thể vẽ l&ecirc;n những đ&ocirc;i gi&agrave;y Vans trắng hoặc đ&ocirc;i gi&agrave;y cũ sau thời gian sử dụng để l&agrave;m mới những họa tiết tr&ecirc;n gi&agrave;y theo sở th&iacute;ch của bản th&acirc;n.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-08.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<h2 dir=\"ltr\"><strong>Lựa chọn gi&agrave;y Vans để bắt đầu &ldquo;biến h&oacute;a&rdquo;</strong></h2>\r\n\r\n<p dir=\"ltr\">Biến tấu đ&ocirc;i&nbsp;<a href=\"https://drake.vn/vans\">gi&agrave;y Vans</a>&nbsp;phụ thuộc v&agrave;o loại gi&agrave;y bạn đang sở hữu, c&oacute; thể l&agrave; một đ&ocirc;i gi&agrave;y đ&atilde; cũ hoặc l&agrave; đ&ocirc;i gi&agrave;y mới bạn mua với &yacute; định sẽ vẽ l&ecirc;n để tạo sự mới mẻ. Trước khi bắt đầu qu&aacute; tr&igrave;nh tạo ra sự kh&aacute;c biệt cho đ&ocirc;i gi&agrave;y của m&igrave;nh, h&atilde;y đảm bảo rằng bạn đ&atilde; c&oacute; đ&ocirc;i gi&agrave;y ph&ugrave; hợp v&agrave; sẵn l&ograve;ng &aacute;p dụng c&aacute;c phương ph&aacute;p t&ugrave;y chỉnh đ&atilde; chọn.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-07.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Vans Slip-On: Với d&ograve;ng gi&agrave;y n&agrave;y c&oacute; phần th&acirc;n ở mu b&agrave;n ch&acirc;n rộng r&atilde;i, bạn c&oacute; thể thỏa sức với sự s&aacute;ng tạo của m&igrave;nh để tạo ra một bức tranh nhỏ, độc đ&aacute;o. Bạn c&oacute; thể vẽ l&ecirc;n gi&agrave;y Vans Slip-On nh&acirc;n vật hoạt h&igrave;nh bạn y&ecirc;u th&iacute;ch hoặc những h&igrave;nh ảnh thi&ecirc;n nhi&ecirc;n, phong cảnh.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-06.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Vans Old Skool: Kiểu thiết kế kinh điển n&agrave;y mang lại sự linh hoạt v&agrave; cho ph&eacute;p bạn thực hiện nhiều &yacute; tưởng kh&aacute;c nhau. Sử dụng sơn nước (hydro dipping) để vẽ hoặc th&ecirc;m v&agrave;o c&aacute;c chi tiết độc đ&aacute;o như đinh t&aacute;n hoặc c&aacute;c họa tiết đặc biệt cũng l&agrave; &yacute; tưởng s&aacute;ng tạo.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-05.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Vans Sk8-Hi: Nếu bạn mong muốn một thiết kế đơn giản nhưng kh&ocirc;ng k&eacute;m phần tinh tế, h&atilde;y sử dụng b&uacute;t vẽ gi&agrave;y Sharpie. Điều n&agrave;y sẽ cho ph&eacute;p bạn tự do thể hiện sự s&aacute;ng tạo của m&igrave;nh th&ocirc;ng qua c&aacute;c họa tiết v&agrave; trang tr&iacute;, tạo ra một đ&ocirc;i gi&agrave;y độc đ&aacute;o v&agrave; n&oacute;i l&ecirc;n c&aacute; t&iacute;nh ri&ecirc;ng của bạn.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-04.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<h2 dir=\"ltr\"><strong>C&aacute;c bước vẽ gi&agrave;y Vans cực kỳ đơn giản</strong></h2>\r\n\r\n<p dir=\"ltr\">Bước 1: L&agrave;m sạch gi&agrave;y&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Nếu l&agrave; đ&ocirc;i gi&agrave;y mới, bạn c&oacute; thể bỏ qua bước n&agrave;y. Nhưng nếu l&agrave; đ&ocirc;i gi&agrave;y cũ, h&atilde;y lau sạch mọi vết bẩn v&agrave; c&aacute;t bụi để bề mặt trở n&ecirc;n s&aacute;ng b&oacute;ng v&agrave; sẵn s&agrave;ng qu&aacute; tr&igrave;nh biến h&oacute;a cho đ&ocirc;i gi&agrave;y của bạn.&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Bước 2: L&ecirc;n &yacute; tưởng&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Kh&ocirc;ng thể thiếu một mẫu họa tiết hoặc h&igrave;nh ảnh ph&ugrave; hợp. Bạn c&oacute; thể t&igrave;m kiếm ở s&aacute;ch b&aacute;o hoặc những nh&acirc;n vật, h&igrave;nh ảnh m&igrave;nh y&ecirc;u th&iacute;ch v&agrave; ph&aacute;c thảo &yacute; tưởng trước khi vẽ gi&agrave;y Vans. Bạn n&ecirc;n ph&aacute;c thảo &yacute; tưởng bằng b&uacute;t ch&igrave; hoặc c&oacute; thể vẽ trước ra giấy để tr&aacute;nh bị sai s&oacute;t trong qu&aacute; tr&igrave;nh vẽ.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-03.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Bước 3: Ph&acirc;n chia ranh giới&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Sử dụng băng keo để ph&acirc;n chia v&agrave; bảo vệ những phần bạn kh&ocirc;ng muốn vẽ. Điều n&agrave;y gi&uacute;p tr&aacute;nh vết lem m&agrave;u v&agrave; đảm bảo sự ch&iacute;nh x&aacute;c trong qu&aacute; tr&igrave;nh tạo h&igrave;nh họa tiết.&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Bước 4: Tiến h&agrave;nh qu&aacute; tr&igrave;nh vẽ gi&agrave;y Vans&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Ở bước n&agrave;y, để ho&agrave;n thiện t&aacute;c phẩm, bạn cần sự kh&eacute;o l&eacute;o, tỉ mỉ v&agrave; ki&ecirc;n nhẫn. Đối với loại sơn bạn n&ecirc;n sử dụng sơn gi&agrave;y Acrylic, loại sơn n&agrave;y rất dễ mua v&agrave; dễ sử dụng. C&aacute;c bước thực hiện được tiến h&agrave;nh như sau:&nbsp;</p>\r\n\r\n<ul>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Cố định gi&agrave;y bằng ghim.&nbsp;</p>\r\n	</li>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Chọn đầu cọ ph&ugrave; hợp v&agrave; gạt m&agrave;u tr&ecirc;n khay để tr&aacute;nh lấy qu&aacute; nhiều m&agrave;u.&nbsp;</p>\r\n	</li>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Bắt đầu vẽ theo họa tiết đ&atilde; ph&aacute;c thảo. Cẩn thận với m&agrave;u kh&ocirc; nhanh v&agrave; b&aacute;m chặt.&nbsp;</p>\r\n	</li>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Khi ho&agrave;n th&agrave;nh, để gi&agrave;y ở nơi kh&ocirc; r&aacute;o, tho&aacute;ng m&aacute;t để m&agrave;u kh&ocirc; tự nhi&ecirc;n.</p>\r\n	</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-01.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Bước 5: Ho&agrave;n thiện&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Sau khi m&agrave;u sơn kh&ocirc;, xịt một lớp bảo vệ để bảo đảm m&agrave;u sắc bền l&acirc;u v&agrave; kh&ocirc;ng bị phai mờ khi tiếp x&uacute;c với nước hoặc m&ocirc;i trường ẩm. Sau đ&oacute;, chi&ecirc;m ngưỡng th&agrave;nh quả của bạn.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Sở hữu đôi giày không “đụng hàng” với nghệ thuật vẽ giày Vans độc đáo\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/v%E1%BA%BD%20gi%C3%A0y%20Vans/v%E1%BA%BD-gi%C3%A0y-vans-10.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Đừng ngần ngại bước ra v&ugrave;ng an to&agrave;n của bản th&acirc;n v&agrave; tạo n&ecirc;n điều mới mẻ, độc đ&aacute;o cho bản th&acirc;n bạn th&ocirc;ng qua việc vẽ gi&agrave;y Vans.</p>', 1, '<p><strong><em>Khi bạn đ&atilde; ch&aacute;n với những họa tiết classic tr&ecirc;n gi&agrave;y th&igrave; việc vẽ gi&agrave;y Vans l&agrave; một &yacute; tưởng kh&ocirc;ng hề tồi để gi&uacute;p bạn sở hữu đ&ocirc;i gi&agrave;y &ldquo;độc nhất v&ocirc; nhị&rdquo;. Kh&ocirc;ng kh&oacute; để bạn c&oacute; thể tự tay l&agrave;m n&ecirc;n những t&aacute;c phẩm nghệ thuật chỉ ri&ecirc;ng bạn c&oacute;. Để l&agrave;m được điều đ&oacute; bạn c&oacute; thể sử dụng sự s&aacute;ng tạo của m&igrave;nh hoặc dựa v&agrave;o những nh&acirc;n vật hoạt h&igrave;nh m&agrave; bạn th&iacute;ch để tạo n&ecirc;n sự ph&aacute; c&aacute;ch v&agrave; độc đ&aacute;o tr&ecirc;n ch&iacute;nh đ&ocirc;i gi&agrave;y của m&igrave;nh.</em></strong></p>', 'Sở hữu đôi giày không \"đụng hàng\" với nghệ thuật vẽ giày Vans độc đáo', 'so-huu-doi-giay-khong-dung-hang-voi-nghe-thuat-ve-giay-vans-doc-dao', 'blog-26488.jpg', '2025-06-26 07:10:57', '2025-08-04 09:30:09'),
(10, '<h2 dir=\"ltr\"><strong>Converse Chuck Taylor All Star Construct - X&acirc;y dựng ngoại h&igrave;nh t&aacute;o bạo</strong></h2>\r\n\r\n<p dir=\"ltr\">Lu&ocirc;n được điểm cộng trong việc s&aacute;ng tạo nhiều kiểu d&aacute;ng độc đ&aacute;o v&agrave; lạ mắt. Mới đ&acirc;y, Converse cho ra mắt&nbsp;<a href=\"https://drake.vn/converse/converse-chuck-taylor-all-star-construct-a05094c\">Converse Chuck Taylor All Star Construct</a>&nbsp;với thiết kế ấn tượng với kiểu d&aacute;ng đế l&oacute;t ly v&agrave; cải tiến với nhiều t&iacute;nh năng nổi trội. H&uacute;t mắt với chiếc đế Platform độc đ&aacute;o vẫn được nh&agrave; thiết kế ứng dụng v&agrave;o c&aacute;c sản phẩm của m&igrave;nh để đ&aacute;p ứng nhu cầu tr&ecirc;n thị trường. Những đường n&eacute;t tỉ mỉ kết hợp c&ugrave;ng chất liệu cao su cao cấp tạo n&ecirc;n kết cấu cực kỳ bền chắc v&agrave; nổi bật.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-08.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Về mặt thiết kế, kiểu d&aacute;ng đế l&oacute;t ly thường c&oacute; c&aacute;c đường cong v&agrave; g&oacute;c cạnh đặc biệt. Lớp phủ ở phần trước của th&acirc;n gi&agrave;y được bọc bằng cao su cứng c&aacute;p tạo ra một cảm gi&aacute;c bảo vệ v&agrave; ổn định cho đ&ocirc;i gi&agrave;y, đồng thời cung cấp sự thoải m&aacute;i v&agrave; sự tự tin khi di chuyển. Khả năng &quot;hack&quot; d&aacute;ng của thiết kế n&agrave;y l&agrave; một điểm đặc biệt đ&aacute;ng ch&uacute; &yacute;. Converse Chuck Taylor All Star Construct kh&ocirc;ng chỉ đ&aacute;nh lừa thị gi&aacute;c bằng c&aacute;ch tạo cho người mang cảm gi&aacute;c cao hơn m&agrave; c&ograve;n giữ cho đ&ocirc;i gi&agrave;y kh&ocirc;ng bị biến dạng hay l&agrave;m mất form sau thời gian sử dụng.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-07.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Mặt đế ngo&agrave;i được phủ bằng kết cấu xương c&aacute;, tạo ra một độ b&aacute;m vững v&agrave;ng hơn tr&ecirc;n mọi bề mặt. Đem lại cho người mang sự tự tin v&agrave; ổn định khi di chuyển, bất kể điều kiện địa h&igrave;nh n&agrave;o. Những đường chỉ được may tỉ mỉ chạy dọc xung quanh gi&agrave;y, bao quanh Patch Logo tr&ograve;n b&ecirc;n h&ocirc;ng để tạo n&ecirc;n điểm nhấn m&agrave; bất cứ t&iacute;n đồ n&agrave;o cũng biết.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-06.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Sử dụng lớp đệm OrthoLite l&agrave; một bước tiến lớn trong việc tạo ra sự thoải m&aacute;i v&agrave; tiện lợi cho đ&ocirc;i gi&agrave;y. Đệm OrthoLite kh&ocirc;ng chỉ mang lại sự &ecirc;m &aacute;i cho b&agrave;n ch&acirc;n m&agrave; c&ograve;n hỗ trợ trong việc hấp thụ chấn động v&agrave; tho&aacute;ng kh&iacute;, giữ cho đ&ocirc;i gi&agrave;y lu&ocirc;n kh&ocirc; r&aacute;o v&agrave; tho&aacute;ng m&aacute;t.&nbsp;</p>\r\n\r\n<p dir=\"ltr\">Với lớp đệm n&agrave;y, người mang c&oacute; thể cảm nhận được sự thoải m&aacute;i ngay từ lần đầu ti&ecirc;n đi gi&agrave;y v&agrave; duy tr&igrave; cảm gi&aacute;c dễ chịu suốt cả ng&agrave;y d&agrave;i. Khả năng hấp thụ sốc của đệm OrthoLite cũng gi&uacute;p giảm bớt &aacute;p lực l&ecirc;n b&agrave;n ch&acirc;n, đặc biệt l&agrave; khi hoạt động nhiều hoặc di chuyển li&ecirc;n tục.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-05.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<h2 dir=\"ltr\"><strong>H&igrave;nh b&oacute;ng cổ điển ứng dụng v&agrave;o Converse Chuck Taylor All Star Construct</strong></h2>\r\n\r\n<p dir=\"ltr\">Thừa hưởng những n&eacute;t đặc trưng v&agrave; truyền thống vốn c&oacute; của Converse để tạo n&ecirc;n một thiết kế độc đ&aacute;o v&agrave; mang đậm dấu ấn của thương hiệu. Sử dụng 100% chất liệu cotton để ho&agrave;n thiện sản phẩm. Chất liệu cotton đ&atilde; được chứng minh l&agrave; mang lại sự thoải m&aacute;i v&agrave; độ bền trong sản xuất gi&agrave;y d&eacute;p, đồng thời tạo ra một cảm gi&aacute;c mềm mại v&agrave; dễ chịu cho người mặc.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-04.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Kh&ocirc;ng thể bỏ qua form d&aacute;ng cổ cao đặc trưng của h&atilde;ng gi&agrave;y b&oacute;ng rổ, mang lại phong c&aacute;ch cổ điển xen lẫn hiện đại đồng thời tạo n&ecirc;n một cảm gi&aacute;c c&aacute; nh&acirc;n v&agrave; độc đ&aacute;o cho người mang. Phi&ecirc;n bản cổ cao kh&ocirc;ng chỉ tạo điểm nhấn th&uacute; vị m&agrave; c&ograve;n bảo vệ tốt hơn cho mắt c&aacute; ch&acirc;n của bạn, đồng thời tạo n&ecirc;n sự ấn tượng mạnh mẽ khi được kết hợp c&ugrave;ng c&aacute;c trang phục kh&aacute;c nhau.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-03.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<h2 dir=\"ltr\"><strong>Converse Chuck Taylor All Star Construct - &ldquo;Kỹ sư&rdquo; của thế hệ tương lai</strong></h2>\r\n\r\n<p dir=\"ltr\">Việc biến tấu kiểu d&aacute;ng của Converse Chuck Taylor All Star Construct l&agrave; một điều m&agrave; h&atilde;ng Converse rất ch&uacute; trọng khi tạo ra một sản phẩm mới. Bằng c&aacute;ch n&agrave;y, h&atilde;ng kh&ocirc;ng chỉ thể hiện sự s&aacute;ng tạo v&agrave; đổi mới m&agrave; c&ograve;n tạo ra một giao diện mới mẻ v&agrave; độc đ&aacute;o so với c&aacute;c mẫu trước đ&oacute;.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-02.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Điều đ&oacute; cũng được thể hiện r&otilde; n&eacute;t qua c&aacute;i t&ecirc;n &ldquo;Construct&rdquo;. Trong ngữ cảnh n&agrave;y, item kh&ocirc;ng chỉ đơn thuần l&agrave; việc x&acirc;y dựng một phi&ecirc;n bản mới của d&ograve;ng gi&agrave;y Chuck Taylor All Star, m&agrave; c&ograve;n &aacute;m chỉ đến qu&aacute; tr&igrave;nh s&aacute;ng tạo v&agrave; đổi mới. Đề cập đến việc tạo ra một sản phẩm mới với sự kết hợp của c&aacute;c yếu tố cổ điển v&agrave; c&aacute;c yếu tố mới, tạo n&ecirc;n một phi&ecirc;n bản độc đ&aacute;o v&agrave; phong c&aacute;ch của d&ograve;ng gi&agrave;y Converse.&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-01.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Điều n&agrave;y kh&ocirc;ng chỉ l&agrave; việc đổi mới về thiết kế m&agrave; c&ograve;n l&agrave; việc tạo ra một trải nghiệm mới mẻ v&agrave; đặc biệt cho người d&ugrave;ng. Thể thể hiện sự t&ocirc;n trọng, kế thừa về mặt truyền thống v&agrave; lịch sử của d&ograve;ng gi&agrave;y Chuck Taylor All Star, đồng thời mở ra c&aacute;nh cửa cho sự ph&aacute;t triển v&agrave; tiến bộ trong thế giới sneaker.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\"Biến hóa phong cách hiện đại với “kỹ sư” Converse Chuck Taylor All Star Construct\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/converse%20construct/converse-construct-10.jpg\" /></p>\r\n\r\n<p dir=\"ltr\"><em>Nguồn: sưu tầm</em></p>\r\n\r\n<p dir=\"ltr\">Với thiết kế t&aacute;o bạo trong từng nhịp ch&acirc;n, chắc hẳn Converse Chuck Taylor All Star Construct sẽ l&agrave; sự lựa chọn ph&ugrave; hợp d&agrave;nh cho những ai đang t&igrave;m kiếm phong c&aacute;ch c&aacute; t&iacute;nh.</p>', 1, '<p><em><strong>Lấy cảm hứng từ phong c&aacute;ch b&oacute;ng rổ những năm thập ni&ecirc;n 80, Converse Chuck Taylor All Star Construct gạt bỏ những giới hạn xưa cũ để từng bước ho&agrave;n thiện hơn. Kho&aacute;c l&ecirc;n diện mạo kh&aacute;c lạ v&agrave; đầy vẻ t&aacute;o bạo c&ugrave;ng lối thiết kế kh&ocirc;ng lẫn v&agrave;o đ&acirc;u được của nh&agrave; gi&agrave;y b&oacute;ng rổ. Bạn đ&atilde; sẵn s&agrave;ng c&ugrave;ng item du h&agrave;nh đến thế giới của phong c&aacute;ch s&aacute;ng tạo v&agrave; thời trang chưa? H&atilde;y c&ugrave;ng Drake kh&aacute;m ph&aacute; ngay qua b&agrave;i viết dưới đ&acirc;y nh&eacute;.</strong></em></p>', 'Biến hóa phong cách hiện đại với \"kỹ sư\" Converse Chuck Taylor All Star Construct', 'bien-hoa-phong-cach-hien-dai-voi-ky-su-converse-chuck-taylor-all-star-construct', 'blog-38620.jpg', '2025-06-26 07:11:29', '2025-06-26 07:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `idBrand` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `BrandName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BrandSlug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BrandImage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idBrand`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`idBrand`, `BrandName`, `BrandSlug`, `BrandImage`, `created_at`, `updated_at`) VALUES
(20, 'Adidas', 'adidas', '1762000228_Adidas-Logo.wine.png', '2025-02-10 04:32:40', '2025-11-01 12:30:28'),
(21, 'Converse', 'converse', '1762001971_converse-logo-700x394_74e0f1a4d9fa4bc2b220945592e85730_1024x1024.png', '2025-02-10 04:34:02', '2025-11-01 12:59:31'),
(22, 'Vans', 'vans', '1762001988_vans-logo-png_seeklogo-257446.png', '2025-02-10 04:34:07', '2025-11-01 12:59:48'),
(23, 'Nike', 'nike', '1762001998_Logo_NIKE.svg.png', '2025-02-10 04:34:21', '2025-11-01 12:59:58'),
(25, 'Ximo', 'ximo', '1762002616_logo.png', '2025-06-26 04:10:15', '2025-11-01 13:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `brand_category`
--

DROP TABLE IF EXISTS `brand_category`;
CREATE TABLE IF NOT EXISTS `brand_category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `idBrand` bigint UNSIGNED NOT NULL,
  `idCategory` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_category_idbrand_foreign` (`idBrand`),
  KEY `brand_category_idcategory_foreign` (`idCategory`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_category`
--

INSERT INTO `brand_category` (`id`, `idBrand`, `idCategory`, `created_at`, `updated_at`) VALUES
(1, 20, 15, NULL, NULL),
(2, 21, 15, NULL, NULL),
(3, 23, 15, NULL, NULL),
(5, 22, 15, NULL, NULL),
(6, 24, 15, NULL, NULL),
(9, 25, 18, NULL, NULL),
(8, 26, 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `idCart` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCustomer` int UNSIGNED NOT NULL,
  `idProduct` int UNSIGNED NOT NULL,
  `idProAttr` int UNSIGNED DEFAULT NULL,
  `proAttr` int UNSIGNED DEFAULT NULL,
  `AttributeProduct` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PriceNew` int NOT NULL,
  `QuantityBuy` int NOT NULL,
  `Total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idCart`),
  KEY `idCustomer` (`idCustomer`),
  KEY `idProduct` (`idProduct`),
  KEY `idProAttr` (`idProAttr`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`idCart`, `idCustomer`, `idProduct`, `idProAttr`, `proAttr`, `AttributeProduct`, `PriceNew`, `QuantityBuy`, `Total`, `created_at`, `updated_at`) VALUES
(23, 46, 105, NULL, 515, 'undefined: undefined', 2210000, 1, 2210000, '2025-11-01 13:09:41', '2025-11-01 13:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `idCategory` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CategorySlug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CategoryImage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`idCategory`, `CategoryName`, `CategorySlug`, `CategoryImage`, `created_at`, `updated_at`) VALUES
(15, 'Giày', 'giay', '1761928693_43e65a6a7afade2d03a4bf25b81e8e96.jpg_720x720q80.jpg', '2025-02-10 04:28:45', '2025-06-26 04:08:23'),
(16, 'Dép', 'dep', '1762534199_Dep_DJi_Boi_Adilette_trang_JP5191_01_00_standard.jpg', NULL, NULL),
(18, 'Phụ kiện', 'phu-kien', '1761928806_leather-shoe-care-full-kit.jpg', '2025-06-26 07:13:26', '2025-06-26 07:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `idCustomer` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PhoneNumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CustomerName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idCustomer`, `username`, `password`, `PhoneNumber`, `CustomerName`, `Address`, `Email`, `Avatar`, `Status`, `created_at`, `updated_at`) VALUES
(34, 'actor123', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLa45GEGddv3pjKOVtwcg0eqVvjwhRdEPooxX4miA2mkQ_W2iQ=s96-c', 1, NULL, NULL),
(35, 'zzzz', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIHO_06EXAZX6cCar9m8K294rC54TH4yqFUocNQ_dUEmTfUV70=s96-c', 1, NULL, NULL),
(36, '2k_yzet', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIXHe-TS9OQIx2Df-UGeL4dTEdotw85O2drdnUSeFtY2pvWGA=s96-c', 1, NULL, NULL),
(37, 'test2222', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKduzU64SaZByRQBG4WILE3VUNYDgCWjHXd6p-djciKkz-BPw=s96-c', 1, NULL, NULL),
(38, 'user1111', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJUb8kvLRJ2QTi6B9-DxNeEQmuZc5WaFP-1fnZd13xJuYCOag=s96-c', 1, NULL, NULL),
(39, 'khoatran', '0d63031864eaeeab8baf66bee4e9c3b9', NULL, NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocI1hRDEEeDxp_Zrqkuoe-Kisk7ptA2LGvb3SCnEVuE5e5ZkNBU=s96-c', 1, NULL, NULL),
(40, 'abc123', 'f5bb0c8de146c67b44babbf4e6584cc0', '079202021288', 'Nguyễn Văn A', '180 cao lỗ, p4, q8, tphcm', NULL, 'Screenshot (1)27.png', 1, NULL, NULL),
(41, 'bin00zz', 'e9f43faa08c00e9bb178fe5bc66d9c46', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(42, 'Dainq1002', '25d55ad283aa400af464c76d713c07ad', '0989889889', 'Ngo Fe', 'V1', NULL, NULL, 1, NULL, NULL),
(43, 'khoa00zz', 'e503f3b445140f547776520995bd4af9', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(44, 'naruto00zz', 'e9f43faa08c00e9bb178fe5bc66d9c46', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(45, 'khoa111', '9210d30b26e60e9b045bdd3e3037fda7', '12034422313', 'Trần Đình Khoa', '34/2b Hưng Thạnh TPHCM', 'khoasama998@gmail.com', 'skysports-charles-leclerc-f1_6137610-230959711162.jpg', 1, NULL, NULL),
(46, 'khoa222', '9210d30b26e60e9b045bdd3e3037fda7', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_07_29_190711_create_tbl_product_table', 2),
(12, '2022_07_29_202441_create_saleproduct_table', 3),
(13, '2022_07_30_154639_create_brand_table', 4),
(14, '2022_07_30_154846_create_category_table', 4),
(15, '2022_07_30_155010_create_attribute_table', 4),
(16, '2022_07_30_155047_create_attributevalue_table', 4),
(17, '2022_07_30_155155_create_productattribute_table', 4),
(18, '2022_07_30_155246_create_productimage_table', 4),
(19, '2022_07_30_160811_create_admin_table', 5),
(20, '2022_07_30_162600_create_bill_table', 6),
(22, '2022_07_30_164010_create_billinfo_table', 7),
(23, '2022_07_30_171111_create_cart_table', 8),
(24, '2022_07_30_171621_create_wishlist_table', 9),
(25, '2022_07_30_171653_create_compare_table', 9),
(26, '2022_07_30_171717_create_blog_table', 9),
(27, '2022_07_30_171748_create_customer_table', 9),
(28, '2022_07_30_171916_create_statistic_table', 9),
(29, '2022_07_30_171958_create_voucher_table', 9),
(30, '2022_07_30_172031_create_billhistory_table', 9),
(31, '2022_07_30_172109_create_addresscustomer_table', 9),
(32, '2025_10_31_231216_add_category_image_to_categories_table', 10),
(33, '2025_11_01_163158_create_brand_category_table', 11),
(34, '2025_11_09_194918_add_email_to_customer_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `idProduct` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCategory` int UNSIGNED NOT NULL,
  `idBrand` int UNSIGNED NOT NULL,
  `QuantityTotal` int NOT NULL,
  `ProductName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProductSlug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DesProduct` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShortDes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Price` int NOT NULL,
  `Sold` int NOT NULL DEFAULT '0',
  `StatusPro` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idProduct`),
  KEY `idCategory` (`idCategory`,`idBrand`),
  KEY `idBrand` (`idBrand`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `idCategory`, `idBrand`, `QuantityTotal`, `ProductName`, `ProductSlug`, `DesProduct`, `ShortDes`, `Price`, `Sold`, `StatusPro`, `created_at`, `updated_at`) VALUES
(100, 15, 21, 25, 'Converse Chuck Classic Cổ Thấp', 'converse-chuck-classic-co-thap', '<p><strong><em>Cho đến nay Converse Chuck Taylor All Star 1970s vẫn l&agrave; xu hướng được nhiều bạn trẻ &ldquo;bắt trend&rdquo;. Kh&ocirc;ng kh&aacute;c nhiều so với mẫu gi&agrave;y Converse nguy&ecirc;n bản, thế nhưng Chuck 1970s vẫn sở hữu nhiều điểm cải tiến đ&uacute;ng với t&ecirc;n gọi. Vậy l&yacute; do n&agrave;o để Chuck 1970s vẫn l&agrave; một trong những xu hướng thời trang dẫn đầu hiện nay?</em></strong></p>\r\n\r\n<p><img alt=\"Converse Chuck Taylor 1970s\" src=\"https://drake.vn/image/catalog/CV%201970s/converse-chuck-taylor-all-star-1970s-3.jpg\" /></p>\r\n\r\n<p><em>Kh&ocirc;ng c&oacute; nhiều thay đổi nhưng Chuck 1970s vẫn dẫn đầu xu hướng</em></p>\r\n\r\n<p><strong>Những điểm cộng tr&ecirc;n đ&ocirc;i gi&agrave;y Converse Chuck Taylor All Star 1970s</strong></p>\r\n\r\n<p>Vẫn giữ nguy&ecirc;n thiết kế gi&agrave;y đặc trưng của đế chế Converse, Chuck Taylor 1970s mang trong m&igrave;nh một dấu ấn của thời trang cố điển. Với những chi tiết gi&agrave;y đảm bảo đ&uacute;ng chất vintage, đồng thời tạo được chất lượng tốt hơn cho người mang. Trong đ&oacute;, những điểm mới tr&ecirc;n đ&ocirc;i gi&agrave;y Chuck 1970s được c&aacute;c nh&agrave; thiết kế đưa v&agrave;o m&agrave; bạn c&oacute; thể nhận diện ngay:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Phần đế gi&agrave;y c&oacute; m&agrave;u ng&agrave; hơn so với c&aacute;c thiết kế trước, cao hơn v&agrave; được phủ một lớp b&oacute;ng để hạn chế b&aacute;m bẩn v&agrave; dễ d&agrave;ng vệ sinh.</p>\r\n	</li>\r\n	<li>\r\n	<p>Lớp vải Canvas phần th&acirc;n gi&agrave;y được dệt d&agrave;y hơn, c&oacute; lớp l&oacute;t đệm gi&uacute;p gi&agrave;y cứng c&aacute;p hơn, kh&ocirc;ng c&ograve;n t&igrave;nh trạng ọp ẹp sau một thời&nbsp;gian sử dụng như c&aacute;c mẫu cũ.</p>\r\n\r\n	<p><img alt=\"Converse Chuck Taylor 1970s\" src=\"https://drake.vn/image/catalog/CV%201970s/converse-chuck-taylor-all-star-1970s-4.jpg\" /></p>\r\n	</li>\r\n</ul>\r\n\r\n<p><em>Chất liệu v&agrave; phần đế c&oacute; sự thay đổi r&otilde; nhất</em></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Đệm ch&acirc;n Ortholite &reg; &ecirc;m &aacute;i gi&uacute;p giảm khả năng trơn trượt, l&agrave;m giảm lực ma s&aacute;t giữa ng&oacute;n - g&oacute;t ch&acirc;n với gi&agrave;y.</p>\r\n	</li>\r\n	<li>\r\n	<p>Form gi&agrave;y được thiết kế chuẩn hơn với g&oacute;t gi&agrave;y v&agrave; mũi gi&agrave;y &ocirc;m s&aacute;t v&agrave;o ch&acirc;n nhưng kh&ocirc;ng g&acirc;y cảm gi&aacute;c kh&oacute; chịu cho người mang.</p>\r\n	</li>\r\n</ul>', '<p>Loại: Cổ thấp</p>\r\n\r\n<p>Giới t&iacute;nh: Nam</p>\r\n\r\n<p>Phần th&acirc;n:&nbsp;Vải</p>\r\n\r\n<p>Lớp l&oacute;t: Vải</p>\r\n\r\n<p>Đế gi&agrave;y: Cao su</p>\r\n\r\n<p>Nơi sản xuất: Việt Nam</p>', 1615000, 4, 1, '2025-06-26 05:09:27', '2025-10-15 01:36:15'),
(105, 15, 21, 30, 'Converse Run Star Motion Canvas Platform Black Cổ Cao', 'converse-run-star-motion-canvas-platform-black-co-cao', '<p dir=\"ltr\">Bản chất cổ điển v&agrave; gợi nhớ qu&aacute; khứ vẫn được giữ nguy&ecirc;n tr&ecirc;n upper, thể hiện qua h&igrave;nh d&aacute;ng tổng thể của gi&agrave;y. Từ chiếc patch logo tr&ograve;n b&ecirc;n h&ocirc;ng th&acirc;n gi&agrave;y quen thuộc đến kiểu d&aacute;ng cao cổ c&aacute; t&iacute;nh. Tuy nhi&ecirc;n Converse Run Star Motion kh&ocirc;ng chỉ đơn thuần l&agrave; một bản sao hay phi&ecirc;n bản cải tiến của mẫu gốc, m&agrave; l&agrave; một c&aacute;ch thể hiện sự s&aacute;ng tạo v&agrave; c&aacute;i nh&igrave;n tương lai của Converse.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\" Converse Run Star Motion - Sự đột phá đầy táo bạo trong thiết kế mới\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Converse%20Run%20Star%20Motion/converse-run-star-motion-12.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Nguồn: Sưu tầm</p>\r\n\r\n<p dir=\"ltr\">Thay v&igrave; đơn thuần giữ nguy&ecirc;n những chi tiết cổ điển, item l&agrave; sự kết hợp ho&agrave;n hảo giữa t&iacute;nh quen thuộc v&agrave; sự cải tiến vượt trội, tạo ra một di sản vừa cổ điển vừa hiện đại đầy sức h&uacute;t.</p>\r\n\r\n<p dir=\"ltr\">Với tinh thần &quot;Create Next Comfort&quot;, Converse Run Star Motion được n&acirc;ng cấp một c&aacute;ch đặc biệt chủ yếu ở phần đế đầy ấn tượng v&agrave; tạo n&ecirc;n dấu ấn ri&ecirc;ng biệt. Converse Run Star Motion được thiết kế theo phong c&aacute;ch Chunky mạnh mẽ với sự đổi mới s&aacute;ng tạo từ đế ngo&agrave;i Platform ph&oacute;ng đại gợn s&oacute;ng cường điệu tạo lực k&eacute;o vượt trội, tạo n&ecirc;n một ngoại h&igrave;nh hầm hố v&agrave; kh&aacute;c biệt. Phần mặt đế của gi&agrave;y được chia th&agrave;nh hai phần với c&aacute;c đường răng cưa lớn v&agrave; đường lượn s&oacute;ng tinh xảo.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\" Converse Run Star Motion - Sự đột phá đầy táo bạo trong thiết kế mới\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Converse%20Run%20Star%20Motion/converse-run-star-motion-13.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Nguồn: Sưu tầm</p>\r\n\r\n<p dir=\"ltr\">Tr&ecirc;n g&oacute;t gi&agrave;y, bạn sẽ dễ d&agrave;ng nhận ra một miếng d&aacute;n h&igrave;nh ng&ocirc;i sao nổi bật đậm chất thương hiệu. Đ&acirc;y ch&iacute;nh l&agrave; điểm nhấn biểu tượng của d&ograve;ng sản phẩm, tạo n&ecirc;n điểm nổi bật kh&ocirc;ng thể bỏ qua. V&agrave; đ&acirc;y cũng ch&iacute;nh l&agrave; biểu tượng nhận dạng thương hiệu m&agrave; bất kỳ t&iacute;n đồ n&agrave;o nh&igrave;n v&agrave;o đều c&oacute; thể ph&acirc;n biệt v&agrave; nhận biết. Th&ecirc;m v&agrave;o đ&oacute;, chi tiết n&agrave;y c&ograve;n thể hiện gi&aacute; trị v&agrave; phong c&aacute;ch cho Converse Run Star Motion.</p>', '<p>Giới t&iacute;nh: Nam</p>\r\n\r\n<p>Phần th&acirc;n:&nbsp;Vải</p>\r\n\r\n<p>Lớp l&oacute;t: Vải</p>\r\n\r\n<p>Đế gi&agrave;y: Cao su</p>\r\n\r\n<p>Nơi sản xuất: Việt Nam</p>', 2210000, 0, 1, '2025-06-26 06:38:50', '2025-06-26 06:38:50'),
(106, 15, 21, 50, 'Converse Run Star Motion Canvas Platform White Cổ Cao', 'converse-run-star-motion-canvas-platform-white-co-cao', '<h5><em><strong>Converse đ&atilde; kh&ocirc;ng ngừng cải tiến từng bước vươn l&ecirc;n khẳng định vị thế của m&igrave;nh trong thế giới gi&agrave;y sneaker. V&agrave; đặc biệt khi h&atilde;ng cho ra mắt phi&ecirc;n bản Converse Run Star Motion - một h&igrave;nh thể mới được n&acirc;ng cấp v&agrave; khai th&aacute;c cho th&ocirc;ng điệp &ldquo;Innovation&rdquo; bắt nguồn từ đ&ocirc;i Run Star Hike. Lấy cảm hứng từ &yacute; niệm thời trang tương lai, item thuộc một trong c&aacute;c thiết kế của BST Create Next Comfort, mang lại trải nghiệm mới mẻ cho người d&ugrave;ng. C&ugrave;ng Drake VN kh&aacute;m ph&aacute; vẻ đẹp từ ngoại h&igrave;nh t&aacute;o bạo c&ugrave;ng những điểm nhấn mới mẻ của Converse Run Star Motion qua b&agrave;i viết n&agrave;y nh&eacute;.</strong></em></h5>\r\n\r\n<p><img alt=\" Converse Run Star Motion - Sự đột phá đầy táo bạo trong thiết kế mới\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Converse%20Run%20Star%20Motion/converse-run-star-motion-11.jpg\" /></p>\r\n\r\n<p>Nguồn: Sưu tầm</p>\r\n\r\n<h2 dir=\"ltr\"><strong>B&iacute; mật đằng sau thiết kế t&aacute;o bạo của Converse Run Star Motion</strong></h2>\r\n\r\n<p dir=\"ltr\">Như một sự kế thừa đầy tự h&agrave;o từ đ&agrave;n anh&nbsp;<a href=\"https://drake.vn/converse/converse-run-star-hike-twisted-classic-foundational-canvas-166799v\">Converse Run Star Hike</a>, Converse Run Star Motion kh&ocirc;ng chỉ l&agrave; sự tiếp nối m&agrave; c&ograve;n mang trong m&igrave;nh sự ho&agrave;i cổ trong thiết kế ho&agrave;n hảo của Converse Chuck Taylor.</p>\r\n\r\n<p dir=\"ltr\"><img alt=\" Converse Run Star Motion - Sự đột phá đầy táo bạo trong thiết kế mới\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Converse%20Run%20Star%20Motion/converse-run-star-motion-1.jpg\" /></p>\r\n\r\n<p dir=\"ltr\">Nguồn: Sưu tầm</p>\r\n\r\n<p dir=\"ltr\">Bản chất cổ điển v&agrave; gợi nhớ qu&aacute; khứ vẫn được giữ nguy&ecirc;n tr&ecirc;n upper, thể hiện qua h&igrave;nh d&aacute;ng tổng thể của gi&agrave;y. Từ chiếc patch logo tr&ograve;n b&ecirc;n h&ocirc;ng th&acirc;n gi&agrave;y quen thuộc đến kiểu d&aacute;ng cao cổ c&aacute; t&iacute;nh. Tuy nhi&ecirc;n Converse Run Star Motion kh&ocirc;ng chỉ đơn thuần l&agrave; một bản sao hay phi&ecirc;n bản cải tiến của mẫu gốc, m&agrave; l&agrave; một c&aacute;ch thể hiện sự s&aacute;ng tạo v&agrave; c&aacute;i nh&igrave;n tương lai của Converse.</p>', '<p>Giới t&iacute;nh: Nam</p>\r\n\r\n<p>Phần th&acirc;n:&nbsp;Vải</p>\r\n\r\n<p>Lớp l&oacute;t: Vải</p>\r\n\r\n<p>Đế gi&agrave;y: Cao su</p>\r\n\r\n<p>Nơi sản xuất: Việt Nam</p>', 2210000, 0, 1, '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(110, 15, 22, 21, 'Vans UA SK8-Hi 38 DX Anaheim Factory Spider', 'vans-ua-sk8-hi-38-dx-anaheim-factory-spider', '<p><em><strong>Một cảm hứng mạnh mẽ với họa tiết bắt mắt, Vans vừa lộ diện BST mới với t&ecirc;n gọi Vans Spider Web Anaheim. Kh&ocirc;ng cần phải h&igrave;nh dung v&igrave; ch&iacute;nh t&ecirc;n gọi cũng đ&atilde; thể hiện được c&aacute;c họa tiết m&agrave; nh&agrave; thiết kế gửi gắm v&agrave;o đ&ocirc;i gi&agrave;y. Những họa tiết &ldquo;Spider Web&rdquo; đầy ma qu&aacute;i được trải đều tr&ecirc;n 2 phi&ecirc;n bản SK8 - Hi v&agrave; Slip - On, mang đến diện mạo mới mẻ c&ugrave;ng nhiều cung bậc cảm x&uacute;c cho người mang v&agrave; cả người đối diện.</strong></em></p>\r\n\r\n<p><em><strong><img alt=\"Vans Spider Web Anaheim cho mùa lễ hội thêm ấn tượng\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Vans%20Spider%20Web%20Anaheim/vans-spider-web-3.jpg\" /></strong></em></p>\r\n\r\n<p>Nguồn: Sưu tầm</p>\r\n\r\n<p><strong>Vans Anaheim lộ diện họa tiết Spider web</strong></p>\r\n\r\n<p>Vans một lần nữa xuất hiện trở lại. V&agrave; lần n&agrave;y, t&aacute;c phẩm nghệ thuật được bao phủ bởi họa tiết Spider Web tr&ecirc;n hai phi&ecirc;n bản đặc trưng. Th&ocirc;ng thường những chiếc mạng&nbsp;nhện được dệt từ những con nhện nhằm mục đ&iacute;ch săn mồi để t&igrave;m kiếm thức ăn. H&igrave;nh ảnh những chiếc mạng nhện n&agrave;y được thiết kế ổn định, đan xen với nhau một c&aacute;ch đặc biệt.</p>\r\n\r\n<p><img alt=\"Vans Spider Web Anaheim cho mùa lễ hội thêm ấn tượng\" src=\"https://drake.vn/image/catalog/H%C3%ACnh%20content/Vans%20Spider%20Web%20Anaheim/vans-spider-web-2.jpg\" /></p>\r\n\r\n<p>Nguồn: Sưu tầm</p>\r\n\r\n<p>Sự hiện diện của họa tiết Spider Web tr&ecirc;n BST nh&agrave; Vans cũng rất dễ hiểu, những chiếc mạng nhện được x&acirc;y dựng l&agrave;m căn cứ săn mồi cho m&igrave;nh, kh&ocirc;ng chỉ gi&uacute;p nhện đ&aacute;nh chặn con mồi m&agrave; c&ograve;n l&agrave; nơi thu h&uacute;t c&aacute;c c&ocirc;n tr&ugrave;ng kh&aacute;c. Từ những h&igrave;nh ảnh của Spider Web đ&atilde; gi&uacute;p Vans thiết lập một &yacute; nghĩa mới, Vans lu&ocirc;n x&acirc;y dựng c&aacute;c thiết kế độc đ&aacute;o để thu h&uacute;t người d&ugrave;ng, chủ động trong việc x&acirc;y dựng h&igrave;nh ảnh thương hiệu mới.</p>', '<p>Giới t&iacute;nh: Nam</p>\r\n\r\n<p>Phần th&acirc;n:&nbsp;100% Textile</p>\r\n\r\n<p>Lớp l&oacute;t: Vải</p>\r\n\r\n<p>Đế gi&agrave;y: Cao su</p>\r\n\r\n<p>Nơi sản xuất: Việt Nam</p>', 650000, 0, 1, '2025-06-26 07:01:05', '2025-06-26 07:01:05'),
(111, 18, 20, 100, 'Đôi tất thể thao cổ ngắn adidas', 'doi-tat-the-thao-co-ngan-adidas', '<p><strong>Đ&Ocirc;I TẤT &Ecirc;M &Aacute;I C&Oacute; SỬ DỤNG HỖN HỢP C&Aacute;C CHẤT LIỆU T&Aacute;I CHẾ V&Agrave; C&Oacute; THỂ T&Aacute;I TẠO.</strong><br />\r\nDiện mẫu tất cổ ch&acirc;n adidas n&agrave;y với gi&agrave;y sneaker cổ thấp để khoe trọn logo tinh tế m&agrave; đặc trưng. L&agrave;m từ chất liệu pha cotton v&agrave; polyester, mẫu tất n&agrave;y c&oacute; thiết kế ch&uacute; trọng cảm gi&aacute;c thoải m&aacute;i suốt ng&agrave;y d&agrave;i. Lớp đệm ở g&oacute;t v&agrave; mũi ch&acirc;n n&acirc;ng đỡ từng sải bước, đồng thời đường may liền ở mũi ch&acirc;n gi&uacute;p ngăn ngừa ch&agrave; x&aacute;t.</p>\r\n\r\n<p>Sản phẩm n&agrave;y c&oacute; chứa tối thiểu 50% hỗn hợp c&aacute;c chất liệu t&aacute;i chế v&agrave; c&oacute; thể t&aacute;i tạo.</p>', '<p>Chiều d&agrave;i đến mắt c&aacute; ch&acirc;n</p>\r\n\r\n<p>62% cotton, 34% polyester t&aacute;i chế, 3% elastane, 1% nylon t&aacute;i chế</p>\r\n\r\n<p>Mỗi bộ sản phẩm gồm ba đ&ocirc;i</p>\r\n\r\n<p>N&acirc;ng đỡ v&ograve;m b&agrave;n ch&acirc;n</p>\r\n\r\n<p>Đệm l&oacute;t ở mũi ch&acirc;n v&agrave; g&oacute;t ch&acirc;n</p>\r\n\r\n<p>Đường may liền ở mũi ch&acirc;n</p>\r\n\r\n<p>Cổ tất bo g&acirc;n</p>', 350000, 0, 1, '2025-06-26 07:14:58', '2025-06-26 07:14:58'),
(112, 18, 20, 100, 'Đôi tất thể thao cổ chân có đệm adidas', 'doi-tat-the-thao-co-chan-co-dem-adidas', '<p><strong>Đ&Ocirc;I TẤT &Ecirc;M &Aacute;I C&Oacute; SỬ DỤNG HỖN HỢP C&Aacute;C CHẤT LIỆU T&Aacute;I CHẾ V&Agrave; C&Oacute; THỂ T&Aacute;I TẠO.</strong><br />\r\nDiện mẫu tất cổ ch&acirc;n adidas n&agrave;y với gi&agrave;y sneaker cổ thấp để khoe trọn logo tinh tế m&agrave; đặc trưng. L&agrave;m từ chất liệu pha cotton v&agrave; polyester, mẫu tất n&agrave;y c&oacute; thiết kế ch&uacute; trọng cảm gi&aacute;c thoải m&aacute;i suốt ng&agrave;y d&agrave;i. Lớp đệm ở g&oacute;t v&agrave; mũi ch&acirc;n n&acirc;ng đỡ từng sải bước, đồng thời đường may liền ở mũi ch&acirc;n gi&uacute;p ngăn ngừa ch&agrave; x&aacute;t.</p>\r\n\r\n<p>Sản phẩm n&agrave;y c&oacute; chứa tối thiểu 50% hỗn hợp c&aacute;c chất liệu t&aacute;i chế v&agrave; c&oacute; thể t&aacute;i tạo.</p>', '<p>Chiều d&agrave;i đến mắt c&aacute; ch&acirc;n</p>\r\n\r\n<p>62% cotton, 34% polyester t&aacute;i chế, 3% elastane, 1% nylon t&aacute;i chế</p>\r\n\r\n<p>Mỗi bộ sản phẩm gồm ba đ&ocirc;i</p>\r\n\r\n<p>N&acirc;ng đỡ v&ograve;m b&agrave;n ch&acirc;n</p>\r\n\r\n<p>Đệm l&oacute;t ở mũi ch&acirc;n v&agrave; g&oacute;t ch&acirc;n</p>\r\n\r\n<p>Đường may liền ở mũi ch&acirc;n</p>\r\n\r\n<p>Cổ tất bo g&acirc;n</p>', 350000, 0, 1, '2025-06-26 07:16:09', '2025-06-26 07:16:09'),
(113, 18, 25, 200, 'Dây giày thể thao cơ bản kiểu tròn', 'day-giay-the-thao-co-ban-kieu-tron', '<h2>Điểm nổi bật của sản phẩm</h2>\r\n\r\n<p>Dệt nhiều sợ d&agrave;y xen kẽ, bền, chống m&agrave;i m&ograve;n theo thời gian.</p>\r\n\r\n<p>Sử dụng c&ocirc;ng nghệ &eacute;p n&oacute;ng, l&agrave;m cứng đầu d&acirc;y gi&agrave;y</p>\r\n\r\n<p>Kh&ocirc;ng phai m&agrave;u.</p>\r\n\r\n<p>Chống trượt (tuột d&acirc;y) vượt trội</p>\r\n\r\n<p>Đa dạng m&agrave;u sắc, ph&ugrave; hợp với nhiều loại gi&agrave;y</p>', '<p>K&iacute;ch thước: 0.5m &ndash; 4m</p>\r\n\r\n<p>Chất liệu: sợi polyester (mịn)</p>\r\n\r\n<p>Bảo vệ m&ocirc;i trường, được chứng nhận bởi Oeko-Tex Stardand 100</p>', 50000, 0, 1, '2025-06-26 07:19:53', '2025-06-26 07:19:53'),
(114, 18, 25, 99, 'Xịt thơm chân Ximo 200ml', 'xit-thom-chan-ximo-200ml', '<p>Bạn thường xuy&ecirc;n cảm thấy kh&oacute; chịu v&igrave; đ&ocirc;i ch&acirc;n bị ẩm ướt v&agrave; m&ugrave;i h&ocirc;i kh&ocirc;ng biết từ đ&acirc;u khiến bạn trở n&ecirc;n tự ti với bạn b&egrave;, mọi người xung quanh.</p>\r\n\r\n<p>Deodorant được l&agrave;m từ dầu sả v&agrave; dầu thực vật l&agrave;m trung h&ograve;a v&agrave; loại bỏ m&ugrave;i h&ocirc;i. Hạt thương thơm tạo m&ugrave;i tự nhiện.</p>\r\n\r\n<p>Với ứng dụng c&ocirc;ng nghệ ti&ecirc;n tiến gi&uacute;p ức chế vi khuẩn g&acirc;y m&ugrave;i, giảm tiết mồ h&ocirc;i ch&acirc;n, sản phẩm Xịt thơm ch&acirc;n Ximo hứa hẹn sẽ l&agrave; giải ph&aacute;p to&agrave;n diện gi&uacute;p bạn lu&ocirc;n tự tin sải bước tr&ecirc;n mọi nẻo đường cuộc sống.</p>', '<p>Dung t&iacute;ch: 200ml</p>\r\n\r\n<p>C&ocirc;ng dụng:&nbsp;gi&uacute;p khử m&ugrave;i h&ocirc;i ch&acirc;n v&agrave; khử m&ugrave;i gi&agrave;y ngăn tiết mồ h&ocirc;i v&agrave; vi khuẩn g&acirc;y m&ugrave;i</p>\r\n\r\n<p>Phạm vi sử dụng: L&ograve;ng b&agrave;n ch&acirc;n, gi&agrave;y, tất</p>\r\n\r\n<p>Sản xuất: Trung Quốc&nbsp;</p>', 150000, 0, 1, '2025-06-26 07:21:21', '2025-06-26 07:36:09'),
(123, 15, 20, 6, 'Adidas VL COURT 3.0 Cloud White', 'adidas-vl-court-30-cloud-white', '<p><span style=\"font-size:20px\"><strong>Adidas Nam VL Court 3.0</strong></span><br />\r\nGi&agrave;y VL COURT 3.0&nbsp;l&agrave; mẫu gi&agrave;y sneaker mang phong c&aacute;ch cổ điển nhưng hiện đại, được ưa chuộng bởi sự đơn giản, tinh tế v&agrave; dễ phối đồ. Với thiết kế phần tr&ecirc;n bằng da mềm mại, đế cao su vulcanized &ecirc;m &aacute;i v&agrave; logo adidas 3 sọc huyền thoại, VL COURT 3.0 l&agrave; lựa chọn ho&agrave;n hảo cho những ai y&ecirc;u th&iacute;ch phong c&aacute;ch thời trang đường phố.</p>\r\n\r\n<p><strong>Điểm nổi bật:</strong></p>\r\n\r\n<p>- Phong c&aacute;ch cổ điển, hiện đại:&nbsp;VL COURT 3.0 mang thiết kế đơn giản, lấy cảm hứng từ những đ&ocirc;i gi&agrave;y tennis kinh điển, ph&ugrave; hợp với mọi phong c&aacute;ch thời trang.<br />\r\n- Chất liệu cao cấp:&nbsp;Phần tr&ecirc;n được l&agrave;m từ da mềm mại, &ecirc;m &aacute;i, gi&uacute;p &ocirc;m s&aacute;t b&agrave;n ch&acirc;n v&agrave; tạo cảm gi&aacute;c thoải m&aacute;i khi mang. Đế gi&agrave;y được l&agrave;m từ cao su vulcanized bền bỉ, chống trơn trượt.<br />\r\nThoải m&aacute;i v&agrave; linh hoạt:&nbsp;VL COURT 3.0 được trang bị lớp đệm l&oacute;t Cloudfoam Lite &ecirc;m &aacute;i, gi&uacute;p giảm thiểu cảm gi&aacute;c mỏi ch&acirc;n khi mang trong thời gian d&agrave;i.<br />\r\nDễ d&agrave;ng phối đồ:&nbsp;VL COURT 3.0 c&oacute; m&agrave;u sắc đơn giản, dễ d&agrave;ng phối hợp với nhiều loại trang phục kh&aacute;c nhau, từ quần jean, &aacute;o thun đến v&aacute;y đầm.</p>', '<p>Phần th&acirc;n: 100% Textile</p>\r\n\r\n<p>Lớp l&oacute;t: Vải</p>\r\n\r\n<p>Đế gi&agrave;y: Cao su</p>\r\n\r\n<p>Nơi sản xuất: Việt Nam</p>', 1290000, 1, 1, '2025-07-21 13:17:02', '2025-11-10 10:56:38'),
(130, 15, 23, 5, 'Air Jordan 1 Lows', 'air-jordan-1-lows', '<p>a</p>', '<p>a</p>', 3669000, 0, 1, '2025-10-29 03:39:05', '2025-11-10 15:24:53'),
(134, 16, 20, 2, 'Dép Đi Bơi Adilette', 'dep-di-boi-adilette', '<ul>\r\n	<li>Kiểu d&aacute;ng ti&ecirc;u chuẩn</li>\r\n	<li>Kiểu d&aacute;ng gi&agrave;y lười, dễ d&agrave;ng xỏ v&agrave;o</li>\r\n	<li>Th&acirc;n gi&agrave;y bằng da</li>\r\n	<li>L&ograve;ng d&eacute;p &ocirc;m theo d&aacute;ng ch&acirc;n</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Đế giữa Cloudfoam</li>\r\n	<li>Đế ngo&agrave;i l&agrave;m từ chất liệu tổng hợp</li>\r\n	<li>M&agrave;u sản phẩm: Wonder White / Wonder White / Wonder White</li>\r\n	<li>M&atilde; sản phẩm: JP5191</li>\r\n</ul>', '<p>Bước ra với phong c&aacute;ch thật s&agrave;nh điệu c&ugrave;ng đ&ocirc;i d&eacute;p Adilette của adidas. Đế giữa Cloudfoam &ecirc;m &aacute;i n&acirc;ng đỡ từng bước ch&acirc;n, trong khi l&ograve;ng d&eacute;p được thiết kế &ocirc;m s&aacute;t b&agrave;n ch&acirc;n mang đến cảm gi&aacute;c thoải m&aacute;i v&agrave; sang trọng. Biểu tượng 3 Sọc hiện đại chạy dọc quai d&eacute;p đơn tạo n&ecirc;n n&eacute;t thanh lịch. D&ugrave; ng&agrave;y của bạn bận rộn thế n&agrave;o, thiết kế đơn giản gi&uacute;p bạn dễ d&agrave;ng xỏ v&agrave;o v&agrave; th&aacute;o ra.</p>', 750000, 0, 1, '2025-11-09 09:10:59', '2025-11-10 10:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `productimage`
--

DROP TABLE IF EXISTS `productimage`;
CREATE TABLE IF NOT EXISTS `productimage` (
  `idImage` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProduct` int UNSIGNED NOT NULL,
  `ImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ImagePaths` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idImage`),
  KEY `idProduct` (`idProduct`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productimage`
--

INSERT INTO `productimage` (`idImage`, `idProduct`, `ImageName`, `ImagePaths`, `created_at`, `updated_at`) VALUES
(106, 100, '[\"converse-classic-18540.jpg\",\"converse-classic-28438.jpg\",\"converse-classic-31441.jpg\"]', NULL, '2025-06-26 05:09:27', '2025-06-26 05:09:27'),
(111, 105, '[\"17276.jpg\",\"186565.jpg\",\"196131.jpg\"]', NULL, '2025-06-26 06:38:50', '2025-06-26 06:38:50'),
(112, 106, '[\"17250.jpg\",\"138790.jpg\",\"142528.jpg\",\"154239.jpg\"]', NULL, '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(115, 110, '[\"12148.jpg\",\"26245.jpg\",\"33269.jpg\"]', NULL, '2025-06-26 07:01:05', '2025-06-26 07:01:05'),
(116, 111, '[\"tat-adidas-trang8250.jpg\"]', NULL, '2025-06-26 07:14:58', '2025-06-26 07:14:58'),
(117, 112, '[\"tat-adidas-den3634.jpg\"]', NULL, '2025-06-26 07:16:09', '2025-06-26 07:16:09'),
(119, 114, '[\"xit-thom-chan-ximo-13553.jpg\"]', NULL, '2025-06-26 07:21:21', '2025-06-26 07:21:21'),
(120, 113, '[\"day-giay-kieu-tron-the-thao-co-ban-du-cac-mau-sac-ben-bi-104954.jpg\",\"thumb-day-giay-kieu-tron-the-thao-co-ban-du-cac-mau-sac-ben-bi-136925.jpg\"]', NULL, '2025-06-26 07:21:39', '2025-06-26 07:21:39'),
(128, 123, '[\"2307537.jpg\",\"3619262.jpg\",\"4569698.jpg\"]', NULL, '2025-07-21 13:17:02', '2025-07-21 13:17:02'),
(139, 130, '[\"airj98.png\",\"airj277.png\",\"airj316.jpg\"]', NULL, '2025-10-29 03:39:05', '2025-10-29 03:39:05'),
(143, 134, '[\"dep381.jpg\",\"dep290.jpg\",\"dep154.jpg\"]', NULL, '2025-11-09 09:11:00', '2025-11-09 09:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

DROP TABLE IF EXISTS `product_attribute`;
CREATE TABLE IF NOT EXISTS `product_attribute` (
  `idProAttr` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProduct` int UNSIGNED NOT NULL,
  `idAttrValue` int UNSIGNED NOT NULL DEFAULT '11',
  `AttrValue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Quantity` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idProAttr`),
  KEY `idProduct` (`idProduct`,`idAttrValue`),
  KEY `idAttrValue` (`idAttrValue`)
) ENGINE=InnoDB AUTO_INCREMENT=593 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute`
--

INSERT INTO `product_attribute` (`idProAttr`, `idProduct`, `idAttrValue`, `AttrValue`, `Quantity`, `created_at`, `updated_at`) VALUES
(501, 100, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"55\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '6', '2025-06-26 05:09:27', '2025-06-26 05:09:27'),
(502, 100, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"56\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '10', '2025-06-26 05:09:27', '2025-06-26 05:09:27'),
(503, 100, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"57\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '9', '2025-06-26 05:09:27', '2025-06-26 05:09:27'),
(514, 105, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"62\"},{\"attribute_item\":\"7\",\"property_item\":\"58\"}]', '10', '2025-06-26 06:38:50', '2025-06-26 06:38:50'),
(515, 105, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"63\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '10', '2025-06-26 06:38:50', '2025-06-26 06:38:50'),
(516, 105, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"64\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '10', '2025-06-26 06:38:50', '2025-06-26 06:38:50'),
(517, 106, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"61\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '10', '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(518, 106, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"62\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '10', '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(519, 106, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"63\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '10', '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(520, 106, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"64\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '10', '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(521, 106, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"65\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '10', '2025-06-26 06:44:01', '2025-06-26 06:44:01'),
(532, 110, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"62\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '10', '2025-06-26 07:01:05', '2025-06-26 07:01:05'),
(533, 110, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"63\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '8', '2025-06-26 07:01:05', '2025-06-26 07:01:05'),
(534, 110, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"64\"},{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '3', '2025-06-26 07:01:05', '2025-06-26 07:01:05'),
(535, 111, 11, '[{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '100', '2025-06-26 07:14:58', '2025-06-26 07:14:58'),
(536, 112, 11, '[{\"attribute_item\":\"7\",\"property_item\":\"59\"}]', '100', '2025-06-26 07:16:09', '2025-06-26 07:16:09'),
(537, 113, 11, '[{\"attribute_item\":\"7\",\"property_item\":\"58\"}]', '100', '2025-06-26 07:19:53', '2025-06-26 07:19:53'),
(538, 113, 11, '[{\"attribute_item\":\"7\",\"property_item\":\"70\"}]', '100', '2025-06-26 07:19:53', '2025-06-26 07:19:53'),
(539, 114, 11, '[{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '100', '2025-06-26 07:21:21', '2025-06-26 07:21:21'),
(575, 123, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"57\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '1', '2025-07-21 13:17:02', '2025-07-21 13:17:02'),
(576, 123, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"61\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '5', '2025-07-21 13:17:02', '2025-07-21 13:17:02'),
(588, 130, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"55\"},{\"attribute_item\":\"7\",\"property_item\":\"58\"}]', '5', '2025-10-29 03:39:05', '2025-11-10 15:24:53'),
(592, 134, 11, '[{\"attribute_item\":\"6\",\"property_item\":\"62\"},{\"attribute_item\":\"7\",\"property_item\":\"60\"}]', '2', '2025-11-09 09:10:59', '2025-11-09 09:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `saleproduct`
--

DROP TABLE IF EXISTS `saleproduct`;
CREATE TABLE IF NOT EXISTS `saleproduct` (
  `idSale` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProduct` int UNSIGNED NOT NULL,
  `SaleName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SaleStart` datetime NOT NULL,
  `SaleEnd` datetime NOT NULL,
  `Percent` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idSale`),
  KEY `idProduct` (`idProduct`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viewer`
--

DROP TABLE IF EXISTS `viewer`;
CREATE TABLE IF NOT EXISTS `viewer` (
  `idView` int NOT NULL AUTO_INCREMENT,
  `idCustomer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idProduct` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idView`),
  KEY `idProduct` (`idProduct`)
) ENGINE=InnoDB AUTO_INCREMENT=454 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `viewer`
--

INSERT INTO `viewer` (`idView`, `idCustomer`, `idProduct`, `created_at`, `updated_at`) VALUES
(357, '93TLKxbLftEwSFYfNnAnQGndrjWZXg8O88rHWGsu', 100, '2025-06-26 06:18:48', '2025-06-26 06:18:48'),
(362, 'WmzXfXRDTXXGXlbVbgHCXZlDWbbDE3lhnS1qQdgg', 110, '2025-06-26 07:23:26', '2025-06-26 07:23:26'),
(377, 'SIjBm9YmxnQGO5K6ALiMrcjwFJzCFiRcR2c75zvf', 100, '2025-07-02 16:35:08', '2025-07-02 16:35:08'),
(383, 'H6qaxmrI2x6BzNF8uVyvXhYAyEb7jdkAt1eXKTE1', 105, '2025-07-03 07:06:48', '2025-07-03 07:06:48'),
(384, 'H6qaxmrI2x6BzNF8uVyvXhYAyEb7jdkAt1eXKTE1', 106, '2025-07-03 07:07:01', '2025-07-03 07:07:01'),
(392, 'al1sm4rQpDe6sl5Sz20HIT0eC8s9va0a79lq7xiJ', 100, '2025-07-03 07:27:35', '2025-07-03 07:27:35'),
(397, '1dTQcxXlQxJAe5Crk1By2PLVwGtD5yLNNggp0qer', 100, '2025-07-18 11:30:50', '2025-07-18 11:30:50'),
(417, 'ed4m2QtETFd9HZl25ZlChMnRjYYZptTX3YcC4RAo', 123, '2025-07-22 03:54:36', '2025-07-22 03:54:36'),
(418, 'ed4m2QtETFd9HZl25ZlChMnRjYYZptTX3YcC4RAo', 100, '2025-07-22 04:07:32', '2025-07-22 04:07:32'),
(421, 'F1KSadP2LCqzP9KxcDkEqunG8ml1PHMo2W2JlXst', 100, '2025-08-04 08:34:51', '2025-08-04 08:34:51'),
(422, '41', 100, '2025-08-04 09:05:48', '2025-08-04 09:05:48'),
(423, '9lcjtY7cBnwLTGLIb8nKxDrqBrIBwCpGFJUeAoXB', 123, '2025-08-04 09:29:35', '2025-08-04 09:29:35'),
(436, '8FXssP0wIliOff8TymO9RKGKiFqgVMXPDzSuDEQq', 100, '2025-10-22 07:29:26', '2025-10-22 07:29:26'),
(437, '8FXssP0wIliOff8TymO9RKGKiFqgVMXPDzSuDEQq', 123, '2025-10-22 07:45:27', '2025-10-22 07:45:27'),
(440, '45', 130, '2025-10-29 03:41:16', '2025-10-29 03:41:16'),
(441, 'B3HcISNvpN8T64JH7ibtlEYePfBujnd9GNxMgGGT', 130, '2025-10-29 08:12:01', '2025-10-29 08:12:01'),
(446, '46', 130, '2025-11-01 08:26:50', '2025-11-01 08:26:50'),
(447, '46', 113, '2025-11-01 11:08:36', '2025-11-01 11:08:36'),
(448, '46', 105, '2025-11-01 13:09:35', '2025-11-01 13:09:35'),
(449, '45', 134, '2025-11-09 14:37:07', '2025-11-09 14:37:07'),
(450, '45', 123, '2025-11-09 14:41:25', '2025-11-09 14:41:25'),
(451, 'LaQqHI02UA4MzkEZinC0aUKzEwPL37ArA2WTRSmG', 130, '2025-11-10 10:46:04', '2025-11-10 10:46:04'),
(452, 'LaQqHI02UA4MzkEZinC0aUKzEwPL37ArA2WTRSmG', 134, '2025-11-10 10:53:29', '2025-11-10 10:53:29'),
(453, 'LaQqHI02UA4MzkEZinC0aUKzEwPL37ArA2WTRSmG', 123, '2025-11-10 10:56:27', '2025-11-10 10:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

DROP TABLE IF EXISTS `voucher`;
CREATE TABLE IF NOT EXISTS `voucher` (
  `idVoucher` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `VoucherName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VoucherQuantity` int NOT NULL,
  `VoucherCondition` tinyint NOT NULL,
  `VoucherNumber` int NOT NULL,
  `VoucherCode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VoucherStart` datetime NOT NULL,
  `VoucherEnd` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idVoucher`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`idVoucher`, `VoucherName`, `VoucherQuantity`, `VoucherCondition`, `VoucherNumber`, `VoucherCode`, `VoucherStart`, `VoucherEnd`, `created_at`, `updated_at`) VALUES
(8, 'CHÀO MỪNG KHÁCH MỚI', 9998, 2, 100000, 'CHAOMUNG', '2025-03-01 21:02:00', '2025-12-31 23:00:00', '2025-03-23 14:02:53', '2025-03-23 14:02:53'),
(9, 'MÃ MIỄN PHÍ SHIP', 9998, 2, 30000, 'FREESHIP', '2025-03-01 21:03:00', '2025-12-31 21:03:00', '2025-03-23 14:03:32', '2025-03-23 14:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `idWish` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCustomer` int UNSIGNED NOT NULL,
  `idProduct` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idWish`),
  KEY `idCustomer` (`idCustomer`,`idProduct`),
  KEY `idProduct` (`idProduct`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product` ADD FULLTEXT KEY `ProductName` (`ProductName`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresscustomer`
--
ALTER TABLE `addresscustomer`
  ADD CONSTRAINT `addresscustomer_ibfk_1` FOREIGN KEY (`idCustomer`) REFERENCES `customer` (`idCustomer`) ON DELETE CASCADE;

--
-- Constraints for table `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD CONSTRAINT `attribute_value_ibfk_1` FOREIGN KEY (`idAttribute`) REFERENCES `attribute` (`idAttribute`) ON DELETE CASCADE;

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`idCustomer`) REFERENCES `customer` (`idCustomer`) ON DELETE CASCADE;

--
-- Constraints for table `billhistory`
--
ALTER TABLE `billhistory`
  ADD CONSTRAINT `billhistory_ibfk_1` FOREIGN KEY (`idBill`) REFERENCES `bill` (`idBill`) ON DELETE CASCADE;

--
-- Constraints for table `billinfo`
--
ALTER TABLE `billinfo`
  ADD CONSTRAINT `billinfo_ibfk_1` FOREIGN KEY (`idBill`) REFERENCES `bill` (`idBill`) ON DELETE CASCADE,
  ADD CONSTRAINT `billinfo_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`idCustomer`) REFERENCES `customer` (`idCustomer`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idBrand`) REFERENCES `brand` (`idBrand`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE CASCADE;

--
-- Constraints for table `productimage`
--
ALTER TABLE `productimage`
  ADD CONSTRAINT `productimage_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD CONSTRAINT `product_attribute_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `saleproduct`
--
ALTER TABLE `saleproduct`
  ADD CONSTRAINT `saleproduct_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `viewer`
--
ALTER TABLE `viewer`
  ADD CONSTRAINT `viewer_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`idCustomer`) REFERENCES `customer` (`idCustomer`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
