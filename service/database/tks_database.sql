-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 11:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tks_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'ตำแหน่ง',
  `sector` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT current_timestamp(),
  `IsActive` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `create_event`
--

CREATE TABLE `create_event` (
  `id` int(11) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `weigth` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `create_event`
--

INSERT INTO `create_event` (`id`, `class`, `weigth`) VALUES
(23, 'A', NULL),
(24, 'B', NULL),
(25, 'C', NULL),
(26, 'D', NULL),
(27, 'E', NULL),
(28, 'F', NULL),
(29, NULL, 'รุ่นไม่เกิน 45 กก'),
(30, NULL, 'รุ่นไม่เกิน 48 กก'),
(31, NULL, 'รุ่นไม่เกิน 51 กก'),
(32, NULL, 'รุ่นไม่เกิน 55 กก'),
(33, NULL, 'รุ่นไม่เกิน 59 กก'),
(34, NULL, 'รุ่นไม่เกิน 63 กก');

-- --------------------------------------------------------

--
-- Table structure for table `data_all`
--

CREATE TABLE `data_all` (
  `id` int(11) NOT NULL,
  `users` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `IsActive` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_all`
--

INSERT INTO `data_all` (`id`, `users`, `name`, `image`, `IsActive`) VALUES
(7, 'SUPERADMIN AD CARD', 'asdas', '../uploads/1708505774_826228.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `data_score`
--

CREATE TABLE `data_score` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `judge1` decimal(10,2) DEFAULT NULL,
  `judge2` decimal(10,2) DEFAULT NULL,
  `judge3` decimal(10,2) DEFAULT NULL,
  `judge4` decimal(10,2) DEFAULT NULL,
  `judge5` decimal(10,2) DEFAULT NULL,
  `judge6` decimal(10,2) DEFAULT NULL,
  `judge7` decimal(10,2) DEFAULT NULL,
  `max_sum` decimal(10,2) NOT NULL,
  `finalsum` decimal(10,2) NOT NULL,
  `Role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `class` varchar(255) NOT NULL,
  `age` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `team` varchar(255) NOT NULL,
  `license` varchar(255) DEFAULT NULL,
  `weigth` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `Match` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'ตำแหน่ง',
  `sector` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT current_timestamp(),
  `IsActive` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `ID_Number` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `team` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `IsActive` enum('0','1','') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `ID_Number`, `firstname`, `lastname`, `team`, `status`, `age`, `license`, `image`, `IsActive`) VALUES
(88, 'TKS000001', 'asdasdasd', 'asdas', 'TY', 'หญิง', '16', 'sadgd', '../tksuploads/1709022788_images.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `stop_date` varchar(255) NOT NULL,
  `IsActive` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `start_date`, `stop_date`, `IsActive`) VALUES
(1, 'btn-add_data', '', '', '0'),
(2, 'Start_date', '', '', '1'),
(3, 'btn-twd_event', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'ตำแหน่ง',
  `province` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT current_timestamp(),
  `IsActive` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`id`, `firstname`, `lastname`, `status`, `province`, `image`, `create_time`, `IsActive`) VALUES
(125, 'awdawd', 'awdawd', 'awdawd', 'กอล์ฟ', '../uploadsport/1708271075_123456.jpg', '2024-02-18 22:44:35', 0),
(126, 'adw', 'awd', 'wadawdwd', 'กอล์ฟ', '../uploadsport/1708285177_111.jpg', '2024-02-19 02:39:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `firstname` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `gender` varchar(255) NOT NULL COMMENT 'เพศ',
  `team` varchar(255) NOT NULL COMMENT 'ชื่อทีม',
  `email` varchar(255) NOT NULL,
  `tell` varchar(255) NOT NULL COMMENT 'เบอร์โทร',
  `Role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `gender`, `team`, `email`, `tell`, `Role`, `password`) VALUES
(23, '', '', '', '', 'plamemee2015@gmail.com', '0943268338', 'SUPERADMIN TWD', '$2y$10$QM3bKU8PWgN81Npm5NRrTOiEnPvFr7npGyKuSEq8ruMWfflH9WsWm'),
(24, 'Palm', 'Nee', 'Male', 'TY', 'enzoritono@gmail.com', '0943268338', 'TY', '$2y$10$i..2IS8bD9bc99MSnCn.qubQ66y3TTet1BcCZwm6SCVX3IpokqQNK'),
(25, 'A', 'C', 'Male', 'TKS', 's62122519032@ssru.ac.th', '0943268331', 'TKS', '$2y$10$RuuUr6LwxYxPfcrSizdy.uRBpI7iD1eS.3yiz/ooggb5K77SxJ3ye');

-- --------------------------------------------------------

--
-- Table structure for table `users_t`
--

CREATE TABLE `users_t` (
  `id` int(11) NOT NULL,
  `users` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `Role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_t`
--

INSERT INTO `users_t` (`id`, `users`, `password`, `area`, `province`, `Role`) VALUES
(1, 'KKTSPDM', '$2y$10$ljfZZrrTfl/KyK7XrHWki.RVexu/7VQUXjOIDddVjZpyf2GGdkznq', 'ทุกภาค', 'SUPERADMIN AD CARD', 'superadmin'),
(2, 'KKTP1', '$2y$10$C8nS.2kTU2zezZowPtZR0uZ.vxr10QKwm6He5C6Qz6bgPLQhpc/qW', 'ภาค 1', 'การกีฬาแห่งประเทศไทย ภาค 1', 'KKTP1'),
(3, 'KKTP2', '$2y$10$5JvGi/ZDrV3qYQbyRtKhmOnIKCFkwkI3qA7.r7V/lG7jAl9RvV1e2', 'ภาค 2', 'การกีฬาแห่งประเทศไทย ภาค 2', 'KKTP2'),
(4, 'KKTP3', '$2y$10$jfzH2VkukLr8Z8SEg/x/wuSBQwYwXm3aHk8Konf0Tw741RpEDNEnu', 'ภาค 3', 'การกีฬาแห่งประเทศไทย ภาค 3', 'KKTP3'),
(5, 'KKTP4', '$2y$10$gYfjKyVyubB/3/d1sdPKFOnUm8gKrztujUEpl2pbI8lsAsJK/YeuW', 'ภาค 4', 'การกีฬาแห่งประเทศไทย ภาค 4', 'KKTP4'),
(6, 'KKTP5', '$2y$10$PKOWSEUQcCXVurwR4IUrHOat3k/2.nbU.mtcqZ9ghBjCLi20wggVi', 'ภาค 5', 'การกีฬาแห่งประเทศไทย ภาค 5', 'KKTP5'),
(7, 'BKK10000', '$2y$10$a4Wsut.V9DnPdwtBtsoMM.4XmK2Ds/X/muBxwbniTIyt8uI/agGFC', 'ภาค 1', 'กรุงเทพมหานคร', 'BKK'),
(8, 'SPK10270', '$2y$10$WnfEqGt9fUmjxMgw94Cj3e7ahyQdFxkuNrcsaBByEDbI.y8WwHWTa', 'ภาค 1', 'สมุทรปราการ', 'SPK'),
(9, 'NBI11000', '$2y$10$bX9g67f1DHoVRGcJ3JJ/UOdSGu0g/x92abLvkokKcCYAlG4533pWi', 'ภาค 1', 'นนทบุรี', 'NBI'),
(10, 'PTE12000', '$2y$10$NKhtYdZzUDD18mnMkmXWuuKoAP9wnLczsxI65.eaH57yR6Qk9VCVe', 'ภาค 1', 'ปทุมธานี', 'PTE'),
(11, 'NKT26000', '$2y$10$TZ1UU0Dqznfue69u67LVSu47lKNpm0z/0WnURV5D/JnvtwX61az.K', 'ภาค 1', 'นครนายก', 'NKT'),
(12, 'PJB25000', '$2y$10$uZ7rerXy6KSer5mYqKLQcOd.yxP19U03a/EV.qoSQn0Njm3ibkZnq', 'ภาค 1', 'ปราจีนบุรี', 'PJB'),
(13, 'SBW27000', '$2y$10$TSp8Rmd2JxHJGKxLBpCDgeilQgRAcfHP2LavSJmx50WrPpaoMb2F2', 'ภาค 1', 'สระแก้ว', 'SBW'),
(14, 'CTO24000', '$2y$10$u.h.hoexhIiVukk0//LUeeuXsPvYgwwqKLNBvabN8lJXCU9IdBou2', 'ภาค 1', 'ฉะเชิงเทรา', 'CTO'),
(15, 'CHB20000', '$2y$10$/RIBFtISTdcK5mp7BUR16u9ByuUbE5UBFTb.Su/lXWgfqUmLUJE6W', 'ภาค 1', 'ชลบุรี', 'CHB'),
(16, 'CHT22000', '$2y$10$FnLudrHo7sVZprvMD/Dp7OikwA/c6z9X4rpFtnQ9q2LoIeD.Y868q', 'ภาค 1', 'จันทบุรี', 'CHT'),
(17, 'RAY21000', '$2y$10$L5MBDlLQp9C7sLjN7xuakelu/YiGAELXuKXm3Q6E6CNSFlAqFir5y', 'ภาค 1', 'ระยอง', 'RAY'),
(18, 'TRT23000', '$2y$10$wSXpOaiKcwHYA1PwDMMPVOnsFYL0yb0JGy6Lvw/JSMKfym4S.HpGq', 'ภาค 1', 'ตราด', 'TRT'),
(19, 'SMK74000', '$2y$10$5rX8.c4WBP0dxDLtvzcG/e7t2Pc6YF7rrgyp6xT7YpNsN2.nugeI2', 'ภาค 1', 'สมุทรสาคร', 'SMK'),
(20, 'KBI71000', '$2y$10$ZFpH7A0Ss2ja8fp9mFNl1OMBq5vmFt0bn6Us2TCLmdd.aIWmmVvZG', 'ภาค 2', 'กาญจนบุรี', 'KBI'),
(21, 'SPB72000', '$2y$10$JhgZ./eLsYtxlnUBwwdUAeEktly9T5joCEvKIT2tUXJPDcbaJ6b4K', 'ภาค 2', 'สุพรรณบุรี', 'SPB'),
(22, 'CNT17000', '$2y$10$qn.D0p9V1jPnGZYrOCo7yunsr73SwGplnHUX.WDfebSk2eWR1TDVO', 'ภาค 2', 'ชัยนาท', 'CNT'),
(23, 'UTI61000', '$2y$10$4xXo45NYFQ.ixPNctl7FJu78G1YUnEVsRo2yR96swg7F4ptjgFydi', 'ภาค 2', 'อุทัยธานี', 'UTI'),
(24, 'SBR16000', '$2y$10$5YFdjIk6AW8uTe8h9/tDLee.1zMuuko0bPAeocDhm30nH7hdtDC2G', 'ภาค 2', 'สิงห์บุรี', 'SBR'),
(25, 'LRI15000', '$2y$10$ZR7vJ5fNmCLhnApzVGTXiuxpPZha/.LI6usvyK6NIRrvB5WAM5aGq', 'ภาค 2', 'ลพบุรี', 'LRI'),
(26, 'SRI18000', '$2y$10$roSpwmgU3/hcWMbU0fW4qeZQeZ958azrGM/lIeSEhfJHhdRnKftAi', 'ภาค 2', 'สระบุรี', 'SRI'),
(27, 'AGT14000', '$2y$10$S.D2HmAGmi02YhVP/R4eseoKRriPFFDD7NePLsbbbx9KQ90aEz1RO', 'ภาค 2', 'อ่างทอง', 'AGT'),
(28, 'AYA13000', '$2y$10$TZ1UU0Dqznfue69u67LVSu47lKNpm0z/0WnURV5D/JnvtwX61az.K', 'ภาค 2', 'พระนครศรีอยุธยา', 'AYA'),
(29, 'NPT73000', '$2y$10$2dBPBHfZA4D1p2dexmKTQudxr0VHqoPHSJwPQeirFM2hdeO17cI/6', 'ภาค 2', 'นครปฐม', 'NPT'),
(30, 'RBR70000', '$2y$10$vUn9WC1/367OisfwfOxEe.dRJF6IMdGed38eKMOuuENf7qQvFNwgW', 'ภาค 2', 'ราชบุรี', 'RBR'),
(31, 'SSE75000', '$2y$10$CRRVkZDeqPF9RgromTMSaOTjDJduexgubE2aOdVEqhPYS9aeEnjzC', 'ภาค 1', 'สมุทรสงคราม', 'SSE'),
(32, 'PBI76000', '$2y$10$/n1s8QnL51rgZbr5g9UKI.gZwkBx7E8kC/WKD/ILi5XFjttV2COga', 'ภาค 2', 'เพชรบุรี', 'PBI'),
(33, 'PKN77000', '$2y$10$33v4HbRIo3h//Q6l7MkgQ.W/RqDC/Vmi3/1.rDzWZ1QdoFhokPMCG', 'ภาค 2', 'ประจวบคีรีขันธ์', 'PKN'),
(34, 'NMA30000', '$2y$10$udH8GJ1.wUUvwt/tHh6ZeOi6Prmg03.MG/.qfN582FZxb3n2.hikG', 'ภาค 3', 'นครราชสีมา', 'NMA'),
(35, 'BRM31000', '$2y$10$9r7MOnf0pipLcxTcxZAIbeiFDFtnAbfqRr/1bDaE0HvKY.yqXcQJ6', 'ภาค 3', 'บุรีรัมย์', 'BRM'),
(36, 'SRN32000', '$2y$10$GYl1pmW.cpAZo8nzfcxbYOqlEVQERjueGLFeTwefB9bpdxZR2ixfi', 'ภาค 3', 'สุรินทร์', 'SRN'),
(37, 'SSK33000', '$2y$10$I7TcfI/cCI5ErNGZVogCIem2vwTLHGoXU5687qmaAHy2LiQKfd5j6', 'ภาค 3', 'ศรีสะเกษ', 'SSK'),
(38, 'UBN34000', '$2y$10$Kv.xXjt9Qa1aZ9ZLLBulPO6uxIzSiXYsafHu8AHzcqWIQjqRNX3Me', 'ภาค 3', 'อุบลราชธานี', 'UBN'),
(39, 'CPM36000', '$2y$10$hY20XTvT1sFkb1L2VnEBcuzW8GbY9hdzBMstqHyDSar8wuUGL9RAS', 'ภาค 3', 'ชัยภูมิ', 'CPM'),
(40, 'KKN40000', '$2y$10$gVt.6tz/qV1rrqNb8Xi2hO4YbW6Gus2TfjkSmUwsTvbl1PrnukDSO', 'ภาค 3', 'ขอนแก่น', 'KKN'),
(41, 'MSN44000', '$2y$10$35qovtlKl1L2WJ/DcwDXSueRhlV5H/KO9tRSFklNdGdBPbNjU2nm6', 'ภาค 3', 'มหาสารคาม', 'MSN'),
(42, 'RET45000', '$2y$10$4.p/NTw/Ls.Qb8R1.rVXDusf6sI8pLw0s1OSgVXcV9rxpRwC7W7pe', 'ภาค 3', 'ร้อยเอ็ด', 'RET'),
(43, 'YSR35000', '$2y$10$xqUAzgA9ZkN8TzFpiDG3HeIBCp11MJ2r3FeXaX2gB7YycIWnt3IIS', 'ภาค 3', 'ยโสธร', 'YSR'),
(44, 'ACN37000', '$2y$10$oZf78xiGPZAlVIyvbhprLO3CAZx5PQ0N8ZN3X5hJFOrLtCamQLhrq', 'ภาค 3', 'อำนาจเจริญ', 'ACN'),
(45, 'MKN49000', '$2y$10$kIYmI.hI1wgsVRRmyJcbRewaib2mbZ8Nb7XgDM1gNXVewjeQ4Z4B6', 'ภาค 3', 'มุกดาหาร', 'MKN'),
(46, 'KKN46000', '$2y$10$Q5.fyaNVnvq8DGWQRpwm3uZrwJVtv7Ae.O/CnjoKERTc3cPpLDzRe', 'ภาค 3', 'กาฬสินธุ์', 'KKN'),
(47, 'LEY42000', '$2y$10$drVIw2O7qcI9/K.I2Qm.U.MZ4WxC6FmkuXcTdKz/NYOtSa9sPjyxG', 'ภาค 3', 'เลย', 'LEY'),
(48, 'NBL38000', '$2y$10$J2a1JkX5YrnXuV5I.h7czOtkR6J4MCAV8PSph4ZsC2l4rEWYk9.8C', 'ภาค 3', 'หนองบัวลำภู', 'NBL'),
(49, 'UDN41000', '$2y$10$YI14HIw6KjsRsI5ykCfZK.Gny6JdAbZulhOHV/O3UHgZZYekn1wWS', 'ภาค 3', 'อุดรธานี', 'UDN'),
(50, 'SKR47000', '$2y$10$gdU1euy9E3y4Pp9.lbNmyererfkUIDEpmPJC8LQWVpzPpZCoN/C1K', 'ภาค 3', 'สกลนคร', 'SKR'),
(51, 'NMP48000', '$2y$10$wu8qKKrJqsIqKOkKBqMpFuoFZM1fCPs7cMIVEIlv6gUQnTasS9yoO', 'ภาค 3', 'นครพนม', 'NMP'),
(52, 'NKH43000', '$2y$10$sZULkfoKgrkdj37yp2CjNOBZGsdB0lKbGHDCJOBtgRCCdoFhf.yia', 'ภาค 3', 'หนองคาย', 'NKH'),
(53, 'BKK96000', '$2y$10$gzgZ54XHBoCIaZUTsNRHbOms8Y4r108Hnw4Y7PACV1OyvHPVE0uca', 'ภาค 3', 'บึงกาฬ', 'BKK'),
(54, 'CPN86000', '$2y$10$ReqzgRNSMHJo4v8CUxj3R.U8u1Evd2p5Z3loLFQDrOz80k4osyZjK', 'ภาค 4', 'ชุมพร', 'CPN'),
(55, 'RNG85000', '$2y$10$SlqNpbO8oHxTgsUzJcnu5es0fe69u60mbPSoX55f5a0NSLJwb7eYO', 'ภาค 4', 'ระนอง', 'RNG'),
(56, 'SRT84000', '$2y$10$fwV8CIe9I2anwu5dyFq/B.r.7J6QaPBeake7Sh7I4YJBS1mcVIJLC', 'ภาค 4', 'สุราษฎร์ธานี', 'SRT'),
(57, 'PNA82000', '$2y$10$MVs8uZP6bbIM/WrM5qT4i.IjWDmzPIT.Pu2kXRTGPR43rcBu1P4fy', 'ภาค 4', 'พังงา', 'PNA'),
(58, 'KBI81000', '$2y$10$LEP1RxB1s6wuOsmJZRdPOO.A666GshZYg8N9YT0rY2kxWcHCK2e72', 'ภาค 4', 'กระบี่', 'KBI'),
(59, 'PKT83000', '$2y$10$qpJwmlLtaQMvRmwHdP1Ai.JoZkHp1nwtVhEkLKT/gxcek5M6vOqlO', 'ภาค 4', 'ภูเก็ต', 'PKT'),
(60, 'NST80000', '$2y$10$.4mxs2hD46fJclyCjfTX9OurhCYeSjjTRNLiSYK8bEprHX1MrQ5Oy', 'ภาค 4', 'นครศรีธรรมราช', 'NST'),
(61, 'TRG92000', '$2y$10$C6tine0OWcPWgUWvilFyE.i8BcrcR9C6kGTD5EHmhIrkKibTrnPHS', 'ภาค 4', 'ตรัง', 'TRG'),
(62, 'PLG93000', '$2y$10$aYjt7nBRMtlzVf.RGN.dyOc0dz5.Eq/CbG21dHIDNlmpjHYd4IKEy', 'ภาค 4', 'พัทลุง', 'PLG'),
(63, 'STN91000', '$2y$10$4OhxiSQQOyJi8.A4H3PxR.hgMk2C.K58D3R9zrGLqEWbIorzBejQy', 'ภาค 4', 'สตูล', 'STN'),
(64, 'SKA90000', '$2y$10$5gM1p3ltFFdNjkwDgTJcIumfuushaMPmwlUkj4p9SGlQAbRwwBZke', 'ภาค 4', 'สงขลา', 'SKA'),
(65, 'PTN94000', '$2y$10$473s2f6qoPZvfNFPF9iqvei6yyb.hwcC287jndVw99Y3m2KgZuvHi', 'ภาค 4', 'ปัตตานี', 'PTN'),
(66, 'YLA95000', '$2y$10$0CyrRcYobsOUP2e1hVCijex.OLBn7ygf4kS3hmS5b/CxwbxeAcVcy', 'ภาค 4', 'ยะลา', 'YLA'),
(67, 'NRT96000', '$2y$10$O2hF6rh43zDYkSIPAj3fcuPNOxt/1Ztk3r.UjKkdOwPnwmmreU22K', 'ภาค 4', 'นราธิวาส', 'NRT'),
(68, 'CGY50000', '$2y$10$MzVwU/HT3W6UlfC7YSl7KeEKPVGundHTWwlaU3UZzegiwFf6NdCmO', 'ภาค 5', 'เชียงใหม่', 'CGY'),
(69, 'LPN51000', '$2y$10$aydakrtGWt27NV2nLnhFAelojlb8s/HGrAzlrpNdIUlems0.iRl4e', 'ภาค 5', 'ลำพูน', 'LPN'),
(70, 'LPG52000', '$2y$10$18tH.C3tKYebtzZB9bVNcubKxslX5Hex9hT3VoFdYRLm6xE15aRq2', 'ภาค 5', 'ลำปาง', 'LPG'),
(71, 'UTD53000', '$2y$10$yJJCTQ7V9RodjdEWMT1.g./tft4UaBqHqAgtmKLzS0Be7Ma5FOFs2', 'ภาค 5', 'อุตรดิตถ์', 'UTD'),
(72, 'PRE54000', '$2y$10$b2433SGuvveJ9Ra.9sQcEONJ3/5r.NzZ/Y/0UJUy71PJmK9cWD36.', 'ภาค 5', 'แพร่', 'PRE'),
(73, 'NAN55000', '$2y$10$t5k8UzIqWEIPC5JcOGlbF.9Sx9rsotNUB9W2g2PwBURC3eHn67tH2', 'ภาค 5', 'น่าน', 'NAN'),
(74, 'PYO56000', '$2y$10$4TTiXDdo2uZzmsPOWOE8tOFgwuHPwfp9/0eLVfc9WDGo9uJnvAxxG', 'ภาค 5', 'พะเยา', 'PYO'),
(75, 'CRI57000', '$2y$10$mvMx5uqlsKQHn5Jvnl/NMu0cJwWMn/ki/xkuMh0qz2rR1SGx2jFG.', 'ภาค 5', 'เชียงราย', 'CRI'),
(76, 'MHS58000', '$2y$10$bDyjoKpBb7TpAzAtDgipyeNtqfxM745Kc7XQApoETZMs6pB1OC0Aq', 'ภาค 5', 'แม่ฮ่องสอน', 'MHS'),
(77, 'NWS60000', '$2y$10$ytBF48ueyAI8ARdaRZHKeeu6rwBhpRgHX6OTMSryFQWQvu90hc2pm', 'ภาค 5', 'นครสวรรค์', 'NWS'),
(78, 'KGC62000', '$2y$10$ipF0/18rn4EeFIx/PQSDruj.7G5t/zffg5.bzZtDQ.fvZS.mfQNSe', 'ภาค 5', 'กำแพงเพชร', 'KGC'),
(79, 'TAK63000', '$2y$10$5Zss7rjQIQubqWkQGzXK4eflv7.7jvpfDFhWUUrM2TlY3Yj00azyW', 'ภาค 5', 'ตาก', 'TAK'),
(80, 'SKT64000', '$2y$10$6nRIk84YDLvSCaG76UUNj.sg8.l0PdymmLeIoJokkPoEnW0DcF2eW', 'ภาค 5', 'สุโขทัย', 'SKT'),
(81, 'PHS65000', '$2y$10$MJu0pMIDBRE8BvWia/TEkuf593KlOL1cTtRT5ilMyCKDcy7gpPKyW', 'ภาค 5', 'พิษณุโลก', 'PHS'),
(82, 'PCT66000', '$2y$10$dqJ8LOUUuXDZSlbM7dSLaOmJpP2G.P/tC66lF1gqCxKlwesj.q1eS', 'ภาค 5', 'พิจิตร', 'PCT'),
(83, 'PBR67000', '$2y$10$bJWFJdDiAXnEbuKqE7tl1.DbRlIIjQ/E3JPjPnggzkOn69/8E5dGK', 'ภาค 5', 'เพชรบูรณ์', 'PBR'),
(84, 'SPGOLF', '$2y$10$yhNcNKah6ai2g/0gbczsF.Jm1/of5SLGPueLMHTgvqAmqTquC6HoS', '', 'กอล์ฟ', 'SPGOLF'),
(85, 'SPARCH', '$2y$10$Ysv0zOMlqMkxAkPRxH3WU.APnXR8QgmgU0h.lps9GYZzAnoandPeu', '', 'กรีฑา', 'SPARCH'),
(86, 'SPFTBL', '$2y$10$ar1XiNaHBdJ5ZSormxsfdeGid5cTBHfrncXQtOfcmr3w/fGdWSsuy', '', 'ฟุตบอล', 'SPFTBL'),
(87, 'SPFUTS', '$2y$10$pvDH9OubxUpmQ6H4w0CG.uEIqTIt63QaqfohQqxU.MDs2yAbFaiXC', '', 'ฟุตซอล', 'SPFUTS'),
(88, 'SPVOLYB', '$2y$10$nesDXxUQoiVC1r4TwDa/geN36mEpFnHmY9Dzo/n0fUzSgZW15/th6', '', 'ตะกร้อ', 'SPVOLYB'),
(89, 'SPTEKB', '$2y$10$3t1FKoBNJBrNfRMfi0rJN.ZIt6flx.fIjLQj8wPmjOLm1.ZpIW1ai', '', 'เทคบอล', 'SPTEKB'),
(90, 'SPTENN', '$2y$10$Vut3vv8lwps/N8YrUM18tOXtyeg/TLpW5K9mLCWbQ1uQiqOFDumbC', '', 'เทเบิลเทนนิส', 'SPTENN'),
(91, 'SPWMNG', '$2y$10$hBG9iWDXub1eJaz1le6YJu7hNLWPwEIH7s1TXCVM3.qvU0gIa7lym', '', 'ว่ายน้ำ', 'SPWMNG'),
(92, 'SPSTEN', '$2y$10$sG.m/.TWeEw7y.FArWbVSOYuJWNWxTOaZsPObRDlKwns513qMQa2e', '', 'ซอฟท์เทนนิส', 'SPSTEN'),
(93, 'SPTENI', '$2y$10$H8ZhjpPnP1awgKW9hMkase8EnFx1KAdFSupGB/TFKqUeHzUy49zt.', '', 'เทนนิส', 'SPTENI'),
(94, 'SPBDMT', '$2y$10$hKgKILY0dCgzW4eiFmOLQejU13FJ0e7O9Y8bjhf95mdv7kaJmvn8.', '', 'แบดมินตัน', 'SPBDMT'),
(95, 'SPBASK', '$2y$10$uQV/2tDTY.Y8udj9rCbE.uDlIMFPKBa2Jr13cTrVEHFL90fIywIni', '', 'บาสเกตบอล', 'SPBASK'),
(96, 'SPTKWD', '$2y$10$6vJ5XyHFaD9YjxuWMGec3.zX5f8KysU0WR5J/eQUJS6sdwWI6KHfW', '', 'เทควันโด', 'SPTKWD'),
(97, 'SPKADO', '$2y$10$4CbyIpZevqobRlURW1Ti1Orp4knsngMyjyEI0BHQEkCNFAHFQODYi', '', 'คาราเต้-โด', 'SPKADO'),
(98, 'SPDNCG', '$2y$10$5sUy9/tPOQjAHcTAgGsNV.nXmJD4zxwuRiCNAjw.K/PYPIkJMB/3m', '', 'ลีลาศ', 'SPDNCG'),
(99, 'SPBRDG', '$2y$10$UjYNSrA7zAHhePVSfr9sDuKlxShSBKt2tv03PHqvZLWTr6rDIzmS.', '', 'บริดจ์', 'SPBRDG'),
(100, 'SPSILT', '$2y$10$k5gEMDOc2mG5UWqTe2b7MOSyjOX.P8jOClCyjX.Ec99.bokWYuN8W', '', 'ปันจักสีลัต', 'SPSILT'),
(101, 'SPAERB', '$2y$10$HsN9uKUmYuSkcR8kprSZduAycZU2ULFLx1K6bJhCWEmZIPiVkZx1e', '', 'เพาะกาย', 'SPAERB'),
(102, 'SPCHSS', '$2y$10$exfIkspzNlQDNcIzaLGqfePoXAZ2h9sP0BKfYzO4R9xd7INE3oVDi', '', 'หมากล้อม', 'SPCHSS'),
(103, 'SPBILR', '$2y$10$c73xv2X9RIYil/roRYT2XeMw.CaybJk4mQ0boCY8b4Yw466QlWyOi', '', 'บิลเลียด-สนุกเกอร์', 'SPBILR'),
(104, 'SPPTNQ', '$2y$10$SB37Anjme9S4ARjP7TY/feM5/dSpPSgIUbMM2edkCq.ts1ASQiuP6', '', 'เปตอง', 'SPPTNQ'),
(105, 'SPESPT', '$2y$10$WWL9oeGDdx5KRnTBCyfQAOskazWCd.TIcqJY7jXVKvJGsIoXtJSKC', '', 'อีสปอร์ต', 'SPESPT'),
(106, 'SPKABD', '$2y$10$JzDwhieRQg8zTb5Znfl.oOpOzhzCVZmYoA4S.wJu9GOghFzvCFB6q', '', 'กาบัดดี้', 'SPKABD'),
(107, 'SPWDBL', '$2y$10$BoNr125bBhBPjfMkkLb8c.iv.Nj0V69MKCdnQQE8Ef9i48RQPMrve', '', 'วู้ดบอล', 'SPWDBL'),
(108, 'SPABXN', '$2y$10$cxHcK3wg0Oboz7puYOhis.LA6HHIGO/.QvNboMNCkdF2dIln7L8Ay', '', 'มวยสากลสมัครเล่น', 'SPABXN'),
(109, 'SPMUTH', '$2y$10$qhS5knxEFBtxawh2qUz4FuQjcX0Eld4Sqm5Db3XrnxSUgaLD2RZeS', '', 'มวยไทยสมัครเล่น', 'SPMUTH'),
(110, 'SPVOLY', '$2y$10$sGwyXAZ/J/31onOlSXy4AuDLRUe3oL7uNsI2nqV0P7av1LonsbS02', '', 'วอลเลย์บอล', 'SPVOLY'),
(111, 'SPHNDL', '$2y$10$cqqUKdNKuzazuXsYhoP40O7fz1CrhE56KGwA.R4iM7qM1fku43OKO', '', 'แฮนด์บอล', 'SPHNDL'),
(112, 'SPWREST', '$2y$10$LGkDW9.S3ZyQ0eRaRlk1Q.Y8o0nDUGVpaooyKnf9mL74c0LayBauC', '', 'มวยปล้ำ', 'SPWREST'),
(113, 'SPYCHT', '$2y$10$yef87Ja.6cCQ2XlI29VOR.GczliRsEA36D3SvWakw8chp81NKv5py', '', 'ยูยิตสู', 'SPYCHT'),
(114, 'SPJUDO', '$2y$10$YvwbX.2KnFD57YmO.9Qx8eg0WvPVr7eAjuOMpCKPYantNDRovZb6S', '', 'ยูโด', 'SPJUDO'),
(115, 'SPCYCL', '$2y$10$XoWpkNOOHzTwB8s5mrEGiuDleYhjoGOE5E3tr9/CVcjmgdYMnZgSm', '', 'จักรยาน', 'SPCYCL'),
(116, 'SPWTLF', '$2y$10$7Bkg1PeYToWO7f2HZ2dhdOcgdgGJff/FRIwZ72Kg3i6oHSuV21qba', '', 'ยกน้ำหนัก', 'SPWTLF'),
(117, 'SPSTAG', '$2y$10$K3fEKm53OtIMuPRk2d1YXeQFx2Th7wJxm1mlRZC18M8dV10NGVBZ6', '', 'ยิงปืน', 'SPSTAG'),
(118, 'SPROWG', '$2y$10$HNGGrC39/onNq5kuxAFhM.vNy.9lgr/GBQm/hu2kJyV3xAmwTv5Je', '', 'เรือพาย', 'SPROWG'),
(119, 'SPHCKY', '$2y$10$UrDnshKAipUDYHB7f.c41.7fNJ9sj.i6qIlCITQEAMN6sMU7SB06S', '', 'ฮอกกี้', 'SPHCKY'),
(120, 'SPRUGB', '$2y$10$iyKhDEXH7GGivxm9.7dm1eJsIAHA0Ur/CNTVGCKcer/vQEEqHCjwS', '', 'รักบี้ฟตุบอล', 'SPRUGB'),
(121, 'SPFENC', '$2y$10$WwakhZD63CgnVkdYtdYW2.yT3Ae1o6ulGaIkp/dolSvLmRbp1uolS', '', 'ฟันดาบสากล', 'SPFENC'),
(122, 'SPMOTC', '$2y$10$dEQ7EM9WrwMbQfvCDF8AwOoCoKpWnodwE7fo7P9.NsLrCDPIDIuLa', '', 'จักรยานยนต์(โมโตครอส)', 'SPMOTC'),
(123, 'SPJTSK', '$2y$10$SlBMqC6FYkDj8nLr3z8hfOt2SLOYjhozspU4NCriWDKn.diwm/k9C', '', 'เจ็ตสกี', 'SPJTSK'),
(124, 'SPROLS', '$2y$10$y2e92x9MNOgGeOuc3jMzTOyRwlfaply5FkUgtusHick/nd2H0jEjy', '', 'โรลเลอร์สกี', 'SPROLS'),
(125, 'SPGYMN', '$2y$10$es5M.4c9mLo2PbhDMPlQ7OwKH6LVhu4vpq8MlSaA9tCDE2Ug7Izpe', '', 'ยิมนาสติก', 'SPGYMN'),
(126, 'SPFGRS', '$2y$10$hbo2Xjb3HnHi.hqqzHgLKuIhRwFHqE5kHEEecolvr.WNBnegxcVx.', '', 'ฟิกเกอร์แลสปีดสเก็ตติ้ง', 'SPFGRS'),
(127, 'SPEXTR', '$2y$10$o8iCBcGUgPL2BSwV1hsql.4lM2jM2yhcOTXZkVPExhi817jF8RAjS', '', 'เอ็กซ์ตรีม', 'SPEXTR'),
(128, 'SPTRAT', '$2y$10$Wmz5NTy3huiSEf/PbLwLrOurX0wsQIbs.t.9X43Z1JBwgljK0gGbm', '', 'ไตรกีฬา (กีฬาสาธิต)', 'SPTRAT'),
(129, 'SPDRAU', '$2y$10$QyNqK.5PSwSAInGST9YIROqakmEo.bbey6dn8VqqxnTiA/AmcH15G', '', 'หมากรุกสากล (กีฬาสาธิต)', 'SPDRAU'),
(130, 'SPKCKB', '$2y$10$ZJMZptOsE6krqawW3iDMR.ArWqKXMarlgDoJV8DWDGLgFXXrZdzOy', '', 'คิกบ็อกซิ่ง (กีฬาสาธิต)', 'SPKCKB'),
(131, 'SCKARATE', '$2y$10$mLswSxC5mFP2G1gITwiDbexoKGKP/oeJWO.RvqHt07QELvdZ3IUV.', '', 'SCKARATE', 'SCKARATE'),
(132, 'SCKARATE1', '$2y$10$PHw5LXCDud9dLD4tMbZYGuCs3DLrZIW6953IMI/gaZIZyD/k2ifha', '', 'SCKARATE1', 'SCKARATE1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_event`
--
ALTER TABLE `create_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_all`
--
ALTER TABLE `data_all`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_score`
--
ALTER TABLE `data_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_t`
--
ALTER TABLE `users_t`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `create_event`
--
ALTER TABLE `create_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `data_all`
--
ALTER TABLE `data_all`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_score`
--
ALTER TABLE `data_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users_t`
--
ALTER TABLE `users_t`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
