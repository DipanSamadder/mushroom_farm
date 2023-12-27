-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 12:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newbackenddec`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `latitude` varchar(399) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` varchar(399) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'email_verification', '1', '2023-06-14 13:10:03', '2023-06-14 13:10:03'),
(10, 'dashboard_title', 'Mushroom', '2023-07-04 10:32:24', '2023-12-15 05:11:10'),
(11, 'dashboard_copyright', '© Copyright 2023', '2023-07-04 10:32:24', '2023-08-11 04:37:34'),
(12, 'dashboard_logo', '2', '2023-07-04 10:32:24', '2023-08-11 04:37:34'),
(13, 'dashboard_fav_icon', '2', '2023-07-04 10:32:24', '2023-08-11 04:37:34'),
(14, 'dashboard_loader_icon', '2', '2023-07-04 10:32:24', '2023-08-11 04:37:34'),
(15, 'dashboard_login_background', '3', '2023-07-04 10:32:24', '2023-08-11 05:10:08'),
(16, 'dashboard_registration_background', '3', '2023-07-04 10:32:24', '2023-08-11 05:10:08'),
(17, 'dashboard_notifications', 'Notification', '2023-07-04 10:32:24', '2023-12-15 05:12:08'),
(18, 'social_link_name', '[\"fb\",\"tw\",\"yt\",\"li\",\"In\"]', '2023-07-07 11:46:40', '2023-08-23 07:18:57'),
(19, 'social_link_url', '[\"#f\",\"#f44\",\"#fsdf\",\"#l\",\"#i\"]', '2023-07-07 11:46:40', '2023-08-23 07:18:57'),
(20, 'dashboard_theme_color', 'light', '2023-07-07 06:46:39', '2023-07-08 03:34:03'),
(21, 'dashboard_base_color', NULL, '2023-07-07 06:46:39', '2023-07-07 06:46:53'),
(22, 'dashboard_rtl_version', 'null', '2023-07-07 06:46:39', '2023-07-07 06:46:53'),
(23, 'site_title', 'Test', '2023-07-10 05:22:43', '2023-07-10 05:22:57'),
(24, 'site_meta_keyword', 'dfgssdf', '2023-07-10 05:22:43', '2023-07-10 05:22:58'),
(25, 'site_meta_description', 'tas', '2023-07-10 05:22:43', '2023-07-10 05:22:58'),
(26, 'site_logo', '1', '2023-07-10 05:22:43', '2023-08-16 02:18:35'),
(27, 'site_fav_icon', '2', '2023-07-10 05:22:44', '2023-08-16 02:18:35'),
(28, 'site_login_background', '3', '2023-07-10 05:22:44', '2023-08-16 02:18:35'),
(29, 'site_registration_background', '3', '2023-07-10 05:22:44', '2023-08-16 02:18:35'),
(36, 'options_user_count', '1022', '2023-07-13 00:50:56', '2023-07-13 05:06:56'),
(37, 'site_footer_phone_number1', '+91 999999XXX', '2023-08-23 07:12:52', '2023-12-15 05:15:49'),
(38, 'site_footer_phone_number2', '+91 999999XXX', '2023-08-23 07:12:52', '2023-12-15 05:15:49'),
(39, 'site_footer_phone_number3', NULL, '2023-08-23 07:12:52', '2023-08-23 07:14:12'),
(40, 'site_footer_email1', 'email@gmail.com', '2023-08-23 07:12:52', '2023-12-15 05:15:49'),
(41, 'site_footer_email2', 'email@gmail.com', '2023-08-23 07:12:52', '2023-12-15 05:15:50'),
(42, 'site_footer_email3', 'email@gmail.com', '2023-08-23 07:12:52', '2023-12-15 05:15:50'),
(43, 'site_footer_address', 'Address', '2023-08-23 07:12:53', '2023-12-15 05:15:50'),
(44, 'site_footer_copyright', '© Copyright 2023', '2023-08-23 07:12:53', '2023-12-15 05:15:50'),
(45, 'site_header_phone_number', '\"0120-4370000\"', '2023-12-15 05:16:03', '2023-12-15 05:16:03'),
(46, 'site_header_address', '\"Address\"', '2023-12-15 05:16:04', '2023-12-15 05:16:04'),
(47, 'site_header_marguee', '\"Test\"', '2023-12-15 05:16:04', '2023-12-15 05:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `dogs_id` int(11) NOT NULL,
  `parents_id` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 0,
  `content` varchar(899) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint(11) NOT NULL,
  `commentable_type` varchar(355) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_id` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `phone_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', '93', 1, NULL, NULL),
(2, 'AL', 'Albania', '355', 1, NULL, NULL),
(3, 'DZ', 'Algeria', '213', 1, NULL, NULL),
(4, 'DS', 'American Samoa', NULL, 1, NULL, NULL),
(5, 'AD', 'Andorra', '376', 1, NULL, NULL),
(6, 'AO', 'Angola', '244', 1, NULL, NULL),
(7, 'AI', 'Anguilla', '1-264', 1, NULL, NULL),
(8, 'AQ', 'Antarctica', '672', 1, NULL, NULL),
(9, 'AG', 'Antigua and Barbuda', '1-268', 1, NULL, NULL),
(10, 'AR', 'Argentina', '54', 1, NULL, NULL),
(11, 'AM', 'Armenia', '374', 1, NULL, NULL),
(12, 'AW', 'Aruba', '297', 1, NULL, NULL),
(13, 'AU', 'Australia', '61', 1, NULL, NULL),
(14, 'AT', 'Austria', '43', 1, NULL, NULL),
(15, 'AZ', 'Azerbaijan', '994', 1, NULL, NULL),
(16, 'BS', 'Bahamas', '1-242', 1, NULL, NULL),
(17, 'BH', 'Bahrain', '973', 1, NULL, NULL),
(18, 'BD', 'Bangladesh', '880', 1, NULL, NULL),
(19, 'BB', 'Barbados', '1-246', 1, NULL, NULL),
(20, 'BY', 'Belarus', '375', 1, NULL, NULL),
(21, 'BE', 'Belgium', '32', 1, NULL, NULL),
(22, 'BZ', 'Belize', '501', 1, NULL, NULL),
(23, 'BJ', 'Benin', '229', 1, NULL, NULL),
(24, 'BM', 'Bermuda', '1-441', 1, NULL, NULL),
(25, 'BT', 'Bhutan', '975', 1, NULL, NULL),
(26, 'BO', 'Bolivia', '591', 1, NULL, NULL),
(27, 'BA', 'Bosnia and Herzegovina', '387', 1, NULL, NULL),
(28, 'BW', 'Botswana', '267', 1, NULL, NULL),
(29, 'BV', 'Bouvet Island', NULL, 1, NULL, NULL),
(30, 'BR', 'Brazil', '55', 1, NULL, NULL),
(31, 'IO', 'British Indian Ocean Territory', '246', 1, NULL, NULL),
(32, 'BN', 'Brunei Darussalam', '673', 1, NULL, NULL),
(33, 'BG', 'Bulgaria', '359', 1, NULL, NULL),
(34, 'BF', 'Burkina Faso', '226', 1, NULL, NULL),
(35, 'BI', 'Burundi', '257', 1, NULL, NULL),
(36, 'KH', 'Cambodia', '855', 1, NULL, NULL),
(37, 'CM', 'Cameroon', '237', 1, NULL, NULL),
(38, 'CA', 'Canada', '1', 1, NULL, NULL),
(39, 'CV', 'Cape Verde', '238', 1, NULL, NULL),
(40, 'KY', 'Cayman Islands', '1-345', 1, NULL, NULL),
(41, 'CF', 'Central African Republic', '236', 1, NULL, NULL),
(42, 'TD', 'Chad', '235', 1, NULL, NULL),
(43, 'CL', 'Chile', '56', 1, NULL, NULL),
(44, 'CN', 'China', '86', 1, NULL, NULL),
(45, 'CX', 'Christmas Island', '61', 1, NULL, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', '61', 1, NULL, NULL),
(47, 'CO', 'Colombia', '57', 1, NULL, NULL),
(48, 'KM', 'Comoros', '269', 1, NULL, NULL),
(49, 'CG', 'Congo', '242', 1, NULL, NULL),
(50, 'CK', 'Cook Islands', '682', 1, NULL, NULL),
(51, 'CR', 'Costa Rica', '506', 1, NULL, NULL),
(52, 'HR', 'Croatia (Hrvatska)', '385', 1, NULL, NULL),
(53, 'CU', 'Cuba', '53', 1, NULL, NULL),
(54, 'CY', 'Cyprus', '357', 1, NULL, NULL),
(55, 'CZ', 'Czech Republic', '420', 1, NULL, NULL),
(56, 'DK', 'Denmark', '45', 1, NULL, NULL),
(57, 'DJ', 'Djibouti', '253', 1, NULL, NULL),
(58, 'DM', 'Dominica', '1-767', 1, NULL, NULL),
(59, 'DO', 'Dominican Republic', '1-809, 1-829, 1-849', 1, NULL, NULL),
(60, 'TP', 'East Timor', NULL, 1, NULL, NULL),
(61, 'EC', 'Ecuador', '593', 1, NULL, NULL),
(62, 'EG', 'Egypt', '20', 1, NULL, NULL),
(63, 'SV', 'El Salvador', '503', 1, NULL, NULL),
(64, 'GQ', 'Equatorial Guinea', '240', 1, NULL, NULL),
(65, 'ER', 'Eritrea', '291', 1, NULL, NULL),
(66, 'EE', 'Estonia', '372', 1, NULL, NULL),
(67, 'ET', 'Ethiopia', '251', 1, NULL, NULL),
(68, 'FK', 'Falkland Islands (Malvinas)', '500', 1, NULL, NULL),
(69, 'FO', 'Faroe Islands', '298', 1, NULL, NULL),
(70, 'FJ', 'Fiji', '679', 1, NULL, NULL),
(71, 'FI', 'Finland', '358', 1, NULL, NULL),
(72, 'FR', 'France', '33', 1, NULL, NULL),
(73, 'FX', 'France, Metropolitan', NULL, 1, NULL, NULL),
(74, 'GF', 'French Guiana', NULL, 1, NULL, NULL),
(75, 'PF', 'French Polynesia', '689', 1, NULL, NULL),
(76, 'TF', 'French Southern Territories', NULL, 1, NULL, NULL),
(77, 'GA', 'Gabon', '241', 1, NULL, NULL),
(78, 'GM', 'Gambia', '220', 1, NULL, NULL),
(79, 'GE', 'Georgia', '995', 1, NULL, NULL),
(80, 'DE', 'Germany', '49', 1, NULL, NULL),
(81, 'GH', 'Ghana', '233', 1, NULL, NULL),
(82, 'GI', 'Gibraltar', '350', 1, NULL, NULL),
(83, 'GK', 'Guernsey', NULL, 1, NULL, NULL),
(84, 'GR', 'Greece', '30', 1, NULL, NULL),
(85, 'GL', 'Greenland', '299', 1, NULL, NULL),
(86, 'GD', 'Grenada', '1-473', 1, NULL, NULL),
(87, 'GP', 'Guadeloupe', NULL, 1, NULL, NULL),
(88, 'GU', 'Guam', '1-671', 1, NULL, NULL),
(89, 'GT', 'Guatemala', '502', 1, NULL, NULL),
(90, 'GN', 'Guinea', '224', 1, NULL, NULL),
(91, 'GW', 'Guinea-Bissau', '245', 1, NULL, NULL),
(92, 'GY', 'Guyana', '592', 1, NULL, NULL),
(93, 'HT', 'Haiti', '509', 1, NULL, NULL),
(94, 'HM', 'Heard and Mc Donald Islands', NULL, 1, NULL, NULL),
(95, 'HN', 'Honduras', '504', 1, NULL, NULL),
(96, 'HK', 'Hong Kong', '852', 1, NULL, NULL),
(97, 'HU', 'Hungary', '36', 1, NULL, NULL),
(98, 'IS', 'Iceland', '354', 1, NULL, NULL),
(99, 'IN', 'India', '91', 1, NULL, NULL),
(100, 'IM', 'Isle of Man', '44-1624', 1, NULL, NULL),
(101, 'ID', 'Indonesia', '62', 1, NULL, NULL),
(102, 'IR', 'Iran (Islamic Republic of)', '98', 1, NULL, NULL),
(103, 'IQ', 'Iraq', '964', 1, NULL, NULL),
(104, 'IE', 'Ireland', '353', 1, NULL, NULL),
(105, 'IL', 'Israel', '972', 1, NULL, NULL),
(106, 'IT', 'Italy', '39', 1, NULL, NULL),
(107, 'CI', 'Ivory Coast', '225', 1, NULL, NULL),
(108, 'JE', 'Jersey', '44-1534', 1, NULL, NULL),
(109, 'JM', 'Jamaica', '1-876', 1, NULL, NULL),
(110, 'JP', 'Japan', '81', 1, NULL, NULL),
(111, 'JO', 'Jordan', '962', 1, NULL, NULL),
(112, 'KZ', 'Kazakhstan', '7', 1, NULL, NULL),
(113, 'KE', 'Kenya', '254', 1, NULL, NULL),
(114, 'KI', 'Kiribati', '686', 1, NULL, NULL),
(115, 'KP', 'Korea, Democratic People\'s Republic of', '850', 1, NULL, NULL),
(116, 'KR', 'Korea, Republic of', '82', 1, NULL, NULL),
(117, 'XK', 'Kosovo', '383', 1, NULL, NULL),
(118, 'KW', 'Kuwait', '965', 1, NULL, NULL),
(119, 'KG', 'Kyrgyzstan', '996', 1, NULL, NULL),
(120, 'LA', 'Lao People\'s Democratic Republic', '856', 1, NULL, NULL),
(121, 'LV', 'Latvia', '371', 1, NULL, NULL),
(122, 'LB', 'Lebanon', '961', 1, NULL, NULL),
(123, 'LS', 'Lesotho', '266', 1, NULL, NULL),
(124, 'LR', 'Liberia', '231', 1, NULL, NULL),
(125, 'LY', 'Libyan Arab Jamahiriya', '218', 1, NULL, NULL),
(126, 'LI', 'Liechtenstein', '423', 1, NULL, NULL),
(127, 'LT', 'Lithuania', '370', 1, NULL, NULL),
(128, 'LU', 'Luxembourg', '352', 1, NULL, NULL),
(129, 'MO', 'Macau', '853', 1, NULL, NULL),
(130, 'MK', 'Macedonia', '389', 1, NULL, NULL),
(131, 'MG', 'Madagascar', '261', 1, NULL, NULL),
(132, 'MW', 'Malawi', '265', 1, NULL, NULL),
(133, 'MY', 'Malaysia', '60', 1, NULL, NULL),
(134, 'MV', 'Maldives', '960', 1, NULL, NULL),
(135, 'ML', 'Mali', '223', 1, NULL, NULL),
(136, 'MT', 'Malta', '356', 1, NULL, NULL),
(137, 'MH', 'Marshall Islands', '692', 1, NULL, NULL),
(138, 'MQ', 'Martinique', NULL, 1, NULL, NULL),
(139, 'MR', 'Mauritania', '222', 1, NULL, NULL),
(140, 'MU', 'Mauritius', '230', 1, NULL, NULL),
(141, 'TY', 'Mayotte', NULL, 1, NULL, NULL),
(142, 'MX', 'Mexico', '52', 1, NULL, NULL),
(143, 'FM', 'Micronesia, Federated States of', '691', 1, NULL, NULL),
(144, 'MD', 'Moldova, Republic of', '373', 1, NULL, NULL),
(145, 'MC', 'Monaco', '377', 1, NULL, NULL),
(146, 'MN', 'Mongolia', '976', 1, NULL, NULL),
(147, 'ME', 'Montenegro', '382', 1, NULL, NULL),
(148, 'MS', 'Montserrat', '1-664', 1, NULL, NULL),
(149, 'MA', 'Morocco', '212', 1, NULL, NULL),
(150, 'MZ', 'Mozambique', '258', 1, NULL, NULL),
(151, 'MM', 'Myanmar', '95', 1, NULL, NULL),
(152, 'NA', 'Namibia', '264', 1, NULL, NULL),
(153, 'NR', 'Nauru', '674', 1, NULL, NULL),
(154, 'NP', 'Nepal', '977', 1, NULL, NULL),
(155, 'NL', 'Netherlands', '31', 1, NULL, NULL),
(156, 'AN', 'Netherlands Antilles', '599', 1, NULL, NULL),
(157, 'NC', 'New Caledonia', '687', 1, NULL, NULL),
(158, 'NZ', 'New Zealand', '64', 1, NULL, NULL),
(159, 'NI', 'Nicaragua', '505', 1, NULL, NULL),
(160, 'NE', 'Niger', '227', 1, NULL, NULL),
(161, 'NG', 'Nigeria', '234', 1, NULL, NULL),
(162, 'NU', 'Niue', '683', 1, NULL, NULL),
(163, 'NF', 'Norfolk Island', NULL, 1, NULL, NULL),
(164, 'MP', 'Northern Mariana Islands', '1-670', 1, NULL, NULL),
(165, 'NO', 'Norway', '47', 1, NULL, NULL),
(166, 'OM', 'Oman', '968', 1, NULL, NULL),
(167, 'PK', 'Pakistan', '92', 1, NULL, NULL),
(168, 'PW', 'Palau', '680', 1, NULL, NULL),
(169, 'PS', 'Palestine', '970', 1, NULL, NULL),
(170, 'PA', 'Panama', '507', 1, NULL, NULL),
(171, 'PG', 'Papua New Guinea', '675', 1, NULL, NULL),
(172, 'PY', 'Paraguay', '595', 1, NULL, NULL),
(173, 'PE', 'Peru', '51', 1, NULL, NULL),
(174, 'PH', 'Philippines', '63', 1, NULL, NULL),
(175, 'PN', 'Pitcairn', '64', 1, NULL, NULL),
(176, 'PL', 'Poland', '48', 1, NULL, NULL),
(177, 'PT', 'Portugal', '351', 1, NULL, NULL),
(178, 'PR', 'Puerto Rico', '1-787, 1-939', 1, NULL, NULL),
(179, 'QA', 'Qatar', '974', 1, NULL, NULL),
(180, 'RE', 'Reunion', '262', 1, NULL, NULL),
(181, 'RO', 'Romania', '40', 1, NULL, NULL),
(182, 'RU', 'Russian Federation', '7', 1, NULL, NULL),
(183, 'RW', 'Rwanda', '250', 1, NULL, NULL),
(184, 'KN', 'Saint Kitts and Nevis', '1-869', 1, NULL, NULL),
(185, 'LC', 'Saint Lucia', '1-758', 1, NULL, NULL),
(186, 'VC', 'Saint Vincent and the Grenadines', '1-784', 1, NULL, NULL),
(187, 'WS', 'Samoa', '685', 1, NULL, NULL),
(188, 'SM', 'San Marino', '378', 1, NULL, NULL),
(189, 'ST', 'Sao Tome and Principe', '239', 1, NULL, NULL),
(190, 'SA', 'Saudi Arabia', '966', 1, NULL, NULL),
(191, 'SN', 'Senegal', '221', 1, NULL, NULL),
(192, 'RS', 'Serbia', '381', 1, NULL, NULL),
(193, 'SC', 'Seychelles', '248', 1, NULL, NULL),
(194, 'SL', 'Sierra Leone', '232', 1, NULL, NULL),
(195, 'SG', 'Singapore', '65', 1, NULL, NULL),
(196, 'SK', 'Slovakia', '421', 1, NULL, NULL),
(197, 'SI', 'Slovenia', '386', 1, NULL, NULL),
(198, 'SB', 'Solomon Islands', '677', 1, NULL, NULL),
(199, 'SO', 'Somalia', '252', 1, NULL, NULL),
(200, 'ZA', 'South Africa', '27', 1, NULL, NULL),
(201, 'GS', 'South Georgia South Sandwich Islands', NULL, 1, NULL, NULL),
(202, 'SS', 'South Sudan', '211', 1, NULL, NULL),
(203, 'ES', 'Spain', '34', 1, NULL, NULL),
(204, 'LK', 'Sri Lanka', '94', 1, NULL, NULL),
(205, 'SH', 'St. Helena', '290', 1, NULL, NULL),
(206, 'PM', 'St. Pierre and Miquelon', '508', 1, NULL, NULL),
(207, 'SD', 'Sudan', '249', 1, NULL, NULL),
(208, 'SR', 'Suriname', '597', 1, NULL, NULL),
(209, 'SJ', 'Svalbard and Jan Mayen Islands', '47', 1, NULL, NULL),
(210, 'SZ', 'Swaziland', '268', 1, NULL, NULL),
(211, 'SE', 'Sweden', '46', 1, NULL, NULL),
(212, 'CH', 'Switzerland', '41', 1, NULL, NULL),
(213, 'SY', 'Syrian Arab Republic', '963', 1, NULL, NULL),
(214, 'TW', 'Taiwan', '886', 1, NULL, NULL),
(215, 'TJ', 'Tajikistan', '992', 1, NULL, NULL),
(216, 'TZ', 'Tanzania, United Republic of', '255', 1, NULL, NULL),
(217, 'TH', 'Thailand', '66', 1, NULL, NULL),
(218, 'TG', 'Togo', '228', 1, NULL, NULL),
(219, 'TK', 'Tokelau', '690', 1, NULL, NULL),
(220, 'TO', 'Tonga', '676', 1, NULL, NULL),
(221, 'TT', 'Trinidad and Tobago', '1-868', 1, NULL, NULL),
(222, 'TN', 'Tunisia', '216', 1, NULL, NULL),
(223, 'TR', 'Turkey', '90', 1, NULL, NULL),
(224, 'TM', 'Turkmenistan', '993', 1, NULL, NULL),
(225, 'TC', 'Turks and Caicos Islands', '1-649', 1, NULL, NULL),
(226, 'TV', 'Tuvalu', '688', 1, NULL, NULL),
(227, 'UG', 'Uganda', '256', 1, NULL, NULL),
(228, 'UA', 'Ukraine', '380', 1, NULL, NULL),
(229, 'AE', 'United Arab Emirates', '971', 1, NULL, NULL),
(230, 'GB', 'United Kingdom', '44', 1, NULL, NULL),
(231, 'US', 'United States', '1', 1, NULL, NULL),
(232, 'UM', 'United States minor outlying islands', NULL, 1, NULL, NULL),
(233, 'UY', 'Uruguay', '598', 1, NULL, NULL),
(234, 'UZ', 'Uzbekistan', '998', 1, NULL, NULL),
(235, 'VU', 'Vanuatu', '678', 1, NULL, NULL),
(236, 'VA', 'Vatican City State', '379', 1, NULL, NULL),
(237, 'VE', 'Venezuela', '58', 1, NULL, NULL),
(238, 'VN', 'Vietnam', '84', 1, NULL, NULL),
(239, 'VG', 'Virgin Islands (British)', '1-284', 1, NULL, NULL),
(240, 'VI', 'Virgin Islands (U.S.)', '1-340', 1, NULL, NULL),
(241, 'WF', 'Wallis and Futuna Islands', '681', 1, NULL, NULL),
(242, 'EH', 'Western Sahara', '212', 1, NULL, NULL),
(243, 'YE', 'Yemen', '967', 1, NULL, NULL),
(244, 'ZR', 'Zaire', NULL, 1, NULL, NULL),
(245, 'ZM', 'Zambia', '260', 1, NULL, NULL),
(246, 'ZW', 'Zimbabwe', '263', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rtl` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 0, '2019-01-20 06:43:20', '2023-07-11 01:25:50');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL DEFAULT 0,
  `setting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_06_13_052559_create_media_table', 2),
(6, '2023_07_06_093310_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(126, 'App\\Models\\User', 2),
(127, 'App\\Models\\User', 2),
(128, 'App\\Models\\User', 2),
(129, 'App\\Models\\User', 2),
(130, 'App\\Models\\User', 2),
(131, 'App\\Models\\User', 2),
(132, 'App\\Models\\User', 2),
(133, 'App\\Models\\User', 2),
(134, 'App\\Models\\User', 2),
(138, 'App\\Models\\User', 2),
(139, 'App\\Models\\User', 2),
(140, 'App\\Models\\User', 2),
(141, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `title`, `guard_name`, `status`, `created_at`, `updated_at`) VALUES
(126, 'roles', 'Show roles', 'web', 1, '2023-07-12 05:09:04', '2023-07-12 05:09:04'),
(127, 'add-roles', 'Add roles', 'web', 1, '2023-07-12 05:09:04', '2023-07-12 05:09:04'),
(128, 'edit-roles', 'Edit roles', 'web', 1, '2023-07-12 05:09:05', '2023-07-12 05:09:05'),
(129, 'delete-roles', 'Delete roles', 'web', 1, '2023-07-12 05:09:05', '2023-07-12 05:09:05'),
(130, 'permissions', 'Show Permissions', 'web', 1, '2023-07-12 05:09:38', '2023-07-12 05:09:38'),
(131, 'add-permissions', 'Add Permissions', 'web', 1, '2023-07-12 05:09:38', '2023-07-12 05:09:38'),
(132, 'edit-permissions', 'Edit Permissions', 'web', 1, '2023-07-12 05:09:38', '2023-07-12 05:09:38'),
(133, 'delete-permissions', 'Delete Permissions', 'web', 1, '2023-07-12 05:09:38', '2023-07-12 05:09:38'),
(134, 'pages', 'Show Pages', 'web', 1, '2023-07-12 05:09:56', '2023-07-12 05:09:56'),
(135, 'add-pages', 'Add Pages', 'web', 1, '2023-07-12 05:09:56', '2023-07-12 05:09:56'),
(136, 'edit-pages', 'Edit Pages', 'web', 1, '2023-07-12 05:09:56', '2023-07-12 05:09:56'),
(137, 'delete-pages', 'Delete Pages', 'web', 1, '2023-07-12 05:09:56', '2023-07-12 05:09:56'),
(138, 'page-sections', 'Show Page Sections', 'web', 1, '2023-07-12 05:10:25', '2023-07-12 05:10:25'),
(139, 'add-page-sections', 'Add Page Sections', 'web', 1, '2023-07-12 05:10:25', '2023-07-12 05:10:25'),
(140, 'edit-page-sections', 'Edit Page Sections', 'web', 1, '2023-07-12 05:10:25', '2023-07-12 05:10:25'),
(141, 'delete-page-sections', 'Delete Page Sections', 'web', 1, '2023-07-12 05:10:25', '2023-07-12 05:10:25'),
(142, 'languages', 'Show Languages', 'web', 1, '2023-07-12 05:10:37', '2023-07-12 05:10:37'),
(143, 'add-languages', 'Add Languages', 'web', 1, '2023-07-12 05:10:37', '2023-07-12 05:10:37'),
(144, 'edit-languages', 'Edit Languages', 'web', 1, '2023-07-12 05:10:37', '2023-07-12 05:10:37'),
(145, 'delete-languages', 'Delete Languages', 'web', 1, '2023-07-12 05:10:37', '2023-07-12 05:10:37'),
(146, 'frontend-setting', 'Show Frontend Setting', 'web', 1, '2023-07-12 05:12:36', '2023-07-12 05:12:36'),
(148, 'edit-frontend-setting', 'Edit Frontend Setting', 'web', 1, '2023-07-12 05:12:37', '2023-07-12 05:12:37'),
(150, 'backend-setting', 'Show Backend Setting', 'web', 1, '2023-07-12 05:13:13', '2023-07-12 05:13:13'),
(152, 'edit-backend-setting', 'Edit Backend Setting', 'web', 1, '2023-07-12 05:13:13', '2023-07-12 05:13:13'),
(154, 'terminals', 'Show terminals', 'web', 1, '2023-07-12 05:24:25', '2023-07-12 05:24:25'),
(155, 'add-terminals', 'Add terminals', 'web', 1, '2023-07-12 05:24:25', '2023-07-12 05:24:25'),
(156, 'edit-terminals', 'Edit terminals', 'web', 1, '2023-07-12 05:24:25', '2023-07-12 05:24:25'),
(157, 'delete-terminals', 'Delete terminals', 'web', 1, '2023-07-12 05:24:25', '2023-07-12 05:24:25'),
(158, 'translates', 'Show translates', 'web', 1, '2023-07-12 05:24:53', '2023-07-12 05:24:53'),
(159, 'add-translates', 'Add translates', 'web', 1, '2023-07-12 05:24:53', '2023-07-12 05:24:53'),
(160, 'edit-translates', 'Edit translates', 'web', 1, '2023-07-12 05:24:53', '2023-07-12 05:24:53'),
(161, 'delete-translates', 'Delete translates', 'web', 1, '2023-07-12 05:24:53', '2023-07-12 05:24:53'),
(162, 'user', 'Show user', 'web', 1, '2023-07-12 05:25:14', '2023-07-12 05:25:14'),
(163, 'add-user', 'Add user', 'web', 1, '2023-07-12 05:25:14', '2023-07-12 05:25:14'),
(164, 'edit-user', 'Edit user', 'web', 1, '2023-07-12 05:25:14', '2023-07-12 05:25:14'),
(165, 'delete-user', 'Delete user', 'web', 1, '2023-07-12 05:25:14', '2023-07-12 05:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  `level` int(11) DEFAULT 1,
  `cat_type` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(366) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_meta` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `meta_fields` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `visitor` bigint(20) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_metas`
--

CREATE TABLE `posts_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `pageable_id` bigint(20) NOT NULL,
  `pageable_type` varchar(355) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_sections`
--

CREATE TABLE `posts_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `meta_fields` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `pageable_id` bigint(20) NOT NULL DEFAULT 0,
  `pageable_type` varchar(366) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_translations`
--

CREATE TABLE `post_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `visitor` bigint(20) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `pageable_id` bigint(20) NOT NULL DEFAULT 0,
  `pageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super-Admin', 'web', '2023-07-06 00:00:00', '2023-07-06 10:12:43'),
(2, 'Admin', 'web', '2023-07-06 00:00:00', '2023-07-06 10:12:58'),
(3, 'SEO', 'web', '2023-07-06 10:13:09', '2023-07-06 10:13:09'),
(4, 'Manager', 'web', '2023-07-06 10:13:24', '2023-07-06 10:13:24'),
(7, 'Editor', 'web', '2023-07-07 10:45:07', '2023-07-07 10:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(141, 2);

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(1, 'en', 'Log in', 'Log in', '2023-08-11 05:16:56', '2023-08-11 05:16:56'),
(2, 'en', 'email', 'email', '2023-08-11 05:16:56', '2023-08-11 05:16:56'),
(3, 'en', 'Password', 'Password', '2023-08-11 05:16:57', '2023-08-11 05:16:57'),
(4, 'en', 'Remember Me', 'Remember Me', '2023-08-11 05:16:57', '2023-08-11 05:16:57'),
(5, 'en', 'SIGN IN', 'SIGN IN', '2023-08-11 05:16:57', '2023-08-11 05:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `page_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(355) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `model_type`, `model_id`, `page_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, '0', 'e72f6184-72e7-43d5-92db-8b892b783743', 'user', 'Close-up-of-mushroom-growing-on-field', 'Close-up-of-mushroom-growing-on-field.webp', 'image/webp', 'uploads', 'uploads', 87178, '[]', '{\"purpose\":\"global\"}', '{\"full\":true,\"thumb\":true,\"cover\":true,\"avatar\":true,\"placeholder\":true}', '[]', 1, '2023-12-15 05:10:00', '2023-12-15 05:10:15'),
(2, 'App\\Models\\User', 1, '0', '1c69c47c-7bcf-4f66-921e-6dda6fd01b67', 'user', 'mushroom-super-bloom-meta', 'mushroom-super-bloom-meta.png', 'image/png', 'uploads', 'uploads', 552026, '[]', '{\"purpose\":\"global\"}', '{\"full\":true,\"thumb\":true,\"cover\":true,\"avatar\":true,\"placeholder\":true}', '[]', 2, '2023-12-15 05:10:28', '2023-12-15 05:10:34'),
(3, 'App\\Models\\User', 1, '0', 'b507020a-af6b-451f-a667-9dd3c90bb79e', 'user', 'gettyimages-1392913510-6410b76f57a4f', 'gettyimages-1392913510-6410b76f57a4f.jpg', 'image/jpeg', 'uploads', 'uploads', 207626, '[]', '{\"purpose\":\"global\"}', '{\"full\":true,\"thumb\":true,\"cover\":true,\"avatar\":true,\"placeholder\":true}', '[]', 3, '2023-12-15 05:10:35', '2023-12-15 05:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_original` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `reward_balance` bigint(20) NOT NULL DEFAULT 0,
  `balance` double(8,2) NOT NULL DEFAULT 0.00,
  `referral_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `banned` tinyint(4) NOT NULL DEFAULT 0,
  `age` int(11) NOT NULL DEFAULT 15,
  `gender` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lang` int(11) DEFAULT 0,
  `target_count` int(11) DEFAULT 0,
  `social_links` varchar(599) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `phone`, `email_verified_at`, `password`, `avatar`, `avatar_original`, `reward_balance`, `balance`, `referral_code`, `banned`, `age`, `gender`, `lang`, `target_count`, `social_links`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'superadmin', 'superadmin@gmail.com', '+9172067376273', NULL, '$2y$10$8NeLUJ1TqCCKkRvkIiS7KunLQXqPpGG4DwfUkAVxw17DPZQPx1hWa', NULL, NULL, 0, 0.00, 'HM1kllw8v3', 0, 15, '0', 0, 0, NULL, 'c4XBXFDi2jdjhgBNheytIB0bL7DCQAZPZW2sWnygxegD5K7M7fffDRsWcCdz', '2023-06-12 08:36:30', '2023-08-11 04:19:42'),
(2, 'admin', 'admin', 'admin@gmail.com', '72000000033', NULL, '$2y$10$xssLZLoJNE7S1vGmSbphuuytFsPFQdGUeJCXdTWnWKO2nbSPKBUDK', NULL, '2', 0, 0.00, NULL, 0, 15, '0', 0, 0, NULL, NULL, '2023-07-11 18:30:00', '2023-12-15 05:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_referral_tokens`
--

CREATE TABLE `user_referral_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referrals_code` varchar(299) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrals_token` varchar(299) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_verifieds`
--

CREATE TABLE `user_verifieds` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(299) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_metas`
--
ALTER TABLE `posts_metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_sections`
--
ALTER TABLE `posts_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_translations`
--
ALTER TABLE `post_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- Indexes for table `user_referral_tokens`
--
ALTER TABLE `user_referral_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_verifieds`
--
ALTER TABLE `user_verifieds`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_metas`
--
ALTER TABLE `posts_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_sections`
--
ALTER TABLE `posts_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_translations`
--
ALTER TABLE `post_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_referral_tokens`
--
ALTER TABLE `user_referral_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_verifieds`
--
ALTER TABLE `user_verifieds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
