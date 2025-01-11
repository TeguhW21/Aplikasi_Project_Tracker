-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2025 pada 10.22
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project_task`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('draft','in_progress','done') DEFAULT 'draft',
  `completion_progress` float DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `name`, `status`, `completion_progress`, `created_at`, `updated_at`) VALUES
(1, 'Project ke-1', 'in_progress', 66.6667, '2025-01-11 11:54:34', '2025-01-11 15:28:57'),
(2, 'Project ke-2', 'draft', 0, '2025-01-11 12:45:36', '2025-01-11 12:45:36'),
(3, 'Project ke-3', 'draft', 0, '2025-01-11 12:46:23', '2025-01-11 12:46:23'),
(4, 'Project ke-4', 'draft', 0, '2025-01-11 12:47:55', '2025-01-11 12:47:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('draft','in_progress','done') DEFAULT 'draft',
  `project_id` int(11) NOT NULL,
  `bobot` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `status`, `project_id`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 'Task 2', 'done', 1, 2, '2025-01-11 11:55:07', '2025-01-11 15:28:56'),
(2, 'Task 1', 'in_progress', 1, 1, '2025-01-11 13:06:57', '2025-01-11 15:28:34'),
(3, 'Task 1', 'draft', 2, 1, '2025-01-11 14:08:35', '2025-01-11 15:21:16'),
(4, 'Task 2', 'draft', 2, 1, '2025-01-11 14:13:02', '2025-01-11 15:21:19'),
(6, 'Task 1', 'draft', 3, 1, '2025-01-11 14:35:11', '2025-01-11 14:35:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
