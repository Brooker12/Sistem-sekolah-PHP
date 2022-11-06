-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 11:14 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `multiuser`
--

CREATE TABLE `multiuser` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','guru','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `multiuser`
--

INSERT INTO `multiuser` (`id_user`, `username`, `password`, `level`) VALUES
(1201, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(1202, 'guru', '77e69c137812518e359196bb2f5e9bb9', 'guru'),
(1203, 'siswa', 'bcd724d15cde8c47650fda962968f102', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nickname`) VALUES
(120605, 'admin2', '21232f297a57a5a743894a0e4a801fc3', 'admin 2'),
(120905, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nip` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `mapel` varchar(50) NOT NULL,
  `kartu` varchar(50) NOT NULL,
  `ijazahs1` varchar(50) NOT NULL,
  `ijazahs2` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `username`, `password`, `nip`, `nama`, `jenis_kelamin`, `mapel`, `kartu`, `ijazahs1`, `ijazahs2`, `foto`) VALUES
(1, 'guru', '77e69c137812518e359196bb2f5e9bb9', 1085015, 'Pak Kahfi', 'Laki-laki', 'PWPB', 'card1085015.png', 'ijazah1085015S1.pdf', 'ijazah1085015S2.pdf', 'guru1662455599.png'),
(2, 'guru_rpl', 'bd9ae328e27f0832b42b265f5fdaebcd', 1401840, 'Pak Nasri', 'Laki-laki', 'PKK', 'card1401840.png', 'ijazah1401840S1.pdf', 'ijazah1401840S2.pdf', 'guru1661737439.png'),
(11, 'trading', '16f51c1ab9137b3733bd210c2d080289', 23580, 'Pak Kasim', 'Laki-laki', 'TRADING', 'card23580.png', 'ijazah23580S1.pdf', 'ijazah23580S2.pdf', 'guru1663064184.png'),
(12, 'pakmail', '', 121212, 'Pak Ismail', 'Laki-laki', 'PBO', 'card121212.png', 'ijazah121212S1.pdf', 'ijazah121212S2.pdf', 'guru1663163863.png'),
(13, 'bd', 'c419b06b4c6579b50ff05adb3b8424f1', 101010, 'Bu Vira', 'Perempuan', 'BASIS DATA', 'card101010.png', 'ijazah101010S1.pdf', 'ijazah101010S2.pdf', 'guru1664185581.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `mapel` varchar(50) DEFAULT NULL,
  `nilai_pengetahuan` varchar(100) DEFAULT NULL,
  `nilai_keterampilan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `id_siswa`, `mapel`, `nilai_pengetahuan`, `nilai_keterampilan`) VALUES
(1, 8, 'PWPB', '73', '30'),
(5, 10, 'TRADING', '100', '100'),
(6, 12, 'PWPB', '90', '90'),
(7, 24, 'BASIS DATA', '60', '65'),
(8, 6, 'PWPB', '85', '89');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `nis` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `agama` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `ijazah` varchar(100) NOT NULL,
  `kartu_keluarga` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `kartu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nisn`, `nis`, `nama`, `jenis_kelamin`, `agama`, `kelas`, `jurusan`, `ijazah`, `kartu_keluarga`, `foto`, `kartu`) VALUES
(5, '24917', 52810, 'Abel', 'Laki-laki', 'Kristen', 'XII', 'RPL', 'ijazah2491752810.pdf', 'kk2491752810.png', 'Abel52810.png', 'card2491752810.png'),
(6, '18401', 20184, 'Akif', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah1840120184.pdf', 'kk1840120184.png', 'Akif20184.png', 'card1840120184.png'),
(8, '1012', 1012, 'Fitra', 'Laki-laki', 'Budha', 'XII', 'TKJ', 'ijazah10121012.pdf', 'kk10121012.png', 'Fitra1012.png', 'card10121012.png'),
(9, '12345', 12345, 'Agung', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah1234512345.pdf', 'kk1234512345.png', 'Agung12345.png', 'card1234512345.png'),
(10, '1206', 1206, 'Dayat', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah12061206.pdf', 'kk12061206.png', 'Dayat2010156.png', 'card12061206.png'),
(12, '1210', 1210, 'Said', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah12101210.pdf', 'kk12101210.png', 'Said1210.png', 'card12101210.png'),
(24, '5108', 5108, 'Joko', 'Laki-laki', 'Islam', 'X', 'TKJ', 'ijazah51085108.pdf', 'kk51085108.png', 'Joko5108.png', 'card51085108.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `multiuser`
--
ALTER TABLE `multiuser`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `multiuser`
--
ALTER TABLE `multiuser`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1204;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120906;

--
-- AUTO_INCREMENT for table `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD CONSTRAINT `tb_nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
