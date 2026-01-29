-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 11:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gobongdelivery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('1b6453892473a467d07372d45eb05abc2031647a', 'i:2;', 1768985884),
('1b6453892473a467d07372d45eb05abc2031647a:timer', 'i:1768985884;', 1768985884),
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1768983554),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1768983554;', 1768983554),
('77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:1;', 1768995083),
('77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1768995083;', 1768995083),
('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1768984376),
('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1768984376;', 1768984376),
('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1769569864),
('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1769569864;', 1769569864),
('livewire-rate-limiter:eab216f95727913eee52b11b4b863b41a4bf4332', 'i:1;', 1769237262),
('livewire-rate-limiter:eab216f95727913eee52b11b4b863b41a4bf4332:timer', 'i:1769237262;', 1769237262);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `stor_food_id` int(11) DEFAULT NULL,
  `f_qty` int(11) DEFAULT NULL,
  `suggetion` varchar(255) DEFAULT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `food_cart_status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `stor_id`, `stor_food_id`, `f_qty`, `suggetion`, `order_status`, `food_cart_status`, `created_at`, `updated_at`) VALUES
(199, 2, 2, 32, 1, NULL, 1, 0, '2026-01-29 03:35:53', '2026-01-29 10:36:09'),
(200, 2, 2, 31, 1, NULL, 1, 0, '2026-01-29 03:35:56', '2026-01-29 10:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_image` varchar(255) DEFAULT NULL,
  `stor_id` varchar(255) DEFAULT NULL,
  `ordering` varchar(255) DEFAULT NULL,
  `trending_status` varchar(255) NOT NULL DEFAULT '1',
  `cat_status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `cat_image`, `stor_id`, `ordering`, `trending_status`, `cat_status`, `created_at`, `updated_at`) VALUES
(9, 'noodle', 'images/categories/01K6MJ8J26JR5C2P74TW7GG9RD.jpg', '3', '1', '1', '1', '2025-10-03 01:15:51', '2025-11-03 01:35:34'),
(10, 'Northeastern food', 'images/categories/01K6MJYBPJX7X7ZNWMJCN7P6EY.jpg', '3', '1', '0', '1', '2025-10-03 01:27:45', '2025-10-03 01:27:45'),
(11, 'Salad', 'images/categories/01K6MK13GRPJK22HQDXV4X95HG.jpg', '3', '2', '0', '1', '2025-10-03 01:29:15', '2025-10-03 01:29:15'),
(12, 'drink', 'images/categories/01K6MK3M6ZVVC5MPJAAHT4YVG4.png', '3', '4', '0', '1', '2025-10-03 01:30:38', '2025-10-03 01:30:38'),
(13, 'pizza', 'images/categories/01K6MK5DFBP7GBNM5WHQZQ47PD.jpg', '3', '3', '1', '1', '2025-10-03 01:31:37', '2025-10-03 01:31:37'),
(14, 'side dish', 'images/categories/01K6MK7R6KM65KEG7JZ32D56VC.jpg', '3', NULL, '0', '1', '2025-10-03 01:32:53', '2025-10-03 01:32:53'),
(15, 'Burger', 'images/categories/01K6MK99W3EP9K4ZB7E3VHAM9Q.jpg', '3', NULL, '0', '1', '2025-10-03 01:33:44', '2025-10-03 01:33:44'),
(16, 'Burger Set', 'images/categories/01K6MKAHCGKY3H1KB9DJ594GGW.jpg', '3', NULL, '0', '0', '2025-10-03 01:34:24', '2025-10-03 01:51:09'),
(17, 'One-dish meal', 'images/categories/01K6MKC06BKFR1K553TSHTV4CZ.jpg', '3', NULL, '0', '0', '2025-10-03 01:35:12', '2025-10-03 01:50:53'),
(19, 'Tea and coffee', NULL, '1', '1', '1', '1', '2025-10-04 01:01:52', '2025-10-04 01:01:52'),
(20, 'mix', NULL, '1', NULL, '0', '1', '2025-10-04 01:02:48', '2025-10-04 01:02:48'),
(21, 'Cold drinks', NULL, '1', NULL, '0', '1', '2025-10-04 01:03:05', '2025-10-04 01:03:05'),
(22, 'Topping', NULL, '1', NULL, '0', '1', '2025-10-04 01:03:18', '2025-10-04 01:03:48'),
(23, 'Wall\'s Paddle Pop', NULL, '2', NULL, '0', '1', '2025-10-07 01:51:20', '2025-10-07 01:51:20'),
(24, 'Wall Top Ten', NULL, '2', NULL, '0', '1', '2025-10-07 01:52:00', '2025-10-07 01:52:00'),
(25, 'Wall\'s Cup', NULL, '2', NULL, '0', '1', '2025-10-07 01:52:19', '2025-10-07 01:52:19'),
(26, 'Wall\'s Classic, small box, 160 grams', NULL, '2', NULL, '0', '1', '2025-10-07 01:52:48', '2025-10-07 01:52:48'),
(27, 'Tub Classic', NULL, '2', NULL, '0', '1', '2025-10-07 01:53:11', '2025-10-07 01:53:11'),
(28, 'Wall 3 in 1', NULL, '2', NULL, '0', '1', '2025-10-07 01:53:27', '2025-10-07 01:53:27'),
(29, 'Wash and dry', NULL, '4', NULL, '0', '1', '2025-10-07 02:35:48', '2025-10-07 02:35:48'),
(30, 'Laundry', NULL, '4', NULL, '0', '1', '2025-10-07 02:36:12', '2025-10-07 02:36:12'),
(31, 'Popular packages', NULL, '4', NULL, '0', '1', '2025-10-07 02:36:29', '2025-10-07 02:36:29'),
(32, 'Customer information', NULL, '4', NULL, '1', '1', '2025-10-07 02:36:44', '2025-10-07 03:23:33'),
(33, 'promotion', NULL, '3', '0', '1', '1', '2025-10-24 02:35:30', '2025-10-24 02:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `cat_translation_name` varchar(255) DEFAULT NULL,
  `cat_desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `language_id`, `cat_translation_name`, `cat_desc`, `created_at`, `updated_at`) VALUES
(1, 19, 1, 'Tea and coffee', 'delicious', '2025-10-06 21:22:20', '2025-10-06 21:22:20'),
(2, 19, 2, 'ชาและกาแฟ', NULL, '2025-10-06 23:22:23', '2025-10-06 23:22:23'),
(3, 19, 3, 'តែ និងកាហ្វេ', NULL, '2025-10-06 23:22:50', '2025-10-06 23:22:50'),
(4, 20, 1, 'mix', NULL, '2025-10-06 23:49:20', '2025-10-06 23:49:20'),
(5, 20, 3, 'លាយ', NULL, '2025-10-06 23:49:41', '2025-10-06 23:49:41'),
(6, 20, 2, 'ผสม', NULL, '2025-10-06 23:49:57', '2025-10-06 23:49:57'),
(7, 21, 1, 'Cold drinks', NULL, '2025-10-06 23:50:19', '2025-10-06 23:50:19'),
(8, 21, 2, 'เครื่องดื่มเย็นๆ', NULL, '2025-10-06 23:50:33', '2025-10-06 23:50:33'),
(9, 21, 3, 'ភេសជ្ជៈត្រជាក់', NULL, '2025-10-06 23:50:51', '2025-10-06 23:50:51'),
(10, 22, 1, 'Topping', NULL, '2025-10-06 23:51:09', '2025-10-06 23:51:09'),
(11, 22, 3, 'កំពូល', NULL, '2025-10-06 23:51:37', '2025-10-06 23:51:37'),
(12, 22, 2, 'ท็อปปิ้ง', NULL, '2025-10-06 23:51:52', '2025-10-06 23:51:52'),
(13, 9, 1, 'noodle', NULL, '2025-10-07 01:28:41', '2025-10-07 01:28:41'),
(14, 9, 2, 'ก๋วยเตี๋ยว', NULL, '2025-10-07 01:29:03', '2025-10-07 01:29:03'),
(15, 9, 3, 'គុយទាវ', NULL, '2025-10-07 01:29:16', '2025-10-07 01:29:16'),
(16, 10, 1, 'Northeastern food', NULL, '2025-10-07 01:29:35', '2025-10-07 01:29:35'),
(17, 10, 3, 'ម្ហូបភាគឦសាន', NULL, '2025-10-07 01:29:50', '2025-10-07 01:29:50'),
(18, 10, 2, 'อาหารอีสาน', NULL, '2025-10-07 01:30:06', '2025-10-07 01:30:06'),
(19, 11, 1, 'Salad', NULL, '2025-10-07 01:30:28', '2025-10-07 01:30:28'),
(20, 11, 2, 'สลัด', NULL, '2025-10-07 01:30:45', '2025-10-07 01:30:45'),
(21, 11, 3, 'សាឡាត់', NULL, '2025-10-07 01:31:00', '2025-10-07 01:31:00'),
(22, 12, 1, 'drink', NULL, '2025-10-07 01:31:33', '2025-10-07 01:31:33'),
(23, 12, 3, 'ផឹក', NULL, '2025-10-07 01:31:47', '2025-10-07 01:31:47'),
(24, 12, 2, 'ดื่ม', NULL, '2025-10-07 01:32:01', '2025-10-07 01:32:01'),
(25, 13, 1, 'pizza', NULL, '2025-10-07 01:32:26', '2025-10-07 01:32:26'),
(26, 13, 2, 'พิซซ่า', NULL, '2025-10-07 01:32:42', '2025-10-07 01:32:42'),
(27, 13, 3, 'ភីហ្សា', NULL, '2025-10-07 01:33:01', '2025-10-07 01:33:01'),
(28, 14, 1, 'side dish', NULL, '2025-10-07 01:33:23', '2025-10-07 01:33:23'),
(29, 14, 3, 'ម្ហូបចំហៀង', NULL, '2025-10-07 01:33:38', '2025-10-07 01:33:38'),
(30, 14, 2, 'กับข้าว', NULL, '2025-10-07 01:33:54', '2025-10-07 01:33:54'),
(31, 15, 1, 'Burger', NULL, '2025-10-07 01:35:03', '2025-10-07 01:35:03'),
(32, 15, 2, 'เบอร์เกอร์', NULL, '2025-10-07 01:35:17', '2025-10-07 01:35:17'),
(33, 15, 3, 'ប៊ឺហ្គឺ', NULL, '2025-10-07 01:35:31', '2025-10-07 01:35:31'),
(34, 16, 1, 'Burger Set', NULL, '2025-10-07 01:35:52', '2025-10-07 01:35:52'),
(35, 16, 3, 'ឈុតប៊ឺហ្គឺ', NULL, '2025-10-07 01:36:06', '2025-10-07 01:36:06'),
(36, 16, 2, 'ชุดเบอร์เกอร์', NULL, '2025-10-07 01:36:21', '2025-10-07 01:36:21'),
(37, 17, 1, 'One-dish meal', NULL, '2025-10-07 01:36:45', '2025-10-07 01:36:45'),
(38, 17, 2, 'อาหารจานเดียว', NULL, '2025-10-07 01:36:57', '2025-10-07 01:36:57'),
(39, 17, 3, 'អាហារមួយចាន', NULL, '2025-10-07 01:37:12', '2025-10-07 01:37:12'),
(40, 23, 1, 'Wall\'s Paddle Pop', NULL, '2025-10-07 01:58:17', '2025-10-07 01:58:17'),
(41, 23, 3, 'Paddle Pop របស់ជញ្ជាំង', NULL, '2025-10-07 01:58:31', '2025-10-07 01:58:31'),
(42, 23, 2, 'วอลล์ส แพดเดิล ป๊อป', NULL, '2025-10-07 01:58:45', '2025-10-07 01:58:45'),
(43, 24, 1, 'Wall Top Ten', NULL, '2025-10-07 01:59:06', '2025-10-07 01:59:06'),
(44, 24, 2, 'วอลล์ท็อปเท็น', NULL, '2025-10-07 01:59:19', '2025-10-07 01:59:19'),
(45, 24, 3, 'ជញ្ជាំងកំពូលដប់', NULL, '2025-10-07 01:59:33', '2025-10-07 01:59:33'),
(46, 25, 1, 'Wall\'s Cup', NULL, '2025-10-07 01:59:55', '2025-10-07 01:59:55'),
(47, 25, 3, 'ពែងជញ្ជាំង', NULL, '2025-10-07 02:00:07', '2025-10-07 02:00:07'),
(48, 25, 2, 'วอลล์คัพ', NULL, '2025-10-07 02:00:22', '2025-10-07 02:00:22'),
(49, 26, 1, 'Wall\'s Classic, small box, 160 grams', NULL, '2025-10-07 02:00:46', '2025-10-07 02:00:46'),
(50, 26, 2, 'วอลล์ คลาสสิก กล่องเล็ก 160 กรัม', NULL, '2025-10-07 02:01:00', '2025-10-07 02:01:00'),
(51, 26, 3, 'Wall\'s Classic ប្រអប់តូច 160 ក្រាម។', NULL, '2025-10-07 02:01:18', '2025-10-07 02:01:18'),
(52, 27, 1, 'Tub Classic', NULL, '2025-10-07 02:31:03', '2025-10-07 02:31:03'),
(53, 27, 3, 'អាងបុរាណ', NULL, '2025-10-07 02:31:24', '2025-10-07 02:31:24'),
(54, 27, 2, 'อ่างคลาสสิค', NULL, '2025-10-07 02:31:38', '2025-10-07 02:31:38'),
(55, 28, 1, 'Wall 3 in 1', NULL, '2025-10-07 02:32:04', '2025-10-07 02:32:04'),
(56, 28, 2, 'วอลล์ 3 อิน 1', NULL, '2025-10-07 02:32:19', '2025-10-07 02:32:19'),
(57, 28, 3, 'ជញ្ជាំង 3 ក្នុង 1', NULL, '2025-10-07 02:32:34', '2025-10-07 02:32:34'),
(58, 29, 1, 'Wash and dry', NULL, '2025-10-07 02:38:57', '2025-10-07 02:38:57'),
(59, 29, 3, 'លាងសមាតនិងស្ងួត', NULL, '2025-10-07 02:39:11', '2025-10-07 02:39:11'),
(60, 29, 2, 'ล้างและทำให้แห้ง', NULL, '2025-10-07 02:39:24', '2025-10-07 02:39:24'),
(61, 30, 1, 'Laundry', NULL, '2025-10-07 03:10:31', '2025-10-07 03:10:31'),
(62, 30, 2, 'ซักรีด', NULL, '2025-10-07 03:10:45', '2025-10-07 03:10:45'),
(63, 30, 3, 'បោកគក់', NULL, '2025-10-07 03:11:01', '2025-10-07 03:11:01'),
(64, 31, 1, 'Popular packages', NULL, '2025-10-07 03:11:31', '2025-10-07 03:11:31'),
(65, 31, 3, 'កញ្ចប់ពេញនិយម', NULL, '2025-10-07 03:11:43', '2025-10-07 03:11:43'),
(66, 31, 2, 'แพ็คเกจยอดนิยม', NULL, '2025-10-07 03:11:57', '2025-10-07 03:11:57'),
(67, 32, 1, 'Customer information', NULL, '2025-10-07 03:19:25', '2025-10-07 03:19:25'),
(68, 32, 2, 'ข้อมูลลูกค้า', NULL, '2025-10-07 03:19:42', '2025-10-07 03:19:42'),
(69, 32, 3, 'ព័ត៌មានអតិថិជន', NULL, '2025-10-07 03:20:01', '2025-10-07 03:20:01'),
(71, 33, 1, 'promotion', NULL, '2025-10-29 23:52:54', '2025-10-29 23:52:54'),
(72, 33, 3, 'ការផ្សព្វផ្សាយ', NULL, '2025-10-29 23:53:26', '2025-10-29 23:53:26'),
(74, 33, 2, 'การส่งเสริม', NULL, '2025-10-30 01:33:00', '2025-10-30 01:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `currency_code`, `currency_symbol`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'USD - United States Dollar', 'USD', '$', NULL, '2024-05-06 06:05:31', '2024-05-05 23:18:06'),
(3, 'THB - Thai Baht', 'THB', '฿', NULL, '2024-05-05 23:18:47', '2024-05-05 23:18:47'),
(4, 'KHR - Cambodian riel', 'KHR', '៛', NULL, '2024-05-05 23:19:43', '2024-05-05 23:19:43'),
(5, 'indian rupee', 'INR', '%', NULL, '2024-05-17 01:10:00', '2024-05-17 01:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile_country_code` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `mobile_country_code`, `phoneNumber`, `picture`, `lat`, `long`, `email`, `password`, `status`, `created_at`, `updated_at`) VALUES
(2, 'sk yafav dk', NULL, '1111111111', 'customers/fgwmCUmNskQynGYIHXeYjFM1RFL3aoTHkM1dHd1s.jpg', NULL, NULL, NULL, NULL, 1, '2025-11-16 21:22:04', '2026-01-21 04:13:48'),
(3, 'dk', NULL, '1111111112', 'customers/ylsO8vHhMOQWOw9sJNJgGZiYCwsnDVwnxfmlzcUX.jpg', NULL, NULL, NULL, NULL, 1, '2025-11-16 23:40:00', '2025-11-21 01:33:44'),
(4, NULL, NULL, '2222222222', NULL, NULL, NULL, NULL, NULL, 1, '2025-11-17 20:49:01', '2025-11-17 20:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_addresses`
--

INSERT INTO `delivery_addresses` (`id`, `cust_id`, `name`, `mobile`, `address`, `city`, `landmark`, `location`, `lat`, `long`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Jack', '+855 69861400', 'building U', 'Poipet Banteay Meanchey Province', 'Akia thmey beer city zone 3', NULL, '-435734587375843', '-3456347534', 1, '2026-01-15 04:24:57', '2026-01-16 20:35:49'),
(4, 2, NULL, NULL, 'ddddddddddd', NULL, '34325345', NULL, NULL, NULL, 0, '2026-01-15 03:43:48', '2026-01-16 20:35:49'),
(5, 2, NULL, NULL, 'phnom penh', NULL, 'TK Avenue  25th floor house no 812', NULL, NULL, NULL, 0, '2026-01-15 21:08:45', '2026-01-16 20:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_type` varchar(255) DEFAULT NULL,
  `distance_in_km` varchar(255) DEFAULT NULL,
  `new_customer_discount` varchar(255) DEFAULT NULL,
  `discount_offer` varchar(255) DEFAULT NULL,
  `shipping_charge` varchar(255) DEFAULT NULL,
  `rider_charge` varchar(255) DEFAULT NULL,
  `own_charge` varchar(255) DEFAULT NULL,
  `active_plan` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_charges`
--

INSERT INTO `delivery_charges` (`id`, `delivery_type`, `distance_in_km`, `new_customer_discount`, `discount_offer`, `shipping_charge`, `rider_charge`, `own_charge`, `active_plan`, `created_at`, `updated_at`) VALUES
(1, 'food', '1', '20', '0', '10', '5', '5', 1, '2026-01-16 07:46:49', '2026-01-16 07:46:49'),
(2, 'Laundry', '1', '20', '0', '20', '20', '0', 1, '2026-01-16 07:46:49', '2026-01-16 07:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `order`, `status`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 0, 1, 'images/flages/01KFFSNG8C5SZANPZAEY0RZPXV.png', NULL, '2026-01-21 01:10:19'),
(2, 'Thai', 'th-TH', 1, 1, 'images/flages/01KFFSPD4KKA72WS0H7KQQWNV6.png', NULL, '2026-01-21 01:10:49'),
(3, 'Khmer', 'km', 2, 1, 'images/flages/01KFFSQG6QZQTS8ZQCFY6855N2.png', NULL, '2026-01-21 01:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_25_043532_create_stors_table', 2),
(5, '2025_09_25_082116_create_stors_table', 3),
(6, '2025_09_25_084648_create_languages_table', 4),
(7, '2025_09_25_085607_create_languages_table', 5),
(8, '2025_09_26_035733_create_stors_table', 6),
(9, '2025_09_26_040045_create_stor_translations_table', 7),
(10, '2025_09_30_045605_create_categories_table', 8),
(11, '2025_09_30_063938_create_categories_table', 9),
(12, '2025_09_30_064046_create_category_translations_table', 10),
(13, '2025_09_30_074131_create_categories_table', 11),
(14, '2025_09_30_074754_create_category_translations_table', 11),
(15, '2025_10_22_074421_create_foods_table', 12),
(16, '2025_10_22_101540_create_stor_foods_table', 13),
(17, '2025_10_22_101644_create_stor_foods_table', 14),
(18, '2025_10_22_103308_create_stor_food_translations_table', 15),
(19, '2025_10_22_103348_create_stor_food_translations_table', 16),
(20, '2025_10_22_105210_create_currencies_table', 17),
(21, '2025_10_22_105857_create_stor_foods_table', 18),
(22, '2025_10_22_110147_create_stor_food_translations_table', 19),
(23, '2025_11_04_064924_create_popups_table', 20),
(24, '2025_11_06_065500_create_carts_table', 21),
(25, '2025_11_07_072916_create_carts_table', 22),
(26, '2025_11_14_031346_create_customers_table', 23),
(27, '2025_11_25_082001_create_carts_table', 24),
(28, '2026_01_12_042105_create_delivery_addresses_table', 25),
(29, '2026_01_16_070115_create_restaurant_orders_table', 26),
(30, '2026_01_16_073411_create_delivery_charges_table', 27),
(31, '2026_01_16_080929_create_stor_orders_table', 28),
(32, '2026_01_16_083226_create_stor_orders_table', 29),
(33, '2026_01_17_072135_create_stor_orders_table', 30),
(34, '2026_01_17_075904_create_stor_orders_table', 31),
(35, '2026_01_22_063318_create_stor_orders_table', 32),
(36, '2026_01_24_050737_create_stor_orders_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popups`
--

CREATE TABLE `popups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `popup_img` varchar(255) DEFAULT NULL,
  `ordering` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popups`
--

INSERT INTO `popups` (`id`, `popup_img`, `ordering`, `status`, `created_at`, `updated_at`) VALUES
(1, 'images/popup/01KFFSTQJTH5ZHRN4ZCSBX6JAR.jpg', '1', '1', '2025-11-04 00:00:41', '2026-01-21 01:13:11'),
(2, 'images/popup/01KFFSZ0CQNEHWAE4S1NAP5H67.png', '2', '1', '2025-11-04 00:44:56', '2026-01-21 01:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JoEebgxtRaoQV1MpeHQFr5EenPAVVLa4UMZ0rVDl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZGlua0Nna2hjUjFxanFjTUtaWkVFc25pZEEydkU4NG5vbTNBQ3FRNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjEyOiJjdXN0b21lckF1dGgiO086MTk6IkFwcFxNb2RlbHNcQ3VzdG9tZXIiOjMwOntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjk6ImN1c3RvbWVycyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjEyOntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjExOiJzayB5YWZhdiBkayI7czoxOToibW9iaWxlX2NvdW50cnlfY29kZSI7TjtzOjExOiJwaG9uZU51bWJlciI7czoxMDoiMTExMTExMTExMSI7czo3OiJwaWN0dXJlIjtzOjU0OiJjdXN0b21lcnMvZmd3bUNVbU5za1F5bkdZSUhYZVlqRk0xUkZMM2FvVEhrTTFkSGQxcy5qcGciO3M6MzoibGF0IjtOO3M6NDoibG9uZyI7TjtzOjU6ImVtYWlsIjtOO3M6ODoicGFzc3dvcmQiO047czo2OiJzdGF0dXMiO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI1LTExLTE3IDA0OjIyOjA0IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI2LTAxLTIxIDExOjEzOjQ4Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTI6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MTE6InNrIHlhZmF2IGRrIjtzOjE5OiJtb2JpbGVfY291bnRyeV9jb2RlIjtOO3M6MTE6InBob25lTnVtYmVyIjtzOjEwOiIxMTExMTExMTExIjtzOjc6InBpY3R1cmUiO3M6NTQ6ImN1c3RvbWVycy9mZ3dtQ1VtTnNrUXluR1lJSFhlWWpGTTFSRkwzYW9USGtNMWRIZDFzLmpwZyI7czozOiJsYXQiO047czo0OiJsb25nIjtOO3M6NToiZW1haWwiO047czo4OiJwYXNzd29yZCI7TjtzOjY6InN0YXR1cyI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjUtMTEtMTcgMDQ6MjI6MDQiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjYtMDEtMjEgMTE6MTM6NDgiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjI6ImlkIjt9fXM6NjoibG9jYWxlIjtzOjU6InRoLVRIIjt9', 1769683458);

-- --------------------------------------------------------

--
-- Table structure for table `stors`
--

CREATE TABLE `stors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `storLoginId` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `stor_photo` varchar(255) DEFAULT NULL,
  `stor_type` varchar(255) DEFAULT NULL,
  `cuisine` varchar(255) DEFAULT NULL,
  `stor_mobile` varchar(255) DEFAULT NULL,
  `commission_type` varchar(255) DEFAULT NULL,
  `shop_commission` varchar(255) DEFAULT NULL,
  `opentime` varchar(255) DEFAULT NULL,
  `closetime` varchar(255) DEFAULT NULL,
  `stor_lat` varchar(255) DEFAULT NULL,
  `stor_long` varchar(255) DEFAULT NULL,
  `distance_from_office` varchar(255) DEFAULT NULL,
  `openStatus` varchar(255) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stors`
--

INSERT INTO `stors` (`id`, `storLoginId`, `area`, `stor_photo`, `stor_type`, `cuisine`, `stor_mobile`, `commission_type`, `shop_commission`, `opentime`, `closetime`, `stor_lat`, `stor_long`, `distance_from_office`, `openStatus`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2', 'Go Bong Delivery', 'images/restaurant/01KFFT42PGT9Y3WE3V01JXD475.jpg', 'Shop', 'Drink', '7234567890', 'Add food costs to the cost price', '20', '07:00:00', '23:59:59', 'rtyrtyrty', 'gjhfghjfh', '0.11', '1', NULL, '2025-09-26 01:47:53', '2026-01-21 01:18:17'),
(2, '3', 'Go Bong Delivery', 'images/restaurant/01KFFT3D190HCA4TV7J3RBGDTR.png', 'Shop', 'Ice Cream', '11111111', 'Set the shop GP deduction method', '20', '07:00:00', '23:59:58', '53454356435455', '45345345345', '0.09', '1', NULL, '2025-09-26 02:12:54', '2026-01-21 01:17:55'),
(3, '4', 'Go Bong Delivery', 'images/restaurant/01KFFT0Y76FVMZA78NF48PBY7D.gif', 'Restaurant', 'Thai food', '0866666666', 'Set the shop GP deduction method', '20', '07:00:00', '23:59:58', '53454356435455', '45345345345', '0.09', '1', NULL, '2025-09-26 02:22:10', '2026-01-21 01:16:34'),
(4, '5', 'Go Bong Delivery', 'images/restaurant/01KFFT2SYZYQVPB4G4T62VEYX0.png', 'Laundry', 'Clothes', '22228888', 'Set the shop GP deduction method', '20', '07:00:00', '21:00:00', '13.645502', '102.56653', '1.5', '1', NULL, '2025-09-26 02:35:04', '2026-01-21 01:17:35'),
(5, '18', 'Go Bong Delivery', 'images/restaurant/01KFFT22VP0X8XPTHNA7GAX5YS.png', 'Shop', 'Thai food', '44444444', 'Set the shop GP deduction method', '10', '05:59:59', '23:26:22', '13.681143', '102.563499', '2.5', '1', NULL, '2025-10-20 01:27:21', '2026-01-21 01:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `stor_foods`
--

CREATE TABLE `stor_foods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `storLoginId` varchar(255) DEFAULT NULL,
  `stor_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_img` varchar(255) DEFAULT NULL,
  `cost_price` varchar(255) DEFAULT NULL,
  `selling_price` varchar(255) DEFAULT NULL,
  `currency_id` varchar(255) DEFAULT NULL,
  `ordering` varchar(255) DEFAULT NULL,
  `trending_status` varchar(255) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stor_foods`
--

INSERT INTO `stor_foods` (`id`, `storLoginId`, `stor_id`, `category_id`, `food_name`, `food_img`, `cost_price`, `selling_price`, `currency_id`, `ordering`, `trending_status`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2', '1', '21', 'Taiwanese milk tea', 'images/restaurant/food/01KFFTX4WBQ9GFX630E5ZXVC81.jpg', '28', '35', '3', NULL, '0', '1', NULL, '2025-10-22 04:19:42', '2026-01-21 01:31:58'),
(2, '2', '1', '21', 'Cocoa milk tea', 'images/restaurant/food/01KFFTFM2A8FGEB0JGGK35T7FP.jpg', '28', '35', '3', '1', '1', '1', NULL, '2025-10-23 23:35:01', '2026-01-21 01:24:35'),
(3, '2', '1', '21', 'Matcha green tea', 'images/restaurant/food/01KFFTGN03HZQ6BXN23EP262J4.jpg', '28', '35', '3', '2', '1', '1', NULL, '2025-10-23 23:42:58', '2026-01-21 01:25:09'),
(4, '2', '1', '19', 'Green Apple Tea', 'images/restaurant/food/01KFFTHJGGMYY0Y2YZVRCCQ75H.jpg', '24', '30', '3', '3', '0', '1', NULL, '2025-10-23 23:45:31', '2026-01-21 01:25:39'),
(5, '2', '1', '19', 'Strawberry tea', 'images/restaurant/food/01KFFTJJ8A3NDNWA6EE3655R1V.jpg', '24', '30', '3', NULL, '0', '1', NULL, '2025-10-23 23:53:08', '2026-01-21 01:26:12'),
(6, '2', '1', '20', 'Purple sweet potato smoothie', 'images/restaurant/food/01KFFTNVEHK1W26BBRZ3WXC58K.jpg', '44', '55', '3', '3', '0', '1', NULL, '2025-10-23 23:55:34', '2026-01-21 01:27:59'),
(7, '2', '1', '20', 'Cocoa Mint', 'images/restaurant/food/01KFFTQEQ2A569EZ7JV4CDHMBK.jpg', '40', '50', '3', NULL, '0', '1', NULL, '2025-10-23 23:57:12', '2026-01-21 01:28:52'),
(8, '2', '1', '22', 'Honeycomb', 'images/restaurant/food/01KFFTS1QNKED1627DSWAMAB5C.jpg', '16', '20', '3', '1', '0', '1', NULL, '2025-10-24 00:49:42', '2026-01-21 01:29:44'),
(9, '2', '1', '22', 'Fruit jelly', 'images/restaurant/food/01KFFTSY4YP8SZQ1PQ4V9SC7AP.jpg', '16', '20', '3', NULL, '0', '1', NULL, '2025-10-24 00:50:38', '2026-01-21 01:30:13'),
(10, '2', '1', '22', 'pearl', 'images/restaurant/food/01KFFTTWMWWRVE1FF2TWCR9SKT.jpg', '12', '15', '3', NULL, '0', '1', NULL, '2025-10-24 00:51:41', '2026-01-21 01:30:44'),
(11, '2', '1', '22', 'whipped cheese', 'images/restaurant/food/01KFFTW658F0CEH7KB12EY21N5.jpg', '16', '20', '3', NULL, '0', '1', NULL, '2025-10-24 00:52:18', '2026-01-21 01:31:27'),
(12, '4', '3', '33', '1 whole grilled chicken', 'images/restaurant/food/01KFFVMGKVJR4KN821YDE13TC7.jpg', '100', '125', '3', '0', '1', '1', NULL, '2025-10-24 02:38:04', '2026-01-21 02:22:48'),
(13, '4', '3', '33', 'Pork Tonkatsu Curry Rice Set', 'images/restaurant/food/01KFFVJ3QG1NHJAKNGTXNFJGPD.jpg', '719', '899', '3', '1', '1', '1', NULL, '2025-10-24 02:40:50', '2026-01-21 01:43:25'),
(14, '4', '3', '14', 'Kale with salted fish', 'images/restaurant/food/01KFFVFR6V8J60X3EAA376MPZ0.jpg', '72', '90', '3', '2', '0', '1', NULL, '2025-10-24 02:42:06', '2026-01-21 01:42:08'),
(15, '4', '3', '14', 'fried egg', 'images/restaurant/food/01KFFVETTQ23RGX1FFEFEC15PQ.jpg', '10', '15', '3', '3', '0', '1', NULL, '2025-10-24 02:43:29', '2026-01-21 01:41:38'),
(16, '4', '3', '9', 'Pork noodle soup', 'images/restaurant/food/01KFFVCBA6T76H0AM98EX2QPQ6.jpg', '64', '80', '3', '4', '1', '1', NULL, '2025-10-24 02:44:52', '2026-01-21 01:40:16'),
(17, '4', '3', '9', 'Beef noodle soup', 'images/restaurant/food/01KFFV8C63T1VF889904KYTKRB.jpg', '96', '120', '3', '5', '0', '1', NULL, '2025-10-24 02:45:46', '2026-01-21 01:38:06'),
(18, '4', '3', '10', 'Fried pork with garlic', 'images/restaurant/food/01KFFVAJSBDJGDXHBDTVCVHTFX.jpg', '104', '130', '3', '6', '0', '1', NULL, '2025-10-24 02:47:26', '2026-01-21 01:39:19'),
(19, '4', '3', '10', 'sun-dried pork', 'images/restaurant/food/01KFFVQP0Y84FFXE7WKM731BCX.jpg', '96', '120', '3', '7', '0', '1', NULL, '2025-10-24 02:48:57', '2026-01-21 01:46:28'),
(20, '4', '3', '10', 'Papaya salad with crab and fermented fish', 'images/restaurant/food/01KFFVNB4MXJMXNCW4JWTBXHQQ.jpg', '56', '70', '3', '8', '0', '1', NULL, '2025-10-24 02:50:17', '2026-01-21 01:45:11'),
(21, '4', '3', '11', 'Pork with lemon', 'images/restaurant/food/01KFFW8QCEG1T2879AEQMV9ZM5.jpg', '88', '110', '3', '9', '0', '1', NULL, '2025-10-24 02:51:11', '2026-01-21 01:55:46'),
(22, '4', '3', '11', 'Seafood salad', 'images/restaurant/food/01KFFW7NB892QRW803V1JQ20XN.jpg', '104', '130', '3', '10', '0', '1', NULL, '2025-10-24 02:52:23', '2026-01-21 01:55:11'),
(23, '4', '3', '15', 'Pork Burger', 'images/restaurant/food/01KFFW6QX0HRCGBC20GYN70CW3.jpg', '95', '119', '3', '11', '0', '1', NULL, '2025-10-24 02:53:26', '2026-01-21 01:54:41'),
(24, '4', '3', '17', 'Rad Na noodles', 'images/restaurant/food/01KFFW5KQJTDT6PWQQ7JYZWFHF.jpg', '60', '75', '3', '12', '0', '1', NULL, '2025-10-24 02:54:54', '2026-01-21 01:54:04'),
(25, '4', '3', '17', 'Duck on rice', 'images/restaurant/food/01KFFW3ZGZ6X8VS90YV9AWQ6J3.jpg', '60', '75', '3', '13', '0', '1', NULL, '2025-10-24 02:55:40', '2026-01-21 01:53:11'),
(26, '4', '3', '17', 'Pork leg rice', 'images/restaurant/food/01KFFW0F9H5VFPTARVCCPCHACS.jpg', '68', '85', '3', '14', '0', '1', NULL, '2025-10-24 02:56:42', '2026-01-21 01:51:16'),
(27, '4', '3', '12', 'Ice, per bucket', 'images/restaurant/food/01KFFWC6KS2Q57QNXR0TPZPQTN.jpg', '10', '20', '3', '15', '0', '1', NULL, '2025-10-24 02:57:40', '2026-01-21 01:57:40'),
(28, '4', '3', '12', 'Stein Lager, German draft beer, 1 liter', 'images/restaurant/food/01KFFWB5XHJ3ZCWDVW5D67VADC.png', '111', '139', '3', '16', '0', '1', NULL, '2025-10-24 02:58:38', '2026-01-21 01:57:07'),
(29, '4', '3', '14', 'Rice porridge', 'images/restaurant/food/01KFFVVAKHPT10VE0JVCMY9N9E.png', '8', '10', '3', '17', '0', '1', NULL, '2025-10-24 02:59:16', '2026-01-21 01:48:27'),
(30, '4', '3', '13', 'Hawaiian Pizza (Medium) 12\"', 'images/restaurant/food/01KFFVTB5ERYP1RBVW23C5V4BS.png', '212', '265', '3', '18', '1', '1', NULL, '2025-10-27 02:18:17', '2026-01-21 01:47:55'),
(31, '3', '2', '27', 'Wall\'s Tub Vanilla 390g.', 'images/restaurant/food/01KFG521QG8TNXJ3VS16W929PP.jpg', '92', '115', '3', NULL, '0', '1', NULL, '2026-01-21 04:29:25', '2026-01-21 04:29:25'),
(32, '3', '2', '27', 'Wall\'s 2 in 1 Chocolate Chip 390 grams', 'images/restaurant/food/01KFG543KC9H77552GQDCZ1R6W.jpg', '92', '115', '3', NULL, '1', '1', NULL, '2026-01-21 04:30:32', '2026-01-21 04:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `stor_food_translations`
--

CREATE TABLE `stor_food_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stor_food_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `food_translation_name` varchar(255) DEFAULT NULL,
  `food_desc` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stor_food_translations`
--

INSERT INTO `stor_food_translations` (`id`, `stor_food_id`, `language_id`, `food_translation_name`, `food_desc`, `created_at`, `updated_at`) VALUES
(1, 29, 1, 'Rice porridge', 'Delicious  thai rice', '2025-10-25 03:17:10', '2025-10-25 03:17:10'),
(2, 29, 3, 'បបរ', NULL, '2025-10-25 03:17:41', '2025-10-25 03:17:41'),
(3, 29, 2, 'โจ๊ก', 'ข้าวไทยอร่อย', '2025-10-25 03:18:36', '2025-10-25 03:18:36'),
(4, 12, 1, 'Special Food', NULL, '2025-10-26 21:23:36', '2025-10-26 21:23:36'),
(5, 12, 2, 'อาหารพิเศษ', 'สั่งเมนูที่อยู่ด้านล่าง 👇👇👇👇 (โปรโมชั่น 5-31 ต.ค.2568 นี้)', '2025-10-26 21:23:56', '2025-10-27 02:09:02'),
(6, 12, 3, 'អាហារពិសេស', NULL, '2025-10-26 21:24:14', '2025-10-26 21:24:14'),
(7, 13, 1, 'Fest Beer Combo Set', NULL, '2025-10-26 21:24:41', '2025-10-26 21:24:41'),
(8, 13, 3, 'Fest Beer Combo Set', NULL, '2025-10-26 21:25:00', '2025-10-26 21:25:00'),
(9, 13, 2, 'ชุดคอมโบเบียร์เฟสต์', 'Fest Beer 2 ลิตร ขาหมูเยอรมัน ไส้กรอกเยอรมันรวม และน้ำแข็ง จากราคาเดิม 1350 บาท (โปรโมชั่น 5-31 ต.ค.2568 นี้)', '2025-10-26 21:25:21', '2025-10-27 02:09:34'),
(10, 14, 1, 'Kale with salted fish', NULL, '2025-10-26 21:25:48', '2025-10-26 21:25:48'),
(11, 14, 2, 'คะน้าปลาเค็ม', NULL, '2025-10-26 21:26:03', '2025-10-26 21:26:03'),
(12, 14, 3, 'ខាត់ណាជាមួយត្រីអំបិល', NULL, '2025-10-26 21:26:20', '2025-10-26 21:26:20'),
(13, 15, 1, 'salted egg', NULL, '2025-10-26 21:26:46', '2025-10-26 21:26:46'),
(14, 15, 3, 'ស៊ុតអំបិល', NULL, '2025-10-26 21:27:09', '2025-10-26 21:27:09'),
(15, 15, 2, 'ไข่เค็ม', NULL, '2025-10-26 21:27:23', '2025-10-26 21:27:23'),
(16, 16, 1, 'Pork noodle soup', NULL, '2025-10-26 21:27:45', '2025-10-26 21:27:45'),
(17, 16, 2, 'ก๋วยเตี๋ยวหมู', NULL, '2025-10-26 21:28:00', '2025-10-26 21:28:00'),
(18, 16, 3, 'ស៊ុបគុយទាវសាច់ជ្រូក', NULL, '2025-10-26 21:28:16', '2025-10-26 21:28:16'),
(19, 17, 1, 'Beef noodle soup', 'delicious food', '2025-10-26 21:28:50', '2025-10-26 21:28:50'),
(20, 17, 3, 'ស៊ុបគុយទាវសាច់គោ', NULL, '2025-10-26 21:29:03', '2025-10-26 21:29:03'),
(21, 17, 2, 'ก๋วยเตี๋ยวเนื้อ', NULL, '2025-10-26 21:29:18', '2025-10-26 21:29:18'),
(22, 18, 1, 'Fried pork salad', NULL, '2025-10-26 23:27:57', '2025-10-26 23:27:57'),
(23, 18, 3, 'សាឡាត់សាច់ជ្រូកចៀន', NULL, '2025-10-26 23:28:18', '2025-10-26 23:28:18'),
(24, 18, 2, 'ยำหมูทอด', NULL, '2025-10-26 23:28:36', '2025-10-26 23:28:36'),
(25, 19, 1, 'Cooked pork salad', NULL, '2025-10-26 23:30:05', '2025-10-26 23:30:05'),
(26, 19, 2, 'สลัดหมูปรุงสุก', NULL, '2025-10-26 23:31:15', '2025-10-26 23:31:15'),
(27, 19, 3, 'សាឡាត់សាច់ជ្រូកឆ្អិន', NULL, '2025-10-26 23:31:31', '2025-10-26 23:31:31'),
(28, 20, 1, 'Papaya salad with crab and fermented fish', NULL, '2025-10-26 23:33:21', '2025-10-26 23:33:21'),
(29, 20, 3, 'ល្ហុងជាមួយក្តាម និងត្រីដែលមានជាតិ fermented', NULL, '2025-10-26 23:34:26', '2025-10-26 23:34:26'),
(30, 20, 2, 'ส้มตำปูปลาร้า', NULL, '2025-10-26 23:35:06', '2025-10-26 23:35:06'),
(31, 21, 1, 'Pork with lemon', NULL, '2025-10-26 23:37:32', '2025-10-26 23:37:32'),
(32, 21, 2, 'หมูมะนาว', NULL, '2025-10-26 23:37:51', '2025-10-26 23:37:51'),
(33, 21, 3, 'សាច់ជ្រូកជាមួយក្រូចឆ្មា', NULL, '2025-10-26 23:38:07', '2025-10-26 23:38:07'),
(34, 22, 1, 'Seafood salad', NULL, '2025-10-26 23:40:06', '2025-10-26 23:40:06'),
(35, 22, 3, 'សាឡាត់អាហារសមុទ្រ', NULL, '2025-10-26 23:40:33', '2025-10-26 23:40:33'),
(36, 22, 2, 'สลัดทะเล', NULL, '2025-10-26 23:40:49', '2025-10-26 23:40:49'),
(37, 23, 1, 'Pork Burger', NULL, '2025-10-26 23:41:22', '2025-10-26 23:41:22'),
(38, 23, 2, 'เบอร์เกอร์หมู', NULL, '2025-10-26 23:41:52', '2025-10-26 23:41:52'),
(39, 23, 3, 'ប៊ឺហ្គឺសាច់ជ្រូក', NULL, '2025-10-26 23:42:16', '2025-10-26 23:42:16'),
(40, 24, 1, 'Rad Na noodles', NULL, '2025-10-26 23:43:01', '2025-10-26 23:43:01'),
(41, 24, 3, 'គុយទាវ Rad Na', NULL, '2025-10-26 23:44:14', '2025-10-26 23:44:14'),
(42, 24, 2, 'ก๋วยเตี๋ยวราดหน้า', NULL, '2025-10-26 23:44:35', '2025-10-26 23:44:35'),
(43, 25, 1, 'Duck on rice', NULL, '2025-10-26 23:45:47', '2025-10-26 23:45:47'),
(44, 25, 2, 'ข้าวหน้าเป็ด', NULL, '2025-10-26 23:46:01', '2025-10-26 23:46:01'),
(45, 25, 3, 'ទានៅលើអង្ករ', NULL, '2025-10-26 23:46:23', '2025-10-26 23:46:23'),
(46, 26, 1, 'Pork leg rice', NULL, '2025-10-26 23:47:10', '2025-10-26 23:47:10'),
(47, 26, 3, 'បាយជើងជ្រូក', NULL, '2025-10-26 23:47:27', '2025-10-26 23:47:27'),
(48, 26, 2, 'ข้าวขาหมู', NULL, '2025-10-26 23:47:59', '2025-10-26 23:47:59'),
(49, 27, 1, 'Ice, per bucket', NULL, '2025-10-26 23:49:20', '2025-10-26 23:49:20'),
(50, 27, 2, 'น้ำแข็ง ถังละ', NULL, '2025-10-26 23:49:38', '2025-10-26 23:49:38'),
(51, 27, 3, 'ទឹកកកក្នុងមួយធុង', NULL, '2025-10-26 23:50:04', '2025-10-26 23:50:04'),
(52, 28, 1, 'Stein Lager, German draft beer, 1 liter', NULL, '2025-10-26 23:50:50', '2025-10-26 23:50:50'),
(53, 28, 3, 'Stein Lager ស្រាបៀរអាឡឺម៉ង់ 1 លីត្រ', NULL, '2025-10-26 23:51:04', '2025-10-26 23:51:04'),
(54, 28, 2, 'Stein Lager เบียร์สดเยอรมัน 1 ลิตร', NULL, '2025-10-26 23:51:19', '2025-10-26 23:51:19'),
(55, 1, 1, 'Taiwanese milk tea', NULL, '2025-10-27 01:48:14', '2025-10-27 01:48:14'),
(56, 1, 2, 'ชานมไต้หวัน', NULL, '2025-10-27 01:48:32', '2025-10-27 01:48:32'),
(57, 1, 3, 'តែទឹកដោះគោតៃវ៉ាន់', NULL, '2025-10-27 01:48:47', '2025-10-27 01:48:47'),
(58, 11, 1, 'whipped cheese', NULL, '2025-10-27 01:50:56', '2025-10-27 01:50:56'),
(59, 11, 3, 'ឈី whipped', NULL, '2025-10-27 01:51:13', '2025-10-27 01:51:13'),
(60, 11, 2, 'วิปชีส', NULL, '2025-10-27 01:51:28', '2025-10-27 01:51:28'),
(61, 10, 1, 'pearl', NULL, '2025-10-27 01:52:22', '2025-10-27 01:52:22'),
(62, 10, 2, 'ไข่มุก', NULL, '2025-10-27 01:52:36', '2025-10-27 01:52:36'),
(63, 10, 3, 'គុជខ្យង', NULL, '2025-10-27 01:52:59', '2025-10-27 01:52:59'),
(64, 9, 1, 'Fruit jelly', NULL, '2025-10-27 01:53:20', '2025-10-27 01:53:20'),
(65, 9, 3, 'ចាហួយផ្លែឈើ', NULL, '2025-10-27 01:53:33', '2025-10-27 01:53:33'),
(66, 9, 2, 'เยลลี่ผลไม้', NULL, '2025-10-27 01:53:47', '2025-10-27 01:53:47'),
(67, 8, 1, 'Honeycomb', NULL, '2025-10-27 01:54:09', '2025-10-27 01:54:09'),
(68, 8, 2, 'รังผึ้ง', NULL, '2025-10-27 01:54:30', '2025-10-27 01:54:30'),
(69, 8, 3, 'សំបុកឃ្មុំ', NULL, '2025-10-27 01:54:44', '2025-10-27 01:54:44'),
(70, 7, 1, 'Cocoa Mint', NULL, '2025-10-27 01:55:09', '2025-10-27 01:55:09'),
(71, 7, 3, 'កាកាវ Mint', NULL, '2025-10-27 01:55:24', '2025-10-27 01:55:24'),
(72, 7, 2, 'โกโก้มิ้นท์', NULL, '2025-10-27 01:55:39', '2025-10-27 01:55:39'),
(73, 6, 1, 'Cocoa Shake', NULL, '2025-10-27 01:56:02', '2025-10-27 01:56:02'),
(74, 6, 2, 'โกโก้เชค', NULL, '2025-10-27 01:56:17', '2025-10-27 01:56:17'),
(75, 6, 3, 'ក្រឡុកកាកាវ', NULL, '2025-10-27 01:56:32', '2025-10-27 01:56:32'),
(76, 5, 1, 'Strawberry tea', NULL, '2025-10-27 01:56:57', '2025-10-27 01:56:57'),
(77, 5, 3, 'តែស្ត្របឺរី', NULL, '2025-10-27 01:57:12', '2025-10-27 01:57:12'),
(78, 5, 2, 'ชาสตอเบอร์รี่', NULL, '2025-10-27 01:57:29', '2025-10-27 01:57:29'),
(79, 4, 1, 'Green Apple Tea', NULL, '2025-10-27 01:57:54', '2025-10-27 01:57:54'),
(80, 4, 2, 'ชาแอปเปิ้ลเขียว', NULL, '2025-10-27 01:58:08', '2025-10-27 01:58:08'),
(81, 4, 3, 'តែបៃតងផ្លែប៉ោម', NULL, '2025-10-27 01:58:21', '2025-10-27 01:58:21'),
(82, 3, 1, 'Matcha green tea', NULL, '2025-10-27 01:58:56', '2025-10-27 01:58:56'),
(83, 3, 3, 'តែបៃតង Matcha', NULL, '2025-10-27 01:59:10', '2025-10-27 01:59:10'),
(84, 3, 2, 'ชาเขียวมัทฉะ', NULL, '2025-10-27 01:59:24', '2025-10-27 01:59:24'),
(85, 2, 1, 'Cocoa milk tea', NULL, '2025-10-27 01:59:43', '2025-10-27 01:59:43'),
(86, 2, 2, 'ชานมโกโก้', NULL, '2025-10-27 01:59:57', '2025-10-27 01:59:57'),
(87, 2, 3, 'តែទឹកដោះគោកាកាវ', NULL, '2025-10-27 02:00:12', '2025-10-27 02:00:12'),
(88, 30, 1, 'Hawaiian Pizza (Medium) 12\"', NULL, '2025-10-27 02:18:59', '2025-10-27 02:18:59'),
(89, 30, 3, 'ភីហ្សាហាវ៉ៃ (មធ្យម) 12 អ៊ីញ', NULL, '2025-10-27 02:19:13', '2025-10-27 02:19:13'),
(90, 30, 2, 'พิซซ่าฮาวายเอี้ยน (ขนาดกลาง) 12 นิ้ว', NULL, '2025-10-27 02:19:28', '2025-10-27 02:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `stor_orders`
--

CREATE TABLE `stor_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stor_id` varchar(255) DEFAULT NULL,
  `storLoginId` varchar(255) DEFAULT NULL,
  `cust_id` varchar(255) DEFAULT NULL,
  `address_id` varchar(255) DEFAULT NULL,
  `order_key` varchar(255) DEFAULT NULL,
  `stor_food_id` varchar(255) DEFAULT NULL,
  `cart_id` varchar(255) DEFAULT NULL,
  `f_qty` varchar(255) DEFAULT NULL,
  `total_cost_price` varchar(255) DEFAULT NULL,
  `subTotal` varchar(255) DEFAULT NULL,
  `distance_between_shop_customer` varchar(255) DEFAULT NULL,
  `minimum_order_diffrence` varchar(255) DEFAULT NULL,
  `shipping_charge` varchar(255) DEFAULT NULL,
  `rider_charge` varchar(255) DEFAULT NULL,
  `owncharge_form_riderside` varchar(255) DEFAULT NULL,
  `owncharge_form_storside` varchar(255) DEFAULT NULL,
  `new_customer_discount` varchar(255) DEFAULT NULL,
  `discount_offer` varchar(255) DEFAULT NULL,
  `totalPayAmount` varchar(255) DEFAULT NULL,
  `currency_id` varchar(255) DEFAULT NULL,
  `TransactionId` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `response_all` longtext DEFAULT NULL,
  `attach_slip` longtext DEFAULT NULL,
  `payment_time` varchar(255) DEFAULT NULL,
  `gateway_name` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_date` varchar(255) DEFAULT NULL,
  `rider_id` varchar(255) DEFAULT NULL,
  `special_instructions` longtext DEFAULT NULL,
  `assign_status` enum('pending','assigntoRider','acceptedbyRider','riderGoingToStor','arrivedatstor','onthewayToDeliver','arrivedatLocation','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `delivery_started_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` longtext DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stor_orders`
--

INSERT INTO `stor_orders` (`id`, `stor_id`, `storLoginId`, `cust_id`, `address_id`, `order_key`, `stor_food_id`, `cart_id`, `f_qty`, `total_cost_price`, `subTotal`, `distance_between_shop_customer`, `minimum_order_diffrence`, `shipping_charge`, `rider_charge`, `owncharge_form_riderside`, `owncharge_form_storside`, `new_customer_discount`, `discount_offer`, `totalPayAmount`, `currency_id`, `TransactionId`, `payment_type`, `payment_status`, `response_all`, `attach_slip`, `payment_time`, `gateway_name`, `order_status`, `order_date`, `rider_id`, `special_instructions`, `assign_status`, `delivery_started_at`, `cancel_reason`, `latitude`, `longitude`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '3', '4', '2', '1', 'BNG-0001', '12', '185', '1', '100', '125', '2', '0', '20', '10', '10', '5', '20', '0', '125', '3', NULL, 'online', 'pending', NULL, NULL, NULL, NULL, 'cancelled', '2026-01-24 12:20:13', NULL, NULL, 'cancelled', NULL, 'fffffffff', '-435734587375843', '-3456347534', NULL, '2026-01-24 05:20:13', '2026-01-23 22:20:22'),
(2, '3', '4', '2', '1', 'BNG-0002', '19', '186', '1', '96', '120', '2', '0', '20', '10', '10', '24', '0', '0', '140', '3', NULL, 'online', 'success', NULL, 'paymentSlip/1w25ZtOIDKdZdwVXyRxENrvCbdbpUIqPZvAqsgZF.png', NULL, NULL, 'delivered', '2026-01-24 12:21:20', NULL, 'need spicy', 'delivered', '2026-01-24 05:27:29', NULL, '-435734587375843', '-3456347534', NULL, '2026-01-24 05:21:20', '2026-01-24 05:27:29'),
(3, '1', '2', '2', '1', 'BNG-0003', '6', '187', '1', '44', '55', '2', '5', '20', '10', '10', '16', '0', '0', '80', '3', NULL, 'online', 'success', NULL, 'paymentSlip/ZuZikFs9qnZgzRQnVt7Q4MLkAEgUR4qnieFOh7Ah.jpg', NULL, NULL, 'delivered', '2026-01-23 03:50:46', NULL, 'need sweet', 'delivered', '2026-01-24 08:53:51', NULL, '-435734587375843', '-3456347534', NULL, '2026-01-24 08:50:46', '2026-01-24 08:53:51'),
(4, '3', '4', '2', '1', 'BNG-0004', '22', '188', '1', '104', '130', '2', '0', '20', '10', '10', '26', '0', '0', '150', '3', NULL, 'online', 'pending', NULL, NULL, NULL, NULL, 'cancelled', '2026-01-24 04:32:43', NULL, NULL, 'cancelled', NULL, 'dfgfgfgfg', '-435734587375843', '-3456347534', NULL, '2026-01-24 09:32:43', '2026-01-24 02:32:51'),
(5, '3', '4', '2', '1', 'BNG-0005', '14', '189', '1', '72', '90', '2', '0', '20', '10', '10', '18', '0', '0', '110', '3', NULL, 'online', 'success', NULL, 'paymentSlip/WGjfRxNmzKwEX5LDze5dGgpaAqLUgIfrQperZC7K.jpg', NULL, NULL, 'delivered', '2026-01-24 04:39:51', NULL, NULL, 'delivered', '2026-01-24 09:45:42', NULL, '-435734587375843', '-3456347534', NULL, '2026-01-24 09:39:51', '2026-01-24 09:45:42'),
(6, '2', '3', '2', '1', 'BNG-0006', '31', '190', '1', '92', '115', '2', '0', '20', '10', '10', '23', '0', '0', '135', '3', NULL, 'online', 'awaiting verification', NULL, 'paymentSlip/Q83KFTeMdG2qawEH9F6d3vm5CoGNtE8iu1GgodIU.jpg', NULL, NULL, 'success', '2026-01-26 11:58:05', NULL, NULL, 'pending', NULL, NULL, '-435734587375843', '-3456347534', NULL, '2026-01-26 04:58:05', '2026-01-26 04:23:36'),
(7, '3', '4', '2', '1', 'BNG-0007', '12', '191', '1', '819', '1024', '2', '0', '20', '10', '10', '205', '0', '0', '1044', '3', NULL, 'online', 'awaiting verification', NULL, 'paymentSlip/vleHIu6054AwkYzoBjetndjLdQwipGGwuOR5VbEW.png', NULL, NULL, 'success', '2026-01-27 11:42:51', NULL, NULL, 'pending', NULL, NULL, '-435734587375843', '-3456347534', NULL, '2026-01-27 04:42:51', '2026-01-26 21:43:02'),
(8, '3', '4', '2', '1', 'BNG-0007', '13', '192', '1', '819', '1024', '2', '0', '20', '10', '10', '205', '0', '0', '1044', '3', NULL, 'online', 'awaiting verification', NULL, 'paymentSlip/vleHIu6054AwkYzoBjetndjLdQwipGGwuOR5VbEW.png', NULL, NULL, 'success', '2026-01-27 11:42:51', NULL, NULL, 'pending', NULL, NULL, '-435734587375843', '-3456347534', NULL, '2026-01-27 04:42:51', '2026-01-26 21:43:02'),
(9, '3', '4', '2', '1', 'BNG-0008', '12', '193', '1', '819', '1024', '2', '0', '20', '10', '10', '205', '0', '0', '1044', '3', NULL, 'online', 'success', NULL, 'paymentSlip/bdVKd18w2hnF1fPpValCYT2TMaeVxMbK34fB9mEj.jpg', NULL, NULL, 'success', '2026-01-28 10:09:29', NULL, 'need spicy', 'delivered', NULL, NULL, '-435734587375843', '-3456347534', NULL, '2026-01-28 03:09:29', '2026-01-27 20:09:42'),
(10, '3', '4', '2', '1', 'BNG-0008', '13', '194', '1', '819', '1024', '2', '0', '20', '10', '10', '205', '0', '0', '1044', '3', NULL, 'online', 'success', NULL, 'paymentSlip/bdVKd18w2hnF1fPpValCYT2TMaeVxMbK34fB9mEj.jpg', NULL, NULL, 'success', '2026-01-28 10:09:29', NULL, 'need spicy', 'delivered', NULL, NULL, '-435734587375843', '-3456347534', NULL, '2026-01-28 03:09:29', '2026-01-27 20:09:42'),
(11, '2', '3', '2', '1', 'BNG-0009', '31', '195', '1', '92', '115', '2', '0', '20', '10', '10', '23', '0', '0', '135', '3', NULL, 'online', 'success', NULL, 'paymentSlip/uCZVK2LkVdOrFvyP66sX99achW15ZmlWLkWgTRLO.jpg', NULL, NULL, 'success', '2026-01-28 10:19:07', NULL, NULL, 'delivered', '2026-01-28 03:21:50', NULL, '-435734587375843', '-3456347534', NULL, '2026-01-28 03:19:07', '2026-01-28 03:21:50'),
(12, '3', '4', '2', '1', 'BNG-0010', '12', '196', '1', '100', '125', '2', '0', '20', '10', '10', '25', '0', '0', '145', '3', NULL, 'online', 'success', NULL, 'paymentSlip/gi9ahgoWFtbsWACN0rf9H2afdXZBBU2mTrcotacz.png', NULL, NULL, 'delivered', '2026-01-29 04:25:17', NULL, NULL, 'delivered', '2026-01-29 09:28:31', NULL, '-435734587375843', '-3456347534', NULL, '2026-01-29 09:25:17', '2026-01-29 09:28:31'),
(13, '2', '3', '2', '1', 'BNG-0011', '32', '199', '1', '184', '230', '2', '0', '20', '10', '10', '46', '0', '0', '250', '3', NULL, 'online', 'success', NULL, 'paymentSlip/7aqMGzD2p15r5JlxANrzoPyLQ6GiibK5Zv4uF5QV.png', NULL, NULL, 'cancelled', '2026-01-29 05:36:09', NULL, 'need sweet', 'cancelled', NULL, 'not delicious', '-435734587375843', '-3456347534', NULL, '2026-01-29 10:36:09', '2026-01-29 03:40:06'),
(14, '2', '3', '2', '1', 'BNG-0011', '31', '200', '1', '184', '230', '2', '0', '20', '10', '10', '46', '0', '0', '250', '3', NULL, 'online', 'success', NULL, 'paymentSlip/7aqMGzD2p15r5JlxANrzoPyLQ6GiibK5Zv4uF5QV.png', NULL, NULL, 'cancelled', '2026-01-29 05:36:09', NULL, 'need sweet', 'cancelled', '2026-01-29 10:39:09', 'not delicious', '-435734587375843', '-3456347534', NULL, '2026-01-29 10:36:09', '2026-01-29 03:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `stor_translations`
--

CREATE TABLE `stor_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stor_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `stor_name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stor_translations`
--

INSERT INTO `stor_translations` (`id`, `stor_id`, `language_id`, `stor_name`, `desc`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'MARUCHA Zone 3', 'delicious cold drink shop', 'Beer City Zone 3', '2025-09-26 03:14:24', '2025-09-26 03:14:24'),
(2, 1, 2, 'MARUCHA  โซน 3', 'ร้านเครื่องดื่มเย็นๆอร่อยๆ', 'เบียร์ซิตี้โซน 3', '2025-09-26 03:32:15', '2025-09-26 03:32:15'),
(3, 1, 3, 'MARUCHA តំបន់ ៣', 'ហាងភេសជ្ជៈត្រជាក់ឆ្ងាញ់', 'បុរី ស៊ីធី ភូមិភាគ ៣', '2025-09-26 03:33:07', '2025-09-26 03:33:07'),
(4, 2, 1, 'Wall\'s Ice Cream', 'delicious ice cream', 'beer City Zone 3', '2025-09-29 04:08:54', '2025-09-29 04:09:10'),
(5, 2, 2, 'วอลล์ไอศกรีม', 'ไอศกรีมแสนอร่อย', 'เบียร์ซิตี้โซน 3', '2025-09-29 04:18:04', '2025-09-29 04:18:04'),
(6, 2, 3, 'ការ៉េមជញ្ជាំង', 'ការ៉េមឆ្ងាញ់', 'ស្រាបៀរ ស៊ីធី តំបន់ ៣', '2025-09-29 04:19:00', '2025-09-29 04:19:00'),
(7, 3, 1, 'Beer City Delivery', 'popular Thai foods', 'beer City Zone 3', '2025-09-29 04:20:40', '2025-09-29 04:20:40'),
(8, 3, 3, 'សេវា​ដឹក​ជញ្ជូន​ទីក្រុង​បៀរ', 'អាហារថៃពេញនិយម', 'បុរី ស៊ីធី ភូមិភាគ ៣', '2025-09-29 04:21:44', '2025-09-29 04:21:44'),
(9, 3, 2, 'เบียร์ซิตี้ เดลิเวอรี่', 'อาหารไทยยอดนิยม', 'เบียร์ซิตี้โซน 3', '2025-09-29 04:22:24', '2025-09-29 04:22:24'),
(10, 4, 1, 'Go bong laundry service', 'provide best service for cleaning clothes', 'beer City Zone 3', '2025-09-29 04:23:38', '2025-09-29 04:23:38'),
(11, 4, 2, 'บริการซักรีดโกบอง', 'ให้บริการทำความสะอาดเสื้อผ้าที่ดีที่สุด', 'เบียร์ซิตี้โซน 3', '2025-09-29 04:24:24', '2025-09-29 04:24:24'),
(12, 4, 3, 'Go bong សេវាកម្មបោកអ៊ុត', 'ផ្តល់សេវាកម្មល្អបំផុតសម្រាប់ការសម្អាតសម្លៀកបំពាក់', 'បុរី ស៊ីធី ភូមិភាគ ៣', '2025-09-29 04:25:27', '2025-09-29 04:25:27'),
(13, 5, 1, ' Chicken Bomb', 'Thai cold drink and fried chicken shop', 'beer City Zone 3', '2025-10-27 02:51:42', '2025-10-27 02:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email_verified_at` varchar(255) DEFAULT '1',
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phoneNumber`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'gobongadmin@gmail.com', '72345678', 'Admin', '1', '$2y$12$/eNX8CH92F200MvFXA/KmuHRar9CzPv9ttYAMQ8ze4k6q7k0Vkn5i', 'mrLCDbsyX2bsBOL0xVKDQcuhpyUTyC5hDdGLCIGvBlXKMAvtA5Q6BIIRK1v0', '2025-09-22 03:22:09', '2025-09-24 23:50:45'),
(2, 'MARUCHA Zone 3', 'MARUCHA@gmail.com', '33333333', 'Shop Manager', '1', '$2y$12$SenUSes1o1WwnDJN.pYjae8qOIzdS4188S/dHUiQ/WeGqCoOqRkYO', 'zNnbHfIH6oQLF01tvFXioJE90vz3qqjpsYhTV796ZE0GlL80hsuIL7mLthwx', '2025-09-24 23:41:19', '2025-10-03 23:32:58'),
(3, 'Wall\'s Ice Cream', 'IceCream@gmail.com', '11111111', 'Shop Manager', '1', '$2y$12$sA6q.FfOQar/PZfHbrpk9epsNyL/WFj.DCJUHQ.Cl0uui31mhxwm2', NULL, '2025-09-26 02:09:21', '2025-10-07 01:46:28'),
(4, 'Beer City Delivery', 'BeerCity@gmail.com', '88888888', 'Shop Manager', '1', '$2y$12$FYiFRdruf5FE9EpXKnQ4/eS2QQ/43yPFX7ecWWNLRjax0PQseoBSq', 'lSvIwbRpbWAQctX5UbAfmHIByGACJn5wpeC3azR2T9wLWL5wXYdkNg5aYqu7', '2025-09-26 02:17:31', '2025-10-02 01:46:57'),
(5, 'Go bong laundry service', 'beercitylaundryservice@gmail.com', '22222222', 'Shop Manager', '1', '$2y$12$plJouHZLpqsHzYCT/lItQe7DukN1v5gazXzcg2pAlf88fyvBKYbNS', NULL, '2025-09-26 02:29:26', '2025-10-07 02:33:45'),
(6, 'Khun  nui', 'khunnui@gmail.com', '77777777', 'Rider', '1', '$2y$12$GXISdCy.fPhwj5HzWy6iZuS5iQLoj9T2HM9Hypv0HM0vhfsvc.6D2', NULL, '2025-10-02 01:37:30', '2025-10-02 01:37:30'),
(18, ' Chicken Bomb', 'sirichaiB@gmail.com', '44444444', 'Shop Manager', '1', NULL, NULL, '2025-10-20 01:23:03', '2025-10-27 02:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_translations_category_id_foreign` (`category_id`),
  ADD KEY `category_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stors`
--
ALTER TABLE `stors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stor_foods`
--
ALTER TABLE `stor_foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stor_food_translations`
--
ALTER TABLE `stor_food_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stor_food_translations_stor_food_id_foreign` (`stor_food_id`),
  ADD KEY `stor_food_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `stor_orders`
--
ALTER TABLE `stor_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stor_translations`
--
ALTER TABLE `stor_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stor_translations_stor_id_foreign` (`stor_id`),
  ADD KEY `stor_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stors`
--
ALTER TABLE `stors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stor_foods`
--
ALTER TABLE `stor_foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `stor_food_translations`
--
ALTER TABLE `stor_food_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `stor_orders`
--
ALTER TABLE `stor_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stor_translations`
--
ALTER TABLE `stor_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stor_food_translations`
--
ALTER TABLE `stor_food_translations`
  ADD CONSTRAINT `stor_food_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stor_food_translations_stor_food_id_foreign` FOREIGN KEY (`stor_food_id`) REFERENCES `stor_foods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stor_translations`
--
ALTER TABLE `stor_translations`
  ADD CONSTRAINT `stor_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stor_translations_stor_id_foreign` FOREIGN KEY (`stor_id`) REFERENCES `stors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
