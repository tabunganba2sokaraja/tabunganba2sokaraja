-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2025 pada 11.00
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tab_paud`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_tabungan`
--

CREATE TABLE `riwayat_tabungan` (
  `id_riwayat` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `saldo_akhir` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_pembuatan` datetime NOT NULL,
  `status_riwayat` enum('aktif','diblokir','ditutup') NOT NULL DEFAULT 'aktif',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `riwayat_tabungan`
--

INSERT INTO `riwayat_tabungan` (`id_riwayat`, `id_siswa`, `saldo_akhir`, `tanggal_pembuatan`, `status_riwayat`, `updated_at`) VALUES
(8, 16, '8000.00', '2025-06-16 08:47:22', 'aktif', '2025-06-16 08:41:57'),
(9, 17, '910.00', '2025-06-16 08:47:59', 'aktif', '2025-06-16 08:02:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_lengkap` varchar(128) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `nama_orang_tua` varchar(128) DEFAULT NULL,
  `kontak_orang_tua` varchar(20) DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `status_siswa` enum('Aktif','Lulus','Pindah','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama_lengkap`, `kelas`, `nama_orang_tua`, `kontak_orang_tua`, `tanggal_daftar`, `status_siswa`, `created_at`) VALUES
(16, '12341231234', 'Anggit Romadhon', '12.5A.21', 'sapa baen', '0890009888', '2025-06-16', 'Lulus', '2025-06-16 06:47:22'),
(17, '12341231235', 'Kholif Anam S', '12.5A.21', 'pak.Jarwo', '08587666666', '2025-06-16', 'Pindah', '2025-06-16 06:47:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_tabungan`
--

CREATE TABLE `transaksi_tabungan` (
  `id_transaksi` int(11) NOT NULL,
  `id_riwayat` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `aksi` enum('tambah','kurang') NOT NULL,
  `jenis_transaksi` enum('tambah','kurang') NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `saldo_sebelum` decimal(15,2) NOT NULL,
  `saldo_sesudah` decimal(15,2) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL,
  `dicatat_oleh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_tabungan`
--

INSERT INTO `transaksi_tabungan` (`id_transaksi`, `id_riwayat`, `id_siswa`, `aksi`, `jenis_transaksi`, `jumlah`, `saldo_sebelum`, `saldo_sesudah`, `tanggal_transaksi`, `keterangan`, `dicatat_oleh`) VALUES
(111119, 8, 16, 'tambah', '', '10000.00', '0.00', '10000.00', '2025-06-16 10:01:39', 'p', NULL),
(111120, 8, 16, 'tambah', '', '10.00', '10000.00', '10010.00', '2025-06-16 10:01:50', 'p', NULL),
(111121, 9, 17, 'tambah', '', '10.00', '0.00', '10.00', '2025-06-16 10:02:15', 'p', NULL),
(111122, 9, 17, 'tambah', '', '900.00', '10.00', '910.00', '2025-06-16 10:02:26', '', NULL),
(111124, 8, 16, 'tambah', '', '10.00', '10010.00', '10000.00', '2025-06-16 10:41:41', 'p', NULL),
(111125, 8, 16, 'tambah', '', '2000.00', '10000.00', '8000.00', '2025-06-16 10:41:57', 'p', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(5) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `image`, `password`, `role_id`, `is_active`, `date`) VALUES
(4, 'Dimas Palldinofa Wahyu Ramadhan', 'dimasp@gmail.com', 'default.jpg', '$2y$10$jbpuGs9RD9GQas7.8FARruFYlTBMokfX2MYgyzYiwrLWU9xpyvECS', 1, 1, 1749147263),
(5, 'Anggit Romadhon', 'anggit@email.com', 'default.jpg', '$2y$10$Tg3vYnKx9g4yFt1qJk5Wkeg.61u28uOhJA40yiUDNEhlBn.vLJ1Qm', 2, 1, 1749219419);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fa-solid fa-fw fa-circle-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fa-solid fa-user-pen', 1),
(6, 1, 'Manajemen Siswa', 'siswa', 'fa-solid fa-users', 1),
(7, 1, 'Manajemen Tabungan', 'tabungan', 'fa-solid fa-money-bill-wave', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `riwayat_tabungan`
--
ALTER TABLE `riwayat_tabungan`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD UNIQUE KEY `id_siswa_unik` (`id_siswa`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_rekening` (`id_riwayat`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `riwayat_tabungan`
--
ALTER TABLE `riwayat_tabungan`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111126;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
