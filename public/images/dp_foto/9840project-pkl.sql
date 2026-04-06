-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pustakawan
CREATE DATABASE IF NOT EXISTS `pustakawan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pustakawan`;

-- Dumping structure for table pustakawan.barangkeluars
CREATE TABLE IF NOT EXISTS `barangkeluars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_tool` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tim` bigint unsigned NOT NULL,
  `id_tool` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barangkeluars_id_tool_foreign` (`id_tool`),
  KEY `barangkeluars_nama_tim_foreign` (`nama_tim`),
  CONSTRAINT `barangkeluars_id_tool_foreign` FOREIGN KEY (`id_tool`) REFERENCES `datapusats` (`id`),
  CONSTRAINT `barangkeluars_nama_tim_foreign` FOREIGN KEY (`nama_tim`) REFERENCES `tims` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.barangkeluars: ~0 rows (approximately)

-- Dumping structure for table pustakawan.barangmasuks
CREATE TABLE IF NOT EXISTS `barangmasuks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_tool` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tim` bigint unsigned NOT NULL,
  `id_tool` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barangmasuks_id_tool_foreign` (`id_tool`),
  KEY `barangmasuks_nama_tim_foreign` (`nama_tim`),
  CONSTRAINT `barangmasuks_id_tool_foreign` FOREIGN KEY (`id_tool`) REFERENCES `datapusats` (`id`),
  CONSTRAINT `barangmasuks_nama_tim_foreign` FOREIGN KEY (`nama_tim`) REFERENCES `tims` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.barangmasuks: ~0 rows (approximately)
INSERT INTO `barangmasuks` (`id`, `kode_tool`, `jumlah`, `tanggal_masuk`, `keterangan`, `lokasi`, `nama_tim`, `id_tool`, `created_at`, `updated_at`) VALUES
	(1, 'PJB-0001', 10, '2026-01-20', 'Pembelian', 'bandung', 1, 1, '2026-01-19 18:16:43', '2026-01-19 18:16:43');

-- Dumping structure for table pustakawan.datapusats
CREATE TABLE IF NOT EXISTS `datapusats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_tool` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tool` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.datapusats: ~0 rows (approximately)
INSERT INTO `datapusats` (`id`, `kode_tool`, `nama_tool`, `foto`, `stok`, `deskripsi`, `lokasi`, `created_at`, `updated_at`) VALUES
	(1, 'KTG-0001', 'Ground Helmet', '4433profil.jpg', '20', 'Pelindung Kepala Dari Benturan', 'bandung', '2026-01-19 18:12:44', '2026-01-19 18:34:55');

-- Dumping structure for table pustakawan.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table pustakawan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_04_29_003435_create_datapusats_table', 1),
	(6, '2025_05_26_005255_add_is_admin_to_users_table', 1),
	(7, '2026_01_20_010219_create_tims_table', 1),
	(8, '2026_01_20_010849_create_barangmasuks_table', 1),
	(9, '2026_01_20_010912_create_barangkeluars_table', 1),
	(10, '2026_01_20_010940_create_peminjamans_table', 1),
	(11, '2026_01_20_011136_create_pengembalians_table', 1);

-- Dumping structure for table pustakawan.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.password_resets: ~0 rows (approximately)

-- Dumping structure for table pustakawan.peminjamans
CREATE TABLE IF NOT EXISTS `peminjamans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pinjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_peminjam` bigint unsigned NOT NULL,
  `id_tool` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peminjamans_kode_pinjam_unique` (`kode_pinjam`),
  KEY `peminjamans_id_tool_foreign` (`id_tool`),
  KEY `peminjamans_nama_peminjam_foreign` (`nama_peminjam`),
  CONSTRAINT `peminjamans_id_tool_foreign` FOREIGN KEY (`id_tool`) REFERENCES `datapusats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjamans_nama_peminjam_foreign` FOREIGN KEY (`nama_peminjam`) REFERENCES `tims` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.peminjamans: ~1 rows (approximately)
INSERT INTO `peminjamans` (`id`, `kode_pinjam`, `jumlah`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `nama_peminjam`, `id_tool`, `created_at`, `updated_at`) VALUES
	(1, 'PJB-0001', 10, '2026-01-19', '2026-01-31', '2026-01-31', 'Sudah Dikembalikan', 1, 1, '2026-01-19 18:17:07', '2026-01-19 18:34:55');

-- Dumping structure for table pustakawan.pengembalians
CREATE TABLE IF NOT EXISTS `pengembalians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_tool` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_peminjam` bigint unsigned NOT NULL,
  `id_tool` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengembalians_id_tool_foreign` (`id_tool`),
  KEY `pengembalians_id_peminjam_foreign` (`id_peminjam`),
  CONSTRAINT `pengembalians_id_peminjam_foreign` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjamans` (`id`),
  CONSTRAINT `pengembalians_id_tool_foreign` FOREIGN KEY (`id_tool`) REFERENCES `datapusats` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.pengembalians: ~0 rows (approximately)

-- Dumping structure for table pustakawan.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table pustakawan.tims
CREATE TABLE IF NOT EXISTS `tims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_anggota_tim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_tim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemimpin_tim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_tim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.tims: ~0 rows (approximately)
INSERT INTO `tims` (`id`, `nama_anggota_tim`, `lokasi_tim`, `pemimpin_tim`, `kontak_tim`, `created_at`, `updated_at`) VALUES
	(1, 'fauzan', 'bandung', 'fauzan', '03456789', '2026-01-19 18:12:55', '2026-01-19 18:12:55');

-- Dumping structure for table pustakawan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pustakawan.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `Admin`) VALUES
	(1, 'admin', 'admin@example.com', NULL, '$2y$10$069q/8.pmlPUlvg2Rn488O4BMMdOhDTzB6xWBzfoGnjUkMp4xsps2', 1, NULL, '2026-01-19 18:12:10', '2026-01-19 18:12:10', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
