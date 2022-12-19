-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2022 at 05:55 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sertifikat`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nested` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `nested`) VALUES
(1, 'Permission', 'permision.index', '1'),
(2, 'Provinsi', 'provinsi.index', '1.1'),
(3, 'Kabupaten', 'kabupaten.index', '1.2'),
(4, 'Puskesmas', 'puskesmas.index', '1.3'),
(5, 'Master', 'master.index', '2'),
(6, 'Provinsi', 'master.provinsi.index', '2.1'),
(7, 'Tambah Provinsi', 'master.provinsi.tambah', '2.1.1'),
(8, 'Ubah Provinsi', 'master.provinsi.ubah', '2.1.2'),
(9, 'Hapus Provinsi', 'master.provinsi.hapus', '2.1.3'),
(10, 'Kabupaten', 'master.kabupaten.index', '2.2'),
(11, 'Tambah Kabupaten', 'master.kabupaten.tambah', '2.2.1'),
(12, 'Ubah Kabupaten', 'master.kabupaten.ubah', '2.2.2'),
(13, 'Hapus Kabupaten', 'master.kabupaten.hapus', '2.2.3'),
(14, 'Staff', 'staff.index', '2.3'),
(15, 'Tambah Staff', 'staff.tambah', '2.3.1'),
(16, 'Ubah Staff', 'staff.ubah', '2.3.2'),
(17, 'Detail Staff', 'staff.detail', '2.3.3'),
(18, 'Hapus Staff', 'staff.hapus', '2.3.3'),
(19, 'Kecamatan', 'master.kecamatan.index', '2.4'),
(20, 'Tambah Kecamatan', 'master.kecamatan.tambah', '2.4.1'),
(21, 'Ubah Kecamatan', 'master.kecamatan.ubah', '2.4.2'),
(22, 'Hapus Kecamatan', 'master.kecamatan.hapus', '2.4.3'),
(23, 'Puskesmas', 'master.puskesmas.index', '2.5'),
(24, 'Tambah Puskesmas', 'master.puskesmas.tambah', '2.5.1'),
(25, 'Ubah Puskesmas', 'master.puskesmas.ubah', '2.5.2'),
(26, 'Hapus Puskesmas', 'master.puskesmas.hapus', '2.5.3'),
(160, 'Keamanan', 'security.index', 'f'),
(161, 'Modul', 'permission.index', 'f.1'),
(162, 'Tambah Modul', 'permission.tambah', 'f.1.1'),
(163, 'Ubah Modul', 'permission.ubah', 'f.1.2'),
(164, 'Akses', 'role.index', 'f.2'),
(165, 'Tambah Akses', 'role.tambah', 'f.2.1'),
(166, 'Ubah Akses', 'role.ubah', 'f.2.2'),
(167, 'Daftar User Akses', 'role.user', 'f.2.3'),
(168, 'Hapus Akses', 'role.hapus', 'f.2.4'),
(172, 'Balkesmas', 'balkesmas.index', '1.4'),
(183, 'Certificates', 'certificate.index', '3'),
(184, 'Generate Certificate', 'certificate.generate.index', '3.1'),
(185, 'Tambah Generate Certificate', 'certificate.generate.tambah', '3.1.1'),
(186, 'Ubah Generate Certificate', 'certificate.generate.ubah', '3.1.2'),
(187, 'Hapus Generate Certificate', 'certificate.generate.hapus', '3.1.3'),
(188, 'Cetak Generate Certificate', 'certificate.generate.cetak', '3.1.4'),
(189, 'Detail Generate Certificate', 'certificate.generate.detail', '3.1.5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
