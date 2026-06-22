-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dw_retail_online
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dim_pelanggan`
--

DROP TABLE IF EXISTS `dim_pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dim_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `kota` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_pelanggan`
--

LOCK TABLES `dim_pelanggan` WRITE;
/*!40000 ALTER TABLE `dim_pelanggan` DISABLE KEYS */;
INSERT INTO `dim_pelanggan` VALUES (1,'PLG001','Budi Santoso','L','Surabaya'),(2,'PLG002','Siti Aisyah','P','Sidoarjo'),(3,'PLG003','Agus Wijaya','L','Malang'),(4,'PLG004','Dewi Lestari','P','Gresik'),(5,'PLG005','Rizky Pratama','L','Mojokerto');
/*!40000 ALTER TABLE `dim_pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_produk`
--

DROP TABLE IF EXISTS `dim_produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dim_produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_produk`
--

LOCK TABLES `dim_produk` WRITE;
/*!40000 ALTER TABLE `dim_produk` DISABLE KEYS */;
INSERT INTO `dim_produk` VALUES (1,'PRD001','Laptop Asus','Elektronik',8500000.00),(2,'PRD002','Mouse Wireless','Aksesoris',150000.00),(3,'PRD003','Keyboard Mechanical','Aksesoris',750000.00),(4,'PRD004','Kaos Polos','Pakaian',90000.00),(5,'PRD005','Headset Gaming','Elektronik',350000.00);
/*!40000 ALTER TABLE `dim_produk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim_waktu`
--

DROP TABLE IF EXISTS `dim_waktu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dim_waktu` (
  `id_waktu` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `tahun` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `bulan_nama` varchar(20) NOT NULL,
  `kuartal` int(11) NOT NULL,
  PRIMARY KEY (`id_waktu`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim_waktu`
--

LOCK TABLES `dim_waktu` WRITE;
/*!40000 ALTER TABLE `dim_waktu` DISABLE KEYS */;
INSERT INTO `dim_waktu` VALUES (1,'2025-01-15',2025,1,'Januari',1),(2,'2025-02-20',2025,2,'Februari',1),(3,'2025-03-10',2025,3,'Maret',1),(4,'2025-04-05',2025,4,'April',2),(5,'2025-05-12',2025,5,'Mei',2);
/*!40000 ALTER TABLE `dim_waktu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fact_penjualan`
--

DROP TABLE IF EXISTS `fact_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fact_penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_waktu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_penjualan`),
  KEY `id_produk` (`id_produk`),
  KEY `id_pelanggan` (`id_pelanggan`),
  KEY `id_waktu` (`id_waktu`),
  CONSTRAINT `fact_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `dim_produk` (`id_produk`),
  CONSTRAINT `fact_penjualan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `dim_pelanggan` (`id_pelanggan`),
  CONSTRAINT `fact_penjualan_ibfk_3` FOREIGN KEY (`id_waktu`) REFERENCES `dim_waktu` (`id_waktu`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fact_penjualan`
--

LOCK TABLES `fact_penjualan` WRITE;
/*!40000 ALTER TABLE `fact_penjualan` DISABLE KEYS */;
INSERT INTO `fact_penjualan` VALUES (1,1,1,1,1,8500000.00,8500000.00),(2,2,2,2,2,150000.00,300000.00),(3,3,3,3,1,750000.00,750000.00),(4,4,4,4,3,90000.00,270000.00),(5,5,5,5,2,350000.00,700000.00),(6,1,2,1,1,8500000.00,8500000.00),(7,2,3,2,4,150000.00,600000.00),(8,3,4,3,2,750000.00,1500000.00),(9,4,5,4,5,90000.00,450000.00),(10,5,1,5,1,350000.00,350000.00);
/*!40000 ALTER TABLE `fact_penjualan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-17 20:08:53
