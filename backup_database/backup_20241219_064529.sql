-- MySQL dump 10.13  Distrib 8.0.35, for Win64 (x86_64)
--
-- Host: localhost    Database: projectdesa
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email_admin` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_tlp_admin` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email_admin` (`email_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approved_users`
--

DROP TABLE IF EXISTS `approved_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approved_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `approved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `approved_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approved_users`
--

LOCK TABLES `approved_users` WRITE;
/*!40000 ALTER TABLE `approved_users` DISABLE KEYS */;
INSERT INTO `approved_users` VALUES (1,1,'2024-09-22 19:03:26');
/*!40000 ALTER TABLE `approved_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulir`
--

DROP TABLE IF EXISTS `formulir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulir` (
  `id_formulir` int NOT NULL AUTO_INCREMENT,
  `id_pengajuan` int NOT NULL,
  `tipe_formulir` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `judul_formulir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_formulir` date NOT NULL,
  PRIMARY KEY (`id_formulir`),
  KEY `id_pengajuan` (`id_pengajuan`),
  CONSTRAINT `formulir_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id_pengajuan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulir`
--

LOCK TABLES `formulir` WRITE;
/*!40000 ALTER TABLE `formulir` DISABLE KEYS */;
INSERT INTO `formulir` VALUES (1,1,'Permohonan Pembuatan Kartu Keluarga','Formulir Permohonan KK','2024-12-17'),(2,2,'Permohonan Pembuatan Kartu Keluarga','Formulir Permohonan KK','2024-12-18'),(3,3,'Permohonan Pembuatan Kartu Keluarga','Formulir Permohonan KK','2024-12-18'),(4,4,'Permohonan Pembuatan Kartu Keluarga','Formulir Permohonan KK','2024-12-18'),(5,5,'Permohonan Pembuatan Surat Keterangan Pindah','Formulir Permohonan Pindah','2024-12-18'),(6,10,'Permohonan Pembuatan Surat Keterangan Pindah','Formulir Permohonan Pindah','2024-12-28'),(7,11,'Permohonan Pembuatan Surat Keterangan Pindah','Formulir Permohonan Pindah','2024-12-19');
/*!40000 ALTER TABLE `formulir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan` (
  `id_laporan` int NOT NULL AUTO_INCREMENT,
  `id_formulir` int NOT NULL,
  `judul_laporan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_laporan` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_laporan` date NOT NULL,
  PRIMARY KEY (`id_laporan`),
  KEY `fk_formulir_laporan` (`id_formulir`),
  CONSTRAINT `fk_formulir_laporan` FOREIGN KEY (`id_formulir`) REFERENCES `formulir` (`id_formulir`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan`
--

LOCK TABLES `laporan` WRITE;
/*!40000 ALTER TABLE `laporan` DISABLE KEYS */;
INSERT INTO `laporan` VALUES (1,7,'Formulir Permohonan Pindah','Permohonan Pembuatan Surat Keterangan Pindah atas nama Balqis','2024-12-19');
/*!40000 ALTER TABLE `laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layanan`
--

DROP TABLE IF EXISTS `layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanan` (
  `id_layanan` int NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_layanan` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanan`
--

LOCK TABLES `layanan` WRITE;
/*!40000 ALTER TABLE `layanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pending_users`
--

DROP TABLE IF EXISTS `pending_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pending_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pending_users`
--

LOCK TABLES `pending_users` WRITE;
/*!40000 ALTER TABLE `pending_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `pending_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penduduk`
--

DROP TABLE IF EXISTS `penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penduduk` (
  `nik_penduduk` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_kk` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_penduduk` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_penduduk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_tlp_penduduk` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`nik_penduduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penduduk`
--

LOCK TABLES `penduduk` WRITE;
/*!40000 ALTER TABLE `penduduk` DISABLE KEYS */;
INSERT INTO `penduduk` VALUES ('3209254601930001','3215293008160007','Balqis Taqiya Sayida','P','2015-07-28','Perum Purwasari-Karawang','Pantai-Kuta-Bali-beach-dede.png','0895353086063'),('3209254601930002','3215293008160007','Fauziyah','P','1993-01-30','Perum Purwasari Regency Blok J No. 3\r\nDesa Purwasari Kec. Purwasari Kab. Karawang','Bunda.jpg','0895353086063'),('3215160408860003','3215293008160007','Adnan Fauji','L','1986-08-04','Perum Purwasari Regency Blok J No. 3\r\nDesa Purwasari Kec. Purwasari Kab. Karawang','Tugas-1-Adnan Fauji.jpg','08988924241');
/*!40000 ALTER TABLE `penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajuan`
--

DROP TABLE IF EXISTS `pengajuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengajuan` (
  `id_pengajuan` int NOT NULL AUTO_INCREMENT,
  `nik_penduduk` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status_pengajuan` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  PRIMARY KEY (`id_pengajuan`),
  KEY `nik_penduduk` (`nik_penduduk`),
  CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`nik_penduduk`) REFERENCES `penduduk` (`nik_penduduk`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajuan`
--

LOCK TABLES `pengajuan` WRITE;
/*!40000 ALTER TABLE `pengajuan` DISABLE KEYS */;
INSERT INTO `pengajuan` VALUES (1,'3215160408860003','2024-12-17','approved'),(2,'3209254601930002','2024-12-18','approved'),(3,'3209254601930002','2024-12-18','rejected'),(4,'3209254601930002','2024-12-18','approved'),(5,'3209254601930002','2024-12-18','approved'),(6,'3209254601930001','2024-12-19','pending'),(7,'3209254601930001','2024-12-19','pending'),(8,'3209254601930001','2024-12-19','pending'),(9,'3209254601930001','2024-12-19','pending'),(10,'3209254601930001','2024-12-19','pending'),(11,'3209254601930001','2024-12-19','pending');
/*!40000 ALTER TABLE `pengajuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sekretaris_desa`
--

DROP TABLE IF EXISTS `sekretaris_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sekretaris_desa` (
  `id_sekretaris` int NOT NULL AUTO_INCREMENT,
  `nama_sekretaris` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email_sekretaris` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_tlp_sekretaris` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto_sekretaris` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_sekretaris`),
  UNIQUE KEY `email_sekretaris` (`email_sekretaris`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sekretaris_desa`
--

LOCK TABLES `sekretaris_desa` WRITE;
/*!40000 ALTER TABLE `sekretaris_desa` DISABLE KEYS */;
/*!40000 ALTER TABLE `sekretaris_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat`
--

DROP TABLE IF EXISTS `surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat` (
  `id_surat` int NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `judul_surat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_surat` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  PRIMARY KEY (`id_surat`),
  UNIQUE KEY `nomor_surat` (`nomor_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat`
--

LOCK TABLES `surat` WRITE;
/*!40000 ALTER TABLE `surat` DISABLE KEYS */;
/*!40000 ALTER TABLE `surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `reset_token_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_zh_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'superuser','adnanfauji48@gmail.com','$2y$10$8DNxIQRp/PqdlVr2WdMnxORORsE4FpOo1aDA.8HOe1cwginnNULt6',0,NULL,1,'approved','2024-09-22 18:03:47','2024-09-22 19:02:52',NULL,NULL),(21,'fauji','fauziyahadnan31@gmail.com','$2y$10$HDDYI7XUYiIfD0323.Nw.enun8pZfkmKVjVDJIujQBo2Y2HYYzNde',0,NULL,0,'pending','2024-11-11 07:10:22',NULL,NULL,NULL),(25,'user','adnan.fauji.fict@krw.horizon.ac.id','29b93dc1c4096882b2c7e2673ae2ce3e',0,NULL,0,'pending','2024-12-15 04:45:16',NULL,'a88b337f790fa5039a94068fe446608bd62dcb813b3eebf3634fa9f32994948a','2024-12-15 13:37:50');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-19 13:45:30
