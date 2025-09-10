-- MySQL dump 10.13  Distrib 9.3.0, for macos14.7 (x86_64)
--
-- Host: localhost    Database: cotizador_seguros
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usd_cop_rate` decimal(12,4) NOT NULL DEFAULT '4000.0000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
INSERT INTO `app_settings` VALUES (1,4400.0000,'2025-09-04 19:02:38','2025-09-04 19:21:40');
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aseguradoras`
--

DROP TABLE IF EXISTS `aseguradoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aseguradoras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aseguradoras`
--

LOCK TABLES `aseguradoras` WRITE;
/*!40000 ALTER TABLE `aseguradoras` DISABLE KEYS */;
INSERT INTO `aseguradoras` VALUES (1,'TAS','logos-aseguradoras/01K4B3B1K15C43EZ5WCJ2R2ZH0.JPG',1,'2025-08-26 22:51:08','2025-09-05 00:30:30'),(2,'TERRAWIND',NULL,1,'2025-08-26 22:51:28','2025-08-26 22:51:28'),(3,'PERVOLARE',NULL,1,'2025-08-26 22:51:48','2025-08-26 22:51:48'),(4,'ASSISTVIAJE',NULL,1,'2025-08-26 22:51:53','2025-08-26 22:51:53'),(5,'ATM',NULL,1,'2025-08-26 23:00:28','2025-08-26 23:00:28'),(8,'AXA Colpatria',NULL,1,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(9,'pepe','logos-aseguradoras/01K4FT6J8M7YQFC8SHMZ9FM8HA.png',1,'2025-09-06 20:26:58','2025-09-06 20:26:58');
/*!40000 ALTER TABLE `aseguradoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacions`
--

DROP TABLE IF EXISTS `cotizacions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizacions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `destino_id` bigint unsigned NOT NULL,
  `tipo_viaje_id` bigint unsigned NOT NULL,
  `pais_origen` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CO',
  `fecha_salida` date NOT NULL,
  `fecha_regreso` date NOT NULL,
  `correo_contacto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pasajeros` json DEFAULT NULL,
  `origen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cotizacions_destino_id_foreign` (`destino_id`),
  KEY `cotizacions_tipo_viaje_id_foreign` (`tipo_viaje_id`),
  CONSTRAINT `cotizacions_destino_id_foreign` FOREIGN KEY (`destino_id`) REFERENCES `destinos` (`id`),
  CONSTRAINT `cotizacions_tipo_viaje_id_foreign` FOREIGN KEY (`tipo_viaje_id`) REFERENCES `tipo_viajes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacions`
--

LOCK TABLES `cotizacions` WRITE;
/*!40000 ALTER TABLE `cotizacions` DISABLE KEYS */;
INSERT INTO `cotizacions` VALUES (1,1,1,'CO','2025-09-03','2025-09-18','davidbarrera75@gmail.com','3208045506','2025-09-03 02:26:53','2025-09-03 02:26:53',NULL,NULL),(2,1,1,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-03 03:35:57','2025-09-03 03:35:57',NULL,NULL),(3,1,1,'CO','2025-09-03','2025-09-06','davidbarrera75@gmail.com','3208045506','2025-09-03 03:42:24','2025-09-03 03:42:24',NULL,NULL),(4,1,1,'CO','2025-09-03','2025-09-12','davidbarrera75@gmail.com','3208045506','2025-09-03 03:53:19','2025-09-03 03:53:19',NULL,NULL),(5,1,3,'CO','2025-09-04','2025-09-12','davidbarrera75@gmail.com','3208045506','2025-09-03 03:59:52','2025-09-03 03:59:52',NULL,NULL),(6,2,3,'CO','2025-09-03','2025-09-05','albamilenaarboleda01@gmail.com','3208045506','2025-09-03 04:01:39','2025-09-03 04:01:39',NULL,NULL),(7,1,1,'CO','2025-09-03','2025-09-06','davidbarrera75@gmail.com','3208045506','2025-09-03 04:03:05','2025-09-03 04:03:05',NULL,NULL),(8,1,2,'CO','2025-09-02','2025-09-03','davidbarrera75@gmail.com','3208045506','2025-09-03 04:09:51','2025-09-03 04:09:51',NULL,NULL),(9,1,1,'CO','2025-09-02','2025-09-03','davidbarrera75@gmail.com','3208045506','2025-09-03 04:15:22','2025-09-03 04:15:22',NULL,NULL),(10,9,6,'CO','2025-09-03','2025-09-04','davidbarrera75@gmail.com','3208045506','2025-09-03 04:25:05','2025-09-03 04:25:05',NULL,NULL),(11,2,2,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-03 04:26:38','2025-09-03 04:26:38',NULL,NULL),(12,1,1,'CO','2025-09-03','2025-09-04','albamilenaarboleda01@gmail.com','3208045506','2025-09-03 04:53:26','2025-09-03 04:53:26',NULL,NULL),(13,1,1,'CO','2025-09-03','2025-09-04','davidbarrera75@gmail.com','3208045506','2025-09-03 04:58:53','2025-09-03 04:58:53',NULL,NULL),(14,1,2,'CO','2025-09-04','2025-09-06','albamilenaarboleda01@gmail.com','3208045506','2025-09-03 05:02:19','2025-09-03 05:02:19',NULL,NULL),(15,1,3,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-03 17:12:44','2025-09-03 17:12:44',NULL,NULL),(17,2,1,'CO','2025-09-03','2025-09-06','albamilenaarboleda01@gmail.com','3012547001','2025-09-03 17:26:14','2025-09-03 17:26:14',NULL,NULL),(18,1,1,'CO','2025-09-04','2025-09-06','davidbarrera75@gmail.com','3208045506','2025-09-03 20:09:27','2025-09-03 20:09:27',NULL,NULL),(19,1,1,'CO','2025-09-04','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-03 21:03:23','2025-09-03 21:03:23',NULL,NULL),(20,1,1,'CO','2025-09-03','2025-09-04','davidbarrera75@gmail.com','3208045506','2025-09-03 21:11:13','2025-09-03 21:11:13',NULL,NULL),(21,1,1,'CO','2025-09-03','2025-09-04','albamilenaarboleda01@gmail.com','3012547001','2025-09-03 21:20:07','2025-09-03 21:20:07',NULL,NULL),(22,1,1,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-03 23:01:23','2025-09-03 23:01:23',NULL,NULL),(23,1,1,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3012547001','2025-09-03 23:12:48','2025-09-03 23:12:48',NULL,NULL),(24,1,1,'CO','2025-09-03','2025-09-05','albamilenaarboleda01@gmail.com','3012547001','2025-09-03 23:39:49','2025-09-03 23:39:49',NULL,NULL),(25,1,1,'CO','2025-09-04','2025-09-06','davidbarrera75@gmail.com','3208045506','2025-09-04 02:09:18','2025-09-04 02:09:18',NULL,'Colombia'),(26,1,1,'CO','2025-09-03','2025-09-05','davidbarrera75@gmail.com','3208045506','2025-09-04 02:19:06','2025-09-04 02:19:06',NULL,'Colombia'),(27,1,1,'CO','2025-09-04','2025-09-05','hospedajepinares@hotmail.com','3136468132','2025-09-04 05:22:06','2025-09-04 05:22:06',NULL,'Colombia'),(28,1,1,'CO','2025-09-04','2025-09-07','hospedajepinares@hotmail.com','3136468132','2025-09-04 18:34:17','2025-09-04 18:34:17',NULL,'Colombia'),(29,1,2,'CO','2025-09-04','2025-09-07','juanitaqw@gmail.com','3118266782','2025-09-04 18:37:24','2025-09-04 18:37:24',NULL,'Colombia'),(30,1,1,'AR','2025-09-04','2025-09-06','juanitaqw@gmail.com','3104237617','2025-09-04 19:22:16','2025-09-04 19:22:16',NULL,'Argentina'),(31,1,3,'AR','2025-09-04','2025-09-07','alonsoibiza@hotmail.com','3104237617','2025-09-04 19:22:41','2025-09-04 19:22:41',NULL,'Argentina'),(32,1,1,'CO','2025-09-04','2025-09-06','mateomercurio@gmail.com','3118266782','2025-09-04 20:05:12','2025-09-04 20:05:12',NULL,'Colombia'),(33,1,1,'AR','2025-09-04','2025-09-07','pymebogot@gmail.com','3208045506','2025-09-04 20:06:15','2025-09-04 20:06:15',NULL,'Argentina'),(34,2,3,'CO','2025-09-04','2025-09-06','mateomercurio@gmail.com','3118266782','2025-09-04 20:24:43','2025-09-04 20:24:43',NULL,'Colombia'),(35,1,1,'CO','2025-09-04','2025-09-07','pymebogota@gmail.com','3208045506','2025-09-05 00:06:08','2025-09-05 00:06:08',NULL,'Colombia'),(36,1,1,'AR','2025-09-04','2025-09-07','pymebogota@gmail.com','3208045506','2025-09-05 01:56:49','2025-09-05 01:56:49',NULL,'Argentina'),(37,1,1,'CO','2025-09-04','2025-09-07','juanitaqw@gmail.com','3136468132','2025-09-05 02:54:41','2025-09-05 02:54:41',NULL,'Colombia'),(38,1,1,'CO','2025-09-06','2025-09-09','juanitaqw@gmail.com','3208045506','2025-09-05 03:51:09','2025-09-05 03:51:09',NULL,'Colombia'),(39,1,1,'BO','2025-09-06','2025-09-14','mateomercurio@gmail.com','3118266782','2025-09-06 17:53:52','2025-09-06 17:53:52',NULL,'Bolivia'),(40,1,1,'CL','2025-09-06','2025-09-13','juanitaqw@gmail.com','3104237617','2025-09-06 19:59:32','2025-09-06 19:59:32',NULL,'Chile'),(41,2,3,'AR','2025-09-06','2025-09-07','juanitaqw@gmail.com','3136468132','2025-09-06 20:20:50','2025-09-06 20:20:50',NULL,'Argentina'),(42,2,3,'CO','2025-09-06','2025-09-07','mateomercurio@gmail.com','3118266782','2025-09-06 20:22:40','2025-09-06 20:22:40',NULL,'Colombia'),(43,2,2,'AR','2025-09-06','2025-09-07','alonsoibiza@hotmail.com','3104237617','2025-09-06 20:27:43','2025-09-06 20:27:43',NULL,'Argentina');
/*!40000 ALTER TABLE `cotizacions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizador_settings`
--

DROP TABLE IF EXISTS `cotizador_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizador_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizador_settings`
--

LOCK TABLES `cotizador_settings` WRITE;
/*!40000 ALTER TABLE `cotizador_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `cotizador_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destino_plan`
--

DROP TABLE IF EXISTS `destino_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destino_plan` (
  `destino_id` bigint unsigned NOT NULL,
  `plan_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`destino_id`,`plan_id`),
  KEY `destino_plan_plan_id_foreign` (`plan_id`),
  CONSTRAINT `destino_plan_destino_id_foreign` FOREIGN KEY (`destino_id`) REFERENCES `destinos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `destino_plan_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destino_plan`
--

LOCK TABLES `destino_plan` WRITE;
/*!40000 ALTER TABLE `destino_plan` DISABLE KEYS */;
INSERT INTO `destino_plan` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(1,4),(2,4),(3,4),(4,4),(5,4),(6,4),(7,4),(8,4),(9,4),(10,4),(11,4),(12,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(9,5),(10,5),(11,5),(12,5),(1,6),(2,6),(3,6),(4,6),(5,6),(6,6),(7,6),(8,6),(9,6),(10,6),(11,6),(12,6),(3,7),(6,7),(10,7),(11,7);
/*!40000 ALTER TABLE `destino_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinos`
--

DROP TABLE IF EXISTS `destinos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinos`
--

LOCK TABLES `destinos` WRITE;
/*!40000 ALTER TABLE `destinos` DISABLE KEYS */;
INSERT INTO `destinos` VALUES (1,'SUR AMERICA',1,'2025-08-26 22:54:15','2025-08-26 22:54:15'),(2,'NORTE AMERICA',1,'2025-08-26 22:54:44','2025-08-26 22:54:44'),(3,'CENTRO AMERICA - CARIBE',1,'2025-08-26 22:54:54','2025-08-26 22:54:54'),(4,'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS',1,'2025-08-26 22:55:05','2025-08-26 22:55:05'),(5,'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO',1,'2025-08-26 22:55:14','2025-08-26 22:55:14'),(6,'COLOMBIA',1,'2025-08-26 22:55:21','2025-08-26 22:55:21'),(7,'COBERTURA NACIONAL',1,'2025-08-26 22:55:29','2025-08-26 22:55:29'),(8,'RECEPTIVO COLOMBIA PARA EXTRANJEROS',1,'2025-08-26 22:55:36','2025-08-26 22:55:36'),(9,'Estados Unidos',1,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(10,'Europa',1,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(11,'Latinoamérica',1,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(12,'Asia',1,'2025-09-03 04:22:20','2025-09-03 04:22:20');
/*!40000 ALTER TABLE `destinos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"01027f31-a2ba-433d-a573-18f5745b5fef\",\"displayName\":\"Maatwebsite\\\\Excel\\\\Jobs\\\\QueueExport\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Maatwebsite\\\\Excel\\\\Jobs\\\\QueueExport\",\"command\":\"O:34:\\\"Maatwebsite\\\\Excel\\\\Jobs\\\\QueueExport\\\":12:{s:6:\\\"export\\\";O:25:\\\"App\\\\Imports\\\\TarifasImport\\\":4:{s:6:\\\"planId\\\";i:2;s:6:\\\"dryRun\\\";b:0;s:7:\\\"maxRows\\\";i:10000;s:6:\\\"report\\\";a:6:{s:9:\\\"processed\\\";i:0;s:5:\\\"valid\\\";i:0;s:8:\\\"imported\\\";i:0;s:7:\\\"skipped\\\";i:0;s:6:\\\"errors\\\";i:0;s:8:\\\"messages\\\";a:0:{}}}s:46:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\QueueExport\\u0000writerType\\\";s:3:\\\"Csv\\\";s:49:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\QueueExport\\u0000temporaryFile\\\";O:42:\\\"Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\\":1:{s:52:\\\"\\u0000Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\u0000filePath\\\";s:136:\\\"\\/Users\\/davidbarrera\\/Descargas\\/cotizador-seguros\\/storage\\/framework\\/cache\\/laravel-excel\\/laravel-excel-CVYofltSxr4VIcJBK9snwgDRnSqMtMOh.csv\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:7:\\\"default\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:3:{i:0;s:945:\\\"O:33:\\\"Maatwebsite\\\\Excel\\\\Jobs\\\\CloseSheet\\\":13:{s:46:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\CloseSheet\\u0000sheetExport\\\";O:25:\\\"App\\\\Imports\\\\TarifasImport\\\":4:{s:6:\\\"planId\\\";i:2;s:6:\\\"dryRun\\\";b:0;s:7:\\\"maxRows\\\";i:10000;s:6:\\\"report\\\";a:6:{s:9:\\\"processed\\\";i:0;s:5:\\\"valid\\\";i:0;s:8:\\\"imported\\\";i:0;s:7:\\\"skipped\\\";i:0;s:6:\\\"errors\\\";i:0;s:8:\\\"messages\\\";a:0:{}}}s:48:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\CloseSheet\\u0000temporaryFile\\\";O:42:\\\"Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\\":1:{s:52:\\\"\\u0000Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\u0000filePath\\\";s:136:\\\"\\/Users\\/davidbarrera\\/Descargas\\/cotizador-seguros\\/storage\\/framework\\/cache\\/laravel-excel\\/laravel-excel-CVYofltSxr4VIcJBK9snwgDRnSqMtMOh.csv\\\";}s:45:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\CloseSheet\\u0000writerType\\\";s:3:\\\"Csv\\\";s:45:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\CloseSheet\\u0000sheetIndex\\\";i:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\\\";i:1;s:850:\\\"O:40:\\\"Maatwebsite\\\\Excel\\\\Jobs\\\\StoreQueuedExport\\\":13:{s:50:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\StoreQueuedExport\\u0000filePath\\\";s:99:\\\"\\/Users\\/davidbarrera\\/Descargas\\/cotizador-seguros\\/storage\\/app\\/private\\/imports\\/tarifas\\/ATM-tarifas.csv\\\";s:46:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\StoreQueuedExport\\u0000disk\\\";N;s:55:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\StoreQueuedExport\\u0000temporaryFile\\\";O:42:\\\"Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\\":1:{s:52:\\\"\\u0000Maatwebsite\\\\Excel\\\\Files\\\\LocalTemporaryFile\\u0000filePath\\\";s:136:\\\"\\/Users\\/davidbarrera\\/Descargas\\/cotizador-seguros\\/storage\\/framework\\/cache\\/laravel-excel\\/laravel-excel-CVYofltSxr4VIcJBK9snwgDRnSqMtMOh.csv\\\";}s:53:\\\"\\u0000Maatwebsite\\\\Excel\\\\Jobs\\\\StoreQueuedExport\\u0000diskOptions\\\";a:0:{}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\\\";i:2;s:2357:\\\"O:34:\\\"Illuminate\\\\Queue\\\\CallQueuedClosure\\\":1:{s:7:\\\"closure\\\";O:47:\\\"Laravel\\\\SerializableClosure\\\\SerializableClosure\\\":1:{s:12:\\\"serializable\\\";O:46:\\\"Laravel\\\\SerializableClosure\\\\Serializers\\\\Signed\\\":2:{s:12:\\\"serializable\\\";s:2067:\\\"O:46:\\\"Laravel\\\\SerializableClosure\\\\Serializers\\\\Native\\\":5:{s:3:\\\"use\\\";a:1:{s:3:\\\"log\\\";O:26:\\\"App\\\\Models\\\\TarifaImportLog\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:18:\\\"tarifa_import_logs\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:7:\\\"plan_id\\\";i:2;s:7:\\\"user_id\\\";i:2;s:8:\\\"filename\\\";s:15:\\\"ATM-tarifas.csv\\\";s:6:\\\"status\\\";s:6:\\\"queued\\\";s:10:\\\"updated_at\\\";s:19:\\\"2025-09-04 13:32:54\\\";s:10:\\\"created_at\\\";s:19:\\\"2025-09-04 13:32:54\\\";s:2:\\\"id\\\";i:1;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:7:\\\"plan_id\\\";i:2;s:7:\\\"user_id\\\";i:2;s:8:\\\"filename\\\";s:15:\\\"ATM-tarifas.csv\\\";s:6:\\\"status\\\";s:6:\\\"queued\\\";s:10:\\\"updated_at\\\";s:19:\\\"2025-09-04 13:32:54\\\";s:10:\\\"created_at\\\";s:19:\\\"2025-09-04 13:32:54\\\";s:2:\\\"id\\\";i:1;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:6:{s:9:\\\"processed\\\";s:3:\\\"int\\\";s:5:\\\"valid\\\";s:3:\\\"int\\\";s:8:\\\"imported\\\";s:3:\\\"int\\\";s:7:\\\"skipped\\\";s:3:\\\"int\\\";s:6:\\\"errors\\\";s:3:\\\"int\\\";s:8:\\\"messages\\\";s:5:\\\"array\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:10:{i:0;s:7:\\\"plan_id\\\";i:1;s:7:\\\"user_id\\\";i:2;s:8:\\\"filename\\\";i:3;s:9:\\\"processed\\\";i:4;s:5:\\\"valid\\\";i:5;s:8:\\\"imported\\\";i:6;s:7:\\\"skipped\\\";i:7;s:6:\\\"errors\\\";i:8;s:8:\\\"messages\\\";i:9;s:6:\\\"status\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:8:\\\"function\\\";s:135:\\\"function () use ($log) {\\n                                    $log->update([\'status\' => \'processed\']);\\n                                }\\\";s:5:\\\"scope\\\";s:50:\\\"App\\\\Filament\\\\Resources\\\\PlanResource\\\\Pages\\\\EditPlan\\\";s:4:\\\"this\\\";N;s:4:\\\"self\\\";s:32:\\\"00000000000009290000000000000000\\\";}\\\";s:4:\\\"hash\\\";s:44:\\\"pGzzLWazmJ0sbmeHO915\\/R4PWeMVlGmGSnCa5\\/Wo11I=\\\";}}}\\\";}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";s:7:\\\"default\\\";s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1756992774,\"delay\":null}',0,NULL,1756992774,1756992774);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_05_144441_create_tipo_viajes_table',1),(5,'2025_07_05_160305_create_destinos_table',1),(6,'2025_07_05_161044_create_plans_table',1),(7,'2025_07_05_161358_create_destino_plan_table',1),(8,'2025_07_05_161441_create_plan_tipo_viaje_table',1),(9,'2025_07_05_164703_create_tarifas_table',1),(10,'2025_07_05_182454_create_aseguradoras_table',1),(11,'2025_07_05_183739_add_aseguradora_id_to_planes_table',1),(12,'2025_07_05_192722_create_cotizacions_table',1),(13,'2025_07_05_221035_create_pasajeros_table',1),(14,'2025_07_06_031000_add_details_to_pasajeros_table',1),(15,'2025_07_06_035057_add_address_fields_to_pasajeros_table',1),(16,'2025_08_21_173701_add_pasajeros_to_cotizacions_table',1),(17,'2025_09_03_185523_add_checkout_fields_to_pasajeros_table',2),(18,'2025_09_03_201808_add_pais_origen_to_cotizacions_table',3),(19,'2025_09_03_204925_add_pais_origen_to_cotizacions_table',4),(20,'2025_09_03_210017_drop_origen_from_cotizacions_table',5),(21,'2025_09_04_111103_add_unique_plan_dias_to_tarifas',6),(22,'2025_09_04_132451_create_tarifa_import_logs_table',7),(23,'2025_09_04_132815_add_unique_plan_dias_to_tarifas',8),(24,'2025_09_04_135238_create_cotizador_settings_table',8),(25,'2025_09_04_135813_create_app_settings_table',8),(26,'2025_09_04_190719_add_emergency_contact_fields_to_pasajeros_table',9),(27,'2025_09_04_193924_create_orders_table',10),(28,'2025_09_04_194128_add_admin_whatsapp_to_app_settings_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cotizacion_id` bigint unsigned NOT NULL,
  `plan_id` bigint unsigned DEFAULT NULL,
  `aseguradora_id` bigint unsigned DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'creada',
  `moneda` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COP',
  `precio` decimal(12,2) DEFAULT NULL,
  `tasa_usd_cop` decimal(12,4) DEFAULT NULL,
  `admin_whatsapp` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_viaje` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `fecha_regreso` date DEFAULT NULL,
  `pasajeros_count` int unsigned NOT NULL DEFAULT '0',
  `pasajeros_payload` json DEFAULT NULL,
  `whatsapp_message` text COLLATE utf8mb4_unicode_ci,
  `sent_to_whatsapp_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_cotizacion_id_foreign` (`cotizacion_id`),
  KEY `orders_plan_id_foreign` (`plan_id`),
  KEY `orders_aseguradora_id_foreign` (`aseguradora_id`),
  CONSTRAINT `orders_aseguradora_id_foreign` FOREIGN KEY (`aseguradora_id`) REFERENCES `aseguradoras` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pasajeros`
--

DROP TABLE IF EXISTS `pasajeros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasajeros` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cotizacion_id` bigint unsigned NOT NULL,
  `edad` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_documento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_emergencia_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_emergencia_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_emergencia_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pasajeros_cotizacion_id_foreign` (`cotizacion_id`),
  CONSTRAINT `pasajeros_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasajeros`
--

LOCK TABLES `pasajeros` WRITE;
/*!40000 ALTER TABLE `pasajeros` DISABLE KEYS */;
INSERT INTO `pasajeros` VALUES (1,1,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 02:26:53','2025-09-03 02:26:53'),(2,2,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 03:35:57','2025-09-03 03:35:57'),(3,3,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 03:42:24','2025-09-03 03:42:24'),(4,4,50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 03:53:19','2025-09-03 03:53:19'),(5,5,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 03:59:52','2025-09-03 03:59:52'),(6,6,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:01:39','2025-09-03 04:01:39'),(7,7,50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:03:05','2025-09-03 04:03:05'),(8,8,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:09:51','2025-09-03 04:09:51'),(9,9,50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:15:22','2025-09-03 04:15:22'),(10,10,25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:25:05','2025-09-03 04:25:05'),(11,11,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:26:38','2025-09-03 04:26:38'),(12,12,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:53:26','2025-09-03 04:53:26'),(13,13,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 04:58:53','2025-09-03 04:58:53'),(14,14,25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 05:02:19','2025-09-03 05:02:19'),(15,15,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 17:12:44','2025-09-03 17:12:44'),(16,15,25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 17:21:42','2025-09-03 17:21:42'),(18,17,50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 17:26:14','2025-09-03 17:26:14'),(19,18,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 20:09:27','2025-09-03 20:09:27'),(20,19,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 21:03:23','2025-09-03 21:03:23'),(21,20,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 21:11:13','2025-09-03 21:11:13'),(22,21,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 21:20:07','2025-09-03 21:20:07'),(23,22,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 23:01:23','2025-09-03 23:01:23'),(24,23,40,'david','barrera','2010-06-11','Cédula de ciudadanía','342','cr 87c No. 22-39 int 4 pto 503','Chile',NULL,NULL,NULL,'2025-09-03 23:12:48','2025-09-04 01:45:42'),(25,24,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-03 23:39:49','2025-09-03 23:39:49'),(26,25,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-04 02:09:18','2025-09-04 02:09:18'),(27,26,30,'david','barrera','2011-02-19','Pasaporte','2424242','cr 87c No. 22-39 int 4 pto 503','Colombia',NULL,NULL,NULL,'2025-09-04 02:19:06','2025-09-04 04:30:26'),(28,27,30,'david','barrera','2007-02-16','Cédula de ciudadanía','423532','cr 87c No. 22-39 int 4 pto 503','Colombia',NULL,NULL,NULL,'2025-09-04 05:22:06','2025-09-04 05:22:53'),(29,27,30,'asfdafsas','fasf','2008-06-19','Cédula de ciudadanía','q35325','CARRERA 17 # 8 - 140 NORTE APARTAMENTO torre','Colombia',NULL,NULL,NULL,'2025-09-04 05:22:06','2025-09-04 05:22:53'),(30,28,50,'david','barrera','2025-09-04','Cédula de ciudadanía','35353','cr 87c No. 22-39 int 4 pto 503','Colombia',NULL,NULL,NULL,'2025-09-04 18:34:17','2025-09-04 18:35:04'),(31,29,30,'david','barrera','2000-02-10','Cédula de ciudadanía','23453465','cr 87c No. 22-39 int 4 pto 503','Colombia',NULL,NULL,NULL,'2025-09-04 18:37:24','2025-09-04 18:37:45'),(32,30,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-04 19:22:16','2025-09-04 19:22:16'),(33,31,40,'david','barrera','1998-06-10','Cédula de ciudadanía','34231','cr 87c No. 22-39 int 4 pto 503','','erewr','3208045506','davidbarrera75@gmail.com','2025-09-04 19:22:41','2025-09-05 00:47:16'),(34,32,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-04 20:05:12','2025-09-04 20:05:12'),(35,33,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-04 20:06:15','2025-09-04 20:06:15'),(36,34,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-04 20:24:43','2025-09-04 20:24:43'),(37,35,40,'david','barrera','2000-02-10','','','cr 87c No. 22-39 int 4 pto 503','','safasf','3208045506','davidbarrera75@gmail.com','2025-09-05 00:06:08','2025-09-05 00:11:14'),(38,36,30,'david','barrera','2000-02-05','Cédula de ciudadanía','1324124','cr 87c No. 22-39 int 4 pto 503','','dvzdvsd','3208045506','davidbarrera75@gmail.com','2025-09-05 01:56:49','2025-09-05 01:57:11'),(39,37,40,'david','barrera','2004-02-06','Cédula de ciudadanía','322','cr 87c No. 22-39 int 4 pto 503','Colombia','reee','+573208045506','davidbarrera75@gmail.com','2025-09-05 02:54:41','2025-09-05 03:01:00'),(40,38,50,'david','barrera','2001-02-11','Cédula de ciudadanía','234234','cr 87c No. 22-39 int 4 pto 503','Colombia','pepe','+573208045506','davidbarrera75@gmail.com','2025-09-05 03:51:09','2025-09-05 03:51:36'),(41,39,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-06 17:53:52','2025-09-06 17:53:52'),(42,40,40,'david','barrera','1993-02-06','Cédula de extranjería','34534','cr 87c No. 22-39 int 4 pto 503','Colombia','david','+573208045506','davidbarrera75@gmail.com','2025-09-06 19:59:32','2025-09-06 20:00:00'),(43,41,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-06 20:20:50','2025-09-06 20:20:50'),(44,42,40,'david','barrera','2025-09-06','Cédula de ciudadanía','8587','cr 87c No. 22-39 int 4 pto 503','Colombia','ygiugui','+573208045506','dbarrera75@gmail.com','2025-09-06 20:22:40','2025-09-06 20:23:13'),(45,43,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-06 20:27:43','2025-09-06 20:27:43');
/*!40000 ALTER TABLE `pasajeros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_tipo_viaje`
--

DROP TABLE IF EXISTS `plan_tipo_viaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_tipo_viaje` (
  `plan_id` bigint unsigned NOT NULL,
  `tipo_viaje_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`plan_id`,`tipo_viaje_id`),
  KEY `plan_tipo_viaje_tipo_viaje_id_foreign` (`tipo_viaje_id`),
  CONSTRAINT `plan_tipo_viaje_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `plan_tipo_viaje_tipo_viaje_id_foreign` FOREIGN KEY (`tipo_viaje_id`) REFERENCES `tipo_viajes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_tipo_viaje`
--

LOCK TABLES `plan_tipo_viaje` WRITE;
/*!40000 ALTER TABLE `plan_tipo_viaje` DISABLE KEYS */;
INSERT INTO `plan_tipo_viaje` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(1,4),(2,4),(3,4),(4,4),(5,4),(6,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(1,6),(2,6),(3,6),(4,6),(5,6),(6,6);
/*!40000 ALTER TABLE `plan_tipo_viaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad_maxima` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aseguradora_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_aseguradora_id_foreign` (`aseguradora_id`),
  CONSTRAINT `plans_aseguradora_id_foreign` FOREIGN KEY (`aseguradora_id`) REFERENCES `aseguradoras` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'PLAN STUDENT ATM',60,1,'2025-08-26 23:01:23','2025-08-26 23:01:23',5),(2,'PLAN SCHENMED ECONOMICO ATM',60,1,'2025-08-26 23:02:26','2025-09-04 18:33:05',5),(3,'david',60,1,'2025-09-03 04:00:52','2025-09-03 04:00:52',5),(4,'Plan Básico',65,1,'2025-09-03 04:22:20','2025-09-03 04:22:20',1),(5,'Plan Premium',75,1,'2025-09-03 04:22:20','2025-09-03 04:22:20',2),(6,'Plan Familiar',80,1,'2025-09-03 04:22:21','2025-09-03 04:22:21',3),(7,'pepe',60,1,'2025-09-06 20:02:34','2025-09-06 20:02:34',5);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('rrVAA9eulyqcGwt8wbNoWrhmfyzci5juW9DILorZ',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiQlFvM25BZ1gwUmIwMzJuSmkwNUhhWjFxNVlpODU5UlpjazRPaGRXdyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGxhbnMvMi9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJExCcUlSREtiUlNIczRJalBScEdDTE90T3Y0emVaaXdveXBKWFVUWERINGJQMHJtVldlUDdhIjtzOjg6ImZpbGFtZW50IjthOjA6e319',1757196088);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifa_import_logs`
--

DROP TABLE IF EXISTS `tarifa_import_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarifa_import_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processed` int unsigned NOT NULL DEFAULT '0',
  `valid` int unsigned NOT NULL DEFAULT '0',
  `imported` int unsigned NOT NULL DEFAULT '0',
  `skipped` int unsigned NOT NULL DEFAULT '0',
  `errors` int unsigned NOT NULL DEFAULT '0',
  `messages` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'processed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarifa_import_logs_user_id_foreign` (`user_id`),
  KEY `tarifa_import_logs_plan_id_created_at_index` (`plan_id`,`created_at`),
  CONSTRAINT `tarifa_import_logs_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tarifa_import_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifa_import_logs`
--

LOCK TABLES `tarifa_import_logs` WRITE;
/*!40000 ALTER TABLE `tarifa_import_logs` DISABLE KEYS */;
INSERT INTO `tarifa_import_logs` VALUES (1,2,2,'ATM-tarifas.csv',0,0,0,0,0,NULL,'queued','2025-09-04 18:32:54','2025-09-04 18:32:54'),(2,2,2,'ATM-tarifas.csv',364,364,364,0,0,'[]','processed','2025-09-04 18:33:22','2025-09-04 18:33:22'),(3,1,2,'plantilla_test_tarifas.csv',364,364,364,0,0,'[]','processed','2025-09-05 03:52:51','2025-09-05 03:52:51'),(4,7,2,'ATM-tarifas.csv',364,364,364,0,0,'[]','processed','2025-09-06 20:04:37','2025-09-06 20:04:38');
/*!40000 ALTER TABLE `tarifa_import_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarifas`
--

DROP TABLE IF EXISTS `tarifas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tarifas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint unsigned NOT NULL,
  `dias` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tarifas_plan_dias_unique` (`plan_id`,`dias`),
  CONSTRAINT `tarifas_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1488 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarifas`
--

LOCK TABLES `tarifas` WRITE;
/*!40000 ALTER TABLE `tarifas` DISABLE KEYS */;
INSERT INTO `tarifas` VALUES (7,3,1,33333.00,'2025-09-03 04:00:52','2025-09-03 04:00:52'),(8,3,2,44443.00,'2025-09-03 04:00:52','2025-09-03 04:00:52'),(9,3,3,666.00,'2025-09-03 04:00:52','2025-09-03 04:00:52'),(10,4,1,25.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(11,4,3,65.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(12,4,7,120.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(13,4,15,200.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(14,4,30,350.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(15,4,60,650.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(16,5,1,25.00,'2025-09-03 04:22:20','2025-09-03 04:22:20'),(17,5,3,65.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(18,5,7,120.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(19,5,15,200.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(20,5,30,350.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(21,5,60,650.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(22,6,1,25.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(23,6,3,65.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(24,6,7,120.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(25,6,15,200.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(26,6,30,350.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(27,6,60,650.00,'2025-09-03 04:22:21','2025-09-03 04:22:21'),(395,2,1,10000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(396,2,2,11000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(397,2,3,12000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(398,2,4,13000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(399,2,5,14000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(400,2,6,15000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(401,2,7,16000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(402,2,8,17000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(403,2,9,18000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(404,2,10,19000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(405,2,11,20000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(406,2,12,21000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(407,2,13,22000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(408,2,14,23000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(409,2,15,24000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(410,2,16,25000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(411,2,17,26000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(412,2,18,27000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(413,2,19,28000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(414,2,20,29000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(415,2,21,30000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(416,2,22,31000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(417,2,23,32000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(418,2,24,33000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(419,2,25,34000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(420,2,26,35000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(421,2,27,36000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(422,2,28,37000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(423,2,29,38000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(424,2,30,39000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(425,2,31,40000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(426,2,32,41000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(427,2,33,42000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(428,2,34,43000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(429,2,35,44000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(430,2,36,45000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(431,2,37,46000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(432,2,38,47000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(433,2,39,48000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(434,2,40,49000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(435,2,41,50000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(436,2,42,51000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(437,2,43,52000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(438,2,44,53000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(439,2,45,54000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(440,2,46,55000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(441,2,47,56000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(442,2,48,57000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(443,2,49,58000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(444,2,50,59000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(445,2,51,60000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(446,2,52,61000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(447,2,53,62000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(448,2,54,63000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(449,2,55,64000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(450,2,56,65000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(451,2,57,66000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(452,2,58,67000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(453,2,59,68000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(454,2,60,69000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(455,2,61,70000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(456,2,62,71000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(457,2,63,72000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(458,2,64,73000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(459,2,65,74000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(460,2,66,75000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(461,2,67,76000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(462,2,68,77000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(463,2,69,78000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(464,2,70,79000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(465,2,71,80000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(466,2,72,81000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(467,2,73,82000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(468,2,74,83000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(469,2,75,84000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(470,2,76,85000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(471,2,77,86000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(472,2,78,87000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(473,2,79,88000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(474,2,80,89000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(475,2,81,90000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(476,2,82,91000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(477,2,83,92000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(478,2,84,93000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(479,2,85,94000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(480,2,86,95000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(481,2,87,96000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(482,2,88,97000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(483,2,89,98000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(484,2,90,99000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(485,2,91,100000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(486,2,92,101000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(487,2,93,102000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(488,2,94,103000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(489,2,95,104000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(490,2,96,105000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(491,2,97,106000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(492,2,98,107000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(493,2,99,108000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(494,2,100,109000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(495,2,101,110000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(496,2,102,111000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(497,2,103,112000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(498,2,104,113000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(499,2,105,114000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(500,2,106,115000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(501,2,107,116000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(502,2,108,117000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(503,2,109,118000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(504,2,110,119000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(505,2,111,120000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(506,2,112,121000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(507,2,113,122000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(508,2,114,123000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(509,2,115,124000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(510,2,116,125000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(511,2,117,126000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(512,2,118,127000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(513,2,119,128000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(514,2,120,129000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(515,2,121,130000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(516,2,122,131000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(517,2,123,132000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(518,2,124,133000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(519,2,125,134000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(520,2,126,135000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(521,2,127,136000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(522,2,128,137000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(523,2,129,138000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(524,2,130,139000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(525,2,131,140000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(526,2,132,141000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(527,2,133,142000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(528,2,134,143000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(529,2,135,144000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(530,2,136,145000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(531,2,137,146000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(532,2,138,147000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(533,2,139,148000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(534,2,140,149000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(535,2,141,150000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(536,2,142,151000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(537,2,143,152000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(538,2,144,153000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(539,2,145,154000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(540,2,146,155000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(541,2,147,156000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(542,2,148,157000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(543,2,149,158000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(544,2,150,159000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(545,2,151,160000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(546,2,152,161000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(547,2,153,162000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(548,2,154,163000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(549,2,155,164000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(550,2,156,165000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(551,2,157,166000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(552,2,158,167000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(553,2,159,168000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(554,2,160,169000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(555,2,161,170000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(556,2,162,171000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(557,2,163,172000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(558,2,164,173000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(559,2,165,174000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(560,2,166,175000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(561,2,167,176000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(562,2,168,177000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(563,2,169,178000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(564,2,170,179000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(565,2,171,180000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(566,2,172,181000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(567,2,173,182000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(568,2,174,183000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(569,2,175,184000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(570,2,176,185000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(571,2,177,186000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(572,2,178,187000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(573,2,179,188000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(574,2,180,189000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(575,2,181,190000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(576,2,182,191000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(577,2,183,192000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(578,2,184,193000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(579,2,185,194000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(580,2,186,195000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(581,2,187,196000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(582,2,188,197000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(583,2,189,198000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(584,2,190,199000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(585,2,191,200000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(586,2,192,201000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(587,2,193,202000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(588,2,194,203000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(589,2,195,204000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(590,2,196,205000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(591,2,197,206000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(592,2,198,207000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(593,2,199,208000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(594,2,200,209000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(595,2,201,210000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(596,2,202,211000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(597,2,203,212000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(598,2,204,213000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(599,2,205,214000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(600,2,206,215000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(601,2,207,216000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(602,2,208,217000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(603,2,209,218000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(604,2,210,219000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(605,2,211,220000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(606,2,212,221000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(607,2,213,222000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(608,2,214,223000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(609,2,215,224000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(610,2,216,225000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(611,2,217,226000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(612,2,218,227000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(613,2,219,228000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(614,2,220,229000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(615,2,221,230000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(616,2,222,231000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(617,2,223,232000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(618,2,224,233000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(619,2,225,234000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(620,2,226,235000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(621,2,227,236000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(622,2,228,237000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(623,2,229,238000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(624,2,230,239000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(625,2,231,240000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(626,2,232,241000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(627,2,233,242000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(628,2,234,243000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(629,2,235,244000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(630,2,236,245000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(631,2,237,246000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(632,2,238,247000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(633,2,239,248000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(634,2,240,249000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(635,2,241,250000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(636,2,242,251000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(637,2,243,252000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(638,2,244,253000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(639,2,245,254000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(640,2,246,255000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(641,2,247,256000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(642,2,248,257000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(643,2,249,258000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(644,2,250,259000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(645,2,251,260000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(646,2,252,261000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(647,2,253,262000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(648,2,254,263000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(649,2,255,264000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(650,2,256,265000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(651,2,257,266000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(652,2,258,267000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(653,2,259,268000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(654,2,260,269000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(655,2,261,270000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(656,2,262,271000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(657,2,263,272000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(658,2,264,273000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(659,2,265,274000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(660,2,266,275000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(661,2,267,276000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(662,2,268,277000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(663,2,269,278000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(664,2,270,279000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(665,2,271,280000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(666,2,272,281000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(667,2,273,282000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(668,2,274,283000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(669,2,275,284000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(670,2,276,285000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(671,2,277,286000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(672,2,278,287000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(673,2,279,288000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(674,2,280,289000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(675,2,281,290000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(676,2,282,291000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(677,2,283,292000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(678,2,284,293000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(679,2,285,294000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(680,2,286,295000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(681,2,287,296000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(682,2,288,297000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(683,2,289,298000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(684,2,290,299000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(685,2,291,300000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(686,2,292,301000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(687,2,293,302000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(688,2,294,303000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(689,2,295,304000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(690,2,296,305000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(691,2,297,306000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(692,2,298,307000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(693,2,299,308000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(694,2,300,309000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(695,2,301,310000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(696,2,302,311000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(697,2,303,312000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(698,2,304,313000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(699,2,305,314000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(700,2,306,315000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(701,2,307,316000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(702,2,308,317000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(703,2,309,318000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(704,2,310,319000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(705,2,311,320000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(706,2,312,321000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(707,2,313,322000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(708,2,314,323000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(709,2,315,324000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(710,2,316,325000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(711,2,317,326000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(712,2,318,327000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(713,2,319,328000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(714,2,320,329000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(715,2,321,330000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(716,2,322,331000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(717,2,323,332000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(718,2,324,333000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(719,2,325,334000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(720,2,326,335000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(721,2,327,336000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(722,2,328,337000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(723,2,329,338000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(724,2,330,339000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(725,2,331,340000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(726,2,332,341000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(727,2,333,342000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(728,2,334,343000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(729,2,335,344000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(730,2,336,345000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(731,2,337,346000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(732,2,338,347000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(733,2,339,348000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(734,2,340,349000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(735,2,341,350000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(736,2,342,351000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(737,2,343,352000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(738,2,344,353000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(739,2,345,354000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(740,2,346,355000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(741,2,347,356000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(742,2,348,357000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(743,2,349,358000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(744,2,350,359000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(745,2,351,360000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(746,2,352,361000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(747,2,353,362000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(748,2,354,363000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(749,2,355,364000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(750,2,356,365000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(751,2,357,366000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(752,2,358,367000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(753,2,359,368000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(754,2,360,369000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(755,2,361,370000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(756,2,362,371000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(757,2,363,372000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(758,2,364,373000.00,'2025-09-04 18:33:22','2025-09-04 18:33:22'),(759,1,1,60000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(760,1,2,61000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(761,1,3,62000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(762,1,4,63000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(763,1,5,64000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(764,1,6,65000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(765,1,7,66000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(766,1,8,67000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(767,1,9,68000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(768,1,10,69000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(769,1,11,70000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(770,1,12,71000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(771,1,13,72000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(772,1,14,73000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(773,1,15,74000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(774,1,16,75000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(775,1,17,76000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(776,1,18,77000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(777,1,19,78000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(778,1,20,79000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(779,1,21,80000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(780,1,22,81000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(781,1,23,82000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(782,1,24,83000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(783,1,25,84000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(784,1,26,85000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(785,1,27,86000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(786,1,28,87000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(787,1,29,88000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(788,1,30,89000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(789,1,31,90000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(790,1,32,91000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(791,1,33,92000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(792,1,34,93000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(793,1,35,94000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(794,1,36,95000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(795,1,37,96000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(796,1,38,97000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(797,1,39,98000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(798,1,40,99000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(799,1,41,100000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(800,1,42,101000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(801,1,43,102000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(802,1,44,103000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(803,1,45,104000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(804,1,46,105000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(805,1,47,106000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(806,1,48,107000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(807,1,49,108000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(808,1,50,109000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(809,1,51,110000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(810,1,52,111000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(811,1,53,112000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(812,1,54,113000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(813,1,55,114000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(814,1,56,115000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(815,1,57,116000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(816,1,58,117000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(817,1,59,118000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(818,1,60,119000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(819,1,61,120000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(820,1,62,121000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(821,1,63,122000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(822,1,64,123000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(823,1,65,124000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(824,1,66,125000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(825,1,67,126000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(826,1,68,127000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(827,1,69,128000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(828,1,70,129000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(829,1,71,130000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(830,1,72,131000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(831,1,73,132000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(832,1,74,133000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(833,1,75,134000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(834,1,76,135000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(835,1,77,136000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(836,1,78,137000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(837,1,79,138000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(838,1,80,139000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(839,1,81,140000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(840,1,82,141000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(841,1,83,142000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(842,1,84,143000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(843,1,85,144000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(844,1,86,145000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(845,1,87,146000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(846,1,88,147000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(847,1,89,148000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(848,1,90,149000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(849,1,91,150000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(850,1,92,151000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(851,1,93,152000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(852,1,94,153000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(853,1,95,154000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(854,1,96,155000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(855,1,97,156000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(856,1,98,157000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(857,1,99,158000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(858,1,100,159000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(859,1,101,160000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(860,1,102,161000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(861,1,103,162000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(862,1,104,163000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(863,1,105,164000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(864,1,106,165000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(865,1,107,166000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(866,1,108,167000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(867,1,109,168000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(868,1,110,169000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(869,1,111,170000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(870,1,112,171000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(871,1,113,172000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(872,1,114,173000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(873,1,115,174000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(874,1,116,175000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(875,1,117,176000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(876,1,118,177000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(877,1,119,178000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(878,1,120,179000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(879,1,121,180000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(880,1,122,181000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(881,1,123,182000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(882,1,124,183000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(883,1,125,184000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(884,1,126,185000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(885,1,127,186000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(886,1,128,187000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(887,1,129,188000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(888,1,130,189000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(889,1,131,190000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(890,1,132,191000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(891,1,133,192000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(892,1,134,193000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(893,1,135,194000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(894,1,136,195000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(895,1,137,196000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(896,1,138,197000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(897,1,139,198000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(898,1,140,199000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(899,1,141,200000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(900,1,142,201000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(901,1,143,202000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(902,1,144,203000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(903,1,145,204000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(904,1,146,205000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(905,1,147,206000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(906,1,148,207000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(907,1,149,208000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(908,1,150,209000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(909,1,151,210000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(910,1,152,211000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(911,1,153,212000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(912,1,154,213000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(913,1,155,214000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(914,1,156,215000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(915,1,157,216000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(916,1,158,217000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(917,1,159,218000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(918,1,160,219000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(919,1,161,220000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(920,1,162,221000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(921,1,163,222000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(922,1,164,223000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(923,1,165,224000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(924,1,166,225000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(925,1,167,226000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(926,1,168,227000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(927,1,169,228000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(928,1,170,229000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(929,1,171,230000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(930,1,172,231000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(931,1,173,232000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(932,1,174,233000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(933,1,175,234000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(934,1,176,235000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(935,1,177,236000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(936,1,178,237000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(937,1,179,238000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(938,1,180,239000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(939,1,181,240000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(940,1,182,241000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(941,1,183,242000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(942,1,184,243000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(943,1,185,244000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(944,1,186,245000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(945,1,187,246000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(946,1,188,247000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(947,1,189,248000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(948,1,190,249000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(949,1,191,250000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(950,1,192,251000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(951,1,193,252000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(952,1,194,253000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(953,1,195,254000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(954,1,196,255000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(955,1,197,256000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(956,1,198,257000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(957,1,199,258000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(958,1,200,259000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(959,1,201,260000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(960,1,202,261000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(961,1,203,262000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(962,1,204,263000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(963,1,205,264000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(964,1,206,265000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(965,1,207,266000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(966,1,208,267000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(967,1,209,268000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(968,1,210,269000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(969,1,211,270000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(970,1,212,271000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(971,1,213,272000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(972,1,214,273000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(973,1,215,274000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(974,1,216,275000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(975,1,217,276000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(976,1,218,277000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(977,1,219,278000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(978,1,220,279000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(979,1,221,280000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(980,1,222,281000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(981,1,223,282000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(982,1,224,283000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(983,1,225,284000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(984,1,226,285000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(985,1,227,286000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(986,1,228,287000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(987,1,229,288000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(988,1,230,289000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(989,1,231,290000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(990,1,232,291000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(991,1,233,292000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(992,1,234,293000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(993,1,235,294000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(994,1,236,295000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(995,1,237,296000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(996,1,238,297000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(997,1,239,298000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(998,1,240,299000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(999,1,241,300000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1000,1,242,301000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1001,1,243,302000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1002,1,244,303000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1003,1,245,304000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1004,1,246,305000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1005,1,247,306000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1006,1,248,307000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1007,1,249,308000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1008,1,250,309000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1009,1,251,310000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1010,1,252,311000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1011,1,253,312000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1012,1,254,313000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1013,1,255,314000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1014,1,256,315000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1015,1,257,316000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1016,1,258,317000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1017,1,259,318000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1018,1,260,319000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1019,1,261,320000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1020,1,262,321000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1021,1,263,322000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1022,1,264,323000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1023,1,265,324000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1024,1,266,325000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1025,1,267,326000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1026,1,268,327000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1027,1,269,328000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1028,1,270,329000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1029,1,271,330000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1030,1,272,331000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1031,1,273,332000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1032,1,274,333000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1033,1,275,334000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1034,1,276,335000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1035,1,277,336000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1036,1,278,337000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1037,1,279,338000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1038,1,280,339000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1039,1,281,340000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1040,1,282,341000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1041,1,283,342000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1042,1,284,343000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1043,1,285,344000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1044,1,286,345000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1045,1,287,346000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1046,1,288,347000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1047,1,289,348000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1048,1,290,349000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1049,1,291,350000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1050,1,292,351000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1051,1,293,352000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1052,1,294,353000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1053,1,295,354000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1054,1,296,355000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1055,1,297,356000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1056,1,298,357000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1057,1,299,358000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1058,1,300,359000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1059,1,301,360000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1060,1,302,361000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1061,1,303,362000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1062,1,304,363000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1063,1,305,364000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1064,1,306,365000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1065,1,307,366000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1066,1,308,367000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1067,1,309,368000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1068,1,310,369000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1069,1,311,370000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1070,1,312,371000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1071,1,313,372000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1072,1,314,373000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1073,1,315,374000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1074,1,316,375000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1075,1,317,376000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1076,1,318,377000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1077,1,319,378000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1078,1,320,379000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1079,1,321,380000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1080,1,322,381000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1081,1,323,382000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1082,1,324,383000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1083,1,325,384000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1084,1,326,385000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1085,1,327,386000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1086,1,328,387000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1087,1,329,388000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1088,1,330,389000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1089,1,331,390000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1090,1,332,391000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1091,1,333,392000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1092,1,334,393000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1093,1,335,394000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1094,1,336,395000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1095,1,337,396000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1096,1,338,397000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1097,1,339,398000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1098,1,340,399000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1099,1,341,400000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1100,1,342,401000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1101,1,343,402000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1102,1,344,403000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1103,1,345,404000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1104,1,346,405000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1105,1,347,406000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1106,1,348,407000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1107,1,349,408000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1108,1,350,409000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1109,1,351,410000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1110,1,352,411000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1111,1,353,412000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1112,1,354,413000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1113,1,355,414000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1114,1,356,415000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1115,1,357,416000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1116,1,358,417000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1117,1,359,418000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1118,1,360,419000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1119,1,361,420000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1120,1,362,421000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1121,1,363,422000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1122,1,364,423000.00,'2025-09-05 03:52:51','2025-09-05 03:52:51'),(1124,7,1,10000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1125,7,2,11000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1126,7,3,12000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1127,7,4,13000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1128,7,5,14000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1129,7,6,15000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1130,7,7,16000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1131,7,8,17000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1132,7,9,18000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1133,7,10,19000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1134,7,11,20000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1135,7,12,21000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1136,7,13,22000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1137,7,14,23000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1138,7,15,24000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1139,7,16,25000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1140,7,17,26000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1141,7,18,27000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1142,7,19,28000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1143,7,20,29000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1144,7,21,30000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1145,7,22,31000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1146,7,23,32000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1147,7,24,33000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1148,7,25,34000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1149,7,26,35000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1150,7,27,36000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1151,7,28,37000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1152,7,29,38000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1153,7,30,39000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1154,7,31,40000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1155,7,32,41000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1156,7,33,42000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1157,7,34,43000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1158,7,35,44000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1159,7,36,45000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1160,7,37,46000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1161,7,38,47000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1162,7,39,48000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1163,7,40,49000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1164,7,41,50000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1165,7,42,51000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1166,7,43,52000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1167,7,44,53000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1168,7,45,54000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1169,7,46,55000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1170,7,47,56000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1171,7,48,57000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1172,7,49,58000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1173,7,50,59000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1174,7,51,60000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1175,7,52,61000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1176,7,53,62000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1177,7,54,63000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1178,7,55,64000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1179,7,56,65000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1180,7,57,66000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1181,7,58,67000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1182,7,59,68000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1183,7,60,69000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1184,7,61,70000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1185,7,62,71000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1186,7,63,72000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1187,7,64,73000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1188,7,65,74000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1189,7,66,75000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1190,7,67,76000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1191,7,68,77000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1192,7,69,78000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1193,7,70,79000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1194,7,71,80000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1195,7,72,81000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1196,7,73,82000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1197,7,74,83000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1198,7,75,84000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1199,7,76,85000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1200,7,77,86000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1201,7,78,87000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1202,7,79,88000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1203,7,80,89000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1204,7,81,90000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1205,7,82,91000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1206,7,83,92000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1207,7,84,93000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1208,7,85,94000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1209,7,86,95000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1210,7,87,96000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1211,7,88,97000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1212,7,89,98000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1213,7,90,99000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1214,7,91,100000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1215,7,92,101000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1216,7,93,102000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1217,7,94,103000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1218,7,95,104000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1219,7,96,105000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1220,7,97,106000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1221,7,98,107000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1222,7,99,108000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1223,7,100,109000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1224,7,101,110000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1225,7,102,111000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1226,7,103,112000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1227,7,104,113000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1228,7,105,114000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1229,7,106,115000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1230,7,107,116000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1231,7,108,117000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1232,7,109,118000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1233,7,110,119000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1234,7,111,120000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1235,7,112,121000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1236,7,113,122000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1237,7,114,123000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1238,7,115,124000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1239,7,116,125000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1240,7,117,126000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1241,7,118,127000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1242,7,119,128000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1243,7,120,129000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1244,7,121,130000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1245,7,122,131000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1246,7,123,132000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1247,7,124,133000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1248,7,125,134000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1249,7,126,135000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1250,7,127,136000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1251,7,128,137000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1252,7,129,138000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1253,7,130,139000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1254,7,131,140000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1255,7,132,141000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1256,7,133,142000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1257,7,134,143000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1258,7,135,144000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1259,7,136,145000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1260,7,137,146000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1261,7,138,147000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1262,7,139,148000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1263,7,140,149000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1264,7,141,150000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1265,7,142,151000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1266,7,143,152000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1267,7,144,153000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1268,7,145,154000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1269,7,146,155000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1270,7,147,156000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1271,7,148,157000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1272,7,149,158000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1273,7,150,159000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1274,7,151,160000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1275,7,152,161000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1276,7,153,162000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1277,7,154,163000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1278,7,155,164000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1279,7,156,165000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1280,7,157,166000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1281,7,158,167000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1282,7,159,168000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1283,7,160,169000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1284,7,161,170000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1285,7,162,171000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1286,7,163,172000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1287,7,164,173000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1288,7,165,174000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1289,7,166,175000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1290,7,167,176000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1291,7,168,177000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1292,7,169,178000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1293,7,170,179000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1294,7,171,180000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1295,7,172,181000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1296,7,173,182000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1297,7,174,183000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1298,7,175,184000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1299,7,176,185000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1300,7,177,186000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1301,7,178,187000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1302,7,179,188000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1303,7,180,189000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1304,7,181,190000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1305,7,182,191000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1306,7,183,192000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1307,7,184,193000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1308,7,185,194000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1309,7,186,195000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1310,7,187,196000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1311,7,188,197000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1312,7,189,198000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1313,7,190,199000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1314,7,191,200000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1315,7,192,201000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1316,7,193,202000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1317,7,194,203000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1318,7,195,204000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1319,7,196,205000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1320,7,197,206000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1321,7,198,207000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1322,7,199,208000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1323,7,200,209000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1324,7,201,210000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1325,7,202,211000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1326,7,203,212000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1327,7,204,213000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1328,7,205,214000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1329,7,206,215000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1330,7,207,216000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1331,7,208,217000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1332,7,209,218000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1333,7,210,219000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1334,7,211,220000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1335,7,212,221000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1336,7,213,222000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1337,7,214,223000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1338,7,215,224000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1339,7,216,225000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1340,7,217,226000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1341,7,218,227000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1342,7,219,228000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1343,7,220,229000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1344,7,221,230000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1345,7,222,231000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1346,7,223,232000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1347,7,224,233000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1348,7,225,234000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1349,7,226,235000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1350,7,227,236000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1351,7,228,237000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1352,7,229,238000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1353,7,230,239000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1354,7,231,240000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1355,7,232,241000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1356,7,233,242000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1357,7,234,243000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1358,7,235,244000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1359,7,236,245000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1360,7,237,246000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1361,7,238,247000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1362,7,239,248000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1363,7,240,249000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1364,7,241,250000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1365,7,242,251000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1366,7,243,252000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1367,7,244,253000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1368,7,245,254000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1369,7,246,255000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1370,7,247,256000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1371,7,248,257000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1372,7,249,258000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1373,7,250,259000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1374,7,251,260000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1375,7,252,261000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1376,7,253,262000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1377,7,254,263000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1378,7,255,264000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1379,7,256,265000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1380,7,257,266000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1381,7,258,267000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1382,7,259,268000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1383,7,260,269000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1384,7,261,270000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1385,7,262,271000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1386,7,263,272000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1387,7,264,273000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1388,7,265,274000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1389,7,266,275000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1390,7,267,276000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1391,7,268,277000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1392,7,269,278000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1393,7,270,279000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1394,7,271,280000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1395,7,272,281000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1396,7,273,282000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1397,7,274,283000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1398,7,275,284000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1399,7,276,285000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1400,7,277,286000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1401,7,278,287000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1402,7,279,288000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1403,7,280,289000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1404,7,281,290000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1405,7,282,291000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1406,7,283,292000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1407,7,284,293000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1408,7,285,294000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1409,7,286,295000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1410,7,287,296000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1411,7,288,297000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1412,7,289,298000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1413,7,290,299000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1414,7,291,300000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1415,7,292,301000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1416,7,293,302000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1417,7,294,303000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1418,7,295,304000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1419,7,296,305000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1420,7,297,306000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1421,7,298,307000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1422,7,299,308000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1423,7,300,309000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1424,7,301,310000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1425,7,302,311000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1426,7,303,312000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1427,7,304,313000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1428,7,305,314000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1429,7,306,315000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1430,7,307,316000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1431,7,308,317000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1432,7,309,318000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1433,7,310,319000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1434,7,311,320000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1435,7,312,321000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1436,7,313,322000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1437,7,314,323000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1438,7,315,324000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1439,7,316,325000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1440,7,317,326000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1441,7,318,327000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1442,7,319,328000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1443,7,320,329000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1444,7,321,330000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1445,7,322,331000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1446,7,323,332000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1447,7,324,333000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1448,7,325,334000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1449,7,326,335000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1450,7,327,336000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1451,7,328,337000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1452,7,329,338000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1453,7,330,339000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1454,7,331,340000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1455,7,332,341000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1456,7,333,342000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1457,7,334,343000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1458,7,335,344000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1459,7,336,345000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1460,7,337,346000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1461,7,338,347000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1462,7,339,348000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1463,7,340,349000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1464,7,341,350000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1465,7,342,351000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1466,7,343,352000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1467,7,344,353000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1468,7,345,354000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1469,7,346,355000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1470,7,347,356000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1471,7,348,357000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1472,7,349,358000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1473,7,350,359000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1474,7,351,360000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1475,7,352,361000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1476,7,353,362000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1477,7,354,363000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1478,7,355,364000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1479,7,356,365000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1480,7,357,366000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1481,7,358,367000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1482,7,359,368000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1483,7,360,369000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1484,7,361,370000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1485,7,362,371000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1486,7,363,372000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38'),(1487,7,364,373000.00,'2025-09-06 20:04:38','2025-09-06 20:04:38');
/*!40000 ALTER TABLE `tarifas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_viajes`
--

DROP TABLE IF EXISTS `tipo_viajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_viajes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_viajes`
--

LOCK TABLES `tipo_viajes` WRITE;
/*!40000 ALTER TABLE `tipo_viajes` DISABLE KEYS */;
INSERT INTO `tipo_viajes` VALUES (1,'PLACER,TURISMO,ESTUDIO Y TRABAJO',1,'2025-08-26 22:57:44','2025-09-07 02:55:24'),(2,'ENFERMEDADES PRE-EXISTENTES',1,'2025-08-26 22:57:57','2025-08-26 22:57:57'),(3,'EMBARAZO',1,'2025-08-26 22:58:06','2025-08-26 22:58:06'),(4,'MULTI VIAJES VIAJEROS FRECUENTES',1,'2025-08-26 22:58:15','2025-08-26 22:58:15'),(5,'RESPONSABILIDAD CIVIL ESTUDIANTES DAÑOS TERCEROS',1,'2025-08-26 22:58:25','2025-08-26 22:58:25'),(6,'Turismo',1,'2025-09-03 04:22:20','2025-09-07 02:57:02');
/*!40000 ALTER TABLE `tipo_viajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-08-22 01:54:29','$2y$12$00SvhbDQc5NnaxJlb9nwU.4.3QTQvZoDmpkaAHDXyteEZCTlAfF42','ssWZOCJOkY','2025-08-22 01:54:29','2025-08-22 01:54:29'),(2,'admin','davidbarrera75@gmail.com',NULL,'$2y$12$LBqIRDKbRSHs4IjPRpGCLOtOv4zeZiwoypJXUTXDH4bP0rmVWeP7a',NULL,'2025-08-26 21:08:22','2025-08-26 21:08:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-06 17:03:44
