-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2020 at 06:45 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sip`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemda`
--

CREATE TABLE `tb_pemda` (
  `id_pemda` int(11) NOT NULL,
  `tahun` varchar(100) NOT NULL DEFAULT '',
  `nama_pemda` text NOT NULL,
  `ibu_kota` text NOT NULL,
  `alamat` text NOT NULL,
  `logo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_pemda`
--

INSERT INTO `tb_pemda` (`id_pemda`, `tahun`, `nama_pemda`, `ibu_kota`, `alamat`, `logo`) VALUES
(1, '2020', 'Kabupaten Buol', 'Buol', 'Jl. Syarief Mansyur', 'buol.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(4, 'EMIL SALIM, S.KOM', 'rara@gmail.com', 'admin2.jpg', '$2y$10$PUY7ubphYFlMP7EQ9WWKiu7I4St1f1I9jDVbHuGTpYczugg0229w6', 1, 1, 1578892995),
(17, 'Emil', 'emilsalimramadhan@gmail.com', 'default.jpg', '$2y$10$1ANYEr19e5d.0JVxNTc1S.W7N6WRMTM2AlCFl.nQD/ZdLGkd7EvPG', 2, 1, 1580008631),
(21, 'EMIL SALIM, S.KOM', 'emilbiosci2018@gmail.com', 'default.jpg', '$2y$10$TOeodwXXfn7mByHwWQY5xuFcrirGk2ipxitBmsUoF5rBFRTCdTh/6', 3, 1, 1580054566);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(5, 1, 4),
(6, 3, 4),
(7, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Parameter');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'member'),
(3, 'Admin Gudang'),
(4, 'Admin Bidang'),
(5, 'Kepala Bidang');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Manajemen', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Sub Menu Manajemen', 'menu/submenu', 'fas fa-sw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-sw fa-universal-access', 1),
(8, 2, 'Ubah Password', 'user/changepassword', 'fas fa-sw fa-key', 1),
(9, 4, 'Identitas', 'parameter', 'fas fa-sw fa-chalkboard', 1),
(10, 4, 'SKPD', 'parameter/skpd', 'fas fa-sw fa-flag', 1),
(11, 4, 'Program Kegiatan', 'parameter/programKegiatan', 'fas fa-sw fa-puzzle-piece', 1),
(12, 4, 'Suplier', 'parameter/suplier', 'fas fa-sw fa-people-carry', 1),
(13, 4, 'Penanggung Jawab', 'parameter/penanggungJawab', 'fas fa-sw fa-user-shield', 1),
(14, 4, 'Penyimpanan Gudang', 'parameter/penyimpananGudang', 'fas fa-sw fa-store-alt', 1),
(15, 4, 'Belanja', 'parameter/belanja', 'fas fa-sw fa-shopping-cart', 1),
(16, 1, 'Pengguna', 'admin/pengguna', 'fas fa-sw fa-user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(13, 'emilsalimramadhan@gmail.com', 'LXbVSWjO8xZWRrkbNTN/N6/qdfU6ux9QlyNivs93SR8=', 1580011767),
(14, 'emilsalim.tkj@gmail.com', 'EeyL8UPWXGlFrVCxc0GSURlF3srpkrWpfu+QI78hYNc=', 1580054134),
(15, 'emilsalim.tkj@gmail.com', '8ke2mvIceMccnI7foDjFSONg5zhLU4QeiDSiESOle1k=', 1580054311),
(16, 'emilsalim.tkj@gmail.com', '2G+Be3+wka9BuPKdlhHfB27WGGnoXMari4cuqz6iR6c=', 1580054486);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_pemda`
--
ALTER TABLE `tb_pemda`
  ADD PRIMARY KEY (`id_pemda`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
