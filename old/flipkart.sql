-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2024 at 04:32 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `winterpr_flipkart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `last_login` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `image`, `password`, `ip`, `last_login`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', 'Admin-24-11-2023-1700810251-Account-User-PNG.png', '5ebb287a76a868f323368e37b222e5fe', 'cGF5b25peHRlY2hub2xvMzg4ODI1LnJ6cEBpY2ljaQ==', '06-09-2024 06:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` text NOT NULL,
  `btn` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `subtitle`, `btn`, `url`, `image`, `status`, `position`) VALUES
(26, 'Sale Live', '', '', '', 'banner-25-11-2023-1700861291-c6671d8aa674ef7b.webp', 0, ''),
(27, 'Sale Live', '', '', '', 'banner-23-03-2024-1711194874-holi-2024.jpeg', 0, ''),
(28, 'Sale is Live', '', '', '', 'banner-06-09-2024-1725627191-1001903296.webp', 1, ''),
(29, 'Premium Phone', '', '', '', 'banner-06-09-2024-1725627214-1001903297.webp', 1, ''),
(30, 'Special Discount', '', '', '', 'banner-06-09-2024-1725627230-1001903298.webp', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `mrp` double(15,2) NOT NULL,
  `price` double(15,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `slug`, `mrp`, `price`, `image`, `status`) VALUES
(68, 'APPLE iPhone 15 Pro Max (Blue Titanium, 256 GB)', 'apple-iphone-15-pro-max-blue-titanium-256-gb', 159990.00, 598.00, 'product-24-11-2023-1700810878--original-imagtc3k6zztrhnb.webp', 1),
(69, 'APPLE iPhone 14 Pro Max (Space Black, 1 TB)', 'apple-iphone-14-pro-max-space-black-1-tb', 177999.00, 499.00, 'product-25-11-2023-1700899035--original-imaghxenhnpyhn5u.webp', 1),
(70, 'SAMSUNG Galaxy S22 Ultra 5G (Phantom Black, 256 GB)  (12 GB RAM)', 'samsung-galaxy-s22-ultra-5g-phantom-black-256-gb--12-gb-ram', 81250.00, 497.00, 'product-25-11-2023-1700899325--original-imaggj68cgtdacxn (1).webp', 1),
(71, 'Google Pixel 8 Pro (Obsidian, 256 GB)  (12 GB RAM)', 'google-pixel-8-pro-obsidian-256-gb--12-gb-ram', 113999.00, 397.00, 'product-25-11-2023-1700899651--original-imagtwh5rbhf7ngh.webp', 1),
(72, 'APPLE AirPods Pro (2nd generation) with MagSafe Case (USB-C) Bluetooth Headset  (White, True Wireless)', 'apple-airpods-pro-2nd-generation-with-magsafe-case-usb-c-bluetooth-headset--white-true-wireless', 24400.00, 398.00, 'product-25-11-2023-1700899817--original-imagtc44nk4b3hfg (1).webp', 1),
(73, 'APPLE New AirPods Max Bluetooth Headset  (Green, On the Ear)', 'apple-new-airpods-max-bluetooth-headset--green-on-the-ear', 59990.00, 458.00, 'product-25-11-2023-1700899939-mgyn3hn-a-apple-original-imafy8wcgvdhsyjj (1).webp', 1),
(74, 'APPLE 2022 MacBook AIR M2 - (8 GB/256 GB SSD/Mac OS Monterey) MLXW3HN/A  (13.6 Inch, Space Grey, 1.24 Kg)', 'apple-2022-macbook-air-m2---8-gb/256-gb-ssd/mac-os-monterey-mlxw3hn/a--136-inch-space-grey-124-kg', 104990.00, 499.00, 'product-25-11-2023-1700900073--original-imagfdf4xnbyyxpa.webp', 1),
(75, 'ASUS ROG Strix G16 (2023) with 90WHr Battery Intel HX-Series Core i9 13th Gen 13980HX - (16 GB/1 TB SSD/Windows 11 Home)', 'asus-rog-strix-g16-2023-with-90whr-battery-intel-hx-series-core-i9-13th-gen-13980hx---16-gb/1-tb-ssd/windows-11-home', 209990.00, 499.00, 'product-25-11-2023-1700900385--original-imagqfxrqgffngth.webp', 1),
(76, 'APPLE Watch Ultra GPS + Cellular - ECG App, Temp sensor, Blood oxygen, Fall Detection  (Orange Alpine Strap, Small)', 'apple-watch-ultra-gps---cellular---ecg-app-temp-sensor-blood-oxygen-fall-detection--orange-alpine-strap-small', 82999.00, 399.00, 'product-25-11-2023-1700900564--original-imaghxg9pcvwvpcf.webp', 1),
(77, 'APPLE Watch Series 9 GPS 41mm Silver Aluminium Case with Storm Blue Sport Band - S/M  (Silver Strap, Free Size)', 'apple-watch-series-9-gps-41mm-silver-aluminium-case-with-storm-blue-sport-band---s/m--silver-strap-free-size', 41990.00, 429.00, 'product-25-11-2023-1700900797--original-imagte6ytn8u7r9j.webp', 1),
(78, 'Canon EOS M50 Mark II Mirrorless Camera EF-M15-45mm is STM Lens  (Black)', 'canon-eos-m50-mark-ii-mirrorless-camera-ef-m15-45mm-is-stm-lens--black', 52990.00, 492.00, 'product-25-11-2023-1700901208-digital-camera-eos-m50-mark-ii-eos-m50-mark-ii-canon-original-imag2gzkexzqhyhu (2) (2).webp', 1),
(79, 'SONY Alpha Full Frame ILCE-7M2K/BQ IN5 Mirrorless Camera Body with 28 - 70 mm Lens  (Black)', 'sony-alpha-full-frame-ilce-7m2k/bq-in5-mirrorless-camera-body-with-28---70-mm-lens--black', 82990.00, 429.00, 'product-25-11-2023-1700901149--original-imagg7hsggshhwbz.webp', 1),
(80, 'boAt Airdopes 131 with upto 60 Hours and ASAP Charge Bluetooth Headset  (Active Black Matte, True Wireless)', 'boat-airdopes-131-with-upto-60-hours-and-asap-charge-bluetooth-headset--active-black-matte-true-wireless', 1299.00, 398.00, 'product-25-11-2023-1700935572--original-imaguv4mm3cwjb5e.webp', 1),
(81, 'boAt Rockerz 551 ANC with Hybrid ANC, 100 HRS Playback, 40mm Drivers & ASAP Charge Bluetooth Headset  (Sage Green, On the Ear)', 'boat-rockerz-551-anc-with-hybrid-anc-100-hrs-playback-40mm-drivers-', 3499.00, 299.00, 'product-25-11-2023-1700935689--original-imagznsrxuseynhy.webp', 1),
(82, 'SAMSUNG 236 L Frost Free Double Door 3 Star Refrigerator with Digital Inverter  (Elegant Inox, RT28C3053S8/HL)', 'samsung-236-l-frost-free-double-door-3-star-refrigerator-with-digital-inverter--elegant-inox-rt28c3053s8/hl', 25990.00, 499.00, 'product-25-11-2023-1700935999--original-imagpqjfcsxhhsqd.webp', 1),
(83, 'LG 7 kg 5 Star with Smart Inverter Technology, TurboDrum and Smart Diagnosis Fully Automatic Top Load Washing Machine Silver  (T70SKSF1Z)', 'lg-7-kg-5-star-with-smart-inverter-technology-turbodrum-and-smart-diagnosis-fully-automatic-top-load-washing-machine-silver--t70sksf1z', 16990.00, 459.00, 'product-25-11-2023-1700936146--original-imagvg7vgkey5xkg.webp', 1),
(84, 'Mi 3i 20000 mAh Power Bank (Fast Charging, 18W)  (Black, Lithium Polymer)', 'mi-3i-20000-mah-power-bank-fast-charging-18w--black-lithium-polymer', 2149.00, 339.00, 'product-25-11-2023-1700936283-power-bank-20000-plm18zm-mi-original-imafvtc7x9zgrzbz.webp', 1),
(85, 'Ambrane 20000 mAh Power Bank (20 W, Power Delivery 3.0, Quick Charge 3.0)  (Blue, Lithium Polymer)', 'ambrane-20000-mah-power-bank-20-w-power-delivery-30-quick-charge-30--blue-lithium-polymer', 1999.00, 249.00, 'product-25-11-2023-1700936458--original-imagpphxh7egjebw.webp', 1),
(86, 'SAMSUNG Crystal 4K iSmart Series 108 cm (43 inch) Ultra HD (4K) LED Smart Tizen TV 2023 Edition  (UA43CUE60AKLXL)', 'samsung-crystal-4k-ismart-series-108-cm-43-inch-ultra-hd-4k-led-smart-tizen-tv-2023-edition--ua43cue60aklxl', 30990.00, 499.00, 'product-25-11-2023-1700936609--original-imagttjpgtshmnms.webp', 1),
(87, 'realme 100.3 cm (40 inch) Full HD LED Smart Android TV 2022 Edition with Android 11 - 2022 Model  (RMV2107)', 'realme-1003-cm-40-inch-full-hd-led-smart-android-tv-2022-edition-with-android-11---2022-model--rmv2107', 18499.00, 498.00, 'product-25-11-2023-1700936712--original-imageuxkcg2fbdkg.webp', 1),
(88, 'Butterfly Butterfly Aluminium Pressure Cooker 2 L, 3 L, 5 L Pressure Cooker  (Aluminium)', 'butterfly-butterfly-aluminium-pressure-cooker-2-l-3-l-5-l-pressure-cooker--aluminium', 1898.00, 399.00, 'product-26-11-2023-1700937225-8906022173611-butterfly-original-imaftw7bx4gczgjg.webp', 1),
(89, 'SAMSUNG 28 L Convection & Grill Microwave Oven  (CE1041DSB3, Black)', 'samsung-28-l-convection-', 12390.00, 497.00, 'product-26-11-2023-1700937340--original-imagt6znzcghgfkb.webp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(200) NOT NULL,
  `storage` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `size`, `storage`) VALUES
(112, 68, '', '256GB'),
(113, 69, '', '1TB'),
(114, 70, '', '256GB'),
(115, 71, '', '256GB'),
(116, 72, '', ''),
(117, 73, '', ''),
(118, 74, '', '256GB'),
(119, 75, '', '1TB'),
(120, 76, '', ''),
(121, 77, '', ''),
(122, 78, '', ''),
(123, 79, '', ''),
(124, 80, '', ''),
(125, 81, '', ''),
(126, 82, '', ''),
(127, 83, '', ''),
(128, 84, '', ''),
(129, 85, '', ''),
(130, 86, '', ''),
(131, 87, '', ''),
(132, 88, '', ''),
(133, 89, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(250) NOT NULL,
  `color` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`id`, `product_id`, `product_images`, `color`) VALUES
(23, 31, 'Color-30-09-2023-169601241761BGE6iu4AL._SL1500.webp', 'Blue'),
(24, 31, 'Color-30-09-2023-169601241761YSNhAb00L._SL1500.webp', 'Purple'),
(25, 31, 'Color-30-09-2023-169601241771emcsxsRPL._SL1500.webp', 'Starlight'),
(27, 32, 'Color-30-09-2023-169602184291z5KuonXrL._SL1500.jpg', 'Red'),
(28, 32, 'Color-30-09-2023-1696021842916acEhBkcL._SL1500.jpg', 'Gray'),
(30, 36, 'Color-30-09-2023-169606761641g1pQr8xUL.jpg', 'Black'),
(37, 42, 'Color-30-09-2023-1696074431na-gaming-laptop-lenovo-original-imag5bg5egrw92gp.jpeg', 'Black'),
(42, 38, 'Color-30-09-2023-1696077292Screenshot_2023-09-30-18-04-26-465_com.android.chrome-edit.jpg', 'Green'),
(43, 43, 'Color-30-09-2023-1696077719Screenshot_2023-09-30-18-06-39-482_com.flipkart.android-edit.jpg', 'Magic blue '),
(49, 47, 'Color-30-09-2023-1696097667Screenshot_2023-09-30-23-37-52-966_com.flipkart.android-edit.jpg', 'Active black'),
(50, 48, 'Color-30-09-2023-1696098135Screenshot_2023-09-30-23-47-42-883_com.flipkart.android-edit.jpg', 'Raging Red'),
(51, 49, 'Color-30-09-2023-1696098501Screenshot_2023-09-30-23-53-19-551_com.flipkart.android-edit.jpg', 'Moon silver '),
(52, 50, 'Color-01-10-2023-1696098777Screenshot_2023-09-30-23-59-15-657_com.flipkart.android-edit.jpg', 'Silver'),
(53, 51, 'Color-01-10-2023-1696098995Screenshot_2023-10-01-00-04-05-158_com.flipkart.android-edit.jpg', 'Green'),
(54, 52, 'Color-01-10-2023-1696099430Screenshot_2023-10-01-00-07-52-889_com.flipkart.android-edit.jpg', 'Black'),
(55, 56, 'Color-06-10-2023-1696615481Screenshot_2023-10-06-23-28-48-720_com.flipkart.android-edit.jpg', 'Blue '),
(56, 56, 'Color-06-10-2023-1696615481Screenshot_2023-10-06-23-30-09-754_com.flipkart.android-edit.jpg', 'Gold '),
(57, 56, 'Color-06-10-2023-1696615481Screenshot_2023-10-06-23-29-38-395_com.flipkart.android-edit.jpg', 'White '),
(58, 56, 'Color-06-10-2023-1696615481Screenshot_2023-10-06-23-29-54-402_com.flipkart.android-edit.jpg', 'Black'),
(70, 29, 'Color-23-10-2023-1698008839download (2).jpeg', 'White '),
(72, 29, 'Color-23-10-2023-169800883971ZDY57yTQL._AC_UF1000,1000_QL80_FMwebp_.webp', 'Gold'),
(75, 29, 'Color-23-10-2023-1698009317-original-imaghxejqvpwfqh2.jpeg', 'Purple '),
(76, 29, 'Color-23-10-2023-1698009439-original-imaghxenhnpyhn5u.jpeg', 'Black ');

-- --------------------------------------------------------

--
-- Table structure for table `product_dsc`
--

CREATE TABLE `product_dsc` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_dsc`
--

INSERT INTO `product_dsc` (`id`, `product_id`, `product_images`) VALUES
(6, 29, 'Dsc-23-11-2023-17007336611b.jpeg'),
(7, 29, 'Dsc-23-11-2023-17007336612.jpeg'),
(9, 67, 'Dsc-24-11-2023-1700810468-original-imagtc3kfyhgfcvr.webp'),
(11, 68, 'Dsc-24-11-2023-1700811506des.webp'),
(12, 69, 'Dsc-25-11-2023-1700921937apple 14.webp'),
(13, 70, 'Dsc-25-11-2023-1700921954samsung mobile.webp'),
(14, 71, 'Dsc-25-11-2023-1700921970google phone.webp'),
(15, 72, 'Dsc-25-11-2023-1700921986apple ear.webp'),
(16, 73, 'Dsc-25-11-2023-1700921999apple ear green.webp'),
(17, 74, 'Dsc-25-11-2023-1700922020apple laptop.webp'),
(18, 75, 'Dsc-25-11-2023-1700922035asus laptop.webp'),
(19, 76, 'Dsc-25-11-2023-1700922054apple ultra watch.webp'),
(20, 77, 'Dsc-25-11-2023-1700922067apple se watch.webp'),
(22, 89, 'Dsc-26-11-2023-1700951437oven.webp'),
(23, 88, 'Dsc-26-11-2023-1700951452cooker.webp'),
(24, 87, 'Dsc-26-11-2023-1700951471real me tv.webp'),
(25, 86, 'Dsc-26-11-2023-1700951485samsung tv.webp'),
(26, 85, 'Dsc-26-11-2023-1700951503amb power.webp'),
(27, 84, 'Dsc-26-11-2023-1700951517mi power.webp'),
(28, 83, 'Dsc-26-11-2023-1700951534lg wash.webp'),
(29, 82, 'Dsc-26-11-2023-1700951547samsung refri.webp'),
(30, 81, 'Dsc-26-11-2023-1700951575boat rockerz.webp'),
(31, 80, 'Dsc-26-11-2023-1700951598boat ear.webp'),
(32, 79, 'Dsc-26-11-2023-1700951617sony.webp'),
(33, 78, 'Dsc-26-11-2023-1700951634canon.webp');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `product_images`) VALUES
(188, 68, 'Gallery-24-11-2023-1700810878-original-imagtc3kfrghczmq.webp'),
(189, 68, 'Gallery-24-11-2023-1700810878-original-imagtc3kjgghehst.webp'),
(191, 69, 'Gallery-25-11-2023-1700899035-original-imaghxemdgq5j8ww.webp'),
(192, 69, 'Gallery-25-11-2023-1700899035-original-imaghxencyz3y2ah.webp'),
(193, 69, 'Gallery-25-11-2023-1700899035-original-imaghycfznsrx3ad.webp'),
(194, 70, 'Gallery-25-11-2023-1700899325-original-imaggj68zgy9wa26 (1).webp'),
(195, 70, 'Gallery-25-11-2023-1700899325-original-imaggj68ckgndnrk.webp'),
(196, 70, 'Gallery-25-11-2023-1700899325-original-imaggj68ed7skur8 (1).webp'),
(197, 71, 'Gallery-25-11-2023-1700899651-original-imagtwh5euxntumw.webp'),
(198, 71, 'Gallery-25-11-2023-1700899651-original-imagtwh5wz4pfk6n.webp'),
(199, 71, 'Gallery-25-11-2023-1700899651-original-imagudnycrhndyfm.webp'),
(200, 72, 'Gallery-25-11-2023-1700899817-original-imagtc44zcupzhqh (1).webp'),
(201, 72, 'Gallery-25-11-2023-1700899817-original-imagtcfghamt7x4z (1).webp'),
(202, 72, 'Gallery-25-11-2023-1700899817-original-imagtdqgnhzehtgm (1).webp'),
(203, 73, 'Gallery-25-11-2023-1700899939mgyn3hn-a-apple-original-imafy8wcgjtruq8m (1).webp'),
(204, 73, 'Gallery-25-11-2023-1700899939mgyn3hn-a-apple-original-imafy8wcw5ddbnsg (1).webp'),
(205, 73, 'Gallery-25-11-2023-1700899939mgyn3hn-a-apple-original-imafyhgzchjwpzyh (1).webp'),
(206, 74, 'Gallery-25-11-2023-1700900073-original-imagfdf4gyhvzmkf.webp'),
(207, 74, 'Gallery-25-11-2023-1700900073-original-imagfdf43zfaab4z.webp'),
(208, 74, 'Gallery-25-11-2023-1700900073-original-imagfdf4aaczgywf.webp'),
(209, 75, 'Gallery-25-11-2023-1700900385-original-imagqfxrvjzvrq2v.webp'),
(210, 75, 'Gallery-25-11-2023-1700900385-original-imagqfxrgd7mxjbf.webp'),
(211, 75, 'Gallery-25-11-2023-1700900385-original-imagqfxre4ap4rse.webp'),
(212, 76, 'Gallery-25-11-2023-1700900564-original-imaghxg9hnk2bztm.webp'),
(213, 76, 'Gallery-25-11-2023-1700900564-original-imaghxg8rhscysu8.webp'),
(214, 76, 'Gallery-25-11-2023-1700900564-original-imaghxg8zhdx4fha.webp'),
(215, 77, 'Gallery-25-11-2023-1700900797-original-imagte6yj5eufcrp.webp'),
(216, 77, 'Gallery-25-11-2023-1700900797-original-imagte6yzpd3pfab.webp'),
(217, 77, 'Gallery-25-11-2023-1700900797-original-imagte6yfu7kzcrz.webp'),
(221, 79, 'Gallery-25-11-2023-1700901149-original-imagg7hswkgzmjue.webp'),
(222, 79, 'Gallery-25-11-2023-1700901149-original-imagg7hsfneggryj.webp'),
(223, 79, 'Gallery-25-11-2023-1700901149-original-imagg7hsaewynxfu.webp'),
(224, 78, 'Gallery-25-11-2023-1700901208digital-camera-eos-m50-mark-ii-eos-m50-mark-ii-canon-original-imag2gzk7bhg55mh (2) (2).webp'),
(225, 78, 'Gallery-25-11-2023-1700901208digital-camera-eos-m50-mark-ii-eos-m50-mark-ii-canon-original-imag2gzkp5ympphv (2) (2).webp'),
(226, 78, 'Gallery-25-11-2023-1700901208digital-camera-eos-m50-mark-ii-eos-m50-mark-ii-canon-original-imag2gzkyjuer5gs (2) (2).webp'),
(227, 80, 'Gallery-25-11-2023-1700935572-original-imagugt82xnszsek.webp'),
(228, 80, 'Gallery-25-11-2023-1700935572-original-imagjwgzyu5r8tu6.webp'),
(229, 80, 'Gallery-25-11-2023-1700935572-original-imagjwgzgucg95g2.webp'),
(230, 81, 'Gallery-25-11-2023-1700935689-original-imagznsru4rjahfp.webp'),
(231, 81, 'Gallery-25-11-2023-1700935689-original-imagznsrtbgxkpjz.webp'),
(232, 81, 'Gallery-25-11-2023-1700935689-original-imagznsr4dbjpdu2.webp'),
(233, 82, 'Gallery-25-11-2023-1700935999-original-imagpqjffwrnjxhp.webp'),
(234, 82, 'Gallery-25-11-2023-1700935999-original-imagpqjfupz9nmy7.webp'),
(235, 82, 'Gallery-25-11-2023-1700935999-original-imagpqjfn3qyghgz.webp'),
(236, 83, 'Gallery-25-11-2023-1700936146-original-imagn8vpess282ny.webp'),
(237, 83, 'Gallery-25-11-2023-1700936146-original-imagn8vpgxwargph.webp'),
(238, 83, 'Gallery-25-11-2023-1700936146-original-imagzug8rdh8uzm2.webp'),
(239, 84, 'Gallery-25-11-2023-1700936283power-bank-20000-plm18zm-mi-original-imafvtc7uvrkykv9.webp'),
(240, 84, 'Gallery-25-11-2023-1700936283power-bank-20000-plm18zm-mi-original-imafvtc7zzxgrfhe.webp'),
(241, 84, 'Gallery-25-11-2023-1700936283power-bank-20000-plm18zm-mi-original-imafvtc7kz9baxxt.webp'),
(242, 85, 'Gallery-25-11-2023-1700936458-original-imagpphxtjkd3gew.webp'),
(243, 85, 'Gallery-25-11-2023-1700936458-original-imagpphxmbtzcgzh.webp'),
(244, 85, 'Gallery-25-11-2023-1700936458-original-imagpphxjuwz5u59.webp'),
(245, 86, 'Gallery-25-11-2023-1700936609-original-imagr6z9ybweghmp.webp'),
(246, 86, 'Gallery-25-11-2023-1700936609ua55cue60aklxl-samsung-original-imagp7uybfycygwr.webp'),
(247, 86, 'Gallery-25-11-2023-1700936609ua55cue60aklxl-samsung-original-imagp7uykyf87ewm.webp'),
(248, 87, 'Gallery-25-11-2023-1700936712-original-imagdw6a6angxgrj.webp'),
(249, 87, 'Gallery-25-11-2023-1700936712rmv2107-realme-original-imagdzgkj9pzc9cy.webp'),
(250, 87, 'Gallery-25-11-2023-1700936712rmv2107-realme-original-imagdzgkj8cpugbp.webp'),
(251, 88, 'Gallery-26-11-2023-1700937225-original-imagrzvrdbqhphgh.webp'),
(252, 88, 'Gallery-26-11-2023-17009372258906022173604-butterfly-original-imafggwrmnzn5vgh.webp'),
(253, 88, 'Gallery-26-11-2023-17009372258906022174823-butterfly-original-imafggwrf4danvwj.webp'),
(254, 89, 'Gallery-26-11-2023-1700937340-original-imagc3kaexbtyzur.webp'),
(255, 89, 'Gallery-26-11-2023-1700937340-original-imagc3kag5zgfavy.webp'),
(256, 89, 'Gallery-26-11-2023-1700937340-original-imagc3kasavhzscy.webp');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `upi` varchar(200) NOT NULL,
  `code` longtext NOT NULL,
  `pay1` int(11) NOT NULL,
  `pay2` int(11) NOT NULL,
  `pay3` int(11) NOT NULL,
  `pay4` int(11) NOT NULL,
  `pay5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `upi`, `code`, `pay1`, `pay2`, `pay3`, `pay4`, `pay5`) VALUES
(1, 'payonixtechnolo388825.rzp@icici', '<script>\r\n\r\n</script>', 1, 1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_dsc`
--
ALTER TABLE `product_dsc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product_dsc`
--
ALTER TABLE `product_dsc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
