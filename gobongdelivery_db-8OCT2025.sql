-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 04:49 AM
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
('livewire-rate-limiter:eab216f95727913eee52b11b4b863b41a4bf4332', 'i:1;', 1759829707),
('livewire-rate-limiter:eab216f95727913eee52b11b4b863b41a4bf4332:timer', 'i:1759829707;', 1759829707);

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
(9, 'noodle', 'images/categories/01K6MJ8J26JR5C2P74TW7GG9RD.jpg', '3', '0', '0', '1', '2025-10-03 01:15:51', '2025-10-03 01:29:33'),
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
(32, 'Customer information', NULL, '4', NULL, '1', '1', '2025-10-07 02:36:44', '2025-10-07 03:23:33');

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
(69, 32, 3, 'ព័ត៌មានអតិថិជន', NULL, '2025-10-07 03:20:01', '2025-10-07 03:20:01');

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
(1, 'English', 'en', 0, 1, 'images/flages/01K603A06R0WV80SFSHYF9ZY5V.png', NULL, '2025-10-01 01:27:21'),
(2, 'Thai', 'th-TH', 1, 1, 'images/flages/01K603FZ90MNNP03SKPQKXVCVQ.png', NULL, '2025-09-25 02:32:57'),
(3, 'Khmer', 'km', 2, 1, 'images/flages/01K603H0NDWJEKNQP4M1QKBYBX.png', NULL, '2025-09-25 02:33:31');

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
(14, '2025_09_30_074754_create_category_translations_table', 11);

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
('eALNZfHRZiAgAhR0PYL5yra2IFAsle1PwjXMcmuW', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiVU9XMmEyQnRqWGdyV1VIaUtERnk3ZGlJNjljcWUydFJqTEZ2cXJvWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wLW1hbmFnZXIvY2F0ZWdvcmllcz9hY3RpdmVUYWI9U2hvdyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRwbEpvdUhaTHBxc0h6WUNUL2xJdFFlN0R1a04xdjVnYXpYemNnMnBBbGY4OGZ5dkJLWWJOUyI7czo4OiJmaWxhbWVudCI7YTowOnt9czo2OiJsb2NhbGUiO3M6NToidGgtVEgiO30=', 1759836659),
('S9DM4kj9Y3WDov3R8lzq7H7j30jERkqpxSfkcEmx', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTzc0ZWpBdWVrMTg2bFJIem9WMU01ZnZBeWdjd0pJdXREU0N1cmh6SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiQvZU5YOENIOTJGMjAwTXZGWEEvS211SFJhcjlDelB2OXR0WUFNUTh6ZTRrNnE3azBWa241aSI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1759836732);

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
(1, '2', 'Go Bong Delivery', 'images/restaurant/01K62KA6JZZXHY652ZZQGF4R6C.jpg', 'Shop', 'Drink', '7234567890', 'Add food costs to the cost price', '20', '07:00:00', '23:59:59', 'rtyrtyrty', 'gjhfghjfh', '0.11', '1', NULL, '2025-09-26 01:47:53', '2025-09-26 02:13:05'),
(2, '3', 'Go Bong Delivery', 'images/restaurant/01K62MR09W5J93FK4P3FZWAW44.png', 'Shop', 'Ice Cream', '11111111', 'Set the shop GP deduction method', '20', '07:00:00', '23:59:58', '53454356435455', '45345345345', '0.09', '1', NULL, '2025-09-26 02:12:54', '2025-09-29 04:08:22'),
(3, '4', 'Go Bong Delivery', 'images/restaurant/01K62N8YG3GJSH9EHZ2AVC83YD.gif', 'Restaurant', 'Thai food', '0866666666', 'Set the shop GP deduction method', '20', '07:00:00', '23:59:58', '53454356435455', '45345345345', '0.09', '1', NULL, '2025-09-26 02:22:10', '2025-10-02 02:02:00'),
(4, '5', 'Go Bong Delivery', 'images/restaurant/01K62P0JPHAMFSZJ2ZA7CR5ACQ.png', 'Laundry', 'Clothes', '22228888', 'Set the shop GP deduction method', '20', '07:00:00', '21:00:00', '13.645502', '102.56653', '1.5', '1', NULL, '2025-09-26 02:35:04', '2025-10-02 01:13:53');

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
(12, 4, 3, 'Go bong សេវាកម្មបោកអ៊ុត', 'ផ្តល់សេវាកម្មល្អបំផុតសម្រាប់ការសម្អាតសម្លៀកបំពាក់', 'បុរី ស៊ីធី ភូមិភាគ ៣', '2025-09-29 04:25:27', '2025-09-29 04:25:27');

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
  `email_verified_at` varchar(255) DEFAULT '''1''',
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phoneNumber`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'gobongadmin@gmail.com', '72345678', 'Admin', '1', '$2y$12$/eNX8CH92F200MvFXA/KmuHRar9CzPv9ttYAMQ8ze4k6q7k0Vkn5i', 'SYofCtVVyFvvzGygTRw4czAFOh0Fcl8o1ojolwLPD3xqAbg0d7eLdqRQrfc2', '2025-09-22 03:22:09', '2025-09-24 23:50:45'),
(2, 'MARUCHA Zone 3', 'MARUCHA@gmail.com', '33333333', 'Shop Manager', '1', '$2y$12$SenUSes1o1WwnDJN.pYjae8qOIzdS4188S/dHUiQ/WeGqCoOqRkYO', 'HLzalaN8wTshej4McegVNSJI9mT5EHLRrSQKsUSEnFOJhMZE2tLZZRhj9CHU', '2025-09-24 23:41:19', '2025-10-03 23:32:58'),
(3, 'Wall\'s Ice Cream', 'IceCream@gmail.com', '11111111', 'Shop Manager', '1', '$2y$12$sA6q.FfOQar/PZfHbrpk9epsNyL/WFj.DCJUHQ.Cl0uui31mhxwm2', NULL, '2025-09-26 02:09:21', '2025-10-07 01:46:28'),
(4, 'Beer City Delivery', 'BeerCity@gmail.com', '88888888', 'Shop Manager', '1', '$2y$12$FYiFRdruf5FE9EpXKnQ4/eS2QQ/43yPFX7ecWWNLRjax0PQseoBSq', 'xBNuBIB4rXILjbIdQTXZC0MW3qt5biVtgxB88tzzziByBF2u45hMaG1U2Ctg', '2025-09-26 02:17:31', '2025-10-02 01:46:57'),
(5, 'Go bong laundry service', 'beercitylaundryservice@gmail.com', '22222222', 'Shop Manager', '1', '$2y$12$plJouHZLpqsHzYCT/lItQe7DukN1v5gazXzcg2pAlf88fyvBKYbNS', NULL, '2025-09-26 02:29:26', '2025-10-07 02:33:45'),
(6, 'Khun  nui', 'khunnui@gmail.com', '77777777', 'Rider', '1', '$2y$12$GXISdCy.fPhwj5HzWy6iZuS5iQLoj9T2HM9Hypv0HM0vhfsvc.6D2', NULL, '2025-10-02 01:37:30', '2025-10-02 01:37:30');

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stors`
--
ALTER TABLE `stors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stor_translations`
--
ALTER TABLE `stor_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `stor_translations`
--
ALTER TABLE `stor_translations`
  ADD CONSTRAINT `stor_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stor_translations_stor_id_foreign` FOREIGN KEY (`stor_id`) REFERENCES `stors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
