-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: la_bendicion
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
-- Table structure for table `cantones`
--

DROP TABLE IF EXISTS `cantones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cantones` (
  `id_canton` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_provincia` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_canton`),
  KEY `fk_ca_provincia` (`id_provincia`),
  CONSTRAINT `fk_ca_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id_provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cantones`
--

LOCK TABLES `cantones` WRITE;
/*!40000 ALTER TABLE `cantones` DISABLE KEYS */;
INSERT INTO `cantones` VALUES (1,1,'San José',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(2,1,'Escazú',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(3,1,'Desamparados',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(4,1,'Puriscal',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(5,1,'Tarrazú',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(6,1,'Aserrí',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(7,1,'Mora',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(8,1,'Goicoechea',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(9,1,'Santa Ana',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(10,1,'Alajuelita',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(11,1,'Vásquez de Coronado',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(12,1,'Acosta',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(13,1,'Tibás',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(14,1,'Moravia',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(15,1,'Montes de Oca',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(16,1,'Turrubares',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(17,1,'Dota',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(18,1,'Curridabat',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(19,1,'Pérez Zeledón',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(20,1,'León Cortés Castro',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(21,2,'Alajuela',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(22,2,'San Ramón',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(23,2,'Grecia',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(24,2,'San Mateo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(25,2,'Atenas',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(26,2,'Naranjo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(27,2,'Palmares',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(28,2,'Poás',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(29,2,'Orotina',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(30,2,'San Carlos',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(31,2,'Zarcero',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(32,2,'Sarchí',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(33,2,'Upala',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(34,2,'Los Chiles',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(35,2,'Guatuso',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(36,2,'Río Cuarto',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(37,3,'Cartago',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(38,3,'Paraíso',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(39,3,'La Unión',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(40,3,'Jiménez',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(41,3,'Turrialba',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(42,3,'Alvarado',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(43,3,'Oreamuno',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(44,3,'El Guarco',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(45,4,'Heredia',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(46,4,'Barva',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(47,4,'Santo Domingo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(48,4,'Santa Bárbara',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(49,4,'San Rafael',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(50,4,'San Isidro',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(51,4,'Belén',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(52,4,'Flores',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(53,4,'San Pablo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(54,4,'Sarapiquí',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(55,5,'Liberia',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(56,5,'Nicoya',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(57,5,'Santa Cruz',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(58,5,'Bagaces',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(59,5,'Carrillo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(60,5,'Cañas',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(61,5,'Abangares',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(62,5,'Tilarán',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(63,5,'Nandayure',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(64,5,'La Cruz',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(65,5,'Hojancha',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(66,6,'Puntarenas',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(67,6,'Esparza',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(68,6,'Buenos Aires',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(69,6,'Montes de Oro',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(70,6,'Osa',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(71,6,'Quepos',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(72,6,'Golfito',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(73,6,'Coto Brus',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(74,6,'Parrita',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(75,6,'Corredores',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(76,6,'Garabito',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(77,7,'Limón',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(78,7,'Pococí',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(79,7,'Siquirres',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(80,7,'Talamanca',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(81,7,'Matina',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(82,7,'Guácimo',1,'2026-03-21 04:55:21','2026-03-21 04:55:21');
/*!40000 ALTER TABLE `cantones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carritos`
--

DROP TABLE IF EXISTS `carritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carritos` (
  `id_carrito` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_carrito`),
  UNIQUE KEY `id_user` (`id_user`),
  CONSTRAINT `fk_car_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carritos`
--

LOCK TABLES `carritos` WRITE;
/*!40000 ALTER TABLE `carritos` DISABLE KEYS */;
INSERT INTO `carritos` VALUES (2,8,0.00,0.00,0.00,'2026-03-21 05:18:19','2026-03-25 18:25:54');
/*!40000 ALTER TABLE `carritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id_c_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_carrito` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_c_item`),
  KEY `fk_ci_carrito` (`id_carrito`),
  KEY `fk_ci_producto` (`id_producto`),
  CONSTRAINT `fk_ci_carrito` FOREIGN KEY (`id_carrito`) REFERENCES `carritos` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ci_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id_categoria` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `slug` varchar(120) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Granos  y Cereales','Arroz integral, quinoa, avena y cereales naturales','granos-y-cereales',NULL,1,'2026-03-21 10:16:46','2026-03-21 10:16:46'),(2,'Capsulas','Suplementos naturales en cápsulas para mejorar la salud y el bienestar general.','capsulas',NULL,1,'2026-03-22 02:12:51','2026-03-22 02:12:51'),(3,'Infusiones','Mezclas naturales de hierbas ideales para relajación, digestión y bienestar.','infusiones',NULL,1,'2026-03-22 02:13:25','2026-03-22 02:13:25'),(4,'Aceites','Aceites naturales para consumo o uso terapéutico.','aceites',NULL,1,'2026-03-22 02:13:53','2026-03-22 02:13:53'),(5,'Gotas','Extractos líquidos concentrados para apoyo en diferentes necesidades de salud.','gotas',NULL,1,'2026-03-22 02:14:16','2026-03-22 02:14:16'),(6,'Aromaterapia','Esencias y aceites esenciales para relajación, equilibrio y bienestar emocional.','aromaterapia',NULL,1,'2026-03-22 02:14:45','2026-03-22 02:14:45'),(7,'Jarabes','Preparaciones naturales líquidas para fortalecer el sistema respiratorio y mas funciones.','jarabes',NULL,1,'2026-03-22 02:15:30','2026-03-22 02:15:30'),(8,'Suplementos Deportivos','Productos para la mejorar del rendimiento físico y la recuperación muscular.','suplementos-deportivos',NULL,1,'2026-03-22 02:16:17','2026-03-22 02:16:17'),(9,'Jabones','Jabones naturales para el cuidado e higiene de la piel.','jabones',NULL,1,'2026-03-22 02:16:51','2026-03-22 02:16:51'),(10,'Shampoos','Productos naturales para el cuidado y fortalecimiento del cabello.','shampoos',NULL,1,'2026-03-22 02:17:20','2026-03-22 02:17:20'),(11,'Semillas y Frutos Secos','Opciones saludables ricas en grasas buenas, proteínas y energía natural.','semillas-y-frutos-secos',NULL,1,'2026-03-22 02:17:47','2026-03-22 02:17:47'),(12,'Ungüentos','Preparaciones naturales de uso tópico elaboradas con extractos de plantas y aceites, ideales para aliviar dolores musculares, inflamaciones y cuidar la piel.','unguentos',NULL,1,'2026-03-22 03:43:12','2026-03-22 03:43:12');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direcciones` (
  `id_direccion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_distrito` int(10) unsigned NOT NULL,
  `es_principal` tinyint(1) NOT NULL DEFAULT 0,
  `detalle` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_direccion`),
  KEY `fk_dir_user` (`id_user`),
  KEY `fk_dir_distrito` (`id_distrito`),
  CONSTRAINT `fk_dir_distrito` FOREIGN KEY (`id_distrito`) REFERENCES `distritos` (`id_distrito`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dir_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
INSERT INTO `direcciones` VALUES (1,8,50,0,'De la plaza de deportes de dulce nombre, 200 metros a la derecha',1,'2026-03-21 11:02:12','2026-03-24 08:42:33'),(2,1,1,0,'Mercado Central',1,'2026-03-22 04:41:57','2026-03-22 04:41:57'),(3,8,54,1,'frente a la iglesia de mercedes sur',1,'2026-03-24 08:42:24','2026-03-24 08:42:33');
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distritos`
--

DROP TABLE IF EXISTS `distritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distritos` (
  `id_distrito` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_canton` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_distrito`),
  KEY `fk_di_canton` (`id_canton`),
  CONSTRAINT `fk_di_canton` FOREIGN KEY (`id_canton`) REFERENCES `cantones` (`id_canton`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distritos`
--

LOCK TABLES `distritos` WRITE;
/*!40000 ALTER TABLE `distritos` DISABLE KEYS */;
INSERT INTO `distritos` VALUES (1,1,'Carmen',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(2,1,'Merced',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(3,1,'Hospital',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(4,1,'Catedral',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(5,1,'Zapote',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(6,1,'San Francisco de Dos Ríos',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(7,1,'Uruca',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(8,1,'Mata Redonda',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(9,1,'Pavas',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(10,1,'Hatillo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(11,1,'San Sebastián',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(12,2,'Escazú',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(13,2,'San Antonio',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(14,2,'San Rafael',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(15,3,'Desamparados',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(16,3,'San Miguel',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(17,3,'San Juan de Dios',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(18,3,'San Rafael Arriba',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(19,3,'San Antonio',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(20,3,'Frailes',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(21,3,'Patarrá',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(22,3,'San Cristóbal',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(23,3,'Rosario',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(24,3,'Damas',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(25,3,'San Rafael Abajo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(26,3,'Gravilias',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(27,3,'Los Guido',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(28,21,'Alajuela',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(29,21,'San José',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(30,21,'Carrizal',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(31,21,'San Antonio',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(32,21,'Guácima',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(33,21,'San Isidro',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(34,21,'Sabanilla',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(35,21,'San Rafael',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(36,21,'Río Segundo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(37,21,'Desamparados',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(38,21,'Turrúcares',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(39,21,'Tambor',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(40,21,'La Garita',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(41,21,'Sarapiquí',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(42,37,'Oriental',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(43,37,'Occidental',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(44,37,'Carmen',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(45,37,'San Nicolás',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(46,37,'Aguacaliente',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(47,37,'Guadalupe',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(48,37,'Corralillo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(49,37,'Tierra Blanca',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(50,37,'Dulce Nombre',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(51,37,'Llano Grande',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(52,37,'Quebradilla',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(53,45,'Heredia',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(54,45,'Mercedes',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(55,45,'San Francisco',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(56,45,'Ulloa',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(57,45,'Varablanca',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(58,55,'Liberia',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(59,55,'Cañas Dulces',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(60,55,'Mayorga',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(61,55,'Nacascolo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(62,55,'Curubandé',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(63,66,'Puntarenas',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(64,66,'Pitahaya',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(65,66,'Chomes',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(66,66,'Lepanto',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(67,66,'Paquera',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(68,66,'Manzanillo',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(69,66,'Guacimal',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(70,66,'Barranca',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(71,66,'Monte Verde',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(72,66,'Isla del Coco',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(73,66,'Cóbano',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(74,66,'Chacarita',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(75,66,'Chira',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(76,66,'Acapulco',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(77,66,'El Roble',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(78,66,'Arancibia',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(79,77,'Limón',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(80,77,'Valle La Estrella',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(81,77,'Río Blanco',1,'2026-03-21 05:00:28','2026-03-21 05:00:28'),(82,77,'Matama',1,'2026-03-21 05:00:28','2026-03-21 05:00:28');
/*!40000 ALTER TABLE `distritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_pedido`
--

DROP TABLE IF EXISTS `estados_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_pedido` (
  `id_estado_ped` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#6c757d',
  `orden` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_estado_ped`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_pedido`
--

LOCK TABLES `estados_pedido` WRITE;
/*!40000 ALTER TABLE `estados_pedido` DISABLE KEYS */;
INSERT INTO `estados_pedido` VALUES (1,'Pendiente','#ffc107',1,1,'2026-03-21 05:10:14','2026-03-21 05:10:14'),(2,'En proceso','#17a2b8',2,1,'2026-03-21 05:10:14','2026-03-21 05:10:14'),(3,'Enviado','#007bff',3,1,'2026-03-21 05:10:14','2026-03-21 05:10:14'),(4,'Entregado','#28a745',4,1,'2026-03-21 05:10:14','2026-03-21 05:10:14'),(5,'Cancelado','#dc3545',5,1,'2026-03-21 05:10:14','2026-03-21 05:10:14');
/*!40000 ALTER TABLE `estados_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_items`
--

DROP TABLE IF EXISTS `factura_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura_items` (
  `id_fac_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_factura` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_fac_item`),
  KEY `fk_fi_factura` (`id_factura`),
  KEY `fk_fi_producto` (`id_producto`),
  CONSTRAINT `fk_fi_factura` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_fi_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_items`
--

LOCK TABLES `factura_items` WRITE;
/*!40000 ALTER TABLE `factura_items` DISABLE KEYS */;
INSERT INTO `factura_items` VALUES (1,2,2,1,4000.00,4000.00,'2026-03-21 05:22:34','2026-03-21 05:22:34');
/*!40000 ALTER TABLE `factura_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `id_factura` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) unsigned NOT NULL,
  `numero_factura` varchar(30) NOT NULL,
  `fecha_emision` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `estado_factura` varchar(50) NOT NULL DEFAULT 'emitida',
  `observaciones` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_factura`),
  UNIQUE KEY `id_pedido` (`id_pedido`),
  UNIQUE KEY `numero_factura` (`numero_factura`),
  CONSTRAINT `fk_fac_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` VALUES (1,1,'FAC-20260320-0001','2026-03-20',4000.00,520.00,4520.00,'emitida',NULL,NULL,'2026-03-21 05:18:32','2026-03-21 05:18:32'),(2,2,'FAC-20260320-0002','2026-03-20',4000.00,520.00,4520.00,'emitida',NULL,NULL,'2026-03-21 05:22:34','2026-03-21 05:22:34'),(3,3,'FAC-20260323-0001','2026-03-23',49000.00,6370.00,55370.00,'emitida',NULL,NULL,'2026-03-24 02:43:08','2026-03-24 02:43:08'),(4,4,'FAC-20260325-0001','2026-03-25',7500.00,975.00,8475.00,'emitida',NULL,NULL,'2026-03-25 18:25:54','2026-03-25 18:25:54');
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes_productos`
--

DROP TABLE IF EXISTS `imagenes_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes_productos` (
  `id_img_prod` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt_text` varchar(150) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `es_principal` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_img_prod`),
  KEY `fk_ip_producto` (`id_producto`),
  CONSTRAINT `fk_ip_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes_productos`
--

LOCK TABLES `imagenes_productos` WRITE;
/*!40000 ALTER TABLE `imagenes_productos` DISABLE KEYS */;
INSERT INTO `imagenes_productos` VALUES (1,1,'productos/VOR2rsSpVPMtkM8DMwqCf7QwQx4ivzbyApEESsTb.webp','Quinoa Orgánica',1,1,'2026-03-21 10:15:51','2026-03-21 10:15:51'),(2,3,'productos/BE9TInkZzARYs0XaL5dWln78QMGdyurBUU910P25.webp','Capsulas de Omega 3',1,1,'2026-03-22 02:22:38','2026-03-22 02:22:38'),(3,4,'productos/PppEnM1B2Mua5LV5lbJqxodwXT9N07BuAfQKSyrI.webp','Capsulas de Citrato de Magnesio',1,1,'2026-03-22 02:25:19','2026-03-22 02:25:19'),(4,5,'productos/2Wg6SI8JD29ps8c2nHXiwo23fPK4ZiL3Eqzr2jOp.webp','Infusion de Manzanilla',1,1,'2026-03-22 02:28:55','2026-03-22 02:28:55'),(5,6,'productos/4blyIkulwJVof4HhdAZ3FjE47HfpBILJpWoM50OW.webp','Infusion de te verde',1,1,'2026-03-22 02:30:40','2026-03-22 02:30:40'),(6,7,'productos/ckhnhUQohRARXjzWWFIOROEmxi1KLeOCN9HMvYBl.webp','Aceite de Coco Extra Virgen',1,1,'2026-03-22 02:33:02','2026-03-22 02:33:02'),(7,8,'productos/9uigbJTqEJqX9rRNXkch2ZsHs9JvBspc0YttAbh6.jpg','Aceite de Oliva Extra Virgen',1,1,'2026-03-22 02:36:58','2026-03-22 02:36:58'),(8,9,'productos/exbAQkuWFyNzJv49pErgwu5E04oFxU97gXhfSdsR.webp','Gotas de Propoleo',1,1,'2026-03-22 02:38:48','2026-03-22 02:38:48'),(9,10,'productos/nYn5Ap8PymddzIEz4YSXyVTVuGAWxU55tV4qUApd.png','Gotas de Valeriana',1,1,'2026-03-22 02:41:30','2026-03-22 02:41:30'),(10,11,'productos/M0QeIcVOzEMK9tclzmKJKVaeUc6kJ5L9IvW2PPmo.jpg','Aceite Esencial de Lavanda',1,1,'2026-03-22 02:44:42','2026-03-22 02:44:42'),(11,12,'productos/ItgBVKFlEypxjJmdV2Dj1a5TadEfzFPGqcAkNLaV.webp','Aceite Esencial de Eucalipto',1,1,'2026-03-22 02:48:34','2026-03-22 02:48:34'),(12,13,'productos/fDrmQOQvMTRcFPWsax8NjtE4zhBQofVEZPIXe8lD.png','Jarabe Oral Natural Life para Niños',1,1,'2026-03-22 02:55:28','2026-03-22 02:55:28'),(13,14,'productos/35fqU0pFccQTw9oJfQbLbnznNTYGdWUZLj6HV8jP.png','Jarabe de Rábano Yodado Lancasco',1,1,'2026-03-22 02:56:40','2026-03-22 02:56:40'),(14,15,'productos/1ScJ3vrWu0GAgR3AG1fHIcHfG7eLc6z9RvRMsLiU.webp','Proteina Whey Organica Vainilla',1,1,'2026-03-22 03:22:24','2026-03-22 03:22:24'),(15,16,'productos/V3Ns0WNR8ytIRaRqcMA4GIdXgRCrqyoHo8lKSjGH.webp','Creatina Monohidratada',1,1,'2026-03-22 03:25:16','2026-03-22 03:25:16'),(16,17,'productos/bF3xQ7QvqvS2Hi7vSogSxXE4LoqW3UI5z1Rgnkkg.jpg','Jabon de Carbon Activado',1,1,'2026-03-22 03:27:02','2026-03-22 03:27:02'),(17,18,'productos/zVE99CA4BFxjW7cwdmienO0NLdPgtNOerkHbIyEZ.jpg','Jabon de Avena y Miel',1,1,'2026-03-22 03:28:19','2026-03-22 03:28:19'),(18,19,'productos/rfJboedeSoDtD7y1sFKOjW1nPuoqgdzCbomTueIG.png','Shampoo Herbácil Antipiojos',1,1,'2026-03-22 03:31:10','2026-03-22 03:31:10'),(19,20,'productos/nggKIHp6OJtjMau9JcZR8usCfrUCRtnAPHLqaw5h.png','Shampoo de Sábila con Ajo y 7 Maravillas',1,1,'2026-03-22 03:32:24','2026-03-22 03:32:24'),(20,21,'productos/Iol8XB8WYI6FNtRFz18FQx56lAJbv29zPx7wUQWr.webp','Avena Integral',1,1,'2026-03-22 03:37:18','2026-03-22 03:37:18'),(21,22,'productos/xf6r7o5aMEdsvrhDz1yyjtWvAOFcKLESaGHYZiw2.webp','Quinoa Orgánica',1,1,'2026-03-22 03:39:06','2026-03-22 03:39:06'),(22,23,'productos/UNxPp1ZmItaQeq00eKnXkhweIdt6HOf9aqeCeoxr.webp','Almendras',1,1,'2026-03-22 03:40:35','2026-03-22 03:40:35'),(23,24,'productos/6lp0gp44EojIlYro5VFqCw2oaAfukBFp4ktVCunm.webp','Semillas de Chia',1,1,'2026-03-22 03:42:11','2026-03-22 03:42:11'),(24,25,'productos/l2DEKHVRwj2kMKkSqciTnciNI2wTQaF7qTnXhBrA.png','Ungüento de Árnica y Caléndula Herbarium',1,1,'2026-03-22 03:44:53','2026-03-22 03:44:53'),(25,26,'productos/6FITLb0oNllJsiZOMsFmPdGKM47wUUHoIlk9MZry.png','Ungüento de Baba de Caracol con Colágeno',1,1,'2026-03-22 03:45:43','2026-03-22 03:45:43');
/*!40000 ALTER TABLE `imagenes_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodos_pago` (
  `id_met_pago` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_met_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodos_pago`
--

LOCK TABLES `metodos_pago` WRITE;
/*!40000 ALTER TABLE `metodos_pago` DISABLE KEYS */;
INSERT INTO `metodos_pago` VALUES (1,'Transferencia SINPE','Pago mediante SINPE Móvil',1,'2026-03-10 04:22:23','2026-03-10 04:22:23'),(2,'Depósito bancario','Depósito en cuenta bancaria',1,'2026-03-10 04:22:23','2026-03-10 04:22:23'),(3,'Efectivo al entregar','Pago en efectivo al momento de la entrega',1,'2026-03-10 04:22:23','2026-03-10 04:22:23'),(4,'Tarjeta Debito/Credito ','Pago en Tarjeta de Debito o Credito',1,'2026-03-10 04:30:11','2026-03-10 04:30:11');
/*!40000 ALTER TABLE `metodos_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `id_pago` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_met_pago` int(10) unsigned NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `referencia` varchar(150) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `fecha_procesamiento` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_pago`),
  KEY `fk_pag_metodo` (`id_met_pago`),
  KEY `fk_pag_pedido` (`id_pedido`),
  CONSTRAINT `fk_pag_metodo` FOREIGN KEY (`id_met_pago`) REFERENCES `metodos_pago` (`id_met_pago`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pag_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,1,1,4520.00,'pendiente',NULL,NULL,NULL,'2026-03-21 05:18:31','2026-03-21 05:18:31'),(2,1,2,4520.00,'pendiente',NULL,NULL,NULL,'2026-03-21 05:22:34','2026-03-21 05:22:34'),(3,4,3,55370.00,'pendiente',NULL,NULL,NULL,'2026-03-24 02:43:08','2026-03-24 02:43:08'),(4,1,4,8475.00,'pendiente',NULL,NULL,NULL,'2026-03-25 18:25:54','2026-03-25 18:25:54');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_items`
--

DROP TABLE IF EXISTS `pedido_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido_items` (
  `id_ped_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) unsigned NOT NULL,
  `id_producto` int(10) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_ped_item`),
  KEY `fk_pi_pedido` (`id_pedido`),
  KEY `fk_pi_producto` (`id_producto`),
  CONSTRAINT `fk_pi_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pi_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_items`
--

LOCK TABLES `pedido_items` WRITE;
/*!40000 ALTER TABLE `pedido_items` DISABLE KEYS */;
INSERT INTO `pedido_items` VALUES (1,2,2,1,4000.00,4000.00,'2026-03-21 05:22:34','2026-03-21 05:22:34');
/*!40000 ALTER TABLE `pedido_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id_pedido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_estado_ped` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `id_direccion` int(10) unsigned NOT NULL,
  `num_pedido` varchar(30) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `impuesto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `fecha_entrega_esperada` date DEFAULT NULL,
  `fecha_entrega_real` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `num_pedido` (`num_pedido`),
  KEY `fk_ped_estado` (`id_estado_ped`),
  KEY `fk_ped_user` (`id_user`),
  KEY `fk_ped_direccion` (`id_direccion`),
  CONSTRAINT `fk_ped_direccion` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`) ON UPDATE CASCADE,
  CONSTRAINT `fk_ped_estado` FOREIGN KEY (`id_estado_ped`) REFERENCES `estados_pedido` (`id_estado_ped`) ON UPDATE CASCADE,
  CONSTRAINT `fk_ped_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,4,8,1,'PED-20260320-0001',4000.00,0.00,520.00,0.00,4520.00,NULL,NULL,'2026-03-20',NULL,'2026-03-21 05:18:31','2026-03-21 05:19:15'),(2,2,8,1,'PED-20260320-0002',4000.00,0.00,520.00,0.00,4520.00,NULL,NULL,NULL,NULL,'2026-03-21 05:22:34','2026-03-24 04:51:01'),(3,4,8,3,'PED-20260323-0001',49000.00,0.00,6370.00,0.00,55370.00,NULL,NULL,'2026-03-23',NULL,'2026-03-24 02:43:08','2026-03-24 02:46:24'),(4,1,8,1,'PED-20260325-0001',7500.00,0.00,975.00,0.00,8475.00,NULL,NULL,NULL,NULL,'2026-03-25 18:25:54','2026-03-25 18:25:54');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_categoria`
--

DROP TABLE IF EXISTS `producto_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_categoria` (
  `id_producto` int(10) unsigned NOT NULL,
  `id_categoria` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_producto`,`id_categoria`),
  KEY `fk_pc_categoria` (`id_categoria`),
  CONSTRAINT `fk_pc_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
INSERT INTO `producto_categoria` VALUES (1,1),(2,1),(3,2),(4,2),(5,3),(6,3),(7,4),(8,4),(9,5),(10,5),(11,6),(12,6),(13,7),(14,7),(15,8),(16,8),(17,9),(18,9),(19,10),(20,10),(21,1),(22,1),(23,11),(24,11),(25,12),(26,12);
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id_producto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `sku` varchar(80) DEFAULT NULL,
  `ingredientes` text DEFAULT NULL,
  `beneficios` text DEFAULT NULL,
  `es_destacado` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Quinoa Orgánica','Quinoa orgánica de alta calidad, rica en proteínas y aminoácidos esenciales.',4000.00,50,5,'QUI-001','Quinoa orgánica 100%','Alto contenido proteico, sin gluten, fuente de hierro y calcio.',1,'2026-03-21 11:08:05','2026-03-21 10:15:51','2026-03-21 11:08:05'),(2,'Quinoa Orgánica','Quinoa orgánica de alta calidad, rica en proteínas y aminoácidos esenciales.',4000.00,29,5,'QUI-002','Quinoa orgánica 100%','Alto contenido proteico, sin gluten, fuente de hierro y calcio.',1,'2026-03-22 02:23:01','2026-03-21 11:17:11','2026-03-22 02:23:01'),(3,'Capsulas de Omega 3','Suplemento rico en ácidos grasos esenciales para la salud cardiovascular.',8500.00,20,5,'CAP-OMEGA3','Aceite de pescado, gelatina, glicerina.','Mejora la salud del corazón, función cerebral y reduce inflamación.',1,NULL,'2026-03-22 02:22:36','2026-03-22 02:22:36'),(4,'Capsulas de Citrato de Magnesio','Suplemento mineral esencial para músculos y sistema nervioso.',6000.00,25,5,'CAP-MAG','Citrato de magnesio, cápsula vegetal.','Reduce estrés, mejora el sueño y previene calambres.',1,NULL,'2026-03-22 02:25:18','2026-03-22 02:25:18'),(5,'Infusion de Manzanilla','Té natural relajante ideal para la digestión.',2500.00,30,5,'INF-MANZ','Flores de manzanilla secas.','Reduce ansiedad y mejora digestión.',1,NULL,'2026-03-22 02:28:55','2026-03-22 02:28:55'),(6,'Infusion de te verde','Bebida antioxidante que apoya el metabolismo.',3000.00,25,5,'INF-TEVERDE','Hojas de té verde.','Ayuda a quemar grasa y mejora energía.',0,NULL,'2026-03-22 02:30:40','2026-03-22 02:30:40'),(7,'Aceite de Coco Extra Virgen','Aceite natural multiuso para cocina y piel.',7000.00,20,5,'ACE-COCO','100% aceite de coco.','Mejora la piel, energía rápida y salud digestiva.',0,NULL,'2026-03-22 02:33:02','2026-03-22 02:33:02'),(8,'Aceite de Oliva Extra Virgen','Aceite saludable rico en grasas buenas.',8000.00,20,5,'ACE-OLIVA','Aceite de oliva prensado en frío.','Protege el corazón y reduce colesterol.',1,NULL,'2026-03-22 02:36:58','2026-03-22 02:36:58'),(9,'Gotas de Propoleo','Extracto natural para fortalecer defensas.',5000.00,15,5,'GOT-PROPO','Propóleo, alcohol.','Refuerza sistema inmune.',1,NULL,'2026-03-22 02:38:48','2026-03-22 02:38:48'),(10,'Gotas de Valeriana','Extracto relajante natural.',5000.00,13,5,'GOT-VAL','Extracto de valeriana.','Mejora sueño y reduce ansiedad.',0,NULL,'2026-03-22 02:41:30','2026-03-22 02:41:30'),(11,'Aceite Esencial de Lavanda','Aceite relajante para uso aromático.',6500.00,12,5,'ARO-LAV','Extracto de lavanda.','Reduce estrés y mejora el sueño.',1,NULL,'2026-03-22 02:44:42','2026-03-22 03:37:40'),(12,'Aceite Esencial de Eucalipto','Aceite refrescante para vías respiratorias.',6500.00,12,5,'ARO-EUC','Extracto de eucalipto.','Descongestiona y mejora respiración.',0,NULL,'2026-03-22 02:48:34','2026-03-22 02:48:34'),(13,'Jarabe Oral Natural Life para Niños','Jarabe natural para niños elaborado con ingredientes herbales que ayudan a fortalecer el sistema respiratorio y mejorar el bienestar general.',4500.00,15,5,'JAR-NATURAL-KIDS','Tomillo, jengibre, zacate de limón, vitaminas y minerales.','Refuerza el sistema inmunológico\r\nAlivia síntomas respiratorios\r\nApto para niños\r\nFórmula natural',0,NULL,'2026-03-22 02:55:28','2026-03-22 02:55:28'),(14,'Jarabe de Rábano Yodado Lancasco','Jarabe natural a base de rábano con yodo y hierro, ideal para fortalecer el organismo y mejorar las defensas.',5500.00,20,5,'JAR-RABANO','Rábano fresco, yodo, hierro, extractos naturales.','Fortalece el sistema inmunológico\r\nAporta hierro\r\nMejora la salud respiratoria\r\nSabor agradable',0,NULL,'2026-03-22 02:56:31','2026-03-22 02:56:31'),(15,'Proteina Whey Organica Vainilla','Proteína para recuperación muscular.',23000.00,15,5,'GYM-WHEY','Proteína de suero.','Aumento masa muscular.',0,NULL,'2026-03-22 03:22:24','2026-03-22 03:22:24'),(16,'Creatina Monohidratada','Suplemento deportivo que mejora la fuerza, potencia y rendimiento físico en entrenamientos intensos.',18000.00,18,5,'GYM-CREA','Creatina monohidratada pura.','Aumenta fuerza y rendimiento\r\nMejora resistencia muscular\r\nFavorece el crecimiento muscular\r\nIdeal para gimnasio',1,NULL,'2026-03-22 03:25:15','2026-03-22 03:37:30'),(17,'Jabon de Carbon Activado','Limpieza profunda para piel grasa.',2500.00,22,5,'JAB-CARB','Carbón activado, aceites naturales.','Elimina impurezas.',0,NULL,'2026-03-22 03:27:02','2026-03-22 03:27:02'),(18,'Jabon de Avena y Miel','Hidratación suave para piel sensible.',2500.00,18,5,'JAB-AVENA','Avena, miel.','Suaviza y nutre la piel.',0,NULL,'2026-03-22 03:28:19','2026-03-22 03:28:19'),(19,'Shampoo Herbácil Antipiojos','Shampoo especializado para eliminar piojos y liendres de forma efectiva y segura, ideal para uso familiar.',6500.00,12,5,'SHA-HERBACIL','Extractos naturales, agentes limpiadores suaves, componentes antipiojos.','Elimina piojos y liendres\r\nUso familiar seguro\r\nFácil aplicación\r\nIncluye peine especial',0,NULL,'2026-03-22 03:31:10','2026-03-22 03:31:10'),(20,'Shampoo de Sábila con Ajo y 7 Maravillas','Shampoo natural enriquecido con sábila, ajo y extractos herbales que fortalecen y nutren el cabello desde la raíz.',5600.00,15,5,'SHA-SABILA','Sábila (aloe vera), ajo, extractos naturales.','Fortalece el cabello\r\nEstimula el crecimiento\r\nHidrata el cuero cabelludo\r\nReduce la caída',0,NULL,'2026-03-22 03:32:12','2026-03-22 03:32:12'),(21,'Avena Integral','Avena integral natural ideal para desayunos saludables, rica en fibra y perfecta para una alimentación equilibrada.',1800.00,40,5,'GRA-AVENA','Avena 100% natural.','Rica en fibra\r\nMejora la digestión\r\nAporta energía sostenida\r\nAyuda a controlar el colesterol',0,NULL,'2026-03-22 03:37:18','2026-03-22 03:37:18'),(22,'Quinoa Orgánica','Quinoa orgánica considerada un superalimento por su alto contenido de proteínas y nutrientes esenciales.',3500.00,30,5,'GRA-QUINOA','Quinoa 100% natural.','Alta en proteína\r\nLibre de gluten\r\nRica en minerales\r\nIdeal para dietas saludables',0,NULL,'2026-03-22 03:39:06','2026-03-22 03:39:06'),(23,'Almendras','Almendras naturales ideales como snack saludable o complemento en diferentes comidas.',4000.00,25,5,'SEM-ALM','Almendras 100% naturales.','Grasas saludables\r\nFuente de proteína\r\nEnergía natural\r\nBenefician la salud del corazón',0,NULL,'2026-03-22 03:40:35','2026-03-22 03:40:35'),(24,'Semillas de Chia','Semillas de chía ricas en omega 3 y fibra, ideales para complementar una dieta balanceada.',2250.00,32,5,'SEM-CHIA','Semillas de chía 100% naturales.','Alta en omega 3\r\nMejora la digestión\r\nAporta energía\r\nAyuda a la saciedad',0,NULL,'2026-03-22 03:42:11','2026-03-22 03:42:11'),(25,'Ungüento de Árnica y Caléndula Herbarium','Ungüento natural elaborado con árnica y caléndula, ideal para aliviar dolores musculares, golpes e inflamaciones.',4500.00,20,5,'UNG-ARNICA-CAL','Árnica, caléndula, aceites naturales, cera.','Alivia dolores musculares\r\nReduce inflamación\r\nAyuda en golpes y moretones\r\nUso tópico natural',0,NULL,'2026-03-22 03:44:53','2026-03-22 03:44:53'),(26,'Ungüento de Baba de Caracol con Colágeno','Crema regeneradora a base de baba de caracol y colágeno que ayuda a mejorar la apariencia de la piel.',5000.00,13,5,'UNG-CARACOL','Extracto de baba de caracol, colágeno, componentes hidratantes.','Regenera la piel\r\nMejora elasticidad\r\nReduce manchas y cicatrices\r\nHidratación profunda',0,NULL,'2026-03-22 03:45:43','2026-03-24 08:45:44');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincias`
--

DROP TABLE IF EXISTS `provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincias` (
  `id_provincia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincias`
--

LOCK TABLES `provincias` WRITE;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` VALUES (1,'San José',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(2,'Alajuela',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(3,'Cartago',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(4,'Heredia',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(5,'Guanacaste',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(6,'Puntarenas',1,'2026-03-21 04:55:21','2026-03-21 04:55:21'),(7,'Limón',1,'2026-03-21 04:55:21','2026-03-21 04:55:21');
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_roles` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_roles`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrador con control total del sistema','2026-03-10 04:22:23','2026-03-10 04:22:23'),(2,'trabajador','Empleado interno con acceso a gestión operativa','2026-03-10 04:22:23','2026-03-10 04:22:23'),(3,'cliente','Usuario registrado que realiza compras','2026-03-10 04:22:23','2026-03-10 04:22:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id_user` int(10) unsigned NOT NULL,
  `id_roles` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`,`id_roles`),
  KEY `fk_ur_roles` (`id_roles`),
  CONSTRAINT `fk_ur_roles` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ur_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1,'2026-03-10 04:22:23','2026-03-10 04:22:23'),(3,2,'2026-03-21 04:33:07','2026-03-21 04:33:07'),(4,2,'2026-03-21 04:34:16','2026-03-21 04:34:16'),(5,2,'2026-03-21 04:35:28','2026-03-21 04:35:28'),(6,2,'2026-03-21 04:36:37','2026-03-21 04:36:37'),(7,2,'2026-03-21 04:37:39','2026-03-21 04:37:39'),(8,3,'2026-03-21 04:38:48','2026-03-21 04:38:48'),(9,3,'2026-03-21 05:05:37','2026-03-21 05:05:37'),(10,3,'2026-03-21 23:34:39','2026-03-21 23:34:39');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `identificacion` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `password_es_temporal` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@labendicion.cr','$2y$12$Q82Q117FRax3MdqCqD7kk.oYr.gNVpR5YIrAVVDNsIFAOPWvcwE36',NULL,NULL,1,0,'2026-03-10 04:22:23',NULL,NULL,'2026-03-10 04:22:23','2026-03-21 10:10:45'),(3,'Pablo Zuniga','pablo.zuniga@labendicion.cr','$2y$12$J7LEzmY4.6V3MC/HftjvceXoR7SkyknqE960WO1uYFUK3H8TuJASK','64727410',NULL,1,0,'2026-03-21 10:33:07',NULL,NULL,'2026-03-21 10:33:07','2026-03-21 10:33:07'),(4,'Fabricio Quesada','fabricio.quesada@labendicion.cr','$2y$12$XAuHVxXKwYEys8NtQFpw/.tV.ILCusddNYdtCZTqUKhk14eV7OO52','86763319',NULL,1,0,'2026-03-21 10:34:16',NULL,NULL,'2026-03-21 10:34:16','2026-03-21 10:34:16'),(5,'Daniel Valverde','daniel.valverde@labendicion.cr','$2y$12$aqmT9ZYSRVFHfnYiwf9wXOSbda84bKDbeIk3EvACphAV4pN5i2nDa','88470149',NULL,1,0,'2026-03-21 10:35:28',NULL,NULL,'2026-03-21 10:35:28','2026-03-21 10:35:28'),(6,'Isaac Acuna','isaac.acuna@labendicion.cr','$2y$12$z//QLstFOLUrc1QKX3wJUektKLRRX9ZlTqcAK60sei7sMnjZWZxJ6','83015594',NULL,1,0,'2026-03-21 10:36:37',NULL,NULL,'2026-03-21 10:36:37','2026-03-21 10:36:37'),(7,'Marcelo Quevedo','marcelo.quevedo@labendicion.cr','$2y$12$ZsW0yzHPl1KFKSciXg41HOpdmU9/rhrdpcfrQEpN/It844pt27Snq','88469017',NULL,1,0,'2026-03-21 10:37:39',NULL,NULL,'2026-03-21 10:37:39','2026-03-21 10:37:39'),(8,'Juan Perez','juan.perez22@outlook.com','$2y$12$.9wxrXVhKOWuc.xFkyAvWOJo8QIjhpxHMMUG1.f7yECMryScLa7m.','55555555',NULL,1,0,'2026-03-21 10:38:48',NULL,NULL,'2026-03-21 10:38:48','2026-03-21 10:38:48'),(9,'Maria Quesada','maria.quesada24@gmail.com','$2y$12$NVZOQvrZFO9iw9SCV77NvOwvtGn7INdithbtUDD4JmZZdfE0BX46e','88888888',NULL,1,0,'2026-03-21 11:05:37',NULL,'2026-03-21 11:07:42','2026-03-21 11:05:37','2026-03-21 11:07:42'),(10,'Isaac Acuna Leon','iacuna90074@ufide.ac.cr','$2y$12$S.L1BXI0eNJ9m3EOOFoVIu5dOuzM0zYGvYzr8zL3XitVMnx696p1.','11111111',NULL,0,1,'2026-03-22 05:34:39',NULL,NULL,'2026-03-22 05:34:39','2026-03-22 05:37:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'la_bendicion'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_agregar_al_carrito` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_agregar_al_carrito`(
    IN p_id_user     INT UNSIGNED,
    IN p_id_producto INT UNSIGNED,
    IN p_cantidad    INT
)
BEGIN
    DECLARE v_id_carrito      INT UNSIGNED;
    DECLARE v_id_c_item       INT UNSIGNED;
    DECLARE v_precio          DECIMAL(10,2);
    DECLARE v_cantidad_actual INT;

    -- Obtener o crear el carrito del usuario
    SELECT id_carrito INTO v_id_carrito
    FROM carritos
    WHERE id_user = p_id_user
    LIMIT 1;

    IF v_id_carrito IS NULL THEN
        INSERT INTO carritos (id_user, descuento, subtotal, total, created_at, updated_at)
        VALUES (p_id_user, 0, 0, 0, NOW(), NOW());
        SET v_id_carrito = LAST_INSERT_ID();
    END IF;

    -- Obtener precio actual del producto
    SELECT precio INTO v_precio
    FROM productos
    WHERE id_producto = p_id_producto
    AND deleted_at IS NULL;

    -- Verificar si el producto ya está en el carrito
    SELECT id_c_item, cantidad INTO v_id_c_item, v_cantidad_actual
    FROM cart_items
    WHERE id_carrito = v_id_carrito
    AND id_producto  = p_id_producto
    LIMIT 1;

    IF v_id_c_item IS NOT NULL THEN
        -- Producto ya existe, actualizar cantidad y subtotal
        UPDATE cart_items
        SET cantidad   = v_cantidad_actual + p_cantidad,
            subtotal   = (v_cantidad_actual + p_cantidad) * v_precio,
            updated_at = NOW()
        WHERE id_c_item = v_id_c_item;
    ELSE
        -- Producto nuevo, insertar en el carrito
        INSERT INTO cart_items (
            id_carrito, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            v_id_carrito, p_id_producto, p_cantidad,
            v_precio, p_cantidad * v_precio, NOW(), NOW()
        );
    END IF;

    -- Recalcular subtotal y total del carrito
    UPDATE carritos
    SET subtotal   = (SELECT COALESCE(SUM(subtotal), 0)
                      FROM cart_items
                      WHERE id_carrito = v_id_carrito),
        total      = (SELECT COALESCE(SUM(subtotal), 0)
                      FROM cart_items
                      WHERE id_carrito = v_id_carrito) - descuento,
        updated_at = NOW()
    WHERE id_carrito = v_id_carrito;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_buscar_productos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_productos`(
    IN  p_busqueda       VARCHAR(200),
    IN  p_categoria_slug VARCHAR(150),
    IN  p_limite         INT,
    IN  p_offset         INT,
    OUT p_total          INT
)
BEGIN

    -- ── 1. Contar total de registros coincidentes (para el paginador) ──────
    SELECT COUNT(DISTINCT p.id_producto) INTO p_total
    FROM productos p
    LEFT JOIN producto_categoria pc ON pc.id_producto  = p.id_producto
    LEFT JOIN categorias          c  ON c.id_categoria  = pc.id_categoria
    WHERE p.deleted_at IS NULL
      AND p.stock > 0
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre      LIKE CONCAT('%', p_busqueda, '%')
            OR p.descripcion LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (
            p_categoria_slug IS NULL OR p_categoria_slug = ''
            OR (c.slug = p_categoria_slug AND c.is_active = 1)
          );

    -- ── 2. Devolver página de resultados con imagen principal ─────────────
    SELECT
        p.id_producto,
        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.sku,
        p.es_destacado,
        p.created_at,
        img.url      AS imagen_url,
        img.alt_text AS imagen_alt
    FROM productos p
    LEFT JOIN producto_categoria pc  ON pc.id_producto  = p.id_producto
    LEFT JOIN categorias          c  ON c.id_categoria  = pc.id_categoria
    LEFT JOIN imagenes_productos  img ON img.id_producto = p.id_producto
                                     AND img.es_principal = 1
    WHERE p.deleted_at IS NULL
      AND p.stock > 0
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre      LIKE CONCAT('%', p_busqueda, '%')
            OR p.descripcion LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (
            p_categoria_slug IS NULL OR p_categoria_slug = ''
            OR (c.slug = p_categoria_slug AND c.is_active = 1)
          )
    GROUP BY p.id_producto
    ORDER BY p.nombre
    LIMIT  p_limite
    OFFSET p_offset;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_cambiar_estado_pedido` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cambiar_estado_pedido`(
    IN p_id_pedido INT UNSIGNED,
    IN p_id_estado INT UNSIGNED
)
BEGIN
    DECLARE v_nombre_estado VARCHAR(80);

    -- Obtener nombre del nuevo estado
    SELECT nombre INTO v_nombre_estado
    FROM estados_pedido
    WHERE id_estado_ped = p_id_estado
    LIMIT 1;

    -- Si es Entregado registrar fecha real
    IF v_nombre_estado = 'Entregado' THEN
        UPDATE pedidos
        SET id_estado_ped      = p_id_estado,
            fecha_entrega_real = CURDATE(),
            updated_at         = NOW()
        WHERE id_pedido    = p_id_pedido
        AND   deleted_at   IS NULL;
    ELSE
        UPDATE pedidos
        SET id_estado_ped = p_id_estado,
            updated_at    = NOW()
        WHERE id_pedido  = p_id_pedido
        AND   deleted_at IS NULL;
    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_confirmar_pedido` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_confirmar_pedido`(
    IN  p_id_user      INT UNSIGNED,
    IN  p_id_direccion INT UNSIGNED,
    IN  p_id_met_pago  INT UNSIGNED,
    OUT p_id_pedido    INT UNSIGNED,
    OUT p_num_pedido   VARCHAR(30)
)
BEGIN
    DECLARE v_id_carrito    INT UNSIGNED;
    DECLARE v_subtotal      DECIMAL(10,2);
    DECLARE v_impuesto      DECIMAL(10,2);
    DECLARE v_total         DECIMAL(10,2);
    DECLARE v_id_estado     INT UNSIGNED;
    DECLARE v_fecha         VARCHAR(8);
    DECLARE v_prefijo       VARCHAR(15);
    DECLARE v_ultimo        VARCHAR(30);
    DECLARE v_secuencia     INT;
    DECLARE v_id_producto   INT UNSIGNED;
    DECLARE v_cantidad      INT;
    DECLARE v_precio        DECIMAL(10,2);
    DECLARE v_item_subtotal DECIMAL(10,2);
    DECLARE done            INT DEFAULT 0;

    DECLARE cur_items CURSOR FOR
        SELECT ci.id_producto, ci.cantidad, ci.precio_unitario, ci.subtotal
        FROM cart_items ci
        INNER JOIN carritos c ON c.id_carrito = ci.id_carrito
        WHERE c.id_user = p_id_user;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    START TRANSACTION;

    -- Obtener el carrito del usuario
    SELECT id_carrito, subtotal INTO v_id_carrito, v_subtotal
    FROM carritos
    WHERE id_user = p_id_user
    LIMIT 1;

    -- Calcular impuesto 13% IVA Costa Rica y total
    SET v_impuesto = ROUND(v_subtotal * 0.13, 2);
    SET v_total    = v_subtotal + v_impuesto;

    -- Obtener estado inicial Pendiente
    SELECT id_estado_ped INTO v_id_estado
    FROM estados_pedido
    WHERE nombre = 'Pendiente'
    LIMIT 1;

    -- Generar número de pedido PED-YYYYMMDD-XXXX
    SET v_fecha   = DATE_FORMAT(NOW(), '%Y%m%d');
    SET v_prefijo = CONCAT('PED-', v_fecha, '-');

    SELECT num_pedido INTO v_ultimo
    FROM pedidos
    WHERE num_pedido LIKE CONCAT(v_prefijo, '%')
    ORDER BY num_pedido DESC
    LIMIT 1;

    IF v_ultimo IS NULL THEN
        SET v_secuencia = 1;
    ELSE
        SET v_secuencia = CAST(SUBSTRING(v_ultimo, -4) AS UNSIGNED) + 1;
    END IF;

    SET p_num_pedido = CONCAT(v_prefijo, LPAD(v_secuencia, 4, '0'));

    -- Crear el pedido
    INSERT INTO pedidos (
        id_estado_ped, id_user, id_direccion, num_pedido,
        subtotal, descuento, impuesto, costo_envio, total,
        created_at, updated_at
    )
    VALUES (
        v_id_estado, p_id_user, p_id_direccion, p_num_pedido,
        v_subtotal, 0, v_impuesto, 0, v_total,
        NOW(), NOW()
    );

    SET p_id_pedido = LAST_INSERT_ID();

    -- Recorrer ítems del carrito e insertarlos en pedido_items
    OPEN cur_items;
    loop_items: LOOP
        FETCH cur_items INTO v_id_producto, v_cantidad, v_precio, v_item_subtotal;
        IF done THEN
            LEAVE loop_items;
        END IF;

        -- Insertar ítem en pedido_items
        INSERT INTO pedido_items (
            id_pedido, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            p_id_pedido, v_id_producto, v_cantidad,
            v_precio, v_item_subtotal, NOW(), NOW()
        );

        -- Descontar stock
        UPDATE productos
        SET stock      = stock - v_cantidad,
            updated_at = NOW()
        WHERE id_producto = v_id_producto;

    END LOOP loop_items;
    CLOSE cur_items;

    -- Registrar pago inicial en estado pendiente
    INSERT INTO pagos (
        id_met_pago, id_pedido, monto,
        estado, created_at, updated_at
    )
    VALUES (
        p_id_met_pago, p_id_pedido, v_total,
        'pendiente', NOW(), NOW()
    );

    -- Vaciar el carrito
    CALL sp_vaciar_carrito(v_id_carrito);

    COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_generar_factura` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generar_factura`(
    IN  p_id_pedido  INT UNSIGNED,
    OUT p_id_factura INT UNSIGNED
)
BEGIN
    DECLARE v_subtotal      DECIMAL(10,2);
    DECLARE v_impuesto      DECIMAL(10,2);
    DECLARE v_total         DECIMAL(10,2);
    DECLARE v_fecha         VARCHAR(8);
    DECLARE v_prefijo       VARCHAR(15);
    DECLARE v_ultimo        VARCHAR(30);
    DECLARE v_secuencia     INT;
    DECLARE v_num_factura   VARCHAR(30);
    DECLARE v_id_producto   INT UNSIGNED;
    DECLARE v_cantidad      INT;
    DECLARE v_precio        DECIMAL(10,2);
    DECLARE v_item_subtotal DECIMAL(10,2);
    DECLARE done            INT DEFAULT 0;

    DECLARE cur_items CURSOR FOR
        SELECT id_producto, cantidad, precio_unitario, subtotal
        FROM pedido_items
        WHERE id_pedido = p_id_pedido;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Obtener totales del pedido
    SELECT subtotal, impuesto, total
    INTO v_subtotal, v_impuesto, v_total
    FROM pedidos
    WHERE id_pedido  = p_id_pedido
    AND   deleted_at IS NULL;

    -- Generar número de factura FAC-YYYYMMDD-XXXX
    SET v_fecha   = DATE_FORMAT(NOW(), '%Y%m%d');
    SET v_prefijo = CONCAT('FAC-', v_fecha, '-');

    SELECT numero_factura INTO v_ultimo
    FROM facturas
    WHERE numero_factura LIKE CONCAT(v_prefijo, '%')
    ORDER BY numero_factura DESC
    LIMIT 1;

    IF v_ultimo IS NULL THEN
        SET v_secuencia = 1;
    ELSE
        SET v_secuencia = CAST(SUBSTRING(v_ultimo, -4) AS UNSIGNED) + 1;
    END IF;

    SET v_num_factura = CONCAT(v_prefijo, LPAD(v_secuencia, 4, '0'));

    -- Crear la factura
    INSERT INTO facturas (
        id_pedido, numero_factura, fecha_emision,
        subtotal, impuesto, total,
        estado_factura, created_at, updated_at
    )
    VALUES (
        p_id_pedido, v_num_factura, CURDATE(),
        v_subtotal, v_impuesto, v_total,
        'emitida', NOW(), NOW()
    );

    SET p_id_factura = LAST_INSERT_ID();

    -- Insertar ítems de la factura desde pedido_items
    OPEN cur_items;
    loop_items: LOOP
        FETCH cur_items INTO v_id_producto, v_cantidad, v_precio, v_item_subtotal;
        IF done THEN
            LEAVE loop_items;
        END IF;

        INSERT INTO factura_items (
            id_factura, id_producto, cantidad,
            precio_unitario, subtotal, created_at, updated_at
        )
        VALUES (
            p_id_factura, v_id_producto, v_cantidad,
            v_precio, v_item_subtotal, NOW(), NOW()
        );

    END LOOP loop_items;
    CLOSE cur_items;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_listar_pedidos_admin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_pedidos_admin`(
    IN  p_busqueda  VARCHAR(200),
    IN  p_id_estado INT,
    IN  p_limite    INT,
    IN  p_offset    INT,
    OUT p_total     INT
)
BEGIN

    -- ── 1. Contar total de pedidos coincidentes ───────────────────────────
    SELECT COUNT(*) INTO p_total
    FROM pedidos ped
    INNER JOIN users u ON u.id_user = ped.id_user
    WHERE ped.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR ped.num_pedido LIKE CONCAT('%', p_busqueda, '%')
            OR u.nombre      LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (p_id_estado IS NULL OR p_id_estado = 0 OR ped.id_estado_ped = p_id_estado);

    -- ── 2. Devolver página de resultados ─────────────────────────────────
    SELECT
        ped.id_pedido,
        ped.num_pedido,
        ped.subtotal,
        ped.impuesto,
        ped.costo_envio,
        ped.total,
        ped.created_at,
        ped.updated_at,
        -- Datos del cliente
        u.id_user           AS cliente_id,
        u.nombre            AS cliente_nombre,
        u.email             AS cliente_email,
        -- Datos del estado
        ep.id_estado_ped,
        ep.nombre           AS estado_nombre,
        ep.color            AS estado_color
    FROM pedidos ped
    INNER JOIN users          u  ON u.id_user       = ped.id_user
    INNER JOIN estados_pedido ep ON ep.id_estado_ped = ped.id_estado_ped
    WHERE ped.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR ped.num_pedido LIKE CONCAT('%', p_busqueda, '%')
            OR u.nombre      LIKE CONCAT('%', p_busqueda, '%')
          )
      AND (p_id_estado IS NULL OR p_id_estado = 0 OR ped.id_estado_ped = p_id_estado)
    ORDER BY ped.created_at DESC
    LIMIT  p_limite
    OFFSET p_offset;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_listar_productos_admin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_productos_admin`(
    IN  p_busqueda VARCHAR(200),
    IN  p_limite   INT,
    IN  p_offset   INT,
    OUT p_total    INT
)
BEGIN

    -- ── 1. Contar total de productos coincidentes ─────────────────────────
    SELECT COUNT(*) INTO p_total
    FROM productos p
    WHERE p.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre LIKE CONCAT('%', p_busqueda, '%')
            OR p.sku    LIKE CONCAT('%', p_busqueda, '%')
          );

    -- ── 2. Devolver página de resultados con imagen principal ─────────────
    SELECT
        p.id_producto,
        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.stock_minimo,
        p.sku,
        p.es_destacado,
        p.created_at,
        p.updated_at,
        -- Imagen principal (NULL si no tiene)
        img.id_img_prod AS imagen_id,
        img.url         AS imagen_url,
        img.alt_text    AS imagen_alt
    FROM productos p
    LEFT JOIN imagenes_productos img
           ON img.id_producto  = p.id_producto
          AND img.es_principal = 1
    WHERE p.deleted_at IS NULL
      AND (
            p_busqueda IS NULL OR p_busqueda = ''
            OR p.nombre LIKE CONCAT('%', p_busqueda, '%')
            OR p.sku    LIKE CONCAT('%', p_busqueda, '%')
          )
    ORDER BY p.created_at DESC
    LIMIT  p_limite
    OFFSET p_offset;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_obtener_dashboard` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_dashboard`()
BEGIN

    SELECT
        -- Usuarios activos (sin soft-delete)
        (SELECT COUNT(*)
         FROM users
         WHERE is_active  = 1
           AND deleted_at IS NULL)                                           AS total_usuarios,

        -- Productos activos (sin soft-delete)
        (SELECT COUNT(*)
         FROM productos
         WHERE deleted_at IS NULL)                                          AS total_productos,

        -- Categorías activas
        (SELECT COUNT(*)
         FROM categorias
         WHERE is_active = 1)                                               AS total_categorias,

        -- Total de pedidos en el sistema
        (SELECT COUNT(*)
         FROM pedidos
         WHERE deleted_at IS NULL)                                          AS total_pedidos,

        -- Pedidos creados hoy
        (SELECT COUNT(*)
         FROM pedidos
         WHERE DATE(created_at) = CURDATE()
           AND deleted_at IS NULL)                                          AS pedidos_hoy,

        -- Ingresos del mes actual (suma de totales)
        (SELECT COALESCE(SUM(total), 0)
         FROM pedidos
         WHERE MONTH(created_at) = MONTH(NOW())
           AND YEAR(created_at)  = YEAR(NOW())
           AND deleted_at IS NULL)                                          AS ingresos_mes;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_vaciar_carrito` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vaciar_carrito`(
    IN p_id_carrito INT UNSIGNED
)
BEGIN
    -- Eliminar todos los ítems del carrito
    DELETE FROM cart_items
    WHERE id_carrito = p_id_carrito;

    -- Resetear totales a cero
    UPDATE carritos
    SET subtotal   = 0,
        descuento  = 0,
        total      = 0,
        updated_at = NOW()
    WHERE id_carrito = p_id_carrito;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-06 20:54:02
