-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 05, 2020 lúc 04:14 PM
-- Phiên bản máy phục vụ: 10.1.34-MariaDB
-- Phiên bản PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `moteldb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `daily_costs`
--

CREATE TABLE `daily_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `payer` int(10) UNSIGNED NOT NULL,
  `payfor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `percent_per_one` int(11) DEFAULT NULL,
  `percent_per_two` int(11) DEFAULT NULL,
  `total_per_one` int(11) DEFAULT NULL,
  `total_per_two` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_together` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `daily_costs`
--

INSERT INTO `daily_costs` (`id`, `payer`, `payfor`, `total`, `date`, `percent_per_one`, `percent_per_two`, `total_per_one`, `total_per_two`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `is_together`) VALUES
(1, 1, 'Tiền phòng', 2600000, '2020-02-01', 50, 50, 1300000, 1300000, NULL, NULL, NULL, '2020-02-23 01:21:34', '2020-02-23 01:21:34', NULL, 1),
(2, 1, 'Tiền nước', 100000, '2020-02-01', 50, 50, 50000, 50000, NULL, NULL, NULL, '2020-02-23 01:21:58', '2020-02-23 01:21:58', NULL, 1),
(3, 1, 'Tiền rác', 25000, '2020-02-01', 50, 50, 12500, 12500, NULL, NULL, NULL, '2020-02-23 01:22:17', '2020-02-23 01:22:17', NULL, 1),
(4, 1, 'Đi chợ', 500000, '2020-02-15', 50, 50, 250000, 250000, NULL, NULL, NULL, '2020-02-23 01:22:48', '2020-02-23 01:22:48', NULL, 1),
(5, 1, 'Thạch mượn 150k + 50k thẻ viettel', 200000, '2020-02-16', 0, 100, 0, 200000, NULL, NULL, NULL, '2020-02-23 01:23:33', '2020-02-23 01:23:33', NULL, 0),
(6, 1, 'Đi chợ', 250000, '2020-01-24', 50, 50, 125000, 125000, 'RhPX_4157DA00-F1B3-44FA-965A-53084CDF6889.jpeg', NULL, NULL, '2020-02-23 01:23:54', '2020-02-23 20:17:18', NULL, 1),
(7, 1, 'test', 100000, '2020-02-24', 30, 70, 70000, 30000, NULL, NULL, NULL, '2020-02-24 01:29:49', '2020-02-24 02:04:39', '2020-02-24 02:04:39', 1),
(8, 1, 'test2', 100000, '2020-02-24', 30, 70, 30000, 70000, NULL, NULL, NULL, '2020-02-24 01:35:57', '2020-02-24 02:04:35', '2020-02-24 02:04:35', 1),
(9, 1, 'test3', 3000000, '2020-02-24', 100, 0, 3000000, 0, NULL, NULL, NULL, '2020-02-24 01:36:21', '2020-02-24 02:04:30', '2020-02-24 02:04:30', 0),
(10, 1, 'test riêng', 500000, '2020-02-24', 100, 0, 500000, 0, NULL, NULL, NULL, '2020-02-24 01:52:05', '2020-02-24 02:04:25', '2020-02-24 02:04:25', 0),
(11, 1, 'test chung', 1000000, '2020-02-24', 70, 30, 700000, 300000, NULL, NULL, NULL, '2020-02-24 01:52:51', '2020-02-24 02:04:15', '2020-02-24 02:04:15', 1),
(12, 1, 'Đi chợ (siêu thị 210k + đi chợ 50k)', 260000, '2020-02-24', 50, 50, 130000, 130000, 'KXUv_4DB6FAF8-87DA-43E6-9E62-2FDFB8C9E172.jpeg', NULL, NULL, '2020-02-24 03:53:16', '2020-02-24 03:54:08', NULL, 1),
(13, 1, 'test', 260000, '2020-02-24', 50, 50, 130000, 130000, NULL, NULL, NULL, '2020-02-24 03:55:43', '2020-02-24 03:56:00', '2020-02-24 03:56:00', 1),
(14, 1, 'test xong xóa', 500000, '2020-02-24', 90, 10, 450000, 50000, NULL, NULL, NULL, '2020-02-24 04:17:04', '2020-02-24 04:17:32', '2020-02-24 04:17:32', 1),
(15, 1, 'Đi siêu thị', 60000, '2020-02-29', 50, 50, 30000, 30000, 'JjXC_image.jpg', NULL, NULL, '2020-03-04 06:51:55', '2020-03-04 06:58:39', NULL, 1),
(16, 1, 'Đi siêu thị(204k) + đi chợ(40k)', 244000, '2020-02-29', 50, 50, 122000, 122000, 'tpQI_image.jpg', NULL, NULL, '2020-03-04 06:54:01', '2020-03-04 06:59:18', NULL, 1),
(17, 1, 'Đi siêu thị', 170000, '2020-02-27', 50, 50, 85000, 85000, 'L2aT_image.jpg', NULL, NULL, '2020-03-04 06:54:57', '2020-03-04 06:57:39', NULL, 1),
(18, 1, 'Tiền điện', 269000, '2020-02-29', 50, 50, 134500, 134500, NULL, NULL, NULL, '2020-03-04 07:00:43', '2020-03-04 07:01:00', NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fixed_costs`
--

CREATE TABLE `fixed_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1',
  `unit_price` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `fixed_costs`
--

INSERT INTO `fixed_costs` (`id`, `name`, `amount`, `unit_price`, `total`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nước', 2, 25000, 50000, NULL, NULL, '2020-02-21 19:05:43', '2020-02-21 19:05:43', NULL),
(2, 'Tiền phòng', 1, 2600000, 2600000, NULL, NULL, '2020-02-21 19:06:10', '2020-02-21 19:06:10', NULL),
(3, 'Rác', 1, 25000, 25000, NULL, NULL, '2020-02-21 19:06:35', '2020-02-21 19:06:35', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_02_16_030651_create_fixed_costs_table', 1),
(5, '2020_02_16_030828_create_daily_costs_table', 1),
(6, '2020_02_16_031501_create_user_info_table', 1),
(7, '2020_02_22_012338_add_image_to_daily_costs_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'Dương Tuấn Kiệt', 'kiet1022@gmail.com', NULL, '$2y$10$SsM6qQGdxMcm3shvZIZvxuoDi.7SHtCiutuxS9nya4Yl7Ccah7B7O', '8YwKHofwHV5ap3ouhi5WO2sNCLh8Pajn0pvlTI2dXz0RrqZ2KIJ7npcgSpGG', '2020-02-21 19:55:32', '2020-02-21 21:06:47', NULL),
(2, 'Trần Hoàng Thạch', 'hoangthach1399@gmail.com', NULL, '$2y$10$DhqeG9CYcZwYB21Y7zRKXuWxhLVA2oJVKIKRshocOC2uTra6xtyoq', NULL, '2020-02-22 18:44:03', '2020-02-22 18:44:03', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_info`
--

CREATE TABLE `user_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `daily_costs`
--
ALTER TABLE `daily_costs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `fixed_costs`
--
ALTER TABLE `fixed_costs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `daily_costs`
--
ALTER TABLE `daily_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `fixed_costs`
--
ALTER TABLE `fixed_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
