-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 12:07 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absenrfiddoorlock`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_akses_2`
--

CREATE TABLE `tabel_akses_2` (
  `no` int(20) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `NAMA` varchar(20) NOT NULL,
  `TANGGAL` date NOT NULL,
  `MASUK` time NOT NULL,
  `KELUAR` time NOT NULL,
  `id_room` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_akses_2`
--


-- --------------------------------------------------------

--
-- Table structure for table `tabel_anggota`
--

CREATE TABLE `tabel_anggota` (
  `ID` varchar(20) NOT NULL,
  `ID_CHAT` varchar(20) NOT NULL,
  `NO_INDUK` varchar(20) NOT NULL,
  `NAMA` varchar(70) NOT NULL,
  `KELAMIN` enum('L','P') NOT NULL,
  `id_sub` int(20) NOT NULL,
  `SW` int(20) NOT NULL,
  `TERDAFTAR` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Level` enum('Anggota','Admin') NOT NULL,
  `id_shift` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_anggota`
--

INSERT INTO `tabel_anggota` (`ID`, `ID_CHAT`, `NO_INDUK`, `NAMA`, `KELAMIN`, `id_sub`, `SW`, `TERDAFTAR`, `Password`, `Level`, `id_shift`) VALUES
('2b614827', '441884684', '0000003', 'Rizky Project', 'L', 5, 1, '2021-01-17', '$2y$10$2qhL1cBY0EvHdK9.u.NdFuV1JzH5ASqwPl6i2KCm2WAGPLGVpqvSe', 'Anggota', 1),
('admin', '441884684', '0000000', 'admin', 'L', 1, 1, '2021-01-16', '$2y$10$S/Ashr1oOQ2K8Kdnys0Y4u920Bpuc2vJHPRC49fk9NfzFm1T/oi1.', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_hak_akses`
--

CREATE TABLE `tabel_hak_akses` (
  `no` int(20) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `NAMA` varchar(20) NOT NULL,
  `id_room` int(20) NOT NULL,
  `room` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_hak_akses`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_hari_libur`
--

CREATE TABLE `tabel_hari_libur` (
  `H_LIBUR_1` varchar(20) NOT NULL,
  `H_LIBUR_2` varchar(20) NOT NULL,
  `T_LIBUR_3` varchar(20) NOT NULL,
  `T_LIBUR_4` varchar(20) NOT NULL,
  `T_LIBUR_5` varchar(20) NOT NULL,
  `T_LIBUR_6A` varchar(20) NOT NULL,
  `T_LIBUR_6B` varchar(20) NOT NULL,
  `T_LIBUR_7A` varchar(20) NOT NULL,
  `T_LIBUR_7B` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_hari_libur`
--

INSERT INTO `tabel_hari_libur` (`H_LIBUR_1`, `H_LIBUR_2`, `T_LIBUR_3`, `T_LIBUR_4`, `T_LIBUR_5`, `T_LIBUR_6A`, `T_LIBUR_6B`, `T_LIBUR_7A`, `T_LIBUR_7B`) VALUES
('Saturday', 'Sunday', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kehadiran`
--

CREATE TABLE `tabel_kehadiran` (
  `no` int(200) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `NO_INDUK` varchar(20) NOT NULL,
  `NAMA` varchar(20) NOT NULL,
  `TANGGAL` date NOT NULL,
  `CHECK_IN` time NOT NULL,
  `LATE_IN` int(20) NOT NULL,
  `CHECK_OUT` time NOT NULL,
  `EARLY_OUT` int(20) NOT NULL,
  `KET` varchar(20) NOT NULL,
  `STAT` varchar(20) NOT NULL,
  `id_shift` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_kehadiran`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pengaturan`
--

CREATE TABLE `tabel_pengaturan` (
  `idbaru` varchar(20) NOT NULL,
  `TOKEN` varchar(100) NOT NULL,
  `KEY_API` varchar(100) NOT NULL,
  `SW` int(20) NOT NULL,
  `SW_2` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_pengaturan`
--

INSERT INTO `tabel_pengaturan` (`idbaru`, `TOKEN`, `KEY_API`, `SW`, `SW_2`) VALUES
('', '1292117779:AAHaF5vrp43ryZSvTzi49sd03NpMbixNRHgbnuYyk', 'abc123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_permit`
--

CREATE TABLE `tabel_permit` (
  `no` int(20) NOT NULL,
  `waktu` datetime NOT NULL,
  `ID` varchar(20) NOT NULL,
  `NAMA` varchar(20) NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `jenis` enum('SAKIT','IZIN') NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  `status` enum('awaiting','accepted','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_permit`
--


-- --------------------------------------------------------

--
-- Table structure for table `tabel_room`
--

CREATE TABLE `tabel_room` (
  `id_room` int(20) NOT NULL,
  `room` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_room`
--

INSERT INTO `tabel_room` (`id_room`, `room`) VALUES
(2, 'Bengkel Teknik'),
(3, 'Kantor Marketing'),
(4, 'Lab. Multimedia'),
(5, 'Ruangan Panel'),
(1, 'Ruangan Staf');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_shift`
--

CREATE TABLE `tabel_shift` (
  `id_shift` int(20) NOT NULL,
  `JAM_MASUK_1` time NOT NULL,
  `JAM_MASUK_2` time NOT NULL,
  `JAM_MASUK_3` time NOT NULL,
  `JAM_PULANG_1` time NOT NULL,
  `JAM_PULANG_2` time NOT NULL,
  `JAM_PULANG_3` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_shift`
--

INSERT INTO `tabel_shift` (`id_shift`, `JAM_MASUK_1`, `JAM_MASUK_2`, `JAM_MASUK_3`, `JAM_PULANG_1`, `JAM_PULANG_2`, `JAM_PULANG_3`) VALUES
(1, '06:00:00', '09:00:00', '13:30:00', '14:10:00', '15:33:00', '18:30:00'),
(2, '07:00:00', '08:00:00', '10:00:00', '14:00:00', '16:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_subject`
--

CREATE TABLE `tabel_subject` (
  `id_sub` int(20) NOT NULL,
  `SUBJECT` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_subject`
--

INSERT INTO `tabel_subject` (`id_sub`, `SUBJECT`) VALUES
(1, 'Admin'),
(4, 'Driver'),
(5, 'Engineer'),
(9, 'Peneliti'),
(10, 'Chef'),
(11, 'Office Boy'),
(12, 'Keuangan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_akses_2`
--
ALTER TABLE `tabel_akses_2`
  ADD PRIMARY KEY (`no`),
  ADD KEY `ID` (`ID`,`NAMA`,`id_room`);

--
-- Indexes for table `tabel_anggota`
--
ALTER TABLE `tabel_anggota`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NO_INDUK` (`NO_INDUK`),
  ADD KEY `NAMA` (`NAMA`),
  ADD KEY `id_sub` (`id_sub`);

--
-- Indexes for table `tabel_hak_akses`
--
ALTER TABLE `tabel_hak_akses`
  ADD PRIMARY KEY (`no`),
  ADD KEY `id_room` (`id_room`),
  ADD KEY `room` (`room`);

--
-- Indexes for table `tabel_hari_libur`
--
ALTER TABLE `tabel_hari_libur`
  ADD PRIMARY KEY (`H_LIBUR_1`);

--
-- Indexes for table `tabel_kehadiran`
--
ALTER TABLE `tabel_kehadiran`
  ADD PRIMARY KEY (`no`),
  ADD KEY `ID` (`ID`),
  ADD KEY `NO_INDUK` (`NO_INDUK`),
  ADD KEY `NAMA` (`NAMA`);

--
-- Indexes for table `tabel_pengaturan`
--
ALTER TABLE `tabel_pengaturan`
  ADD PRIMARY KEY (`idbaru`);

--
-- Indexes for table `tabel_permit`
--
ALTER TABLE `tabel_permit`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tabel_room`
--
ALTER TABLE `tabel_room`
  ADD PRIMARY KEY (`id_room`),
  ADD KEY `room` (`room`);

--
-- Indexes for table `tabel_shift`
--
ALTER TABLE `tabel_shift`
  ADD PRIMARY KEY (`id_shift`);

--
-- Indexes for table `tabel_subject`
--
ALTER TABLE `tabel_subject`
  ADD PRIMARY KEY (`id_sub`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_akses_2`
--
ALTER TABLE `tabel_akses_2`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `tabel_hak_akses`
--
ALTER TABLE `tabel_hak_akses`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tabel_kehadiran`
--
ALTER TABLE `tabel_kehadiran`
  MODIFY `no` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1301;

--
-- AUTO_INCREMENT for table `tabel_permit`
--
ALTER TABLE `tabel_permit`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tabel_subject`
--
ALTER TABLE `tabel_subject`
  MODIFY `id_sub` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tabel_hak_akses`
--
ALTER TABLE `tabel_hak_akses`
  ADD CONSTRAINT `tabel_hak_akses_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `tabel_room` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabel_hak_akses_ibfk_2` FOREIGN KEY (`room`) REFERENCES `tabel_room` (`room`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tabel_kehadiran`
--
ALTER TABLE `tabel_kehadiran`
  ADD CONSTRAINT `tabel_kehadiran_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `tabel_anggota` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabel_kehadiran_ibfk_2` FOREIGN KEY (`NO_INDUK`) REFERENCES `tabel_anggota` (`NO_INDUK`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tabel_kehadiran_ibfk_3` FOREIGN KEY (`NAMA`) REFERENCES `tabel_anggota` (`NAMA`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
