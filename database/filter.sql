-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2023 at 05:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filter`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama`, `id_jenis`, `harga`) VALUES
(25, 'BRG0001', 'Iphone 7 64Gb', 9, 2000000),
(26, 'BRG0002', 'Laptop Asus Vivobook 14', 9, 12000000),
(28, 'BRG0004', 'Jaket Bomber', 10, 250000),
(29, 'BRG0005', 'Sweeter Non Hoodie', 10, 75000),
(30, 'BRG0006', 'Celana Chinos', 10, 130000),
(31, 'BRG0007', 'testing', 10, 25000),
(32, 'BRG0010', 'aqua', 9, 19000),
(33, 'BRG0009', 'aqua', 9, 18000),
(34, 'BRG0012', 'beras', 11, 14000);

-- --------------------------------------------------------

--
-- Table structure for table `in_detail`
--

CREATE TABLE `in_detail` (
  `id` int(11) NOT NULL,
  `invoice_masuk` varchar(15) NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `expire` date NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `in_detail`
--

INSERT INTO `in_detail` (`id`, `invoice_masuk`, `kode_barang`, `expire`, `qty`, `harga`, `sub_total`) VALUES
(104, 'TER-20221110002', 'BRG0004', '2022-11-10', 100, 250000, 25000000),
(105, 'TER-20221110002', 'BRG0006', '2022-11-10', 100, 130000, 13000000),
(106, 'TER-20221110002', 'BRG0005', '2022-11-10', 100, 75000, 7500000),
(111, 'TER-20221110001', 'BRG0001', '2022-11-10', 20, 2000000, 40000000),
(128, 'TER-20221201003', 'BRG0001', '2022-12-01', 1, 2000000, 2000000),
(129, 'TER-20221201003', 'BRG0005', '2022-12-01', 1, 75000, 75000),
(130, 'TER-20221201003', 'BRG0005', '2022-12-01', 1, 75000, 75000);

-- --------------------------------------------------------

--
-- Table structure for table `in_header`
--

CREATE TABLE `in_header` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `invoice_masuk` varchar(15) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `in_header`
--

INSERT INTO `in_header` (`id`, `id_supplier`, `username`, `invoice_masuk`, `tgl`, `jam`, `total`) VALUES
(23, 3, 'admin', 'TER-20221110001', '2022-11-10', '09:59:37', 40000000),
(24, 1, 'admin', 'TER-20221110002', '2022-11-10', '13:58:41', 45500000),
(28, 1, 'admin', 'TER-20221201003', '2022-12-01', '06:41:50', 2150000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `jenis_barang`) VALUES
(9, 'Elektronik'),
(10, 'Pakaian'),
(11, 'sembako'),
(25, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `kunci` varchar(255) NOT NULL,
  `tgl` datetime NOT NULL DEFAULT current_timestamp(),
  `pesan` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `background` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`id`, `kunci`, `tgl`, `pesan`, `username`, `url`, `icon`, `background`) VALUES
(43, 'BRG0002', '2023-01-23 23:20:57', 'Laptop Asus Vivobook 14 habis / kosong', 'BRG0002', 'Laporan/stok', '<i class=\"fas fa-box text-white\"></i>', 'bg-danger');

-- --------------------------------------------------------

--
-- Table structure for table `out_detail`
--

CREATE TABLE `out_detail` (
  `id` int(11) NOT NULL,
  `invoice_keluar` varchar(15) NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `expire` date NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `out_detail`
--

INSERT INTO `out_detail` (`id`, `invoice_keluar`, `kode_barang`, `expire`, `qty`, `harga`, `sub_total`) VALUES
(31, 'KEL-20221110001', 'BRG0001', '2022-11-10', 5, 2000000, 10000000),
(34, 'KEL-20221110002', 'BRG0004', '2022-11-10', 5, 250000, 1250000),
(35, 'KEL-20221110002', 'BRG0005', '2022-11-10', 5, 75000, 225000),
(44, 'KEL-20221214003', 'BRG0006', '2022-12-14', 10, 130000, 1300000);

-- --------------------------------------------------------

--
-- Table structure for table `out_header`
--

CREATE TABLE `out_header` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `invoice_keluar` varchar(15) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `out_header`
--

INSERT INTO `out_header` (`id`, `username`, `invoice_keluar`, `tgl`, `jam`, `total`) VALUES
(11, 'admin', 'KEL-20221110001', '2022-11-10', '14:49:39', 10000000),
(12, 'admin', 'KEL-20221110002', '2022-11-10', '14:49:53', 1475000),
(15, 'admin', 'KEL-20221214003', '2022-12-14', '22:55:44', 1300000);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon_whatsapp` varchar(15) NOT NULL,
  `npwp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `no_telepon_whatsapp`, `npwp`) VALUES
(1, 'supplier A', 'MAGELANG', '8080', '123'),
(3, 'supplier B', 'mungkid', '9090', '456');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `barang` varchar(200) NOT NULL,
  `stok_in` int(11) NOT NULL,
  `stok_out` int(11) NOT NULL,
  `stok_hasil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_barang`, `barang`, `stok_in`, `stok_out`, `stok_hasil`) VALUES
(23, 'BRG0001', 'Iphone 7 64Gb', 21, 5, 16),
(24, 'BRG0006', 'Celana Chinos', 100, 10, 90),
(25, 'BRG0002', 'Laptop Asus Vivobook 14', 0, 0, 0),
(26, 'BRG0004', 'Jaket Bomber', 100, 5, 95),
(27, 'BRG0005', 'Sweeter Non Hoodie', 102, 5, 97),
(28, 'BRG0012', 'beras', 0, 0, 0),
(29, 'BRG0007', 'testing', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon_whatsapp` varchar(15) NOT NULL,
  `on_off` int(1) NOT NULL,
  `image` text NOT NULL DEFAULT 'default.png',
  `id_role` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `alamat`, `no_telepon_whatsapp`, `on_off`, `image`, `id_role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'temanggung', '000', 1, 'default.png', 1),
(6, 'kasir', 'c7911af3adbd12a035b289556d96470a', 'kasir aja', 'mungkid', '123', 0, 'default.png', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `in_detail`
--
ALTER TABLE `in_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `in_header`
--
ALTER TABLE `in_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `out_detail`
--
ALTER TABLE `out_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `out_header`
--
ALTER TABLE `out_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `in_detail`
--
ALTER TABLE `in_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `in_header`
--
ALTER TABLE `in_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `out_detail`
--
ALTER TABLE `out_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `out_header`
--
ALTER TABLE `out_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
