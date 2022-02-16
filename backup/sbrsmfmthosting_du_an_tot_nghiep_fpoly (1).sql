-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 11, 2021 lúc 09:26 PM
-- Phiên bản máy phục vụ: 10.3.32-MariaDB-log-cll-lve
-- Phiên bản PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sbrsmfmthosting_du_an_tot_nghiep_fpoly`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accessories`
--

CREATE TABLE `accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `coupon_id` int(11) DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_quantity` int(191) DEFAULT NULL,
  `discount_start_date` timestamp NULL DEFAULT NULL,
  `discount_end_date` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `category_id`, `color_id`, `user_id`, `slug`, `image`, `rating`, `price`, `coupon_id`, `discount`, `discount_type`, `min_quantity`, `discount_start_date`, `discount_end_date`, `status`, `quantity`, `detail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Khay đựng thức ăn cho chó', 4, NULL, 1, 'khay-dung-thuc-an-cho-cho', 'uploads/accessories/61a7317d0b611-bird-1.jpg', 0, 102310, NULL, '1200', '1', NULL, NULL, NULL, 1, 21, NULL, '2021-10-30 08:17:48', '2021-12-08 18:27:20', NULL),
(2, 'Khay đựng nước cho Huy', 5, NULL, 1, 'khay-dung-nuoc-cho-huy', 'uploads/accessories/61a731af57997-bird-2.jpg', 0, 102310, NULL, NULL, NULL, NULL, NULL, NULL, 1, 122, 'test', '2021-10-30 08:21:50', '2021-12-08 18:27:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accessory_galleries`
--

