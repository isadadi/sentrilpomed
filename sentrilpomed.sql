-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24 Jan 2018 pada 02.56
-- Versi Server: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sentrilpomed`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kegiatan`
--

CREATE TABLE `tbl_kegiatan` (
  `id_kegiatan` varchar(100) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `target` int(10) NOT NULL,
  `anggaran` bigint(20) NOT NULL,
  `realisasi` int(10) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `nama_pj` varchar(255) NOT NULL,
  `realisasi_anggaran` bigint(20) NOT NULL,
  `sisa_anggaran` bigint(20) NOT NULL,
  `sisa_target` int(10) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_subkegiatan`
--

CREATE TABLE `tbl_subkegiatan` (
  `id_subkegiatan` int(9) NOT NULL,
  `id_kegiatan` varchar(100) NOT NULL,
  `tanggal_kegiatan` varchar(100) NOT NULL,
  `anggaran` bigint(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `pj_kegiatan` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` enum('terverifikasi','belum verifikasi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(9) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('superuser','admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$o1OP69dWACWX7X3wDI2QWODurGsNfpbYna5.cyhePd70m6toQ5xWq', 'superuser'),
(2, 'ibal', '$2y$10$2wck2m6e1mHfJSk/tpYKaOI04rsj26tldPPc9Uv/faJugDmkOwmxS', 'admin'),
(3, 'amel', '$2y$10$x/8hQCUjONAhnVA7dUjLoeg3SvK6eRQPaX4TwxkMskcZ/28FXWBi2', 'petugas'),
(4, 'user1', '$2y$10$CGCg.lNRKsthdIT/c4L2FearvwP6SXQwv6GaW3YQvoqUuIyMAfYBu', 'admin'),
(5, 'petugas', '$2y$10$KJjTgjlRsUBkNMXmlRyR5.7vHJziyJi99tWURM3izqAH5Y4S6AwP6', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `tbl_subkegiatan`
--
ALTER TABLE `tbl_subkegiatan`
  ADD PRIMARY KEY (`id_subkegiatan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_subkegiatan`
--
ALTER TABLE `tbl_subkegiatan`
  MODIFY `id_subkegiatan` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
