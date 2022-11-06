-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Sep 2022 pada 13.07
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

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
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`, `nickname`) VALUES
(120605, 'admin2', '21232f297a57a5a743894a0e4a801fc3', 'admin 2'),
(120905, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Dayat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
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
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `username`, `password`, `nip`, `nama`, `jenis_kelamin`, `mapel`, `kartu`, `ijazahs1`, `ijazahs2`, `foto`) VALUES
(1, 'guru', '77e69c137812518e359196bb2f5e9bb9', 1085015, 'Pak Kahfi', 'Laki-laki', 'PWPB', '1085015card.png', 'ijazah1085015S1.pdf', 'ijazah1085015S2.pdf', 'guru1662455599.png'),
(2, 'guru_rpl', 'bd9ae328e27f0832b42b265f5fdaebcd', 1401840, 'Pak Nasri', 'Laki-laki', 'PBO', '1401840card.png', 'ijazah1401840S1.pdf', 'ijazah1401840S2.pdf', 'guru1661737439.png'),
(3, 'guru_pkk', '59164fab9d03cc63b28f409d928022a0', 124801, 'Pak Tri', 'Laki-laki', 'PKK', '124801card.png', 'ijazah124801S1.pdf', 'ijazah124801S2.pdf', 'guru1661737459.png'),
(5, 'pakmail', '1cda15692e7537fceb091307e67f4487', 3820, 'Pak Ismail', 'Laki-laki', 'PWPB', '3820card.png', 'ijazah3820S1.pdf', 'ijazah3820S2.pdf', 'guru1662993971.png'),
(11, '', '', 23580, 'Pak Kasim', 'Laki-laki', 'TRADING', '23580card.png', 'ijazah23580S1.pdf', 'ijazah23580S2.pdf', 'guru1663064184.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
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
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nisn`, `nis`, `nama`, `jenis_kelamin`, `agama`, `kelas`, `jurusan`, `ijazah`, `kartu_keluarga`, `foto`, `kartu`) VALUES
(5, '24917', 52810, 'Abel', 'Laki-laki', 'Kristen', 'XII', 'RPL', 'ijazah2491752810.pdf', 'kk2491752810.jpg', 'Abel52810.png', 'card2491752810.png'),
(6, '18401', 20184, 'Akif', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah1840120184.pdf', 'kk1840120184.pdf', 'Akif20184.png', 'card1840120184.png'),
(8, '1012', 1012, 'Fitra', 'Laki-laki', 'Budha', 'XII', 'TKJ', 'ijazah10121012.pdf', 'kk10121012.pdf', 'Fitra1012.png', 'card10121012.png'),
(9, '12345', 12345, 'Agung', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah1234512345.pdf', 'kk1234512345.jpg', 'Agung12345.png', 'card1234512345.png'),
(10, '1206', 1206, 'Dayat', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah12061206.pdf', 'kk12061206.pdf', 'Dayat2010156.png', 'card12061206.png'),
(12, '1210', 1210, 'Said', 'Laki-laki', 'Islam', 'XII', 'RPL', 'ijazah12101210.pdf', 'kk12101210.pdf', 'Said1210.png', 'card12101210.png'),
(24, '5108', 5108, 'Joko', 'Laki-laki', 'Islam', 'X', 'TKJ', 'ijazah51085108.pdf', 'kk51085108.sql', 'Joko5108.png', 'card51085108.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120906;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