CREATE TABLE `accessory_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `accessory_galleries`
--

INSERT INTO `accessory_galleries` (`id`, `accessory_id`, `image_url`, `order_no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'uploads/accessories/galleries/5/618a271c96642-banner-muitl.png', '1', '2021-11-09 07:45:32', '2021-11-30 17:05:36', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ages`
--

CREATE TABLE `ages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `age` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ages`
--

INSERT INTO `ages` (`id`, `age`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Từ 1 đến 5 tháng tuổi', '2021-10-28 16:17:53', '2021-10-28 16:17:53', NULL),
(2, 'Từ 6 đến 8 tháng tuổi', '2021-10-28 16:17:53', '2021-10-28 16:17:53', NULL),
(9, '1 năm tuổi', '2021-11-28 08:15:30', '2021-11-28 08:15:30', NULL),
(10, '11', '2021-11-28 08:27:05', '2021-11-28 08:27:05', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_blog_id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `user_id`, `category_blog_id`, `image`, `content`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Testla', 'testla', 2, 1, '', 'adsad', 0, '2021-10-30 08:45:55', '2021-12-09 16:09:59', NULL),
(2, 'Sad Sdasd 2', 'sad-sdasd-2', 2, 2, 'uploads/blog//617d070e54399-cate-cat.jpg', 'ádasd', 0, '2021-10-30 08:49:18', '2021-12-09 16:09:59', NULL),
(3, 'Asda Dsad', 'df', 1, 2, 'uploads/blog//617d074fd8e4f-hinh-anh-cho-pitbull-deo-kinh-ram-ngau.jpg', 'ádsad', 1, '2021-10-30 08:50:23', '2021-10-30 08:50:23', NULL),
(4, 'ád', 'ss', 1, 1, 'uploads/blog//617d076241797-204918_29103313_4123971411264945_6910818101047676291_n.jpg', 'ádasd', 1, '2021-10-30 08:50:42', '2021-11-17 07:42:12', NULL),
(7, 'ádd', 'add', 1, 2, 'uploads/blog//617d096ac3250-cate-bight.jpg', 'ád', 1, '2021-10-30 08:59:22', '2021-11-17 06:51:48', NULL),
(8, 'Trang chủ', 'trang-chu', 1, 1, 'uploads/blog//618cce62474a5-1200px-Mangekyou_Sharingan_Itachi.svg.png', '<p><img src=\"/storage/images/kLs10wVk65bR76Pq2F3gmf0WMnqti1PptB7kma4M.png\" alt=\"\" width=\"1200\" height=\"1200\" /></p>', 1, '2021-11-11 08:03:46', '2021-11-11 08:24:25', NULL),
(9, 'Huyffh', 'huyffh', 1, 2, 'uploads/blog//618cce9c71831-logololipet.png', '<p>xcvbnm</p>', 1, '2021-11-11 08:04:44', '2021-11-16 15:55:11', NULL),
(12, 'Tesltg', 'tesltg', 1, 1, 'uploads/blog//619539ad811a1-Screenshot (7).png', '<p>sdfgbhnm</p>', 1, '2021-11-17 17:19:41', '2021-11-17 17:19:41', NULL),
(13, 'tiêu d', 'tieu-d', 1, 1, 'uploads/blog//61953a5b6c639-Screenshot (2).png', '<p style=\"text-align: center;\">dfghj</p>\r\n<p style=\"text-align: center;\"><img src=\"/storage/images/79pYtXgxA0pIpMt6iAjRJTv3MUJzJZBgile7Wu0C.png\" alt=\"\" width=\"607\" height=\"341\" /></p>', 1, '2021-11-17 17:22:35', '2021-11-17 17:22:35', NULL),
(18, 'Nguồn gốc của Huy', 'nguon-goc-cua-huy', 2, 1, 'uploads/blog//61a4891a499dc-1200px-Mangekyou_Sharingan_Itachi.svg.png', '<h2 style=\"text-align: center;\"><strong>Nguồn gốc ch&oacute; Pit Bull</strong></h2>\r\n<p><img class=\"i-amphtml-intrinsic-sizer\" role=\"presentation\" src=\"/storage/images/zW3KkOhicenTd0EWfoZphVtCNKOFPf98bLW8aaOw.svg\" alt=\"\" aria-hidden=\"true\" /><img class=\"i-amphtml-fill-content i-amphtml-replaced-content\" title=\"Ch&oacute; Pitbull\" src=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull.jpg\" sizes=\"(max-width: 771px) 100vw, 771px\" srcset=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull.jpg?v=1611290772 771w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-300x142.jpg?v=1611290772 300w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-768x365.jpg?v=1611290772 768w\" alt=\"Ch&oacute; Pitbull\" /></p>\r\n<p>Pit Bull l&agrave; giống ch&oacute; được lại tạo giữa ch&oacute; ngao Anh v&agrave; ch&oacute; sục, được nu&ocirc;i lần đầu ti&ecirc;n ở Anh v&agrave;o thế kỉ 18. Pit Bull l&agrave; t&ecirc;n gọi chung của ch&oacute; sục Pit Bull mỹ, Staffordshire Bull Terrier, American Staffordshire Terrier&hellip; Giống ch&oacute; nguồn gốc từ Ch&acirc;u Mỹ n&agrave;y đang dần được nu&ocirc;i phổ biến tại Việt Nam.</p>\r\n<h2><span id=\"Dac_diem_cua_giong_cho_pit_bull\" class=\"ez-toc-section\"></span>Đặc điểm của&nbsp;<a href=\"https://www.2thucung.com/cho-pit-bull.html\">giống ch&oacute; pit bull</a></h2>\r\n<p><strong>Về ngoại h&igrave;nh v&agrave; thể chất</strong>, Pit Bull l&agrave; d&ograve;ng ch&oacute; tầm nhỏ v&agrave; trung b&igrave;nh, cao 45 &ndash; 55 cm, nặng từ 18 &ndash; 22kg với một ch&uacute; ch&oacute; trưởng th&agrave;nh. Nh&igrave;n qua c&oacute; thể thấy lo&agrave;i ch&oacute; n&agrave;y kh&aacute; dữ tợn, ch&uacute;ng c&oacute; khung xương vững ch&atilde;i, vai trước vạm vỡ, cơ bắp săn chắc, tr&aacute;n to gồ với đ&ocirc;i mắt đỏ ngầu. Giống ch&oacute; n&agrave;y nổi tiếng với vẻ ngo&agrave;i hầm hố v&agrave; hung dữ. Vậy n&ecirc;n giống ch&oacute; n&agrave;y được nhiều người chọn nu&ocirc;i để giữ nh&agrave; d&ugrave; nguy hiểm, v&igrave; vẻ ngo&agrave;i h&ugrave;ng hổ sẵn s&agrave;ng tấn c&ocirc;ng m&agrave; c&oacute; thể uy hiếp được người kh&aacute;c.</p>\r\n<p>Đặc biệt của ch&oacute; Pit Bull c&oacute; cậu tạo cơ h&agrave;m như khớp kh&oacute;a, v&igrave; vậy khi cắn vật g&igrave; hoặc đối thủ th&igrave; kh&ocirc;ng dễ nhả ra. Nếu bị Pit Bull cắn, vết thương để lại rất s&acirc;u v&agrave; rộng v&igrave; răng ch&uacute;ng kh&aacute; d&agrave;i v&agrave; cực k&igrave; sắc nhọn, nhẹ th&igrave; c&oacute; thể mang tật, nặng hơn c&oacute; thể g&acirc;y nguy hiểm đến t&iacute;nh mạng. Lực cắn của ch&uacute;ng l&ecirc;n đến 107kg c&oacute; thể giết chết ngay một con ch&oacute; kh&aacute;c. Một con Pit Bull b&igrave;nh thường c&oacute; thể cắn v&agrave; đu m&igrave;nh trong 30 ph&uacute;t, xuất phất từ thể trạng khỏe v&agrave; thần kinh th&eacute;p, cộng với sức mạnh cơ bắp tuyệt vời, một số con c&oacute; thể k&eacute;o cả một chiếc &ocirc; t&ocirc; 4 b&aacute;nh như vận động vi&ecirc;n hạng nặng.</p>\r\n<p><img class=\"i-amphtml-intrinsic-sizer\" role=\"presentation\" src=\"/storage/images/o4NxX2WzjC0vTkvkZvrwkBisMBaJpNqd2xh4w1RG.svg\" alt=\"\" aria-hidden=\"true\" /><img class=\"i-amphtml-fill-content i-amphtml-replaced-content\" title=\"Ch&oacute; Pitbull\" src=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-1.jpg\" sizes=\"(max-width: 735px) 100vw, 735px\" srcset=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-1.jpg?v=1611290772 735w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-1-300x200.jpg?v=1611290772 300w\" alt=\"Ch&oacute; Pitbull\" /></p>\r\n<p class=\"amp-wp-cdd8ca0\" data-amp-original-style=\"text-align: center;\"><em>H&igrave;nh ảnh con ch&oacute; c&oacute; thể k&eacute;o được chiếc &ocirc; t&ocirc; :)))))</em></p>\r\n<p>Về t&iacute;nh c&aacute;ch, Pit Bull b&igrave;nh thường rất hiền v&agrave; kh&aacute; th&acirc;n thiện, ch&uacute;ng chỉ th&uacute; t&iacute;nh khi bị đe dọa hoặc bị tấn c&ocirc;ng, ngo&agrave;i ra th&igrave; đ&acirc;y l&agrave; một lo&agrave;i ch&oacute; rất trung th&agrave;nh. Tuy nhi&ecirc;n, điểm đặc biệt của giống ch&oacute; n&agrave;y vẫn l&agrave; khả năng chiến đấu. Ch&uacute;ng đ&aacute;nh nhau rất hăng nếu c&oacute; đứa n&agrave;o k&iacute;ch th&iacute;ch hoặc c&oacute; người lạ x&acirc;m nhập v&agrave;o l&atilde;nh thổ v&agrave; sẵn s&agrave;ng tấn c&ocirc;ng cho đến chết. Ch&oacute; Pit Bull l&agrave; d&ograve;ng ch&oacute; nguy hiểm nhất đối với con người trong tổng số hơn 400 lo&agrave;i ch&oacute; tr&ecirc;n thế giới.</p>\r\n<p>Sự nguy hiểm của ch&uacute;ng thể hiện ở chỗ khi đ&atilde; ngoạm vật g&igrave; th&igrave; kh&ocirc;ng nhả ra cho đến khi đứt k&igrave;a v&agrave; chuyển sang chỗ kh&aacute;c, thậm ch&iacute; đay nghiến cho đến chết. Phải dại dột lắm mới d&aacute;m tấn c&ocirc;ng Pit Bull, kể cả ch&oacute; s&oacute;i hay những con th&uacute; to lớn hơn gấp nhiều lần cũng kh&oacute; l&agrave; đối thủ của ch&uacute;ng, khi đ&atilde; l&acirc;m trận, ch&uacute;ng cuồng hơn cả ch&oacute; dại.</p>\r\n<p><img class=\"i-amphtml-intrinsic-sizer\" role=\"presentation\" src=\"/storage/images/bSCGHI6KYwymciZbgpDiziw1ZKJrHU0rzZGbw9vr.svg\" alt=\"\" aria-hidden=\"true\" /><img class=\"i-amphtml-fill-content i-amphtml-replaced-content\" title=\"Ch&oacute; Pitbull\" src=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-2.jpg\" sizes=\"(max-width: 640px) 100vw, 640px\" srcset=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-2.jpg?v=1611290772 640w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-2-300x208.jpg?v=1611290772 300w\" alt=\"Ch&oacute; Pitbull\" /></p>\r\n<p class=\"amp-wp-cdd8ca0\" data-amp-original-style=\"text-align: center;\"><em>H&igrave;nh ảnh một ch&uacute; ch&oacute; Pit Bull trưởng th&agrave;nh</em></p>\r\n<h2><span id=\"Cach_cham_soc_va_huan_luyen_cho_Pit_Bull\" class=\"ez-toc-section\"></span><strong>C&aacute;ch chăm s&oacute;c v&agrave; huấn luyện ch&oacute; Pit Bull.</strong></h2>\r\n<p>Cũng như nhiều loại ch&oacute; kh&aacute;c, Pit Bull cần được kiếm tra sức khỏe định k&igrave; h&agrave;ng năm thậm ch&iacute; h&agrave;ng 3 &ndash; 6 th&aacute;ng. Tuy nhi&ecirc;n Pit Bull l&agrave; lo&agrave;i vận động mạnh n&ecirc;n cần được bổ sung nhiều đạm đặc biệt l&agrave; thịt b&ograve;. Trong thực đơn huấn luyện của Pit Bull cũng thuờng xuy&ecirc;n c&oacute; cổ g&agrave;, thường l&agrave; 12 chiếc/ng&agrave;y vừa bổ sung chất vừa luyện răng cho Pit Bull. Ăn thịt ch&oacute; sẽ khiến Pit Bull dữ tợn hơn. Về huấn luyện, ch&oacute; Pit Bull cần được huấn luyện ngay từ khi c&ograve;n nhỏ, t&ugrave;y v&agrave;o mục đ&iacute;ch của người chủ khi nu&ocirc;i Pit Bull m&agrave; sẽ c&oacute; c&aacute;ch huấn luyện kh&aacute;c nhau. Một số b&agrave;i tập thường được sử dụng như: tập bơi, chạy bộ, đeo lốp xe chạy marathon, cắn c&acirc;y chuối, x&eacute; quả dừa kh&ocirc;, t&aacute;p l&ecirc;n sợi d&acirc;y rồi treo lủng lẳng&hellip; C&aacute;c b&agrave;i tập phải được luyện tập thường xuy&ecirc;n v&agrave; người chủ phải ch&uacute; &yacute; trong qu&aacute; tr&igrave;nh huấn luyện, cần phải kh&eacute;t khe v&agrave; phải đảm bảo an to&agrave;n.</p>\r\n<p><img class=\"i-amphtml-intrinsic-sizer\" role=\"presentation\" src=\"/storage/images/IxZOZUtYBQYf5uRFS9CBL20DdB5ozMUuupAW3Wv1.svg\" alt=\"\" aria-hidden=\"true\" /><img class=\"i-amphtml-fill-content i-amphtml-replaced-content\" title=\"Ch&oacute; Pitbull\" src=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull.png\" sizes=\"(max-width: 1000px) 100vw, 1000px\" srcset=\"https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull.png?v=1611290772 1000w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-300x200.png?v=1611290772 300w, https://www.2thucung.com/wp-content/uploads/2021/01/cho-pitbull-768x511.png?v=1611290772 768w\" alt=\"Ch&oacute; Pitbull\" /></p>\r\n<p class=\"amp-wp-cdd8ca0\" data-amp-original-style=\"text-align: center;\"><em>Nếu được huấn luyện tốt, đ&acirc;y sẽ l&agrave; một người bạn tuyệt vời</em></p>', 1, '2021-11-29 08:02:34', '2021-12-09 16:09:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chăm sóc thú cưng', 'cham-soc-thu-cung', '2021-10-30 08:35:10', '2021-11-17 07:54:48', NULL),
(2, 'Dấu hiện nhận biết chó bị bệnh dại', 'dau-hieu-nhan-biet-cho-bi-benh-dai', '2021-10-30 08:35:10', '2021-10-30 08:35:10', NULL),
(3, 'Testla', 'testla', '2021-10-30 09:26:54', '2021-11-22 08:18:34', NULL),
(6, 'Trị chấy rận trên cơ thể của thú cưng', 'tri-chay-ran-tren-co-the-cua-thu-cung', '2021-11-22 08:29:00', '2021-11-22 08:39:10', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `breeds`
--

CREATE TABLE `breeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `breeds`
--

