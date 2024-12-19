-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 12 Des 2024 pada 07.51
-- Versi server: 8.0.35
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectdesa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `approved_users`
--

CREATE TABLE `approved_users` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `approved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `approved_users`
--

INSERT INTO `approved_users` (`id`, `user_id`, `approved_at`) VALUES
(1, 1, '2024-09-22 19:03:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_zh_0900_as_cs NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_zh_0900_as_cs NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_zh_0900_as_cs NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8mb4_zh_0900_as_cs DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_zh_0900_as_cs DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_at` timestamp NULL DEFAULT NULL,
  `reset_token_hash` varchar(64) COLLATE utf8mb4_zh_0900_as_cs DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_zh_0900_as_cs;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `verified`, `token`, `is_admin`, `status`, `created_at`, `approved_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'superuser', 'adnanfauji48@gmail.com', '$2y$10$8DNxIQRp/PqdlVr2WdMnxORORsE4FpOo1aDA.8HOe1cwginnNULt6', 0, NULL, 1, 'approved', '2024-09-22 18:03:47', '2024-09-22 19:02:52', NULL, NULL),
(21, 'fauji', 'fauziyahadnan31@gmail.com', '$2y$10$MaOMHYs16mGiZFNfdQgZXuGCbB95Heoj3orSGIuBxPT10Md/izGlG', 0, NULL, 0, 'pending', '2024-11-11 07:10:22', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `approved_users`
--
ALTER TABLE `approved_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `approved_users`
--
ALTER TABLE `approved_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `approved_users`
--
ALTER TABLE `approved_users`
  ADD CONSTRAINT `approved_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