INSERT INTO `breeds` (`id`, `name`, `slug`, `category_id`, `user_id`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chó Cảnh', 'cho-canh', 1, 1, NULL, 1, '2021-10-28 13:10:49', '2021-11-20 15:19:07', NULL),
(2, 'Vẹt', 'vet', 1, 1, NULL, 1, '2021-11-21 07:49:18', '2021-11-21 07:49:20', NULL),
(3, 'Chó Săn', 'cho-san', 1, 1, NULL, 1, '2021-10-28 13:14:48', '2021-11-20 15:19:07', NULL),
(15, 'Mèo Ba Tư', 'meo-ba-tu', 2, 3, 'uploads/breeds//61a33b21894bb-Ba-tu3.png', 0, '2021-11-28 08:17:37', '2021-11-28 08:17:37', NULL),
(16, 'Mèo Bengal', 'meo-bengal', 2, 3, 'uploads/breeds//61a5c882a2527-Bengal2.png', 1, '2021-11-30 06:45:22', '2021-11-30 06:45:22', NULL),
(17, 'Mèo Munchkin', 'meo-munchkin', 2, 3, 'uploads/breeds//61a5c8a33449d-Meo-Munchkin1.png', 1, '2021-11-30 06:45:55', '2021-11-30 06:45:55', NULL),
(18, 'Mèo Mỹ lông ngắn', 'meo-my-long-ngan', 2, 3, 'uploads/breeds//61a5c8dea2f6e-Meo-My-long-ngan1.png', 1, '2021-11-30 06:46:54', '2021-11-30 06:46:54', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_slide` int(11) NOT NULL DEFAULT 1,
  `category_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `coupon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `show_slide`, `category_type_id`, `created_at`, `updated_at`, `deleted_at`, `coupon_id`) VALUES
(1, 'Chó', 'cho', 'uploads/categories/1/61acc5a09a009-Dobermann4.png', 1, 1, '2021-10-28 13:08:16', '2021-12-09 16:09:59', NULL, 0),
(2, 'Mèo', 'meo', 'uploads/categories/2/61acc5cbc073b-Meo-Munchkin2.png', 1, 1, '2021-11-21 07:50:08', '2021-12-05 14:02:25', NULL, 0),
(3, 'Chim', 'chim', 'uploads/categories/3/61acc63219f41-images.jfif', 1, 1, '2021-11-21 07:50:44', '2021-12-05 14:01:22', NULL, 0),
(4, 'Khay đựng Thức ăn', 'khay-dung-thuc-an', '6195251c5da89-Screenshot (8)', 0, 2, '2021-10-30 08:15:01', '2021-11-30 17:05:36', NULL, 0),
(5, 'Khay đựng Nước', 'khay-dung-nuoc', '6195251c5da89-Screenshot (8)', 0, 2, '2021-10-30 08:15:17', '2021-11-17 09:01:40', NULL, 0),
(6, 'Reptiles', 'reptiles', 'uploads/categories/6/61868e30c2ec1-category-reptiles.jpg', 1, 1, '2021-11-02 16:14:17', '2021-11-20 17:01:56', NULL, 0),
(7, 'Fishs', 'fishs', 'uploads/categories//61868e439ccfb-category-fish.jpg', 1, 1, '2021-11-06 14:16:35', '2021-11-20 15:19:08', NULL, 0),
(8, 'Chuột', 'chuot', 'uploads/categories//61868e7511ea5-category-mouse.jpg', 1, 1, '2021-11-06 14:17:25', '2021-12-09 16:09:59', NULL, 0),
(36, 'Dây dắt', 'day-dat', 'uploads/categories//618f7fbd16200-logololipet.png', 0, 2, '2021-11-13 09:05:01', '2021-11-15 16:03:27', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_types`
--

CREATE TABLE `category_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category_types`
--

INSERT INTO `category_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `slug`) VALUES
(1, 'Thú cưng', '2021-10-28 13:06:35', '2021-10-28 13:06:35', NULL, 'thu-cung'),
(2, 'Phụ kiện', '2021-10-28 13:06:35', '2021-10-28 13:06:35', NULL, 'phu-kien'),
(3, 'Thức ăn', '2021-10-28 13:06:56', '2021-10-28 13:06:56', NULL, 'thuc-an'),
(4, 'Noobs', '2021-11-22 09:39:53', '2021-11-22 09:39:53', NULL, 'noobs'),
(6, 'Noo', '2021-11-22 09:41:16', '2021-11-22 16:00:00', '2021-11-22 16:00:00', 'noo'),
(7, 'Noosess', '2021-11-22 09:42:15', '2021-11-22 09:46:55', NULL, 'nooess');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` int(11) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `user_id`, `type`, `code`, `details`, `discount`, `discount_type`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Covid-2021', 'Khuyen mai covid', '12', 1, '2021-10-27 17:00:00', '2021-10-28 17:00:00', '2021-10-28 10:10:32', '2021-11-27 08:19:42', NULL),
(2, 1, 2, 'Covid-2021', 'Khuyen mai covid', '12', 1, '2021-10-27 17:00:00', '2021-10-28 17:00:00', '2021-10-28 10:10:46', '2021-11-27 08:19:42', NULL),
(4, 1, 1, 'PH11301', 'opps!!!', '300000', 1, '2021-11-07 17:00:00', '2021-11-09 17:00:00', '2021-11-06 16:03:51', '2021-11-27 08:19:42', NULL),
(5, 1, 1, 'PH11302', 'Khuyến mãi 1 năm cửa hàng hoạt động', '300000', 1, '2021-11-07 17:00:00', '2021-11-09 17:00:00', '2021-11-08 06:24:13', '2021-11-27 08:19:42', NULL),
(7, 2, 1, 'ph111', '00008', '300000', 1, NULL, NULL, '2021-11-08 06:41:59', '2021-12-09 16:09:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_types`
--

CREATE TABLE `coupon_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_types`
--

INSERT INTO `coupon_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sản phẩm', '2021-10-28 11:04:31', '2021-10-28 11:04:31', NULL),
(2, 'Tổng đơn hàng', '2021-10-28 11:04:31', '2021-10-28 11:04:31', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, '2021-11-12 07:00:31', '2021-12-09 16:09:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_types`
--

CREATE TABLE `discount_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `discount_types`
--

INSERT INTO `discount_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Giá tiền', '2021-10-28 11:05:16', '2021-11-27 08:19:43', NULL),
(2, 'Phần trăm', '2021-10-28 11:05:16', '2021-11-27 08:19:43', NULL),
(5, 'Nobels', '2021-11-27 08:55:58', '2021-11-27 08:56:57', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `footers`
--

CREATE TABLE `footers` (
  `id` int(11) NOT NULL,
  `footer_title_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `general_setting_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `footers`
--

INSERT INTO `footers` (`id`, `footer_title_id`, `type`, `content`, `icon`, `url`, `general_setting_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'nope', 'nope', 'nope', 1, '2021-11-23 14:35:42', '2021-11-25 15:45:15', NULL),
(2, 2, 1, 'Super', 'h', 'http://huypqph11301.xyz/', 1, '2021-11-23 16:55:09', '2021-11-25 15:45:15', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `footer_titles`
--

CREATE TABLE `footer_titles` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `footer_titles`
--

INSERT INTO `footer_titles` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lolipet', 1, '2021-11-23 14:24:59', '2021-11-23 15:54:04', NULL),
(2, 'Lolipets', 1, '2021-11-23 14:24:59', '2021-11-23 15:54:04', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `genders`
--

INSERT INTO `genders` (`id`, `gender`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Giống đực', '2021-10-28 14:02:04', '2021-10-28 14:02:04', NULL),
(2, 'Giống cái', '2021-10-28 14:02:04', '2021-10-28 14:02:04', NULL),
(3, 'Lưỡng tính', '2021-10-28 14:02:32', '2021-10-28 14:02:32', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `phone`, `email`, `map`, `address`, `open_time`, `facebook`, `instagram`, `twitter`, `youtube`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'uploads/logo//61b3ebfce44fa-logo_full.png', '0336126725', 'lolipetvn@gmail.com', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8638558814587!2d105.74459841533215!3d21.038132792833153!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b991d80fd5%3A0x53cefc99d6b0bf6f!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1638181372341!5m2!1svi!2s\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'Số 168 Thượng Đình – Thanh Xuân – Hà Nội', '8:00AM - 18:00PM', 'https://www.facebook.com/huyphan291001', NULL, NULL, NULL, NULL, '2021-12-11 00:09:55', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_28_072629_create_products_table', 1),
(6, '2021_09_28_092237_create_categories_table', 1),
(7, '2021_09_28_093616_create_breeds_table', 1),
(8, '2021_09_28_093640_create_genders_table', 1),
(9, '2021_09_28_093714_create_ages_table', 1),
(10, '2021_09_28_093733_create_colors_table', 1),
(11, '2021_10_03_070859_create_permission_tables', 1),
(12, '2021_10_20_074335_create_accessories_table', 1),
(13, '2021_10_20_075621_create_slides_table', 1),
(14, '2021_10_20_075916_create_announcements_table', 1),
(15, '2021_10_20_080146_create_product_galleries_table', 1),
(16, '2021_10_20_080209_create_accessory_galleries_table', 1),
(17, '2021_10_23_161451_create_general_settings_table', 1),
(18, '2021_10_23_162350_create_coupons_table', 1),
(19, '2021_10_23_162830_create_coupon_usages_table', 1),
(20, '2021_10_23_172204_create_carts_table', 1),
(21, '2021_10_23_173432_create_cities_table', 1),
(22, '2021_10_23_173807_create_countries_table', 1),
(23, '2021_10_23_174323_create_blog_categories_table', 1),
(24, '2021_10_23_174623_create_blogs_table', 1),
(25, '2021_10_23_175028_create_orders_table', 1),
(26, '2021_10_23_175859_create_order_details_table', 2),
(27, '2021_10_24_213155_create_category_types_table', 2),
(28, '2021_10_28_175429_create_coupon_types_table', 3),
(29, '2021_10_28_175456_create_discount_types_table', 3),
(30, '2021_11_06_112815_create_reviews_table', 4),
(31, '2021_11_09_152808_updatecategoriestable', 5),
(32, '2021_11_09_214043_updateproductstable', 6),
(33, '2021_11_09_225602_updateproduct_galleriestable', 7),
(34, '2021_11_11_211229_updateaccessoriestable', 8),
(35, '2021_11_11_211356_updateblogstable', 8),
(36, '2021_11_11_211449_updatebreedstable', 8),
(37, '2021_11_11_211634_updatecartstable', 8),
(38, '2021_11_11_211718_updatecoupon_usagestable', 8),
(39, '2021_11_11_211750_updatecouponstable', 8),
(40, '2021_11_11_211832_updateorderstable', 8),
(41, '2021_11_11_212017_updateslidestable', 8),
(42, '2021_11_12_005016_updateuserstable', 9),
(43, '2021_11_12_012507_updateorder_detailstable', 10),
(44, '2021_11_12_012716_updatereviewstable', 11),
(45, '2021_11_12_140327_updateannouncementstable', 11),
(46, '2021_11_12_141417_updateaccessory_galleriestable', 12),
(47, '2021_11_13_233554_updatecategory_typestable', 13),
(48, '2021_11_14_150046_updateaddressestable', 14),
(49, '2021_11_14_150118_updateagestable', 14),
(50, '2021_11_14_152142_updateblog_categoriestable', 14),
(51, '2021_11_14_152228_updatecitiestable', 14),
(52, '2021_11_14_152257_updatecountriestable', 14),
(53, '2021_11_14_152318_updatecoupon_typestable', 14),
(54, '2021_11_14_152357_updatediscount_typestable', 14),
(55, '2021_11_14_152421_updatedistrictstable', 14),
(56, '2021_11_14_152449_updategenderstable', 14),
(57, '2021_11_14_152514_updategeneral_settingstable', 14),
(58, '2021_11_18_003148_updateblogstexrtable', 15),
(59, '2021_11_19_140634_updatecategorytable', 16),
(60, '2021_11_19_145735_updatecategorytable', 17),
(61, '2021_11_19_150120_updatecategorytable', 18),
(62, '2021_11_23_152024_updatefooter_titletable', 19),
(63, '2021_11_23_213746_updatefooterstable', 20),
(64, '2021_12_04_205403_updatecategory_typetable', 21),
(65, '2021_12_05_145259_create_table_statistical', 22),
(66, '2021_11_09_205616_create_addresses_table', 23),
(67, '2021_11_09_215440_create_districts_table', 23),
(68, '2021_11_09_215509_create_wards_table', 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_status` int(11) NOT NULL,
  `grand_total` double(20,2) NOT NULL,
  `coupon_discount` int(11) DEFAULT NULL,
  `code` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `seller_id`, `user_id`, `name`, `phone`, `email`, `note`, `shipping_address`, `payment_type`, `payment_status`, `delivery_status`, `grand_total`, `coupon_discount`, `code`, `cancel_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 1, 1, 'Big boss', '0336126725', 'hungtmph10583@gmail.com', 'Giao hàng ngay', '196 Hồ Tùng Mậu, Cầu Diễn, Nam Từ Liêm, Hà Nội', 'Trả tiền khi nhận hàng', '2', 3, 39600000.00, NULL, '11112021-194819', NULL, '2021-11-11 12:48:19', '2021-12-09 10:40:20', NULL),
(25, 1, 2, 'ádasdsad', '3214123123', '12313221@fpt.edu.vn', 'đá', 'no, Cầu Diễn, Nam Từ Liêm, no', 'Trả tiền khi nhận hàng', '2', 3, 92070000.00, NULL, '13112021-194819', NULL, '2021-11-11 15:01:28', '2021-12-09 16:09:59', NULL),
(34, 1, 3, 'Khánh Ngọc', '0961316491', 'hungtmph10583@gmail.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thành phố Bạc Liêu, Bạc Liêu', 'Trả tiền khi nhận hàng', '1', 2, 21780000.00, NULL, '25112021-100337', NULL, '2021-11-25 03:03:37', '2021-12-02 07:36:04', NULL),
(35, 1, 3, 'Khánh Ngọc', '0961316491', 'ngoctkph11120@fpt.edu.vn', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Huyện Cái Nước, Cà Mau', 'Trả tiền khi nhận hàng', '1', 1, 25740000.00, NULL, '28112021-154144', NULL, '2021-11-28 08:41:44', '2021-12-02 07:36:08', NULL),
(36, 1, NULL, 'Mạnh Hung', '0336126724', 'tranmanhhung1832001@gmail.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thị xã Buôn Hồ, Đắk Lắk', 'Trả tiền khi nhận hàng', '1', 1, 12981221.00, NULL, '01122021-172813', NULL, '2021-12-01 10:28:13', '2021-12-02 07:36:13', NULL),
(37, 1, 1, 'Big boss', '0336126725', 'hungtmph10583@gmail.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thị xã Buôn Hồ, Đắk Lắk', 'Trả tiền khi nhận hàng', '1', 4, 111221.00, NULL, '01122021-173412', 'hungtmph10583@gmail.com', '2021-12-01 10:34:12', '2021-12-07 08:40:08', NULL),
(39, 1, NULL, 'Sao Kim', '0336126725', 'manhhunglzx@gmai.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thị xã Buôn Hồ, Đắk Lắk', 'Trả tiền khi nhận hàng', '1', 2, 12870000.00, NULL, '01122021-173515', NULL, '2021-12-01 10:35:15', '2021-12-08 20:29:10', NULL),
(42, 1, 1, 'Mạnh Hùng', '0336126725', 'hungtmph10583@gmail.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thành phố Bắc Giang, Bắc Giang', 'Trả tiền khi nhận hàng', '1', 2, 12982541.00, NULL, '02122021-090449', '', '2021-12-02 02:04:49', '2021-12-08 18:42:33', NULL),
(43, 1, 8, 'Manh Hung', '0365791629', 'manhhunglzx@gmail.com', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thành phố Cà Mau, Cà Mau', 'Trả tiền khi nhận hàng', '2', 3, 13093762.00, NULL, '06122021-212438', NULL, '2021-12-06 14:24:38', '2021-12-09 10:21:19', NULL),
(44, 1, 2, 'Huy Phan', '0365791629', 'huypqph11301@fpt.edu.vn', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thị xã Hoàng Mai, Nghệ An', 'Trả tiền khi nhận hàng', '2', 3, 278300000.00, NULL, '08122021-212640', NULL, '2021-12-08 14:26:40', '2021-12-09 16:09:59', NULL),
(45, NULL, 6, 'Thắng', '0965029062', 'thangdvph08801@fpt.edu.vn', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Quận Cầu Giấy, Đồng Tháp', 'Trả tiền khi nhận hàng', '1', 4, 16500000.00, NULL, '08122021-222829', 'thangdvph08801@fpt.edu.vn', '2021-12-08 15:28:29', '2021-12-08 16:16:09', NULL),
(48, 1, 2, 'Huy Phan', '0365791629', 'huypqph11301@fpt.edu.vn', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Thị xã Hoàng Mai, Nghệ An', 'Trả tiền khi nhận hàng', '2', 3, 77220000.00, NULL, '08122021-224056', NULL, '2021-12-08 15:40:56', '2021-12-09 16:09:59', NULL),
(49, NULL, 7, 'Quang Trung', '0399832584', 'trunghnqph10278@fpt.edu.vn', NULL, '196 Hồ Tùng Mậu, Cầu Diễn, Huyện Hòa Bình, Bạc Liêu', 'Trả tiền khi nhận hàng', '1', 1, 12870000.00, NULL, '10122021-211224', NULL, '2021-12-10 14:12:24', '2021-12-10 14:12:24', NULL),
(50, NULL, 2, 'Huy Phan', '0365791629', 'huypqph11301@fpt.edu.vn', NULL, 'khối 8 phường quỳnh thiện, Phường quỳnh thiện, Thị xã Hoàng Mai, Nghệ An', 'Trả tiền khi nhận hàng', '1', 4, 154440000.00, NULL, '11122021-150859', 'huypqph11301@fpt.edu.vn', '2021-12-11 08:08:59', '2021-12-11 09:13:24', NULL),
(51, NULL, 2, 'Huy Phan', '0365791629', 'huypqph11301@fpt.edu.vn', NULL, 'khối 8 phường quỳnh thiện, Quỳnh Thiện, Thị xã Hoàng Mai, Nghệ An', 'Trả tiền khi nhận hàng', '1', 4, 154996105.00, NULL, '11122021-151529', 'huypqph11301@fpt.edu.vn', '2021-12-11 08:15:29', '2021-12-11 08:34:06', NULL),
(56, NULL, 2, 'Huy Phan', '0365791629', 'huypqph11301@fpt.edu.vn', NULL, 'khối 8 phường quỳnh thiện, Quỳnh Thiện, Thị xã Hoàng Mai, Nghệ An', 'Trả tiền khi nhận hàng', '1', 4, 0.00, NULL, '11122021-162522', 'huypqph11301@fpt.edu.vn', '2021-12-11 09:25:22', '2021-12-11 09:29:39', NULL),
(57, NULL, 1, 'Mạnh Hùng', '0336126723', 'hungtmph10583@gmail.com', NULL, 'test, test, Huyện Châu Đức, Bà Rịa - Vũng Tàu', 'Trả tiền khi nhận hàng', '1', 1, 51480000.00, NULL, '11122021-212031', NULL, '2021-12-11 14:20:31', '2021-12-11 14:20:31', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `tax` double(20,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` int(11) NOT NULL DEFAULT 0,
  `shipping_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_type`, `price`, `tax`, `shipping_cost`, `shipping_type`, `payment_status`, `delivery_status`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 22, 4, 1, 24000000, 3600000.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 2, '2021-11-11 12:48:19', '2021-12-09 16:09:59', NULL),
(18, 25, 13, 1, 83700000, 8370000.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 9, '2021-11-11 15:01:28', '2021-12-09 16:09:59', NULL),
(43, 34, 5, 1, 19800000, 1980000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang giao hàng', 2, '2021-11-25 03:03:37', '2021-12-02 07:36:04', NULL),
(44, 35, 1, 1, 23400000, 2340000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lí', 2, '2021-11-28 08:41:44', '2021-12-02 07:36:08', NULL),
(45, 36, 1, 1, 11700000, 1180111.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lí', 1, '2021-12-01 10:28:13', '2021-12-02 07:36:13', NULL),
(46, 36, 1, 2, 101110, 1180111.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lí', 1, '2021-12-01 10:28:13', '2021-12-02 07:36:13', NULL),
(47, 37, 1, 2, 101110, 10111.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đơn hàng bị hủy', 1, '2021-12-01 10:34:12', '2021-12-07 08:40:08', NULL),
(48, 39, 1, 1, 11700000, 1170000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang giao hàng', 1, '2021-12-01 10:35:15', '2021-12-08 20:29:11', NULL),
(49, 42, 1, 1, 11700000, 1180231.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 1, '2021-12-02 02:04:49', '2021-12-02 08:42:36', NULL),
(50, 42, 2, 2, 102310, 1180231.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 1, '2021-12-02 02:04:49', '2021-12-09 08:06:28', NULL),
(53, 43, 2, 2, 102310, 1190342.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Đang chờ xử lý', 1, '2021-12-06 14:24:38', '2021-12-09 08:06:28', NULL),
(54, 43, 1, 2, 101110, 1190342.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Đang chờ xử lý', 1, '2021-12-06 14:24:38', '2021-12-08 10:14:08', NULL),
(55, 43, 1, 1, 11700000, 102.31, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 1, '2021-12-06 14:24:38', '2021-12-09 10:21:19', NULL),
(56, 44, 5, 1, 118800000, 25300000.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 12, '2021-12-08 14:26:40', '2021-12-08 14:26:40', NULL),
(57, 44, 4, 1, 134200000, 25300000.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 11, '2021-12-08 14:26:40', '2021-12-09 16:09:59', NULL),
(58, 45, 34, 1, 15000000, 1500000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đơn hàng bị hủy', 1, '2021-12-08 15:28:29', '2021-12-08 16:16:09', NULL),
(61, 48, 1, 1, 70200000, 7020000.00, 0, 'Giao hàng tận nhà', 'Đã thanh toán', 'Giao hàng thành công', 6, '2021-12-08 15:40:56', '2021-12-09 10:41:23', NULL),
(62, 49, 1, 1, 11700000, 1170000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lý', 1, '2021-12-10 14:12:24', '2021-12-10 14:12:24', NULL),
(63, 50, 1, 1, 140400000, 14040000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đơn hàng bị hủy', 12, '2021-12-11 08:08:59', '2021-12-11 09:13:24', NULL),
(64, 50, 2, 1, 0, 14040000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đơn hàng bị hủy', 5, '2021-12-11 08:08:59', '2021-12-11 09:13:24', NULL),
(65, 51, 1, 1, 140400000, 14090555.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lý', 12, '2021-12-11 08:15:29', '2021-12-11 08:15:29', NULL),
(66, 51, 1, 2, 505550, 14090555.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lý', 5, '2021-12-11 08:15:29', '2021-12-11 08:15:29', NULL),
(71, 56, 2, 1, 0, 0.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đơn hàng bị hủy', 5, '2021-12-11 09:25:22', '2021-12-11 09:29:39', NULL),
(72, 57, 1, 1, 46800000, 4680000.00, 0, 'Giao hàng tận nhà', 'Chưa thanh toán', 'Đang chờ xử lý', 4, '2021-12-11 14:20:31', '2021-12-11 14:20:31', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(5, 'thonvph11059@fpt.edu.vn', 'SgYirWNB2QLYhGQgbTue5K7xus8U8qmURPz1CP5xK1F3FO51zaNkumAxGdyQ', '2021-11-20 15:57:02', NULL),
(36, 'trunghnqph10278@fpt.edu.vn', 'KoFkVSGYqs6lGHMiYOsiFqOV5B63IwO63f5vBQjAPcDdHZlKD3eBfLTl3yho', '2021-12-10 14:26:34', NULL),
(67, 'hungtmph10583@gmail.com', 'AQaiiAJqxCNEqWMnNh369gNE2cnQgJUG33jclgLzdWE5RxdPnz02urBYiU2K', '2021-12-10 15:25:13', NULL),
(68, 'huypqph11301@fpt.edu.vn', 'Wjn8Wo8MDboinIXIPPFmTGMBBTL2zjFBvq391Ibbwm7XhTZdxIu0npwd6Jnv', '2021-12-10 15:26:13', NULL),
(70, 'hungtmph10583@fpt.edu.vn', 'bm5LgD0DjYaMRMg5eo5ZqmDcuQ036SPJJSnxyixI7BXEjp2r8waVxj2MfJtD', '2021-12-10 15:45:39', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'add users', 'web', '2021-10-28 09:37:35', '2021-10-28 09:37:35'),
(2, 'edit users', 'web', '2021-10-28 09:37:35', '2021-10-28 09:37:35'),
(3, 'delete users', 'web', '2021-10-28 09:38:07', '2021-10-28 09:38:07'),
(4, 'add posts', 'web', '2021-12-05 17:14:21', '2021-12-05 17:14:21'),
(5, 'edit posts', 'web', '2021-12-05 17:14:21', '2021-12-05 17:14:21'),
(6, 'add roles', 'web', '2021-12-05 17:15:33', '2021-12-05 17:15:33'),
(7, 'edit roles', 'web', '2021-12-05 17:15:33', '2021-12-05 17:15:33'),
(8, 'delete roles', 'web', '2021-12-05 17:16:14', '2021-12-05 17:16:14'),
(9, 'add coupons', 'web', '2021-12-05 17:16:14', '2021-12-05 17:16:14'),
(10, 'edit coupons', 'web', '2021-12-05 17:17:29', '2021-12-05 17:17:29'),
(11, 'delete coupons', 'web', '2021-12-05 17:17:29', '2021-12-05 17:17:29'),
(12, 'add products', 'web', '2021-12-05 17:21:54', '2021-12-05 17:21:54'),
(13, 'edit products', 'web', '2021-12-05 17:21:54', '2021-12-05 17:21:54'),
(14, 'delete products', 'web', '2021-12-05 17:22:33', '2021-12-05 17:22:33'),
(15, 'add categories', 'web', '2021-12-05 17:22:33', '2021-12-05 17:22:33'),
(16, 'edit categories', 'web', '2021-12-05 17:23:42', '2021-12-05 17:23:42'),
(17, 'delete categories', 'web', '2021-12-05 17:23:42', '2021-12-05 17:23:42'),
(18, 'login_admin', 'web', '2021-12-09 16:39:51', '2021-12-09 16:39:51'),
(19, 'edit_order', 'web', '2021-12-09 16:56:51', '2021-12-09 16:56:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `breed_id` int(11) NOT NULL,
  `age_id` int(11) DEFAULT NULL,
  `gender_id` int(11) NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `coupon_id` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `min_quantity` int(11) DEFAULT NULL,
  `discount_start_date` timestamp NULL DEFAULT NULL,
  `discount_end_date` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `user_id`, `category_id`, `slug`, `image`, `weight`, `breed_id`, `age_id`, `gender_id`, `rating`, `price`, `coupon_id`, `discount`, `discount_type`, `min_quantity`, `discount_start_date`, `discount_end_date`, `status`, `quantity`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chó đốm trắng đen', 1, 1, 'cho-dom-trang-den', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '12', 1, 1, 2, 0, 12000000, 4, 300000, 1, NULL, NULL, NULL, 1, 12, 'Đặc điểm nhận dạng: Lông trắng đen', '2021-10-28 16:29:54', '2021-12-08 23:38:13', NULL),
(2, 'Mèo trắng mắt xanh', 1, 2, 'meo-trang-mat-xanh', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '13', 3, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 5, NULL, '2021-11-21 07:51:52', '2021-12-09 08:06:29', NULL),
(3, 'Vẹt Xoài', 1, 1, 'vet-xoai', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '', 3, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 5, NULL, '2021-11-21 07:48:47', '2021-11-21 07:48:50', NULL),
(4, 'Mèo cụt chân', 1, 1, 'pitbull', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '12', 1, 1, 1, 0, 12500000, 7, 300000, 1, NULL, NULL, NULL, 1, 11, 'Đặc điểm nhận dạng: Đeo kính', '2021-11-02 16:49:08', '2021-12-09 16:09:59', NULL),
(5, 'Chó mặt xệ', 1, 1, 'cho-mat-xe', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '10', 1, 1, 1, 0, 10200000, 5, 300000, 1, NULL, '2021-11-07 17:00:00', '2021-11-09 17:00:00', 1, 15, 'Đặc điểm nhận dạng: mặt xệ', '2021-11-02 16:50:04', '2021-11-27 08:19:42', NULL),
(7, 'Husky', 1, 1, 'husky', 'uploads/products//6184f38643826-Untitled-1.png', '28', 1, 2, 1, 0, 25000000, 4, 300000, 1, NULL, '2021-11-07 17:00:00', '2021-11-09 17:00:00', 1, 6, NULL, '2021-11-05 09:04:06', '2021-11-27 08:19:42', NULL),
(8, 'Corgi', 1, 8, 'corgi', 'uploads/products//6184f38643826-Untitled-1.png', '20', 1, 1, 1, 0, 0, 7, 300000, 1, NULL, '2021-11-19 09:05:00', '2021-11-20 09:05:00', 1, 2, '4422222', '2021-11-05 09:04:06', '2021-12-09 16:09:59', NULL),
(11, 'Husky ngáo', 1, 1, 'husky-ngao', 'https://wihlkit.files.wordpress.com/2010/11/images04.jpg', '', 0, 0, 2, 0, 12000000, 0, 0, 0, NULL, NULL, NULL, 1, 12, 'Chưa có thông tin', '2021-11-10 07:56:40', '2021-11-20 15:19:08', NULL),
(12, 'Husky đần', 2, 8, 'husky-dan', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0TUu-ROeewYG6S8zPhBMjRDsDrlrMIQdZgUv0OA5bDEepCV3-gVA_bbhCJE_GHkrKufM&usqp=CAU', '', 0, 0, 2, 0, 9300000, 7, 0, 0, NULL, NULL, NULL, 1, 12, 'Chưa có thông tin', '2021-11-10 07:56:40', '2021-12-09 16:09:59', NULL),
(13, 'Husky mắt trắn', 2, 8, 'husky-mat-tran', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Le%C3%AFko_au_bois_de_la_Cambre.jpg/220px-Le%C3%AFko_au_bois_de_la_Cambre.jpg', '', 0, 0, 3, 0, 12000000, 7, 0, 0, NULL, NULL, NULL, 1, 12, 'Chưa có thông tin', '2021-11-10 08:31:34', '2021-12-09 16:09:59', NULL),
(15, 'Husky đầ', 2, 1, 'husky-da', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0TUu-ROeewYG6S8zPhBMjRDsDrlrMIQdZgUv0OA5bDEepCV3-gVA_bbhCJE_GHkrKufM&usqp=CAU', '', 0, 0, 3, 0, 9300000, 7, 300000, 1, NULL, '2021-11-19 09:05:00', '2021-11-20 09:05:00', 1, 12, 'Chưa có thông tin', '2021-11-10 08:31:34', '2021-12-09 16:09:59', NULL),
(32, 'Áo thu đông', 2, 1, 'ao-thu-dong', 'uploads/products//61a48cf1dbdfe-1200px-Mangekyou_Sharingan_Itachi.svg.png', '28', 1, 1, 1, 0, 250000, NULL, NULL, NULL, NULL, NULL, NULL, 1, 6, NULL, '2021-11-29 08:18:57', '2021-12-09 16:09:59', NULL),
(33, 'Shiranuii', 2, 1, 'shiranuii', 'uploads/products//61a48d62e2b56-1200px-Mangekyou_Sharingan_Itachi.svg.png', '28', 1, 1, 1, 0, 250000, NULL, NULL, NULL, NULL, NULL, NULL, 1, 6, NULL, '2021-11-29 08:20:50', '2021-12-09 16:09:59', NULL),
(34, 'Mèo Ba Tư', 1, 2, 'meo-ba-tu', 'uploads/products/617ad002e5ef8-cate-dog.jpg', '3.5', 15, 2, 1, 0, 15000000, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, '<p><a href=\"https://www.2thucung.com/meo-ba-tu.html\"><strong>M&egrave;o Ba Tư</strong></a>&nbsp;c&oacute; nguồn gốc từ xứ sở Ba Tư, v&igrave; đặc điểm mũi bẹt n&ecirc;n ch&uacute;ng c&ograve;n c&oacute; t&ecirc;n l&agrave; Ba Tư mặt tịt. Hiện nay, những ch&uacute; m&egrave;o n&agrave;y rất được săn đ&oacute;n v&agrave; nu&ocirc;i kh&aacute; rộng r&atilde;i tại nhiều quốc gia d&ugrave; gi&aacute; th&agrave;nh kh&ocirc;ng hề rẻ.</p>\r\n<p><a href=\"https://www.2thucung.com/meo-ba-tu.html\"><strong>M&egrave;o Ba Tư</strong></a>&nbsp;c&oacute; nguồn gốc từ xứ sở Ba Tư, v&igrave; đặc điểm mũi bẹt n&ecirc;n ch&uacute;ng c&ograve;n c&oacute; t&ecirc;n l&agrave; Ba Tư mặt tịt. Hiện nay, những ch&uacute; m&egrave;o n&agrave;y rất được săn đ&oacute;n v&agrave; nu&ocirc;i kh&aacute; rộng r&atilde;i tại nhiều quốc gia d&ugrave; gi&aacute; th&agrave;nh kh&ocirc;ng hề rẻ.</p>\r\n<p>Một ch&uacute; m&egrave;o Ba Tư đạt chuẩn bắt buộc phải c&oacute; c&aacute;c đặc điểm: mũi b&eacute;, mắt to, bộ l&ocirc;ng d&agrave;y x&ugrave;. Tuy nhi&ecirc;n cũng v&igrave; vậy m&agrave; c&aacute;c b&eacute; c&oacute; thể gặp kh&oacute; khăn trong việc h&iacute;t thở hoặc chảy nước mắt. Vậy n&ecirc;n cần cẩn thận khi lựa chọn nu&ocirc;i giống m&egrave;o n&agrave;y.</p>\r\n<p>Bộ l&ocirc;ng của m&egrave;o Ba Tư c&oacute; thể gặp c&aacute;c m&agrave;u: trắng, kem, cafe sữa, x&aacute;m xanh, n&acirc;u đỏ, n&acirc;u, vằn vện,&hellip;</p>\r\n<p>Những ch&uacute; m&egrave;o Ba Tư vốn c&oacute; t&iacute;nh c&aacute;ch &ocirc;n h&ograve;a, dễ chịu, th&ocirc;ng minh v&agrave; quấn chủ. Ch&uacute;ng kh&ocirc;ng c&oacute; qu&aacute; nhiều nhu cầu, ho&agrave;n to&agrave;n c&oacute; thể ở trong nh&agrave; cả ng&agrave;y m&agrave; kh&ocirc;ng ch&uacute;t kh&oacute; chịu, nhưng nếu được thả ra chạy nhảy, leo tr&egrave;o ch&uacute;ng vẫn rất vui sướng. M&egrave;o Ba Tư th&iacute;ch hợp cho cuộc sống của những người chủ bận rộn nhất.</p>\r\n<p>Hiện nay ngo&agrave;i giống Ba Tư l&ocirc;ng d&agrave;i thường thấy th&igrave; sau c&aacute;c qu&aacute; tr&igrave;nh lai tạo, m&egrave;o ba Tư l&ocirc;ng ngắn (Exotic), Hymalayan, Chinchilla cũng đ&atilde; xuất hiện.</p>', '2021-11-30 06:43:41', '2021-11-30 07:13:09', NULL),
(35, 'Mèo Bengal', 3, 2, 'meo-bengal', 'uploads/products//61a5c99ec431e-Bengal2.png', '2.7', 16, 1, 1, 0, 21400000, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '<p><strong>M&egrave;o Bengal</strong>&nbsp;(đọc l&agrave; ben-gồ) l&agrave; một giống m&egrave;o nh&agrave; được ph&aacute;t triển sao cho giống những lo&agrave;i họ m&egrave;o hoang d&atilde; với mục ti&ecirc;u tạo ra một giống m&egrave;o tinh ranh, khỏe mạnh v&agrave; th&acirc;n thiện &nbsp;với bộ l&ocirc;ng mang m&agrave;u sắc rực rỡ v&agrave; độ tương phản cao<sup id=\"cite_ref-1\" class=\"reference\"><a href=\"https://vi.wikipedia.org/wiki/M%C3%A8o_Bengal#cite_note-1\">[1]</a></sup>. Người đ&atilde; lai tạo m&egrave;o Bengal c&oacute; t&ecirc;n l&agrave; Jean Mill khi c&ocirc; ấy mua được một ch&uacute; m&egrave;o b&aacute;o v&agrave; ch&uacute; m&egrave;o nh&agrave;. Năm 1965 th&igrave; ch&uacute; m&egrave;o Bengal đầu ti&ecirc;n c&oacute; t&ecirc;n l&agrave; Kin Kin đ&atilde; ra đời.</p>\r\n<p>C&aacute;i t&ecirc;n \"Bengal\" c&oacute; nguồn gốc từ ph&acirc;n lo&agrave;i m&egrave;o b&aacute;o ch&acirc;u &Aacute; (<em>P. b. bengalensis</em>). Ch&uacute;ng c&oacute; một ngoại h&igrave;nh mang vẻ \"hoang d&atilde;\" với c&aacute;c đốm &nbsp;chấm/ hoa gốm, v&agrave; một c&aacute;i&nbsp;bụng trắng, v&agrave; một cấu tr&uacute;c cơ thể kh&aacute; tương đương với m&egrave;o b&aacute;o ch&acirc;u &Aacute;.<sup id=\"cite_ref-animal-world_2-0\" class=\"reference\"><a href=\"https://vi.wikipedia.org/wiki/M%C3%A8o_Bengal#cite_note-animal-world-2\">[2]</a></sup>&nbsp;Một khi được t&aacute;ch ra từ phối giống m&egrave;o b&aacute;o với m&egrave;o nh&agrave;, tập t&iacute;nh của m&egrave;o bengal sẽ giống với những con m&egrave;o nh&agrave; kh&aacute;c.</p>\r\n<p>M&egrave;o Bengal hầu hết sở hữu bộ l&ocirc;ng m&agrave;u cam s&aacute;ng v&agrave; m&agrave;u n&acirc;u nhạt. Mặc d&ugrave; kh&ocirc;ng nổi bật nhưng vẫn tồn tại c&aacute;c c&aacute; thẻ mang m&agrave;u l&ocirc;ng \"trắng tuyết\" m&agrave; cũng kh&aacute; phổ biến</p>', '2021-11-30 06:50:06', '2021-11-30 06:50:06', NULL),
(36, 'Áo thu đônghhh', 1, 1, 'ao-thu-donghhh', 'uploads/products/36/61acc2d22d475-1.jpg', '28', 1, 1, 1, 0, 250000, NULL, NULL, NULL, NULL, NULL, NULL, 0, 6, NULL, '2021-11-30 07:50:57', '2021-12-05 13:46:58', NULL),
(37, 'Trầm cảm', 2, 1, 'tram-cam', 'uploads/products//61ae4566322fc-banner-muitl.png', '29', 1, 2, 1, 0, 25000000, NULL, NULL, NULL, NULL, NULL, NULL, 1, 7, NULL, '2021-12-06 17:16:22', '2021-12-09 16:09:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_galleries`
--

CREATE TABLE `product_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_galleries`
--

INSERT INTO `product_galleries` (`id`, `product_id`, `image_url`, `order_no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'uploads/products/galleries/1/617ad0031e583-cate-dog.jpg', 1, '2021-10-28 16:29:55', '2021-11-27 08:19:42', NULL),
(2, 7, 'uploads/gallery/7/6184f38649d62-Untitled-1.png', 1, '2021-11-05 09:04:06', '2021-11-27 08:19:42', NULL),
(3, 4, 'uploads/products/galleries/4/6188c471c6c40-shiba2.png', 1, '2021-11-08 06:32:17', '2021-12-09 16:09:59', NULL),
(4, 4, 'uploads/products/galleries/4/6188c471cdc25-shiba3.png', 2, '2021-11-08 06:32:17', '2021-12-09 16:09:59', NULL),
(21, 34, 'uploads/gallery/34/61a5c81d21b53-Ba-tu2.png', 1, '2021-11-30 06:43:41', '2021-11-30 06:43:41', NULL),
(22, 34, 'uploads/gallery/34/61a5c81d22732-Ba-tu3.png', 2, '2021-11-30 06:43:41', '2021-11-30 06:43:41', NULL),
(23, 34, 'uploads/gallery/34/61a5c81d22d45-Ba-tu4.png', 3, '2021-11-30 06:43:41', '2021-11-30 06:43:41', NULL),
(24, 35, 'uploads/gallery/35/61a5c99ec580f-Bengal1.png', 1, '2021-11-30 06:50:06', '2021-11-30 06:50:06', NULL),
(25, 35, 'uploads/gallery/35/61a5c99ec5cb1-Bengal3.png', 2, '2021-11-30 06:50:06', '2021-11-30 06:50:06', NULL),
(26, 35, 'uploads/gallery/35/61a5c99ec60a7-Bengal4.png', 3, '2021-11-30 06:50:06', '2021-11-30 06:50:06', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `product_type`, `user_id`, `name`, `email`, `rating`, `comment`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 3, 1, 2, '', 'huypqph11301@fpt.edu.vn', 2, 'test', 1, '2021-11-06 05:01:35', '2021-12-09 16:09:59', NULL),
(29, 3, 1, 1, 'Mạnh Hùng', 'hungtmph10583@gmail.com', 5, 'Hàng tốt!', 1, '2021-12-06 15:45:34', '2021-12-06 15:46:39', NULL),
(24, 2, 2, 1, 'Mạnh Hùng', 'hungtmph10583@gmail.com', 4, 'Good', 1, '2021-12-03 04:26:18', '2021-12-09 08:06:28', NULL),
(25, 1, 2, 1, '', 'hungtmph10583@gmail.com', 5, 'pk 1', 1, '2021-12-03 04:27:42', '2021-12-03 04:27:42', NULL),
(27, 1, 1, NULL, 'test', 'manhhunglzx@gmail.com', 3, 'sdsd', 1, '2021-12-06 15:29:15', '2021-12-06 15:29:15', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2021-10-28 09:35:28', '2021-10-28 09:35:28'),
(2, 'Manage', 'web', '2021-10-28 09:35:28', '2021-10-28 09:35:28'),
(12, 'Employee', 'web', '2021-12-09 16:37:18', '2021-12-09 16:37:18'),
(13, 'Godfather', 'web', '2021-12-09 18:38:43', '2021-12-09 18:38:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(14, 12),
(15, 1),
(15, 12),
(16, 1),
(16, 12),
(17, 1),
(18, 1),
(18, 2),
(18, 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slides`
--

INSERT INTO `slides` (`id`, `user_id`, `image`, `url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'uploads/slide/1/6192db27bcf6d-slide1.jpg', 'urk', 1, '2021-11-12 07:11:20', '2021-11-15 22:11:51', '2021-11-12 08:07:16'),
(2, 1, 'uploads/slide//6192d824f265e-slide2.jpg', NULL, 1, '2021-11-15 21:59:01', '2021-11-15 22:16:14', NULL),
(6, 1, 'uploads/slide//619dfd9ba4756-logongoc-_1_.png', 'http://huypqph11301.xyz/', 0, '2021-11-24 08:53:47', '2021-11-25 13:45:36', NULL),
(7, 1, 'uploads/slide//619dfd9baa562-1200px-Mangekyou_Sharingan_Itachi.svg.png', 'http://huypqph11301.xyz/', 0, '2021-11-24 08:53:47', '2021-11-25 13:45:45', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `statistical`
--

CREATE TABLE `statistical` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantityMonth` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `statistical`
--

INSERT INTO `statistical` (`id`, `product_id`, `order_id`, `product_type`, `quantity`, `quantityMonth`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 11, 12, '2021-12-05 08:00:21', '2021-12-11 09:13:24'),
(2, 4, 0, 1, 11, 11, '2021-12-05 08:00:21', '2021-12-08 15:40:56'),
(3, 13, 0, 1, 9, 12, '2021-12-05 08:00:21', '2021-12-08 15:40:56'),
(4, 5, 0, 1, 14, 14, '2021-12-08 16:25:59', '2021-12-08 16:26:01'),
(5, 2, 0, 2, 2, 12, '2021-12-08 16:25:59', '2021-12-08 16:26:01'),
(6, 1, 0, 2, 7, 12, '2021-12-08 16:25:59', '2021-12-11 08:15:29'),
(10, 2, 0, 1, 0, 5, '2021-12-11 09:25:22', '2021-12-11 09:29:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `avatar`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mạnh Hùng', 'hungtmph10583@gmail.com', NULL, 'uploads/users/61a8e63c45319-hotboy.jpg', '$2y$10$iEsqlXgX3CJWjz7vqcLF9.b/2U2KySQn8TCR9tU0lGD1i7UhN8mgO', '0336126723', 1, NULL, '2021-10-28 09:34:47', '2021-12-02 15:51:47', NULL),
(2, 'Huy Phan', 'huypqph11301@fpt.edu.vn', NULL, 'uploads/users/618ab2a5d1b82-hinh-anh-hacker-3.jpg', '$2y$10$DW4QRv5Y6yfYuIfp8fpNLeJF/9AlBXU3/Y9fIRDn68CDDO6KSWNq6', '0365791629', 1, 'LtMOadwRnSz4vBp8LeNZubcyWb1f6RKjUI8yJMg1YEasFZajQVKigi6WvuNM', '2021-10-30 09:03:09', '2021-12-09 16:09:59', NULL),
(3, 'Khánh Ngọc', 'ngoctkph11120@fpt.edu.vn', NULL, 'uploads/users/618aae7ea9213-1.jpg', '$2y$10$DW4QRv5Y6yfYuIfp8fpNLeJF/9AlBXU3/Y9fIRDn68CDDO6KSWNq6', '0961316491', 1, NULL, '2021-11-08 16:23:18', '2021-11-09 17:23:10', NULL),
(4, 'Ngoc Anh', 'anhhnph09909@fpt.edu.vn', NULL, 'uploads/users/618d22167f6e4-bo-hung.jpg', '$2y$10$DW4QRv5Y6yfYuIfp8fpNLeJF/9AlBXU3/Y9fIRDn68CDDO6KSWNq6', '0961316491', 1, NULL, '2021-11-08 16:24:39', '2021-11-11 14:00:54', NULL),
(5, 'Van Tho', 'thonvph11059@fpt.edu.vn', NULL, 'uploads/users/618d222b346a6-weo.jpg', '$2y$10$DW4QRv5Y6yfYuIfp8fpNLeJF/9AlBXU3/Y9fIRDn68CDDO6KSWNq6', '0388241422', 1, NULL, '2021-11-09 09:46:35', '2021-11-11 14:01:15', NULL),
(6, 'Thắng', 'thangdvph08801@fpt.edu.vn', NULL, 'uploads/users/618d223e76218-dcakc88-3221f2a7-ab41-4230-9fee-6753bb4d5bc6.png', '$2y$10$DW4QRv5Y6yfYuIfp8fpNLeJF/9AlBXU3/Y9fIRDn68CDDO6KSWNq6', '0965029062', 1, NULL, '2021-11-09 09:47:08', '2021-12-06 13:54:55', NULL),
(7, 'Quang Trung', 'trunghnqph10278@fpt.edu.vn', NULL, 'uploads/users/618d22504460b-doramon_lolYellow.png', '$2y$10$YuCVF19Kp0e50hf7FhkOTOJmweAN4tkCpLCiYRQ4Yq/.9SFWF1aMa', '0399832584', 1, NULL, '2021-11-09 09:48:23', '2021-12-10 14:42:00', NULL),
(8, 'Manh Hung', 'manhhunglzx@gmail.com', NULL, 'uploads/users/61b417b3882fd-star-trophy.png', '$2y$10$zg.UxZrI1rcSF/jyUkq/L.CHKjv0ypt9nAUZhkHh0MBrL8V0AkNGC', '0365791629', 1, 'oi1TqnuPCTAoxbGXu95SAeurYX3gD2UJqO64j7MYCyjKQsYJE1Cvih1EIAA3', '2021-11-10 16:36:21', '2021-12-11 03:14:59', NULL),
(9, 'test', 'hungtmph10583@fpt.edu.vn', NULL, NULL, '$2y$10$6o/kuF0LHvjI89VdokoFse9dVPpqoiUS3CSGzd6ucucOKw1WDfOcW', NULL, 1, NULL, '2021-11-22 13:29:23', '2021-11-22 13:29:23', NULL),
(10, 'Wayne', 'thonvph1109@fpt.edu.vn', NULL, NULL, '$2y$10$R2NhLVu.lCQBnGuJdwZJ2uaCElj5mZVao8/waZQzmxtKQY08lv0vC', NULL, 1, NULL, '2021-12-08 09:47:53', '2021-12-08 09:47:53', NULL),
(11, 'Tester', 'phanquochuyqthm@gmail.com', NULL, 'uploads/users/61b2342481b38-1200px-Mangekyou_Sharingan_Itachi.svg.png', '$2y$10$E4l/jtryT5n0pQLAzK5dleSh9PsuMOIkuWcNn909uBkXLMxvzA3S.', '0977778558', 1, 'oLmmY5neeMk', '2021-12-09 16:51:49', '2021-12-09 16:51:49', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wards`
--

CREATE TABLE `wards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `accessory_galleries`
--
ALTER TABLE `accessory_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ages`
--
ALTER TABLE `ages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_types`
--
ALTER TABLE `category_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupon_types`
--
ALTER TABLE `coupon_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount_types`
--
ALTER TABLE `discount_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `footer_titles`
--
ALTER TABLE `footer_titles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_galleries`
--
ALTER TABLE `product_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `statistical`
--
ALTER TABLE `statistical`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `accessory_galleries`
--
ALTER TABLE `accessory_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ages`
--
ALTER TABLE `ages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `breeds`
--
ALTER TABLE `breeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `category_types`
--
ALTER TABLE `category_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `coupon_types`
--
ALTER TABLE `coupon_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `discount_types`
--
ALTER TABLE `discount_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `footers`
--
ALTER TABLE `footers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `footer_titles`
--
ALTER TABLE `footer_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `product_galleries`
--
ALTER TABLE `product_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `statistical`
--
ALTER TABLE `statistical`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `wards`
--
ALTER TABLE `wards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
