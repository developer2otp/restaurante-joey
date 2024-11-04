-- MariaDB dump 10.19  Distrib 10.6.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: rbuvtkxo_res1
-- ------------------------------------------------------
-- Server version	10.6.15-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comunicacion_baja`
--

DROP TABLE IF EXISTS `comunicacion_baja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comunicacion_baja` (
  `id_comunicacion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `fecha_referencia` date DEFAULT NULL,
  `tipo_doc` char(2) DEFAULT NULL,
  `serie_doc` char(4) DEFAULT NULL,
  `num_doc` varchar(8) DEFAULT NULL,
  `nombre_baja` varchar(200) DEFAULT NULL,
  `correlativo` varchar(5) DEFAULT NULL,
  `enviado_sunat` char(1) DEFAULT NULL,
  `hash_cpe` varchar(100) DEFAULT NULL,
  `hash_cdr` varchar(100) DEFAULT NULL,
  `code_respuesta_sunat` varchar(5) DEFAULT NULL,
  `descripcion_sunat_cdr` varchar(300) DEFAULT NULL,
  `name_file_sunat` varchar(80) DEFAULT NULL,
  `estado` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id_comunicacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comunicacion_baja`
--

LOCK TABLES `comunicacion_baja` WRITE;
/*!40000 ALTER TABLE `comunicacion_baja` DISABLE KEYS */;
/*!40000 ALTER TABLE `comunicacion_baja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resumen_diario`
--

DROP TABLE IF EXISTS `resumen_diario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resumen_diario` (
  `id_resumen` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_resumen` date DEFAULT NULL,
  `fecha_referencia` date DEFAULT NULL,
  `correlativo` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enviado_sunat` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hash_cpe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hash_cdr` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_respuesta_sunat` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion_sunat_cdr` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name_file_sunat` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_resumen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resumen_diario`
--

LOCK TABLES `resumen_diario` WRITE;
/*!40000 ALTER TABLE `resumen_diario` DISABLE KEYS */;
/*!40000 ALTER TABLE `resumen_diario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resumen_diario_detalle`
--

DROP TABLE IF EXISTS `resumen_diario_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resumen_diario_detalle` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_resumen` int(11) DEFAULT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `status_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `FK_RDD_RES` (`id_resumen`),
  KEY `FK_RDD_VEN` (`id_venta`),
  CONSTRAINT `FK_RDD_RES` FOREIGN KEY (`id_resumen`) REFERENCES `resumen_diario` (`id_resumen`),
  CONSTRAINT `FK_RDD_VEN` FOREIGN KEY (`id_venta`) REFERENCES `tm_venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resumen_diario_detalle`
--

LOCK TABLES `resumen_diario_detalle` WRITE;
/*!40000 ALTER TABLE `resumen_diario_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `resumen_diario_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_almacen`
--

DROP TABLE IF EXISTS `tm_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_almacen` (
  `id_alm` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `estado` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'a',
  PRIMARY KEY (`id_alm`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_almacen`
--

LOCK TABLES `tm_almacen` WRITE;
/*!40000 ALTER TABLE `tm_almacen` DISABLE KEYS */;
INSERT INTO `tm_almacen` VALUES (1,'ABARROTES E INSUMOS','a'),(2,'BEBIDAS, GASEOSAS Y CERVEZAS','a');
/*!40000 ALTER TABLE `tm_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_aper_cierre`
--

DROP TABLE IF EXISTS `tm_aper_cierre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_aper_cierre` (
  `id_apc` int(11) NOT NULL AUTO_INCREMENT,
  `id_usu` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `id_turno` int(11) NOT NULL,
  `fecha_aper` datetime DEFAULT NULL,
  `monto_aper` decimal(10,2) DEFAULT 0.00,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_cierre` decimal(10,2) DEFAULT 0.00,
  `monto_sistema` decimal(10,2) DEFAULT 0.00,
  `stock_pollo` varchar(11) NOT NULL DEFAULT '0',
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_apc`),
  KEY `FK_ac_caja` (`id_caja`),
  KEY `FK_ac_turno` (`id_turno`),
  KEY `FK_ac_usu` (`id_usu`),
  CONSTRAINT `FK_ac_caja` FOREIGN KEY (`id_caja`) REFERENCES `tm_caja` (`id_caja`),
  CONSTRAINT `FK_ac_turno` FOREIGN KEY (`id_turno`) REFERENCES `tm_turno` (`id_turno`),
  CONSTRAINT `FK_ac_usu` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_aper_cierre`
--

LOCK TABLES `tm_aper_cierre` WRITE;
/*!40000 ALTER TABLE `tm_aper_cierre` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_aper_cierre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_area_prod`
--

DROP TABLE IF EXISTS `tm_area_prod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_area_prod` (
  `id_areap` int(11) NOT NULL AUTO_INCREMENT,
  `id_imp` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_areap`),
  KEY `FK_ap_alm` (`id_imp`),
  CONSTRAINT `FK_AP_IMP` FOREIGN KEY (`id_imp`) REFERENCES `tm_impresora` (`id_imp`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_area_prod`
--

LOCK TABLES `tm_area_prod` WRITE;
/*!40000 ALTER TABLE `tm_area_prod` DISABLE KEYS */;
INSERT INTO `tm_area_prod` VALUES (1,2,'COCINA','a'),(2,3,'BAR','a'),(3,2,'PARILLA','a');
/*!40000 ALTER TABLE `tm_area_prod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_caja`
--

DROP TABLE IF EXISTS `tm_caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_caja` (
  `id_caja` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_caja`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_caja`
--

LOCK TABLES `tm_caja` WRITE;
/*!40000 ALTER TABLE `tm_caja` DISABLE KEYS */;
INSERT INTO `tm_caja` VALUES (1,'CAJA PRINCIPAL','a');
/*!40000 ALTER TABLE `tm_caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_cliente`
--

DROP TABLE IF EXISTS `tm_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cliente` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL DEFAULT '00000000',
  `ruc` varchar(13) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `fecha_nac` date NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL DEFAULT 'S/DIRECCION',
  `referencia` varchar(100) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_cliente`
--

LOCK TABLES `tm_cliente` WRITE;
/*!40000 ALTER TABLE `tm_cliente` DISABLE KEYS */;
INSERT INTO `tm_cliente` VALUES (1,1,'00000000','','PUBLICO EN GENERAL','',0,'','','-','','a');
/*!40000 ALTER TABLE `tm_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_compra`
--

DROP TABLE IF EXISTS `tm_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_compra` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_prov` int(11) NOT NULL,
  `id_tipo_compra` int(11) NOT NULL,
  `id_tipo_doc` int(11) NOT NULL,
  `id_usu` int(11) DEFAULT NULL,
  `fecha_c` date DEFAULT NULL,
  `hora_c` varchar(45) DEFAULT NULL,
  `serie_doc` varchar(45) DEFAULT NULL,
  `num_doc` varchar(45) DEFAULT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'a',
  `observaciones` varchar(100) DEFAULT NULL,
  `fecha_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `FK_comp_prov` (`id_prov`),
  KEY `FK_comp_tipoc` (`id_tipo_compra`),
  KEY `FK_comp_tipod` (`id_tipo_doc`),
  KEY `FK_comp_usu` (`id_usu`),
  CONSTRAINT `FK_comp_prov` FOREIGN KEY (`id_prov`) REFERENCES `tm_proveedor` (`id_prov`),
  CONSTRAINT `FK_comp_tipoc` FOREIGN KEY (`id_tipo_compra`) REFERENCES `tm_tipo_compra` (`id_tipo_compra`),
  CONSTRAINT `FK_comp_tipod` FOREIGN KEY (`id_tipo_doc`) REFERENCES `tm_tipo_doc` (`id_tipo_doc`),
  CONSTRAINT `FK_comp_usu` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_compra`
--

LOCK TABLES `tm_compra` WRITE;
/*!40000 ALTER TABLE `tm_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_compra_credito`
--

DROP TABLE IF EXISTS `tm_compra_credito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_compra_credito` (
  `id_credito` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `interes` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(5) DEFAULT 'p',
  PRIMARY KEY (`id_credito`),
  KEY `FK_CC_ID_COMPRA_idx` (`id_compra`),
  CONSTRAINT `FK_compcre_idcomp` FOREIGN KEY (`id_compra`) REFERENCES `tm_compra` (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_compra_credito`
--

LOCK TABLES `tm_compra_credito` WRITE;
/*!40000 ALTER TABLE `tm_compra_credito` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_compra_credito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_compra_detalle`
--

DROP TABLE IF EXISTS `tm_compra_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_compra_detalle` (
  `id_compra` int(11) NOT NULL,
  `id_tp` int(11) NOT NULL,
  `id_pres` int(11) NOT NULL,
  `cant` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  KEY `FK_CDET_COM` (`id_compra`),
  CONSTRAINT `FK_CDET_COM` FOREIGN KEY (`id_compra`) REFERENCES `tm_compra` (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_compra_detalle`
--

LOCK TABLES `tm_compra_detalle` WRITE;
/*!40000 ALTER TABLE `tm_compra_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_compra_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_configuracion`
--

DROP TABLE IF EXISTS `tm_configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_configuracion` (
  `id_cfg` int(11) NOT NULL AUTO_INCREMENT,
  `zona_hora` varchar(100) DEFAULT NULL,
  `trib_acr` varchar(20) DEFAULT NULL,
  `trib_car` int(5) DEFAULT NULL,
  `di_acr` varchar(20) DEFAULT NULL,
  `di_car` int(5) DEFAULT NULL,
  `imp_acr` varchar(20) DEFAULT NULL,
  `imp_val` decimal(10,2) DEFAULT NULL,
  `mon_acr` varchar(20) DEFAULT NULL,
  `mon_val` varchar(5) DEFAULT NULL,
  `pc_name` varchar(50) DEFAULT NULL,
  `pc_ip` varchar(20) DEFAULT NULL,
  `print_com` int(1) DEFAULT NULL,
  `print_pre` int(1) DEFAULT NULL,
  `print_cpe` int(1) DEFAULT NULL,
  `opc_01` int(1) DEFAULT NULL,
  `opc_02` int(1) DEFAULT NULL,
  `opc_03` int(1) DEFAULT NULL,
  `bloqueo` int(1) DEFAULT NULL,
  `cod_seg` varchar(45) NOT NULL DEFAULT '123456',
  `style_tenant` longtext NOT NULL DEFAULT '{"body":"dark-mode layout-navbar-fixed","nav-sidebar":"","main-header":"bg-dark","main-sidebar":"sidebar-dark-primary","brand-link":""}',
  `type_operation` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cfg`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_configuracion`
--

LOCK TABLES `tm_configuracion` WRITE;
/*!40000 ALTER TABLE `tm_configuracion` DISABLE KEYS */;
INSERT INTO `tm_configuracion` VALUES (1,'America/Lima','RUC',11,'DNI',8,'IGV',10.00,'SOL','S/','PES-101ISL03','192.168.18.51',0,0,0,0,0,1,0,'123456','{"body":"dark-mode layout-navbar-fixed","nav-sidebar":"","main-header":"bg-dark","main-sidebar":"sidebar-dark-primary","brand-link":""}', 1);
/*!40000 ALTER TABLE `tm_configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_credito_detalle`
--

DROP TABLE IF EXISTS `tm_credito_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_credito_detalle` (
  `id_credito` int(11) DEFAULT NULL,
  `id_usu` int(11) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `egreso` int(1) DEFAULT 0,
  KEY `FK_cred_usu` (`id_usu`),
  KEY `FK_CRED_CRED` (`id_credito`),
  CONSTRAINT `FK_CRED_CRED` FOREIGN KEY (`id_credito`) REFERENCES `tm_compra_credito` (`id_credito`),
  CONSTRAINT `FK_cred_usu` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_credito_detalle`
--

LOCK TABLES `tm_credito_detalle` WRITE;
/*!40000 ALTER TABLE `tm_credito_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_credito_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_detalle_pedido`
--

DROP TABLE IF EXISTS `tm_detalle_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_detalle_pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_pres` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `fecha_pedido` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  KEY `FK_DPED_PRES` (`id_pres`),
  KEY `FK_DPED_PED` (`id_pedido`),
  KEY `FK_DPED_USU` (`id_usu`),
  CONSTRAINT `FK_DPED_PED` FOREIGN KEY (`id_pedido`) REFERENCES `tm_pedido` (`id_pedido`),
  CONSTRAINT `FK_DPED_PRES` FOREIGN KEY (`id_pres`) REFERENCES `tm_producto_pres` (`id_pres`),
  CONSTRAINT `FK_DPED_USU` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_detalle_pedido`
--

LOCK TABLES `tm_detalle_pedido` WRITE;
/*!40000 ALTER TABLE `tm_detalle_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_detalle_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_detalle_venta`
--

DROP TABLE IF EXISTS `tm_detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_detalle_venta` (
  `id_venta` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  KEY `FK_DVEN_VEN` (`id_venta`),
  KEY `FK_DVEN_PRES` (`id_prod`),
  CONSTRAINT `FK_DVEN_VEN` FOREIGN KEY (`id_venta`) REFERENCES `tm_venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_detalle_venta`
--

LOCK TABLES `tm_detalle_venta` WRITE;
/*!40000 ALTER TABLE `tm_detalle_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_empresa`
--

DROP TABLE IF EXISTS `tm_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_empresa` (
  `id_de` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(20) DEFAULT NULL,
  `razon_social` varchar(200) DEFAULT NULL,
  `nombre_comercial` varchar(200) DEFAULT NULL,
  `direccion_comercial` varchar(200) DEFAULT NULL,
  `direccion_fiscal` varchar(200) DEFAULT NULL,
  `ubigeo` varchar(8) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  `sunat` int(1) NOT NULL,
  `api_url_pro` varchar(60) DEFAULT NULL,
  `api_token_pro` varchar(200) DEFAULT NULL,
  `modo` int(1) DEFAULT NULL,
  `usuariosol` varchar(50) DEFAULT NULL,
  `clavesol` varchar(50) DEFAULT NULL,
  `clavecertificado` varchar(50) DEFAULT NULL,
  `client_id` varchar(45) DEFAULT NULL,
  `client_secret` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `comentario_comprobante` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_de`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_empresa`
--

LOCK TABLES `tm_empresa` WRITE;
/*!40000 ALTER TABLE `tm_empresa` DISABLE KEYS */;
INSERT INTO `tm_empresa` VALUES (1,'20432168213','INVERSIONES NOR CHICKEN S.A.C','INVERSIONES NOR CHICKEN S.A.C','JR. DOMINGO CUETO NRO. 444 INT. 307 URB. RISSO','JR. DOMINGO CUETO NRO. 444 INT. 307 URB. RISSO','150132','LIMA','LIMA','JESUS MARIA',1,'https://demo.tudominio.com','aOSQNnmXpnf3lcRtfRaHadEmkK8EIHJtsvKgTKxLHCEWmqTbsC',3,'MODDATOS','MODDATOS','institutoisi','052636a1-befe-4591-8c83-aadf0e2854a7','Us23ZfDVYxNpCqx75wlztg==','logoprint.png','000000000','','');
/*!40000 ALTER TABLE `tm_empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_gastos_adm`
--

DROP TABLE IF EXISTS `tm_gastos_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_gastos_adm` (
  `id_ga` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_gasto` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_apc` int(11) NOT NULL,
  `id_per` int(11) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_ga`),
  KEY `FK_gasto_tg` (`id_tipo_gasto`),
  KEY `FK_EADM_APC` (`id_apc`),
  KEY `FK_EADM_USU` (`id_usu`),
  CONSTRAINT `FK_EADM_APC` FOREIGN KEY (`id_apc`) REFERENCES `tm_aper_cierre` (`id_apc`),
  CONSTRAINT `FK_EADM_TGAS` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `tm_tipo_gasto` (`id_tipo_gasto`),
  CONSTRAINT `FK_EADM_USU` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_gastos_adm`
--

LOCK TABLES `tm_gastos_adm` WRITE;
/*!40000 ALTER TABLE `tm_gastos_adm` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_gastos_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_impresora`
--

DROP TABLE IF EXISTS `tm_impresora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_impresora` (
  `id_imp` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_imp`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_impresora`
--

LOCK TABLES `tm_impresora` WRITE;
/*!40000 ALTER TABLE `tm_impresora` DISABLE KEYS */;
INSERT INTO `tm_impresora` VALUES (1,'NINGUNO','a'),(2,'COCINA','a'),(3,'CAJA','a');
/*!40000 ALTER TABLE `tm_impresora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_ingresos_adm`
--

DROP TABLE IF EXISTS `tm_ingresos_adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_ingresos_adm` (
  `id_ing` int(11) NOT NULL AUTO_INCREMENT,
  `id_usu` int(11) NOT NULL,
  `id_apc` int(11) NOT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `fecha_reg` datetime DEFAULT NULL,
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_ing`),
  KEY `FK_IADM_USU` (`id_usu`),
  KEY `FK_IADM_APC` (`id_apc`),
  CONSTRAINT `FK_IADM_APC` FOREIGN KEY (`id_apc`) REFERENCES `tm_aper_cierre` (`id_apc`),
  CONSTRAINT `FK_IADM_USU` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_ingresos_adm`
--

LOCK TABLES `tm_ingresos_adm` WRITE;
/*!40000 ALTER TABLE `tm_ingresos_adm` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_ingresos_adm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_insumo`
--

DROP TABLE IF EXISTS `tm_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_insumo` (
  `id_ins` int(11) NOT NULL AUTO_INCREMENT,
  `id_catg` int(11) NOT NULL,
  `id_med` int(11) NOT NULL,
  `cod_ins` varchar(10) DEFAULT NULL,
  `nomb_ins` varchar(45) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `cos_uni` decimal(10,2) DEFAULT NULL,
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_ins`),
  KEY `FK_ins_catg` (`id_catg`),
  KEY `FK_ins_med` (`id_med`),
  CONSTRAINT `FK_ins_catg` FOREIGN KEY (`id_catg`) REFERENCES `tm_insumo_catg` (`id_catg`),
  CONSTRAINT `FK_ins_med` FOREIGN KEY (`id_med`) REFERENCES `tm_tipo_medida` (`id_med`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_insumo`
--

LOCK TABLES `tm_insumo` WRITE;
/*!40000 ALTER TABLE `tm_insumo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_insumo_catg`
--

DROP TABLE IF EXISTS `tm_insumo_catg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_insumo_catg` (
  `id_catg` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `estado` varchar(5) DEFAULT 'a',
  PRIMARY KEY (`id_catg`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_insumo_catg`
--

LOCK TABLES `tm_insumo_catg` WRITE;
/*!40000 ALTER TABLE `tm_insumo_catg` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_insumo_catg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_inventario`
--

DROP TABLE IF EXISTS `tm_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_inventario` (
  `id_inv` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_ope` int(11) NOT NULL,
  `id_ope` int(11) NOT NULL,
  `id_tipo_ins` int(11) NOT NULL,
  `id_ins` int(11) NOT NULL,
  `cos_uni` decimal(10,2) NOT NULL,
  `cant` float NOT NULL,
  `fecha_r` datetime NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_inv`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_inventario`
--

LOCK TABLES `tm_inventario` WRITE;
/*!40000 ALTER TABLE `tm_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_inventario_entsal`
--

DROP TABLE IF EXISTS `tm_inventario_entsal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_inventario_entsal` (
  `id_es` int(11) NOT NULL AUTO_INCREMENT,
  `id_usu` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `motivo` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_es`),
  KEY `FK_INVES_USU` (`id_usu`),
  KEY `FK_INVES_RESP` (`id_responsable`),
  CONSTRAINT `FK_INVES_RESP` FOREIGN KEY (`id_responsable`) REFERENCES `tm_usuario` (`id_usu`),
  CONSTRAINT `FK_INVES_USU` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_inventario_entsal`
--

LOCK TABLES `tm_inventario_entsal` WRITE;
/*!40000 ALTER TABLE `tm_inventario_entsal` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_inventario_entsal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_margen_venta`
--

DROP TABLE IF EXISTS `tm_margen_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_margen_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dia` int(11) NOT NULL,
  `dia` varchar(45) NOT NULL,
  `margen` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_margen_venta`
--

LOCK TABLES `tm_margen_venta` WRITE;
/*!40000 ALTER TABLE `tm_margen_venta` DISABLE KEYS */;
INSERT INTO `tm_margen_venta` VALUES (1,1,'Lunes',150.00),(2,2,'Martes',750.00),(3,3,'Miércoles',750.00),(4,4,'Jueves',850.00),(5,5,'Viernes',1200.00),(6,6,'Sábado',1800.00),(7,0,'Domingo',2500.00);
/*!40000 ALTER TABLE `tm_margen_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_mesa`
--

DROP TABLE IF EXISTS `tm_mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_mesa` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `id_salon` int(11) NOT NULL,
  `nro_mesa` varchar(7) NOT NULL,
  `estado` varchar(3) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_mesa`),
  KEY `FKM_IDCATG_idx` (`id_salon`),
  CONSTRAINT `fk_mesa_salon` FOREIGN KEY (`id_salon`) REFERENCES `tm_salon` (`id_salon`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_mesa`
--

LOCK TABLES `tm_mesa` WRITE;
/*!40000 ALTER TABLE `tm_mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_pago`
--

DROP TABLE IF EXISTS `tm_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_pago` (
  `id_pago` int(2) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_pago`
--

LOCK TABLES `tm_pago` WRITE;
/*!40000 ALTER TABLE `tm_pago` DISABLE KEYS */;
INSERT INTO `tm_pago` VALUES (1,'EFECTIVO'),(2,'TARJETAS'),(3,'MIXTO'),(4,'EN LINEA'),(5,'TRANSFERENCIAS'),(6,'VALES');
/*!40000 ALTER TABLE `tm_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_pedido`
--

DROP TABLE IF EXISTS `tm_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_pedido` int(11) NOT NULL,
  `id_apc` int(11) DEFAULT NULL,
  `id_usu` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_pedido`),
  KEY `FK_ped_tp` (`id_tipo_pedido`),
  KEY `FK_ped_usu` (`id_usu`),
  KEY `FK_ped_apc` (`id_apc`),
  CONSTRAINT `FK_ped_tp` FOREIGN KEY (`id_tipo_pedido`) REFERENCES `tm_tipo_pedido` (`id_tipo_pedido`),
  CONSTRAINT `FK_ped_usu` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_pedido`
--

LOCK TABLES `tm_pedido` WRITE;
/*!40000 ALTER TABLE `tm_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_pedido_delivery`
--

DROP TABLE IF EXISTS `tm_pedido_delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_pedido_delivery` (
  `id_pedido` int(11) NOT NULL,
  `tipo_canal` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_repartidor` int(11) NOT NULL,
  `tipo_pago` int(11) NOT NULL,
  `tipo_entrega` int(11) NOT NULL,
  `pedido_programado` int(11) DEFAULT 0,
  `hora_entrega` time DEFAULT '00:00:00',
  `paga_con` decimal(10,2) NOT NULL,
  `comision_delivery` decimal(10,2) NOT NULL,
  `amortizacion` decimal(10,2) NOT NULL,
  `nro_pedido` varchar(10) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `telefono_cliente` varchar(20) NOT NULL,
  `direccion_cliente` varchar(100) NOT NULL,
  `referencia_cliente` varchar(100) NOT NULL,
  `email_cliente` varchar(200) NOT NULL,
  `fecha_preparacion` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  KEY `FK_peddel_ped` (`id_pedido`),
  KEY `FK_peddel_cli` (`id_cliente`),
  CONSTRAINT `FK_peddel_cli` FOREIGN KEY (`id_cliente`) REFERENCES `tm_cliente` (`id_cliente`),
  CONSTRAINT `FK_peddel_ped` FOREIGN KEY (`id_pedido`) REFERENCES `tm_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_pedido_delivery`
--

LOCK TABLES `tm_pedido_delivery` WRITE;
/*!40000 ALTER TABLE `tm_pedido_delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_pedido_delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_pedido_llevar`
--

DROP TABLE IF EXISTS `tm_pedido_llevar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_pedido_llevar` (
  `id_pedido` int(11) NOT NULL,
  `nro_pedido` varchar(10) NOT NULL,
  `nomb_cliente` varchar(100) NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  KEY `FK_pedlle_ped` (`id_pedido`),
  CONSTRAINT `FK_pedlle_ped` FOREIGN KEY (`id_pedido`) REFERENCES `tm_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_pedido_llevar`
--

LOCK TABLES `tm_pedido_llevar` WRITE;
/*!40000 ALTER TABLE `tm_pedido_llevar` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_pedido_llevar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_pedido_mesa`
--

DROP TABLE IF EXISTS `tm_pedido_mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_pedido_mesa` (
  `id_pedido` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_mozo` int(11) NOT NULL,
  `nomb_cliente` varchar(45) NOT NULL,
  `nro_personas` int(11) NOT NULL,
  KEY `FK_pedme_ped` (`id_pedido`),
  KEY `FK_pedme_mesa` (`id_mesa`),
  KEY `FK_pedme_mozo` (`id_mozo`),
  CONSTRAINT `FK_pedme_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tm_mesa` (`id_mesa`),
  CONSTRAINT `FK_pedme_mozo` FOREIGN KEY (`id_mozo`) REFERENCES `tm_usuario` (`id_usu`),
  CONSTRAINT `FK_pedme_ped` FOREIGN KEY (`id_pedido`) REFERENCES `tm_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_pedido_mesa`
--

LOCK TABLES `tm_pedido_mesa` WRITE;
/*!40000 ALTER TABLE `tm_pedido_mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_pedido_mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_producto`
--

DROP TABLE IF EXISTS `tm_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_producto` (
  `id_prod` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo` int(11) NOT NULL,
  `id_catg` int(11) NOT NULL DEFAULT 0,
  `id_areap` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `notas` varchar(200) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `delivery` int(1) DEFAULT 0,
  `estado` varchar(1) DEFAULT 'a',
  `cod_pro` varchar(45) NOT NULL,
  PRIMARY KEY (`id_prod`),
  KEY `FK_prod_catg` (`id_catg`),
  KEY `FK_prod_area` (`id_areap`),
  CONSTRAINT `FK_prod_area` FOREIGN KEY (`id_areap`) REFERENCES `tm_area_prod` (`id_areap`),
  CONSTRAINT `FK_prod_catg` FOREIGN KEY (`id_catg`) REFERENCES `tm_producto_catg` (`id_catg`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_producto`
--

LOCK TABLES `tm_producto` WRITE;
/*!40000 ALTER TABLE `tm_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_producto_catg`
--

DROP TABLE IF EXISTS `tm_producto_catg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_producto_catg` (
  `id_catg` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `delivery` int(1) NOT NULL DEFAULT 0,
  `orden` int(11) NOT NULL DEFAULT 100,
  `imagen` varchar(200) NOT NULL DEFAULT 'default.png',
  `estado` varchar(1) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_catg`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_producto_catg`
--

LOCK TABLES `tm_producto_catg` WRITE;
/*!40000 ALTER TABLE `tm_producto_catg` DISABLE KEYS */;
INSERT INTO `tm_producto_catg` VALUES (1,'COMBOS',0,100,'default.png','a');
/*!40000 ALTER TABLE `tm_producto_catg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_producto_ingr`
--

DROP TABLE IF EXISTS `tm_producto_ingr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_producto_ingr` (
  `id_pi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pres` int(11) NOT NULL,
  `id_tipo_ins` int(11) NOT NULL,
  `id_ins` int(11) NOT NULL,
  `id_med` int(11) NOT NULL,
  `cant` float(10,6) NOT NULL,
  PRIMARY KEY (`id_pi`),
  KEY `FK_PING_PRES` (`id_pres`),
  KEY `FK_PING_INS` (`id_ins`),
  KEY `FK_PING_MED` (`id_med`),
  CONSTRAINT `FK_PING_MED` FOREIGN KEY (`id_med`) REFERENCES `tm_tipo_medida` (`id_med`),
  CONSTRAINT `FK_PING_PRES` FOREIGN KEY (`id_pres`) REFERENCES `tm_producto_pres` (`id_pres`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_producto_ingr`
--

LOCK TABLES `tm_producto_ingr` WRITE;
/*!40000 ALTER TABLE `tm_producto_ingr` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_producto_ingr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_producto_pres`
--

DROP TABLE IF EXISTS `tm_producto_pres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_producto_pres` (
  `id_pres` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) NOT NULL,
  `cod_prod` varchar(45) NOT NULL,
  `presentacion` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precio_delivery` decimal(10,2) NOT NULL,
  `receta` int(1) NOT NULL,
  `stock_min` int(11) NOT NULL,
  `crt_stock` int(1) NOT NULL DEFAULT 0,
  `impuesto` int(1) NOT NULL,
  `delivery` int(1) NOT NULL DEFAULT 0,
  `margen` int(11) NOT NULL DEFAULT 0,
  `igv` decimal(10,2) NOT NULL,
  `imagen` varchar(200) NOT NULL DEFAULT 'default.png',
  `estado` varchar(1) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_pres`),
  KEY `FK_PROP_PROD` (`id_prod`),
  CONSTRAINT `FK_PROP_PROD` FOREIGN KEY (`id_prod`) REFERENCES `tm_producto` (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_producto_pres`
--

LOCK TABLES `tm_producto_pres` WRITE;
/*!40000 ALTER TABLE `tm_producto_pres` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_producto_pres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_proveedor`
--

DROP TABLE IF EXISTS `tm_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_proveedor` (
  `id_prov` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(13) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` int(9) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contacto` varchar(45) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'a',
  PRIMARY KEY (`id_prov`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_proveedor`
--

LOCK TABLES `tm_proveedor` WRITE;
/*!40000 ALTER TABLE `tm_proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_repartidor`
--

DROP TABLE IF EXISTS `tm_repartidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_repartidor` (
  `id_repartidor` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_repartidor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_repartidor`
--

LOCK TABLES `tm_repartidor` WRITE;
/*!40000 ALTER TABLE `tm_repartidor` DISABLE KEYS */;
INSERT INTO `tm_repartidor` VALUES (1,'INTERNO','a'),(2,'RAPPI','a'),(3,'UBER','a'),(4,'GLOVO','a');
/*!40000 ALTER TABLE `tm_repartidor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_rol`
--

DROP TABLE IF EXISTS `tm_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_rol`
--

LOCK TABLES `tm_rol` WRITE;
/*!40000 ALTER TABLE `tm_rol` DISABLE KEYS */;
INSERT INTO `tm_rol` VALUES (1,'ADMINISTRATOR'),(2,'ADMINISTRADOR'),(3,'CAJERO'),(4,'PRODUCCION'),(5,'MOZO'),(6,'REPARTIDOR');
/*!40000 ALTER TABLE `tm_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_salon`
--

DROP TABLE IF EXISTS `tm_salon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_salon` (
  `id_salon` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_salon`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_salon`
--

LOCK TABLES `tm_salon` WRITE;
/*!40000 ALTER TABLE `tm_salon` DISABLE KEYS */;
INSERT INTO `tm_salon` VALUES (1,'PRIMER PISO','a'),(2,'SEGUNDO PISO','a');
/*!40000 ALTER TABLE `tm_salon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_stock_pedidos`
--

CREATE TABLE `tm_stock_pedidos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_pres` INT,
    `cant` INT,
    `estado` VARCHAR(1)
);

--
-- Table structure for table `tm_tipo_compra`
--

DROP TABLE IF EXISTS `tm_tipo_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_compra` (
  `id_tipo_compra` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_compra`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_compra`
--

LOCK TABLES `tm_tipo_compra` WRITE;
/*!40000 ALTER TABLE `tm_tipo_compra` DISABLE KEYS */;
INSERT INTO `tm_tipo_compra` VALUES (1,'CONTADO'),(2,'CREDITO');
/*!40000 ALTER TABLE `tm_tipo_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_doc`
--

DROP TABLE IF EXISTS `tm_tipo_doc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_doc` (
  `id_tipo_doc` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `serie` char(4) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_tipo_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_doc`
--

LOCK TABLES `tm_tipo_doc` WRITE;
/*!40000 ALTER TABLE `tm_tipo_doc` DISABLE KEYS */;
INSERT INTO `tm_tipo_doc` VALUES (1,'BOLETA DE VENTA','B001','00000000','a'),(2,'FACTURA','F001','00000000','a'),(3,'NOTA DE VENTA','NV01','00000000','a');
/*!40000 ALTER TABLE `tm_tipo_doc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_gasto`
--

DROP TABLE IF EXISTS `tm_tipo_gasto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_gasto` (
  `id_tipo_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_gasto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_gasto`
--

LOCK TABLES `tm_tipo_gasto` WRITE;
/*!40000 ALTER TABLE `tm_tipo_gasto` DISABLE KEYS */;
INSERT INTO `tm_tipo_gasto` VALUES (1,'POR COMPRAS'),(2,'POR SREVICIOS'),(3,'POR REMUNERACION'),(4,'POR CREDITO DE COMPRAS');
/*!40000 ALTER TABLE `tm_tipo_gasto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_medida`
--

DROP TABLE IF EXISTS `tm_tipo_medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_medida` (
  `id_med` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `grupo` int(11) NOT NULL,
  PRIMARY KEY (`id_med`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_medida`
--

LOCK TABLES `tm_tipo_medida` WRITE;
/*!40000 ALTER TABLE `tm_tipo_medida` DISABLE KEYS */;
INSERT INTO `tm_tipo_medida` VALUES (1,'UNIDAD',1),(2,'KILOS',2),(3,'GRAMOS',2),(4,'MILIGRAMOS',2),(5,'LITRO',3),(6,'MILILITRO',3),(7,'LIBRAS',2),(8,'ONZAS',4);
/*!40000 ALTER TABLE `tm_tipo_medida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_pago`
--

DROP TABLE IF EXISTS `tm_tipo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_pago` (
  `id_tipo_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_pago` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `estado` varchar(5) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`id_tipo_pago`),
  KEY `FK_TIPODEPAGO` (`id_pago`),
  CONSTRAINT `FK_TIPODEPAGO` FOREIGN KEY (`id_pago`) REFERENCES `tm_pago` (`id_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_pago`
--

LOCK TABLES `tm_tipo_pago` WRITE;
/*!40000 ALTER TABLE `tm_tipo_pago` DISABLE KEYS */;
INSERT INTO `tm_tipo_pago` VALUES (1,1,'EFECTIVO','a'),(2,2,'TARJETA','a'),(3,3,'PAGO MIXTO','a'),(4,4,'CULQI','a'),(5,5,'YAPE','a'),(6,5,'LUKITA','a'),(7,5,'TRANSFERENCIA','a'),(8,5,'PLIN','a'),(9,5,'TUNKI','a');
/*!40000 ALTER TABLE `tm_tipo_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_pedido`
--

DROP TABLE IF EXISTS `tm_tipo_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_pedido` (
  `id_tipo_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_pedido`
--

LOCK TABLES `tm_tipo_pedido` WRITE;
/*!40000 ALTER TABLE `tm_tipo_pedido` DISABLE KEYS */;
INSERT INTO `tm_tipo_pedido` VALUES (1,'MESA'),(2,'LLEVAR'),(3,'DELIVERY');
/*!40000 ALTER TABLE `tm_tipo_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_tipo_venta`
--

DROP TABLE IF EXISTS `tm_tipo_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_tipo_venta` (
  `id_tipo_venta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo_venta`
--

LOCK TABLES `tm_tipo_venta` WRITE;
/*!40000 ALTER TABLE `tm_tipo_venta` DISABLE KEYS */;
INSERT INTO `tm_tipo_venta` VALUES (1,'CONTADO'),(2,'CREDITO');
/*!40000 ALTER TABLE `tm_tipo_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_turno`
--

DROP TABLE IF EXISTS `tm_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_turno` (
  `id_turno` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_turno`
--

LOCK TABLES `tm_turno` WRITE;
/*!40000 ALTER TABLE `tm_turno` DISABLE KEYS */;
INSERT INTO `tm_turno` VALUES (1,'PRIMER TURNO');
/*!40000 ALTER TABLE `tm_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_usuario`
--

DROP TABLE IF EXISTS `tm_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_usuario` (
  `id_usu` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_areap` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `ape_paterno` varchar(45) DEFAULT NULL,
  `ape_materno` varchar(45) DEFAULT NULL,
  `nombres` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT 'cmVzdHBl',
  `estado` varchar(5) DEFAULT 'a',
  `imagen` varchar(45) DEFAULT 'default-avatar.png',
  PRIMARY KEY (`id_usu`),
  KEY `FKU_IDROL_idx` (`id_rol`),
  CONSTRAINT `FK_usu_rol` FOREIGN KEY (`id_rol`) REFERENCES `tm_rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_usuario`
--

LOCK TABLES `tm_usuario` WRITE;
/*!40000 ALTER TABLE `tm_usuario` DISABLE KEYS */;
INSERT INTO `tm_usuario` VALUES (1,1,0,'44827499','ADMINISTRADOR','ADMINISTRADOR','ADMINISTRADOR','administrador@gmail.com','administrador','YWRtaW5pc3RyYWRvcg==','a','default-avatar.png');
/*!40000 ALTER TABLE `tm_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tm_venta`
--

DROP TABLE IF EXISTS `tm_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tm_venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_tipo_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tipo_doc` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_apc` int(11) NOT NULL,
  `serie_doc` char(4) NOT NULL,
  `nro_doc` varchar(8) NOT NULL,
  `pago_efe` decimal(10,2) DEFAULT 0.00,
  `pago_efe_none` decimal(10,2) DEFAULT 0.00,
  `pago_tar` decimal(10,2) DEFAULT 0.00,
  `descuento_tipo` char(1) NOT NULL DEFAULT '1',
  `descuento_personal` int(11) DEFAULT NULL,
  `descuento_monto` decimal(10,2) DEFAULT 0.00,
  `descuento_motivo` varchar(200) DEFAULT NULL,
  `comision_tarjeta` decimal(10,2) DEFAULT 0.00,
  `comision_delivery` decimal(10,2) DEFAULT 0.00,
  `igv` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `codigo_operacion` varchar(20) DEFAULT NULL,
  `fecha_venta` datetime DEFAULT NULL,
  `estado` varchar(15) DEFAULT 'a',
  `enviado_sunat` char(1) DEFAULT NULL,
  `code_respuesta_sunat` varchar(5) NOT NULL,
  `descripcion_sunat_cdr` varchar(300) NOT NULL,
  `name_file_sunat` varchar(80) NOT NULL,
  `hash_cdr` varchar(200) NOT NULL,
  `hash_cpe` varchar(200) NOT NULL,
  `external_id` varchar(80) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `FK_venta_cli` (`id_cliente`),
  KEY `FK_venta_td` (`id_tipo_doc`),
  KEY `FK_venta_tp` (`id_tipo_pago`),
  KEY `FK_venta_usu` (`id_usu`),
  KEY `FK_venta_apc` (`id_apc`),
  KEY `FK_venta_tpe` (`id_tipo_pedido`),
  CONSTRAINT `FK_venta_apc` FOREIGN KEY (`id_apc`) REFERENCES `tm_aper_cierre` (`id_apc`),
  CONSTRAINT `FK_venta_cli` FOREIGN KEY (`id_cliente`) REFERENCES `tm_cliente` (`id_cliente`),
  CONSTRAINT `FK_venta_td` FOREIGN KEY (`id_tipo_doc`) REFERENCES `tm_tipo_doc` (`id_tipo_doc`),
  CONSTRAINT `FK_venta_tp` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tm_tipo_pago` (`id_tipo_pago`),
  CONSTRAINT `FK_venta_tpe` FOREIGN KEY (`id_tipo_pedido`) REFERENCES `tm_tipo_pedido` (`id_tipo_pedido`),
  CONSTRAINT `FK_venta_usu` FOREIGN KEY (`id_usu`) REFERENCES `tm_usuario` (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_venta`
--

LOCK TABLES `tm_venta` WRITE;
/*!40000 ALTER TABLE `tm_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `v_caja_aper`
--

DROP TABLE IF EXISTS `v_caja_aper`;
/*!50001 DROP VIEW IF EXISTS `v_caja_aper`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_caja_aper` AS SELECT
 1 AS `id_apc`,
  1 AS `id_usu`,
  1 AS `id_caja`,
  1 AS `id_turno`,
  1 AS `fecha_aper`,
  1 AS `monto_aper`,
  1 AS `fecha_cierre`,
  1 AS `monto_cierre`,
  1 AS `monto_sistema`,
  1 AS `stock_pollo`,
  1 AS `estado`,
  1 AS `desc_per`,
  1 AS `desc_caja`,
  1 AS `desc_turno` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_clientes`
--

DROP TABLE IF EXISTS `v_clientes`;
/*!50001 DROP VIEW IF EXISTS `v_clientes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_clientes` AS SELECT
 1 AS `id_cliente`,
  1 AS `tipo_cliente`,
  1 AS `dni`,
  1 AS `ruc`,
  1 AS `nombre`,
  1 AS `telefono`,
  1 AS `fecha_nac`,
  1 AS `direccion`,
  1 AS `referencia`,
  1 AS `estado` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_cocina_de`
--

DROP TABLE IF EXISTS `v_cocina_de`;
/*!50001 DROP VIEW IF EXISTS `v_cocina_de`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_cocina_de` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_areap`,
  1 AS `id_tipo`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `comentario`,
  1 AS `fecha_pedido`,
  1 AS `fecha_envio`,
  1 AS `estado`,
  1 AS `nro_pedido`,
  1 AS `id_usu`,
  1 AS `nombre_prod`,
  1 AS `pres_prod`,
  1 AS `ape_paterno`,
  1 AS `ape_materno`,
  1 AS `nombres`,
  1 AS `estado_pedido` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_cocina_me`
--

DROP TABLE IF EXISTS `v_cocina_me`;
/*!50001 DROP VIEW IF EXISTS `v_cocina_me`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_cocina_me` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_areap`,
  1 AS `id_tipo`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `comentario`,
  1 AS `fecha_pedido`,
  1 AS `fecha_envio`,
  1 AS `estado`,
  1 AS `id_mesa`,
  1 AS `id_mozo`,
  1 AS `nombre_prod`,
  1 AS `pres_prod`,
  1 AS `nro_mesa`,
  1 AS `desc_salon`,
  1 AS `ape_paterno`,
  1 AS `ape_materno`,
  1 AS `nombres`,
  1 AS `estado_pedido` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_cocina_mo`
--

DROP TABLE IF EXISTS `v_cocina_mo`;
/*!50001 DROP VIEW IF EXISTS `v_cocina_mo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_cocina_mo` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_areap`,
  1 AS `id_tipo`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `comentario`,
  1 AS `fecha_pedido`,
  1 AS `fecha_envio`,
  1 AS `estado`,
  1 AS `nro_pedido`,
  1 AS `id_usu`,
  1 AS `nombre_prod`,
  1 AS `pres_prod`,
  1 AS `ape_paterno`,
  1 AS `ape_materno`,
  1 AS `nombres`,
  1 AS `estado_pedido` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_compras`
--

DROP TABLE IF EXISTS `v_compras`;
/*!50001 DROP VIEW IF EXISTS `v_compras`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_compras` AS SELECT
 1 AS `id_compra`,
  1 AS `id_prov`,
  1 AS `id_tipo_compra`,
  1 AS `id_tipo_doc`,
  1 AS `fecha_c`,
  1 AS `fecha_r`,
  1 AS `hora_c`,
  1 AS `serie_doc`,
  1 AS `num_doc`,
  1 AS `igv`,
  1 AS `total`,
  1 AS `estado`,
  1 AS `desc_tc`,
  1 AS `desc_td`,
  1 AS `desc_prov` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_det_delivery`
--

DROP TABLE IF EXISTS `v_det_delivery`;
/*!50001 DROP VIEW IF EXISTS `v_det_delivery`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_det_delivery` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `precio`,
  1 AS `estado`,
  1 AS `nombre_prod`,
  1 AS `pres_prod` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_det_llevar`
--

DROP TABLE IF EXISTS `v_det_llevar`;
/*!50001 DROP VIEW IF EXISTS `v_det_llevar`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_det_llevar` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `precio`,
  1 AS `estado`,
  1 AS `nombre_prod`,
  1 AS `pres_prod` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_gastosadm`
--

DROP TABLE IF EXISTS `v_gastosadm`;
/*!50001 DROP VIEW IF EXISTS `v_gastosadm`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_gastosadm` AS SELECT
 1 AS `id_ga`,
  1 AS `id_tg`,
  1 AS `id_per`,
  1 AS `id_usu`,
  1 AS `id_apc`,
  1 AS `importe`,
  1 AS `responsable`,
  1 AS `motivo`,
  1 AS `fecha_re`,
  1 AS `estado`,
  1 AS `des_tg`,
  1 AS `desc_usu`,
  1 AS `desc_per` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_insprod`
--

DROP TABLE IF EXISTS `v_insprod`;
/*!50001 DROP VIEW IF EXISTS `v_insprod`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_insprod` AS SELECT
 1 AS `id_tipo_ins`,
  1 AS `id_ins`,
  1 AS `id_med`,
  1 AS `id_gru`,
  1 AS `ins_cod`,
  1 AS `ins_nom`,
  1 AS `ins_cat`,
  1 AS `ins_med`,
  1 AS `ins_rec`,
  1 AS `ins_cos`,
  1 AS `ins_sto`,
  1 AS `est_a`,
  1 AS `est_b`,
  1 AS `est_c`,
  1 AS `crt_stock` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_insumos`
--

DROP TABLE IF EXISTS `v_insumos`;
/*!50001 DROP VIEW IF EXISTS `v_insumos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_insumos` AS SELECT
 1 AS `id_ins`,
  1 AS `id_catg`,
  1 AS `id_med`,
  1 AS `id_gru`,
  1 AS `ins_cod`,
  1 AS `ins_nom`,
  1 AS `ins_sto`,
  1 AS `ins_cos`,
  1 AS `ins_est`,
  1 AS `ins_cat`,
  1 AS `ins_med` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_inventario`
--

DROP TABLE IF EXISTS `v_inventario`;
/*!50001 DROP VIEW IF EXISTS `v_inventario`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inventario` AS SELECT
 1 AS `id_tipo_ins`,
  1 AS `id_ins`,
  1 AS `ent`,
  1 AS `sal` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_inventario_ent`
--

DROP TABLE IF EXISTS `v_inventario_ent`;
/*!50001 DROP VIEW IF EXISTS `v_inventario_ent`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inventario_ent` AS SELECT
 1 AS `id_tipo_ins`,
  1 AS `id_ins`,
  1 AS `total` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_inventario_sal`
--

DROP TABLE IF EXISTS `v_inventario_sal`;
/*!50001 DROP VIEW IF EXISTS `v_inventario_sal`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_inventario_sal` AS SELECT
 1 AS `id_tipo_ins`,
  1 AS `id_ins`,
  1 AS `total` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_listar_mesas`
--

DROP TABLE IF EXISTS `v_listar_mesas`;
/*!50001 DROP VIEW IF EXISTS `v_listar_mesas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_listar_mesas` AS SELECT
 1 AS `id_mesa`,
  1 AS `id_salon`,
  1 AS `nro_mesa`,
  1 AS `estado`,
  1 AS `desc_salon`,
  1 AS `id_pedido`,
  1 AS `fecha_pedido`,
  1 AS `nro_personas` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_mesas`
--

DROP TABLE IF EXISTS `v_mesas`;
/*!50001 DROP VIEW IF EXISTS `v_mesas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_mesas` AS SELECT
 1 AS `id_mesa`,
  1 AS `id_salon`,
  1 AS `nro_mesa`,
  1 AS `estado`,
  1 AS `desc_salon` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedido_delivery`
--

DROP TABLE IF EXISTS `v_pedido_delivery`;
/*!50001 DROP VIEW IF EXISTS `v_pedido_delivery`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedido_delivery` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_tipo_pedido`,
  1 AS `id_usu`,
  1 AS `id_repartidor`,
  1 AS `fecha_pedido`,
  1 AS `estado_pedido`,
  1 AS `tipo_entrega`,
  1 AS `pedido_programado`,
  1 AS `hora_entrega`,
  1 AS `amortizacion`,
  1 AS `tipo_pago`,
  1 AS `paga_con`,
  1 AS `comision_delivery`,
  1 AS `nro_pedido`,
  1 AS `id_cliente`,
  1 AS `tipo_cliente`,
  1 AS `dni_cliente`,
  1 AS `ruc_cliente`,
  1 AS `nombre_cliente`,
  1 AS `telefono_cliente`,
  1 AS `direccion_cliente`,
  1 AS `referencia_cliente`,
  1 AS `email_cliente`,
  1 AS `desc_repartidor` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedido_llevar`
--

DROP TABLE IF EXISTS `v_pedido_llevar`;
/*!50001 DROP VIEW IF EXISTS `v_pedido_llevar`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedido_llevar` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_tipo_pedido`,
  1 AS `id_usu`,
  1 AS `fecha_pedido`,
  1 AS `estado_pedido`,
  1 AS `nro_pedido`,
  1 AS `nombre_cliente` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedido_mesa`
--

DROP TABLE IF EXISTS `v_pedido_mesa`;
/*!50001 DROP VIEW IF EXISTS `v_pedido_mesa`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedido_mesa` AS SELECT
 1 AS `id_pedido`,
  1 AS `id_tipo_pedido`,
  1 AS `id_usu`,
  1 AS `id_mesa`,
  1 AS `fecha_pedido`,
  1 AS `estado_pedido`,
  1 AS `nombre_cliente`,
  1 AS `nro_personas`,
  1 AS `nro_mesa`,
  1 AS `desc_salon`,
  1 AS `estado_mesa`,
  1 AS `nombre_mozo` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_agrupados`
--

DROP TABLE IF EXISTS `v_pedidos_agrupados`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_agrupados`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_agrupados` AS SELECT
 1 AS `tipo_atencion`,
  1 AS `id_pedido`,
  1 AS `id_areap`,
  1 AS `id_tipo`,
  1 AS `id_pres`,
  1 AS `cantidad`,
  1 AS `comentario`,
  1 AS `fecha_pedido`,
  1 AS `fecha_envio`,
  1 AS `estado`,
  1 AS `nombre_prod`,
  1 AS `pres_prod`,
  1 AS `nro_mesa`,
  1 AS `desc_salon`,
  1 AS `ape_paterno`,
  1 AS `ape_materno`,
  1 AS `nombres`,
  1 AS `estado_pedido` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_productos`
--

DROP TABLE IF EXISTS `v_productos`;
/*!50001 DROP VIEW IF EXISTS `v_productos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_productos` AS SELECT
 1 AS `id_pres`,
  1 AS `id_prod`,
  1 AS `id_tipo`,
  1 AS `id_catg`,
  1 AS `id_areap`,
  1 AS `pro_cat`,
  1 AS `pro_cod`,
  1 AS `pro_nom`,
  1 AS `pro_pre`,
  1 AS `pro_des`,
  1 AS `pro_cos`,
  1 AS `pro_cos_del`,
  1 AS `pro_rec`,
  1 AS `pro_sto`,
  1 AS `pro_imp`,
  1 AS `pro_mar`,
  1 AS `pro_igv`,
  1 AS `pro_img`,
  1 AS `del_a`,
  1 AS `del_b`,
  1 AS `del_c`,
  1 AS `est_a`,
  1 AS `est_b`,
  1 AS `est_c`,
  1 AS `crt_stock` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_repartidores`
--

DROP TABLE IF EXISTS `v_repartidores`;
/*!50001 DROP VIEW IF EXISTS `v_repartidores`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_repartidores` AS SELECT
 1 AS `id_repartidor`,
  1 AS `desc_repartidor` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_stock`
--

DROP TABLE IF EXISTS `v_stock`;
/*!50001 DROP VIEW IF EXISTS `v_stock`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_stock` AS SELECT
 1 AS `id_tipo_ins`,
  1 AS `id_ins`,
  1 AS `ent`,
  1 AS `sal`,
  1 AS `est_a`,
  1 AS `est_b`,
  1 AS `debajo_stock` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_stock_pedido`
--

DROP TABLE IF EXISTS `v_stock_pedido`;
/*!50001 DROP VIEW IF EXISTS `v_stock_pedido`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_stock_pedido` AS SELECT
 1 AS `id_ins`,
  1 AS `ent`,
  1 AS `sal`,
  1 AS `control` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_usuarios`
--

DROP TABLE IF EXISTS `v_usuarios`;
/*!50001 DROP VIEW IF EXISTS `v_usuarios`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_usuarios` AS SELECT
 1 AS `id_usu`,
  1 AS `id_rol`,
  1 AS `id_areap`,
  1 AS `dni`,
  1 AS `ape_paterno`,
  1 AS `ape_materno`,
  1 AS `nombres`,
  1 AS `email`,
  1 AS `usuario`,
  1 AS `contrasena`,
  1 AS `estado`,
  1 AS `imagen`,
  1 AS `desc_r`,
  1 AS `desc_ap` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_ventas_con`
--

DROP TABLE IF EXISTS `v_ventas_con`;
/*!50001 DROP VIEW IF EXISTS `v_ventas_con`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_ventas_con` AS SELECT
 1 AS `id_ven`,
  1 AS `id_ped`,
  1 AS `id_tped`,
  1 AS `id_cli`,
  1 AS `id_tdoc`,
  1 AS `id_tpag`,
  1 AS `id_usu`,
  1 AS `id_apc`,
  1 AS `ser_doc`,
  1 AS `nro_doc`,
  1 AS `pago_efe`,
  1 AS `pago_efe_none`,
  1 AS `pago_tar`,
  1 AS `desc_monto`,
  1 AS `desc_tipo`,
  1 AS `desc_personal`,
  1 AS `desc_motivo`,
  1 AS `comis_tar`,
  1 AS `comis_del`,
  1 AS `igv`,
  1 AS `total`,
  1 AS `codigo_operacion`,
  1 AS `fec_ven`,
  1 AS `estado`,
  1 AS `enviado_sunat`,
  1 AS `code_respuesta_sunat`,
  1 AS `descripcion_sunat_cdr`,
  1 AS `name_file_sunat`,
  1 AS `hash_cdr`,
  1 AS `hash_cpe`,
  1 AS `fecha_vencimiento`,
  1 AS `desc_td`,
  1 AS `desc_tp`,
  1 AS `desc_usu` */;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'rbuvtkxo_res1'
--

--
-- Dumping routines for database 'rbuvtkxo_res1'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualizar_cdr_baja` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_actualizar_cdr_baja`(`p_id_comunicacion` INT, `p_hash_cpe` VARCHAR(100), `p_hash_cdr` VARCHAR(100), `p_code_respuesta_sunat` VARCHAR(5), `p_descripcion_sunat_cdr` VARCHAR(300), `p_name_file_sunat` VARCHAR(80), OUT `mensaje` VARCHAR(100))
BEGIN
	IF(NOT EXISTS(SELECT * FROM comunicacion_baja WHERE id_comunicacion=p_id_comunicacion))THEN
		SET mensaje='No existe la comunicación de baja';
	ELSE
		UPDATE comunicacion_baja SET enviado_sunat=1,hash_cpe=p_hash_cpe,hash_cdr=p_hash_cdr,code_respuesta_sunat=p_code_respuesta_sunat,descripcion_sunat_cdr=p_descripcion_sunat_cdr,name_file_sunat=p_name_file_sunat WHERE id_comunicacion=p_id_comunicacion;
		SET mensaje='Actualizado correctamente';
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_actualizar_cdr_resumen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_actualizar_cdr_resumen`(`p_id_resumen` INT, `p_hash_cpe` VARCHAR(100), `p_hash_cdr` VARCHAR(100), `p_code_respuesta_sunat` VARCHAR(5), `p_descripcion_sunat_cdr` VARCHAR(300), `p_name_file_sunat` VARCHAR(80), OUT `mensaje` VARCHAR(100))
BEGIN
	IF(NOT EXISTS(SELECT * FROM resumen_diario WHERE id_resumen=p_id_resumen))THEN
		SET mensaje='No existe el resumen diario';
	ELSE
		UPDATE resumen_diario SET enviado_sunat=1,hash_cpe=p_hash_cpe,hash_cdr=p_hash_cdr,code_respuesta_sunat=p_code_respuesta_sunat,descripcion_sunat_cdr=p_descripcion_sunat_cdr,name_file_sunat=p_name_file_sunat WHERE id_resumen=p_id_resumen;
		SET mensaje='Actualizado correctamente';
		
		block:BEGIN
		DECLARE done INT DEFAULT FALSE;
		DECLARE idven BIGINT;
		DECLARE venta CURSOR FOR SELECT dr.id_venta FROM resumen_diario AS rd INNER JOIN resumen_diario_detalle AS dr ON rd.id_resumen = dr.id_resumen WHERE dr.id_resumen = p_id_resumen;
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;
		OPEN venta;
		
			read_loop: LOOP
			FETCH venta INTO idven;
				IF done THEN
					LEAVE read_loop;
				END IF;
				UPDATE tm_venta SET code_respuesta_sunat=p_code_respuesta_sunat,descripcion_sunat_cdr=p_descripcion_sunat_cdr,name_file_sunat=p_name_file_sunat,hash_cpe=p_hash_cpe,hash_cdr=p_hash_cdr WHERE id_venta = idven;
			END LOOP;
			
		CLOSE venta;
		END block;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_consultar_boletas_resumen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_consultar_boletas_resumen`(`p_fecha_resumen` DATE)
BEGIN
	SELECT
		'03' AS 'tipo_comprobante',DATE_FORMAT(v.fecha_venta,'%Y-%m-%d') AS 'fecha_resumen',IF(c.dni="" OR c.dni="-",0,1) AS 'tipo_documento',
		IF(c.dni="" OR c.dni="-","00000000",c.dni) AS "dni",CONCAT(c.nombres," ",c.ape_paterno," ",c.ape_materno) AS 'cliente',v.serie_doc AS 'serie_doc',
		v.nro_doc AS 'nro_doc',"PEN" AS 'tipo_moneda',ROUND((v.total/(1 + v.igv)) *(v.igv),2) AS 'total_igv',
		ROUND((v.total/(1 + v.igv)),2) AS 'total_gravadas',ROUND(v.total,2) AS 'total_facturado',IF(v.estado="a",1,3) AS 'status_code',v.id_venta
	FROM tm_venta v INNER JOIN tm_cliente c ON c.id_cliente=v.id_cliente
	WHERE v.id_tipo_doc=1 AND v.code_respuesta_sunat="" AND DATE_FORMAT(v.fecha_venta,"%Y-%m-%d") = p_fecha_resumen
	ORDER BY v.fecha_venta ASC;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_consultar_documento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_consultar_documento`(`p_id_venta` INT)
BEGIN
	SELECT
		IF(id_tipo_doc='1','03','01') AS tipo_comprobante, IF(c.dni="" OR c.dni="-",0,1) AS 'tipo_documento',
		IF(c.dni="" OR c.dni="-","00000000",c.dni) AS "dni",v.serie_doc AS 'serie_doc', v.nro_doc AS 'nro_doc',"PEN" AS 'tipo_moneda',ROUND((v.total/(1 + v.igv)) *(v.igv),2) AS 'total_igv',
		ROUND((v.total/(1 + v.igv)),2) AS 'total_gravadas',ROUND(v.total,2) AS 'total_facturado',v.id_venta, v.estado
	FROM tm_venta v INNER JOIN tm_cliente c ON c.id_cliente=v.id_cliente
	WHERE v.id_venta = p_id_venta;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_generar_numerobaja` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_generar_numerobaja`(`p_tipo_doc` CHAR(3), OUT `numerobaja` CHAR(5))
BEGIN
	DECLARE contador INT;
	IF(NOT EXISTS(SELECT * FROM comunicacion_baja WHERE tipo_doc = p_tipo_doc))THEN
		SET contador:= (SELECT IFNULL(MAX(correlativo), 0)+1 AS 'codigo' FROM comunicacion_baja WHERE tipo_doc = p_tipo_doc);
		SET numerobaja:= (SELECT LPAD(contador,5,'0') AS 'correlativo');
	ELSE		
		SET contador:= (SELECT IFNULL(MAX(correlativo), 0)+1 AS 'codigo' FROM comunicacion_baja WHERE tipo_doc = p_tipo_doc);
		SET numerobaja:= (SELECT LPAD(contador,5,'0') AS 'correlativo');
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_generar_numeroresumen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `sp_generar_numeroresumen`(OUT `numeroresumen` CHAR(5))
BEGIN
	DECLARE contador INT;
	IF(NOT EXISTS(SELECT * FROM resumen_diario))THEN
		SET contador:= (SELECT IFNULL(MAX(correlativo), 0)+1 AS 'codigo' FROM resumen_diario);
		SET numeroresumen:= (SELECT LPAD(contador,5,'0') AS 'correlativo');
	ELSE		
		SET contador:= (SELECT IFNULL(MAX(correlativo), 0)+1 AS 'codigo' FROM resumen_diario);
		SET numeroresumen:= (SELECT LPAD(contador,5,'0') AS 'correlativo');
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_cajaAperturar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_cajaAperturar`(IN `_flag` INT(11), IN `_id_usu` INT(11), IN `_id_caja` INT(11), IN `_id_turno` INT(11), IN `_fecha_aper` DATETIME, IN `_monto_aper` DECIMAL(10,2))
BEGIN
	DECLARE _filtro INT DEFAULT 1;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_aper_cierre WHERE (id_usu = _id_usu or id_caja = _id_caja) AND estado = 'a';
		
		IF _filtro = 0 THEN
			INSERT INTO tm_aper_cierre (id_usu,id_caja,id_turno,fecha_aper,monto_aper) VALUES (_id_usu, _id_caja, _id_turno, _fecha_aper, _monto_aper);
			
			SELECT @@IDENTITY INTO @id;
			
			SELECT @id AS id_apc, _filtro AS cod;
		ELSE
			SELECT _filtro AS cod;
		END IF;
		
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_cajaCerrar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_cajaCerrar`(IN `_flag` INT(11), IN `_id_apc` INT(11), IN `_fecha_cierre` DATETIME, IN `_monto_cierre` DECIMAL(10,2), IN `_monto_sistema` DECIMAL(10,2), IN `_stock_pollo` VARCHAR(11))
BEGIN
		DECLARE _filtro INT DEFAULT 0;
		DECLARE _id_usu INT DEFAULT 0;
		
		IF _flag = 1 THEN
		
			SELECT COUNT(*) INTO _filtro FROM tm_aper_cierre WHERE id_apc = _id_apc AND estado = 'a';
			SELECT id_usu INTO _id_usu FROM tm_aper_cierre WHERE id_apc = _id_apc AND estado = 'a';
			
			IF _filtro = 1 THEN
			
				UPDATE tm_aper_cierre SET fecha_cierre = _fecha_cierre, monto_cierre = _monto_cierre, monto_sistema = _monto_sistema, stock_pollo = _stock_pollo, estado = 'c' 
				WHERE id_apc = _id_apc;
				
				SELECT _filtro AS cod, _id_usu AS id_usu;
			ELSE
				SELECT _filtro AS cod, _id_usu AS id_usu;
			END IF;
		END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_comprasAnular` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_comprasAnular`(IN `_flag` INT(11), IN `_id_compra` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	if _flag = 1 then
	
		SELECT COUNT(*) INTO _filtro FROM tm_compra WHERE estado = 'a' AND id_compra = _id_compra;
		
		IF _filtro = 1 THEN
			UPDATE tm_compra SET estado = 'i' WHERE id_compra = _id_compra;
			DELETE FROM tm_inventario WHERE id_tipo_ope = 1 AND id_ope = _id_compra;
			SELECT _filtro AS cod;
		ELSE
			SELECT _filtro AS cod;
		END IF;
	end if;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_comprasCreditoCuotas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_comprasCreditoCuotas`(IN `_flag` INT(11), IN `_id_credito` INT(11), IN `_id_usu` INT(11), IN `_id_apc` INT(11), IN `_importe` DECIMAL(10,2), IN `_fecha` DATETIME, IN `_egreso` INT(11), IN `_monto_egreso` DECIMAL(10,2), IN `_monto_amortizado` DECIMAL(10,2), IN `_total_credito` DECIMAL(10,2))
BEGIN
	DECLARE tcuota DECIMAL(10,2) DEFAULT 0;
	DECLARE motivo VARCHAR(100);
	
	IF _flag = 1 THEN
	
		INSERT INTO tm_credito_detalle (id_credito,id_usu,importe,fecha,egreso)
		VALUES (_id_credito, _id_usu, _importe, _fecha, _egreso);
	
			IF (_egreso = 1) THEN
	
				SELECT v.desc_prov INTO @descP
				FROM v_compras AS v INNER JOIN tm_compra_credito AS c ON v.id_compra = c.id_compra
				WHERE c.id_credito = _id_credito;
		
			SET motivo = @descP;
		
				INSERT INTO tm_gastos_adm (id_tipo_gasto,id_usu,id_apc,importe,motivo,fecha_registro)
				VALUES (4,_id_usu,_id_apc,_monto_egreso,motivo,_fecha);
	
			END IF;
	
		SET tcuota = _monto_amortizado + _importe;
	
		IF ( _total_credito <= tcuota ) THEN
	
			UPDATE tm_compra_credito SET estado = 'a' WHERE id_credito = _id_credito;
	
		END IF;
	
	END IF;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_comprasRegProveedor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_comprasRegProveedor`(IN `_flag` INT(11), IN `_id_prov` INT(11), IN `_ruc` VARCHAR(13), IN `_razon_social` VARCHAR(100), IN `_direccion` VARCHAR(100), IN `_telefono` INT(9), IN `_email` VARCHAR(45), IN `_contacto` VARCHAR(45))
BEGIN
		DECLARE _filtro INT DEFAULT 1;
		
		IF _flag = 1 THEN
		
			SELECT count(*) INTO _filtro FROM tm_proveedor WHERE ruc = _ruc;
		
			IF _filtro = 0 THEN
			
				INSERT INTO tm_proveedor (ruc,razon_social,direccion,telefono,email,contacto) 
				VALUES (_ruc, _razon_social, _direccion, _telefono, _email, _contacto);
				
				SELECT @@IDENTITY INTO @id;
			
				SELECT _filtro AS cod,@id AS id_prov;
			ELSE
				SELECT _filtro AS cod;
			END IF;	
			
		END IF;
		
		if _flag = 2 then
		
			UPDATE tm_proveedor SET ruc = _ruc, razon_social = _razon_social, direccion = _direccion, telefono = _telefono, email = _email, contacto = _contacto
			WHERE id_prov = _id_prov;
			
		end if;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configAlmacenes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configAlmacenes`(IN `_flag` INT(11), IN `_nombre` VARCHAR(45), IN `_estado` VARCHAR(5), IN `_idAlm` INT(11))
BEGIN
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		SELECT COUNT(*) INTO _cont FROM tm_almacen WHERE nombre = _nombre;
	
		IF _cont = 0 THEN
			INSERT INTO tm_almacen (nombre,estado) VALUES (_nombre, _estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	END IF;
	
	IF _flag = 2 THEN
		SELECT COUNT(*) INTO _cont FROM tm_almacen WHERE nombre = _nombre AND estado = _estado;
	
		IF _cont = 0 THEN
			UPDATE tm_almacen SET nombre = _nombre, estado = _estado WHERE id_alm = _idAlm;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configAreasProd` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configAreasProd`(IN `_flag` INT(11), IN `_id_areap` INT(11), IN `_id_imp` INT(11), IN `_nombre` VARCHAR(45), IN `_estado` VARCHAR(5))
BEGIN
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		SELECT COUNT(*) INTO _cont FROM tm_area_prod WHERE nombre = _nombre;
	
		IF _cont = 0 THEN
			INSERT INTO tm_area_prod (id_imp,nombre,estado) VALUES (_id_imp, _nombre, _estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	END IF;
	
	IF _flag = 2 THEN
		SELECT COUNT(*) INTO _cont FROM tm_area_prod WHERE id_imp = _id_imp AND nombre = _nombre AND estado = _estado;
	
		IF _cont = 0 THEN
			UPDATE tm_area_prod SET id_imp = _id_imp, nombre = _nombre, estado = _estado WHERE id_areap = _id_areap;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configCajas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configCajas`(IN `_flag` INT(11), IN `_id_caja` INT(11), IN `_descripcion` VARCHAR(45), IN `_estado` VARCHAR(5))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		SELECT COUNT(*) INTO _filtro FROM tm_caja WHERE descripcion = _descripcion;
	
		IF _filtro = 0 THEN
			INSERT INTO tm_caja (descripcion,estado) VALUES (_descripcion, _estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	END IF;
	
	IF _flag = 2 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_caja WHERE descripcion = _descripcion AND estado = _estado;
	
		IF _filtro = 0 THEN
			UPDATE tm_caja SET descripcion = _descripcion, estado = _estado WHERE id_caja = _id_caja;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configEliminarCategoriaIns` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configEliminarCategoriaIns`(IN `_id_catg` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	
	SELECT COUNT(*) INTO _filtro FROM tm_insumo WHERE id_catg = _id_catg;
	IF _filtro = 0 THEN
		DELETE FROM tm_insumo_catg WHERE id_catg = _id_catg;
		SELECT _cod1 AS cod;
	ELSE
		SELECT _cod0 AS cod;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configEliminarCategoriaProd` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configEliminarCategoriaProd`(IN `_id_catg` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	
	SELECT COUNT(*) INTO _filtro FROM tm_producto WHERE id_catg = _id_catg;
	IF _filtro = 0 THEN
		DELETE FROM tm_producto_catg WHERE id_catg = _id_catg;
		SELECT _cod1 AS cod;
	ELSE
		SELECT _cod0 AS cod;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configImpresoras` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configImpresoras`(IN `_flag` INT(11), IN `_id_imp` INT(11), IN `_nombre` VARCHAR(50), IN `_estado` VARCHAR(5))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		SELECT COUNT(*) INTO _filtro FROM tm_impresora WHERE nombre = _nombre;
	
		IF _filtro = 0 THEN
			INSERT INTO tm_impresora (nombre,estado) VALUES (_nombre,_estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	END IF;
	
	IF _flag = 2 THEN
		SELECT COUNT(*) INTO _filtro FROM tm_impresora WHERE nombre = _nombre AND estado = _estado;
	
		IF _filtro = 0 THEN
			UPDATE tm_impresora SET nombre = _nombre, estado = _estado WHERE id_imp = _id_imp;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configInsumo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configInsumo`(IN `_flag` INT(11), IN `_idCatg` INT(11), IN `_idMed` INT(11), IN `_cod` VARCHAR(10), IN `_nombre` VARCHAR(45), IN `_stock` INT(11), IN `_costo` DECIMAL(10,2), IN `_estado` VARCHAR(5), IN `_idIns` INT(11))
BEGIN
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_insumo WHERE nomb_ins = _nombre and cod_ins = _cod and id_catg = _idCatg;
	
		IF _cont = 0 THEN
			INSERT INTO tm_insumo (id_catg,id_med,cod_ins,nomb_ins,stock_min,cos_uni) VALUES ( _idCatg, _idMed, _cod, _nombre, _stock, _costo);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
		
	END IF;
	
	IF _flag = 2 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_insumo WHERE id_catg = _idCatg AND id_med = _idMed AND cod_ins = _cod AND nomb_ins = _nombre AND stock_min = _stock AND cos_uni = _costo AND estado = _estado;
	
		IF _cont = 0 THEN
			UPDATE tm_insumo SET id_catg = _idCatg, id_med = _idMed, cod_ins = _cod, nomb_ins = _nombre, stock_min = _stock, cos_uni = _costo, estado = _estado WHERE id_ins = _idIns;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configInsumoCatgs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configInsumoCatgs`(IN `_flag` INT(11), IN `_descC` VARCHAR(45), IN `_idCatg` INT(11))
BEGIN
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_insumo_catg WHERE descripcion = _descC;
		
		IF _cont = 0 THEN
			INSERT INTO tm_insumo_catg (descripcion) VALUES (_descC);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	END IF;
	
	IF _flag = 2 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_insumo_catg WHERE descripcion = _descC;
		
		IF _cont = 0 THEN
			UPDATE tm_insumo_catg SET descripcion = _descC WHERE id_catg = _idCatg;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configMesas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configMesas`(IN `_flag` INT(11), IN `_id_mesa` INT(11), IN `_id_salon` INT(11), IN `_nro_mesa` VARCHAR(5), IN `_estado` VARCHAR(45))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_mesa WHERE id_salon = _id_salon AND nro_mesa = _nro_mesa;
	
		IF _filtro = 0 THEN
			INSERT INTO tm_mesa (id_salon,nro_mesa) VALUES (_id_salon, _nro_mesa);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	end if;
	
	IF _flag = 2 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_mesa WHERE id_salon = _id_salon AND nro_mesa = _nro_mesa AND estado = _estado;
	
		IF _filtro = 0 THEN
			UPDATE tm_mesa SET nro_mesa = _nro_mesa, estado = _estado WHERE id_mesa = _id_mesa;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	
	END IF;
	
	IF _flag = 3 THEN
	
		SELECT count(*) INTO _filtro FROM tm_pedido_mesa WHERE id_mesa = _id_mesa;
	
		IF _filtro = 0 THEN
			DELETE FROM tm_mesa WHERE id_mesa = _id_mesa;
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configProducto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configProducto`(IN `_flag` INT(11), IN `_id_prod` INT(11), IN `_id_tipo` INT(11), IN `_id_catg` INT(11), IN `_id_areap` INT(11), IN `_nombre` VARCHAR(45), IN `_notas` VARCHAR(200), IN `_delivery` INT(1), IN `_estado` VARCHAR(1))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		SELECT COUNT(*) INTO _filtro FROM tm_producto WHERE id_tipo = _id_tipo AND id_catg = _id_catg AND id_areap = _id_areap AND nombre = _nombre;
		IF _filtro = 0 THEN
			INSERT INTO tm_producto (id_tipo,id_catg,id_areap,nombre,notas,delivery) 
			VALUES ( _id_tipo, _id_catg, _id_areap, _nombre, _notas, _delivery);
			SELECT _cod1 AS cod;
		else
			SELECT _cod0 AS cod;
		end if;
	end if;
	
	if _flag = 2 then
		SELECT COUNT(*) INTO _filtro FROM tm_producto WHERE id_tipo = _id_tipo AND id_catg = _id_catg AND id_areap = _id_areap AND nombre = _nombre AND notas = _notas AND delivery = _delivery and estado = _estado;
		IF _filtro = 0 THEN
			UPDATE tm_producto SET id_tipo = _id_tipo, id_catg = _id_catg, id_areap = _id_areap, nombre = _nombre, notas = _notas, delivery = _delivery, estado = _estado 
			WHERE id_prod = _id_prod;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	end if;
	
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configProductoCatgs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configProductoCatgs`(
	IN `_flag` INT(11), 
	IN `_id_catg` INT(11), 
	IN `_descripcion` VARCHAR(45), 
	IN `_delivery` INT(1), 
	IN `_orden` INT(11), 
	IN `_imagen` VARCHAR(200), 
	IN `_estado` VARCHAR(1))
BEGIN	
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN	
		
		SELECT COUNT(*) INTO _filtro FROM tm_producto_catg WHERE descripcion = _descripcion;
		IF _filtro = 0 THEN
			INSERT INTO tm_producto_catg (descripcion,delivery,orden,imagen,estado) VALUES (_descripcion,_delivery,100,_imagen,_estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	end if;
		
	IF _flag = 2 THEN
		SELECT COUNT(*) INTO _filtro FROM tm_producto_catg WHERE descripcion = _descripcion and delivery = _delivery and orden = _orden AND imagen = _imagen AND estado = _estado;
		IF _filtro = 0 THEN
			UPDATE tm_producto_catg SET descripcion = _descripcion, delivery = _delivery, orden =_orden, imagen = _imagen, estado = _estado WHERE id_catg = _id_catg;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	END IF;
	
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configProductoIngrs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configProductoIngrs`(IN `_flag` INT(11), IN `_id_pi` INT(11), IN `_id_pres` INT(11), IN `_id_tipo_ins` INT(11), IN `_id_ins` INT(11), IN `_id_med` INT(11), IN `_cant` FLOAT)
BEGIN
	if _flag = 1 then
		INSERT INTO tm_producto_ingr (id_pres,id_tipo_ins,id_ins,id_med,cant) VALUES (_id_pres, _id_tipo_ins, _id_ins, _id_med, _cant);
	end if;
	if _flag = 2 then
		UPDATE tm_producto_ingr SET cant = _cant WHERE id_pi = _id_pi;
	end if;
	if _flag = 3 then
		DELETE FROM tm_producto_ingr WHERE id_pi = _id_pi;
	end if;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configProductoPres` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configProductoPres`(IN `_flag` INT(11), IN `_id_pres` INT(11), IN `_id_prod` INT(11), IN `_cod_prod` VARCHAR(45), IN `_presentacion` VARCHAR(45), IN `_descripcion` VARCHAR(200), IN `_precio` DECIMAL(10,2), IN `_precio_delivery` DECIMAL(10,2), IN `_receta` INT(1), IN `_stock_min` INT(11), IN `_stock_limit` INT(1), IN `_impuesto` INT(1), IN `_delivery` INT(1), IN `_margen` INT(1), IN `_igv` DECIMAL(10,2), IN `_imagen` VARCHAR(200), IN `_estado` VARCHAR(1))
BEGIN
		
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_producto_pres WHERE presentacion = _presentacion AND id_prod = _id_prod;
		
		IF _cont = 0 THEN
			INSERT INTO tm_producto_pres (id_prod,cod_prod,presentacion,descripcion,precio,precio_delivery,receta,stock_min,crt_stock,impuesto,delivery,margen,igv,imagen,estado) 
			VALUES (_id_prod, _cod_prod, _presentacion, _descripcion, _precio, _precio_delivery, _receta, _stock_min, _stock_limit, _impuesto, _delivery, _margen, _igv, _imagen, _estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
		
	end if;
	
	IF _flag = 2 THEN
	
		UPDATE tm_producto_pres SET cod_prod = _cod_prod, presentacion = _presentacion, descripcion = _descripcion, precio = _precio, precio_delivery = _precio_delivery, receta = _receta, stock_min = _stock_min, crt_stock = _stock_limit, impuesto = _impuesto, delivery = _delivery, margen = _margen, igv = _igv, imagen = _imagen, estado = _estado 
		WHERE id_pres = _id_pres;
		SELECT _cod2 AS cod;
		
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configRol` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configRol`(IN `_flag` INT(11), IN `_desc` VARCHAR(45), IN `_idRol` INT(11))
BEGIN
		DECLARE _duplicado INT DEFAULT 1;
		
		IF _flag = 1 THEN
		
				SELECT count(*) INTO _duplicado FROM tm_rol WHERE descripcion = _desc;
			
			IF _duplicado = 0 THEN
				INSERT INTO tm_rol (descripcion) VALUES (_desc);
				
				SELECT _duplicado AS dup;
			ELSE
				SELECT _duplicado AS dup;
			END IF;
		
		end if;
		
		IF _flag = 2 THEN
		
				SELECT COUNT(*) INTO _duplicado FROM tm_rol WHERE descripcion = _desc;
			
			IF _duplicado = 0 THEN
				UPDATE tm_rol SET descripcion = _desc WHERE id_rol = _idRol;
				
				SELECT _duplicado AS dup;
			ELSE
				SELECT _duplicado AS dup;
			END IF;
		
		END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configSalones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configSalones`(IN `_flag` INT(11), IN `_id_salon` INT(11), IN `_descripcion` VARCHAR(45), IN `_estado` VARCHAR(5))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _filtro2 INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_salon WHERE descripcion = _descripcion AND estado = _estado;
	
		IF _filtro = 0 THEN
			INSERT INTO tm_salon (descripcion,estado) VALUES (_descripcion,_estado);
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	end if;
	
	IF _flag = 2 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_salon WHERE descripcion = _descripcion AND estado = _estado;
	
		IF _filtro = 0 THEN
			UPDATE tm_salon SET descripcion = _descripcion, estado = _estado WHERE id_salon = _id_salon;
			SELECT _cod2 AS cod;
		ELSE
			SELECT _cod2 AS cod;
		END IF;
	
	END IF;
	
	IF _flag = 3 THEN
	
		SELECT count(*) INTO _filtro FROM tm_mesa WHERE id_salon = _id_salon;
	
		IF _filtro = 0 THEn
			
			SELECT COUNT(*) AS _filtro2 FROM tm_salon;
			
			if _filtro2 = 1 then
			
				DELETE FROM tm_salon WHERE id_salon = _id_salon;
				ALTER TABLE tm_salon AUTO_INCREMENT = 1;
				SELECT _cod1 AS cod;
			
			else 
		
				DELETE FROM tm_salon WHERE id_salon = _id_salon;
				SELECT _cod1 AS cod;
	
			end if;		
			
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_configUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_configUsuario`(IN `_flag` INT(11), IN `_id_usu` INT(11), IN `_id_rol` INT(11), IN `_id_areap` INT(11), IN `_dni` VARCHAR(10), IN `_ape_paterno` VARCHAR(45), IN `_ape_materno` VARCHAR(45), IN `_nombres` VARCHAR(45), IN `_email` VARCHAR(100), IN `_usuario` VARCHAR(45), IN `_contrasena` VARCHAR(45), IN `_imagen` VARCHAR(45))
BEGIN
		DECLARE _filtro INT DEFAULT 1;
		
		IF _flag = 1 THEN
		
			SELECT count(*) INTO _filtro FROM tm_usuario WHERE usuario = _usuario;
		
			IF _filtro = 0 THEN
			
				INSERT INTO tm_usuario (id_rol,id_areap,dni,ape_paterno,ape_materno,nombres,email,usuario,contrasena,imagen) 
				VALUES (_id_rol,_id_areap,_dni,_ape_paterno,_ape_materno,_nombres,_email,_usuario,_contrasena,_imagen);
				
				SELECT _filtro AS cod;
			ELSE
				SELECT _filtro AS cod;
			END IF;
		
		end if;
		
		IF _flag = 2 THEN
			UPDATE tm_usuario SET id_rol = _id_rol, id_areap = _id_areap, dni = _dni, ape_paterno = _ape_paterno, ape_materno = _ape_materno, nombres = _nombres, email = _email, usuario = _usuario, contrasena = _contrasena, imagen = _imagen
			WHERE id_usu = _id_usu;
		END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_invESAnular` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_invESAnular`(IN `_flag` INT(11), IN `_id_es` INT(11), IN `_id_tipo` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	IF _flag = 1 THEN
	
		SELECT COUNT(*) INTO _filtro FROM tm_inventario_entsal WHERE estado = 'a' AND id_es = _id_es;
		
		IF _filtro = 1 THEN
			UPDATE tm_inventario_entsal SET estado = 'i' WHERE id_es = _id_es;
			UPDATE tm_inventario SET estado = 'i' WHERE id_tipo_ope = _id_tipo AND id_ope = _id_es;
			SELECT _filtro AS cod;
		ELSE
			SELECT _filtro AS cod;
		END IF;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_optPedidos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_optPedidos`(IN `_flag` INT(11))
BEGIN
	DECLARE _cont INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	
	IF _flag = 1 THEN
	
		SELECT COUNT(*) FROM tm_aper_cierre WHERE estado = 'a';
		
		IF _cont = 0 THEN
			DELETE FROM tm_detalle_pedido;
			UPDATE tm_pedido SET estado = 'z' WHERE estado = 'a';
			/*mostrador*/
			UPDATE tm_pedido SET estado = 'd' WHERE estado = 'b' AND id_tipo_pedido = 2;
			/*delivery*/
			UPDATE tm_pedido SET estado = 'd' WHERE estado = 'c' AND id_tipo_pedido = 3;
			UPDATE tm_pedido SET estado = 'z' WHERE estado = 'b' AND id_tipo_pedido = 3;
			UPDATE tm_mesa SET estado = 'a';
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
	
	END IF;
	
	IF _flag = 2 THEN
	
		DELETE FROM tm_detalle_pedido;
		DELETE FROM tm_pedido_mesa;
		DELETE FROM tm_pedido_llevar;
		DELETE FROM tm_pedido_delivery;
		DELETE FROM tm_pedido;
		ALTER TABLE tm_pedido AUTO_INCREMENT = 1;
		DELETE FROM tm_compra_detalle;
		DELETE FROM tm_credito_detalle;
		DELETE FROM tm_compra_credito;
		ALTER TABLE tm_compra_credito AUTO_INCREMENT = 1;
		DELETE FROM tm_compra;
		ALTER TABLE tm_compra AUTO_INCREMENT = 1;
		DELETE FROM tm_gastos_adm;
		ALTER TABLE tm_gastos_adm AUTO_INCREMENT = 1;
		DELETE FROM tm_ingresos_adm;
		ALTER TABLE tm_ingresos_adm AUTO_INCREMENT = 1;
		DELETE FROM tm_detalle_venta;
		DELETE FROM comunicacion_baja;
		ALTER TABLE comunicacion_baja AUTO_INCREMENT = 1;
		DELETE FROM resumen_diario_detalle;
		ALTER TABLE resumen_diario_detalle AUTO_INCREMENT = 1;
		DELETE FROM resumen_diario;
		ALTER TABLE resumen_diario AUTO_INCREMENT = 1;			
		DELETE FROM tm_venta;
		ALTER TABLE tm_venta AUTO_INCREMENT = 1;
		DELETE FROM tm_aper_cierre;
		ALTER TABLE tm_aper_cierre AUTO_INCREMENT = 1;
		DELETE FROM tm_inventario_entsal;
		ALTER TABLE tm_inventario_entsal AUTO_INCREMENT = 1;
		DELETE FROM tm_inventario;
		ALTER TABLE tm_inventario AUTO_INCREMENT = 1;
		UPDATE tm_mesa SET estado = 'a' WHERE estado <> 'm';
		SELECT _cod1 AS cod;
		
	END IF;
	
	IF _flag = 3 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_detalle_venta;
		
		IF _cont = 0 THEN
			DELETE FROM tm_producto_ingr;
			ALTER TABLE tm_producto_ingr AUTO_INCREMENT = 1;
			DELETE FROM tm_producto_pres;
			ALTER TABLE tm_producto_pres AUTO_INCREMENT = 1;
			DELETE FROM tm_producto;
			ALTER TABLE tm_producto AUTO_INCREMENT = 1;
			DELETE FROM tm_producto_catg WHERE id_catg <> 1;
			ALTER TABLE tm_producto_catg AUTO_INCREMENT = 1;
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
		
	END IF;
	
	IF _flag = 4 THEN
	
		SELECT COUNT(*) INTO _cont FROM tm_producto_ingr;
		
		IF _cont = 0 THEN
			DELETE FROM tm_insumo;
			ALTER TABLE tm_insumo AUTO_INCREMENT = 1;
			DELETE FROM tm_insumo_catg;
			ALTER TABLE tm_insumo_catg AUTO_INCREMENT = 1;
			SELECT _cod1 AS cod;
		ELSE
			SELECT _cod0 AS cod;
		END IF;
		
	END IF;
	
	IF _flag = 5 THEN
	
		DELETE FROM tm_cliente where id_cliente <> 1;
		ALTER TABLE tm_cliente AUTO_INCREMENT = 2;
		SELECT _cod1 AS cod;
		
	END IF;
	
	IF _flag = 6 THEN
	
		DELETE FROM tm_proveedor;
		ALTER TABLE tm_proveedor AUTO_INCREMENT = 1;
		SELECT _cod1 AS cod;
		
	END IF;
	
	IF _flag = 7 THEN
	
		DELETE FROM tm_mesa;
		ALTER TABLE tm_mesa AUTO_INCREMENT = 1;
		DELETE FROM tm_salon;
		ALTER TABLE tm_salon AUTO_INCREMENT = 1;
		SELECT _cod1 AS cod;
		
	END IF;
			
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restCancelarPedido` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restCancelarPedido`(IN `_flag` INT(11), IN `_id_usu` INT(11), IN `_id_pres` INT(11), IN `_id_pedido` INT(11), IN `_estado_pedido` VARCHAR(5), IN `_fecha_pedido` DATETIME, IN `_fecha_envio` DATETIME, IN `_codigo_seguridad` VARCHAR(50), IN `_filtro_seguridad` VARCHAR(50))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	DECLARE _cod0 INT DEFAULT 0;
	DECLARE	_cod1 INT DEFAULT 1;
	DECLARE	_cod2 INT DEFAULT 2;
	
	IF _flag = 1 THEN
		/*
		SELECT COUNT(*) INTO _filtro FROM tm_detalle_pedido WHERE id_pedido = _id_pedido AND id_pres = _id_pres AND fecha_pedido = _fecha_pedido AND (_estado_pedido = 'a' OR _estado_pedido = 'y');
		*/
		iF _estado_pedido = 'a' or _estado_pedido = 'y' THEN		
			if _codigo_seguridad = _filtro_seguridad then
				UPDATE tm_detalle_pedido SET estado = 'z', id_usu = _id_usu, fecha_envio = _fecha_envio WHERE id_pedido = _id_pedido AND id_pres = _id_pres AND fecha_pedido = _fecha_pedido AND estado = _estado_pedido LIMIT 1;
				SELECT _cod1 AS cod;			
			else
				SELECT _cod0 AS cod;
			end if;			
		ELSE
			SELECT _cod2 AS cod;
		END IF;	
	END IF;
	
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restDesocuparMesa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restDesocuparMesa`(`_flag` INT(11), `_id_pedido` INT(11))
BEGIN
	DECLARE result INT DEFAULT 1;
	IF _flag = 1 THEN
		SELECT id_mesa INTO @codmesa FROM tm_pedido_mesa WHERE id_pedido = _id_pedido;
		UPDATE tm_mesa SET estado = 'a' WHERE id_mesa = @codmesa;
		UPDATE tm_pedido SET estado = 'z' WHERE id_pedido = _id_pedido;
		SELECT result AS resultado;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restEditarVentaDocumento` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restEditarVentaDocumento`(`_flag` INT(11), `_id_venta` INT(11), `_id_cliente` INT(11), `_id_tipo_documento` INT(11))
BEGIN
	DECLARE _cod INT DEFAULT 1;
	
	IF _flag = 1 THEN
		SELECT td.serie,CONCAT(LPAD(COUNT(id_venta)+(td.numero),8,'0')) AS numero INTO @serie, @numero
		FROM tm_venta AS v INNER JOIN tm_tipo_doc AS td ON v.id_tipo_doc = td.id_tipo_doc
		WHERE v.id_tipo_doc = _id_tipo_documento AND v.serie_doc = td.serie;
		UPDATE tm_venta SET id_cliente = _id_cliente, id_tipo_doc = _id_tipo_documento, serie_doc = @serie, nro_doc = @numero WHERE id_venta = _id_venta;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restEmitirVenta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restEmitirVenta`(`_flag` INT(11), `_dividir_cuenta` INT(11), `_id_pedido` INT(11), `_tipo_pedido` INT(11), `_tipo_entrega` VARCHAR(1), `_id_cliente` INT(11), `_id_tipo_doc` INT(11), `_id_tipo_pago` INT(11), `_id_usu` INT(11), `_id_apc` INT(11), `_pago_efe_none` DECIMAL(10,2), `_pago_tar` DECIMAL(10,2), `_descuento_tipo` CHAR(1), `_descuento_personal` INT(11), `_descuento_monto` DECIMAL(10,2), `_descuento_motivo` VARCHAR(200), `_comision_tarjeta` DECIMAL(10,2), `_comision_delivery` DECIMAL(10,2), `_igv` DECIMAL(10,2), `_total` DECIMAL(10,2), `_codigo_operacion` VARCHAR(20), `_fecha_venta` DATETIME)
BEGIN
	DECLARE pago_efe DECIMAL(10,2) DEFAULT 0;
	DECLARE pago_tar DECIMAL(10,2) DEFAULT 0;
	
	if (_descuento_tipo = 1 or _descuento_tipo = 3) then
		SET pago_efe = 0;
		SET pago_tar = 0;
	else 
		IF _id_tipo_pago = 1 THEN
			SET pago_efe = ( _total + _comision_delivery - _descuento_monto);
			SET pago_tar = 0;
		ELSEIF _id_tipo_pago = 2 THEN
			SET pago_efe = 0;
			SET pago_tar = ( _total + _comision_delivery - _descuento_monto);
		ELSEIF _id_tipo_pago = 3 THEN
			SET pago_efe = ( _total + _comision_delivery - _descuento_monto) - _pago_tar;
			SET pago_tar = _pago_tar;
		ELSE
			SET pago_efe = 0;
			SET pago_tar = ( _total + _comision_delivery - _descuento_monto);
		END IF;
	end if;
	
	IF _flag = 1 THEN
	
		SELECT td.serie, CONCAT(LPAD(IFNULL(MAX(CAST(SUBSTRING(nro_doc, 1, 8) AS UNSIGNED)), 0) + td.numero + 1, 8, '0')) AS numero INTO @serie, @numero
		FROM tm_venta AS v RIGHT JOIN tm_tipo_doc AS td ON v.id_tipo_doc = td.id_tipo_doc
		WHERE td.id_tipo_doc = _id_tipo_doc GROUP BY td.serie, td.numero;
		INSERT INTO tm_venta (id_pedido, id_tipo_pedido, id_cliente, id_tipo_doc, id_tipo_pago, id_usu, id_apc, serie_doc, nro_doc, pago_efe, pago_efe_none, pago_tar, descuento_tipo, descuento_personal, descuento_monto, descuento_motivo, comision_tarjeta, comision_delivery, igv, total, codigo_operacion, fecha_venta)
		VALUES (_id_pedido, _tipo_pedido, _id_cliente, _id_tipo_doc, _id_tipo_pago,_id_usu,_id_apc, @serie,@numero, pago_efe, _pago_efe_none, pago_tar, _descuento_tipo, _descuento_personal, _descuento_monto, _descuento_motivo, _comision_tarjeta, _comision_delivery, _igv, _total, _codigo_operacion, _fecha_venta );
		
		SELECT @@IDENTITY INTO @id;
		
		/* DIVIDIR CUENTA 1 = FALSE, 2 = TRUE */
		IF _dividir_cuenta = 1 THEN
		
			IF _tipo_pedido = 1 THEN	
				SELECT id_mesa INTO @idMesa FROM tm_pedido_mesa WHERE id_pedido = _id_pedido;
				UPDATE tm_mesa SET estado = 'a' WHERE id_mesa = @idMesa;
				UPDATE tm_pedido SET estado = 'd' WHERE id_pedido = _id_pedido;
			elseIF _tipo_pedido = 2 then
				UPDATE tm_pedido SET estado = 'b' WHERE id_pedido = _id_pedido;
				UPDATE tm_pedido_llevar SET fecha_entrega = _fecha_venta WHERE id_pedido = _id_pedido;
			ELSEIF _tipo_pedido = 3 THEN
			
				UPDATE tm_pedido SET id_apc = _id_apc, id_usu = _id_usu, estado = _tipo_entrega WHERE id_pedido = _id_pedido;
				
				if _tipo_entrega = 'c' then
					UPDATE tm_pedido_delivery SET fecha_envio = _fecha_venta WHERE id_pedido = _id_pedido;
				elseif _tipo_entrega = 'd' then
					UPDATE tm_pedido_delivery SET fecha_entrega = _fecha_venta WHERE id_pedido = _id_pedido;
				end if;
				/*
				UPDATE tm_pedido SET id_apc = _id_apc, id_usu = _id_usu, estado = 'b' WHERE id_pedido = _id_pedido;
				UPDATE tm_pedido_delivery SET fecha_preparacion = _fecha_venta WHERE id_pedido = _id_pedido;
				*/
			END IF;
			
		END IF;
			
		SELECT @id AS id_venta;
			
	END IF;
	
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restEmitirVentaDet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restEmitirVentaDet`(IN `_flag` INT(11), IN `_id_venta` INT(11), IN `_id_pedido` INT(11), IN `_fecha` DATETIME)
BEGIN
    
	DECLARE _idprod INT; 
	DECLARE _cantidad1 INT;
	DECLARE _precio1 FLOAT;
	DECLARE _receta INT;
	DECLARE _tipopedido INT;
	DECLARE _controlstock INT;
	DECLARE done INT DEFAULT 0;
	
	DECLARE _cantidadi INT;
	DECLARE _resultado INT;
	DECLARE _contador INT;
	
	DECLARE primera CURSOR FOR SELECT dv.id_prod, SUM(dv.cantidad) AS cantidad, dv.precio, pp.receta, p.id_tipo, pp.crt_stock  FROM tm_detalle_venta AS dv INNER JOIN tm_producto_pres AS pp
	ON dv.id_prod = pp.id_pres LEFT JOIN tm_producto AS p ON pp.id_prod = p.id_prod WHERE dv.id_venta = _id_venta GROUP BY dv.id_prod;
	DECLARE segunda CURSOR FOR SELECT i.id_tipo_ins,i.id_ins,i.cant,v.ins_cos FROM tm_producto_ingr AS i INNER JOIN v_insprod AS v ON i.id_ins = v.id_ins AND i.id_tipo_ins = v.id_tipo_ins WHERE i.id_pres = _idprod;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	
	OPEN primera;
	REPEAT
	
	FETCH primera INTO _idprod, _cantidad1, _precio1, _receta, _tipopedido, _controlstock;
	IF NOT done THEN
			
		
	
	UPDATE tm_detalle_pedido SET cantidad = (cantidad - _cantidad1) WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad > 0 ORDER BY fecha_pedido ASC LIMIT 1;
	
	 	SELECT COUNT(1) INTO _contador FROM tm_detalle_pedido WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad < 0 ORDER BY fecha_pedido ASC LIMIT 1;

		while _contador <> 0 do
			SELECT IFNULL(cantidad,0) INTO _resultado FROM tm_detalle_pedido WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad < 0 ORDER BY fecha_pedido ASC LIMIT 1;

	IF _resultado < 0 THEN
        UPDATE tm_detalle_pedido SET cantidad = 0 WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad < 0 ORDER BY fecha_pedido ASC LIMIT 1;
		
		UPDATE tm_detalle_pedido SET cantidad = (cantidad + _resultado) WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad <> 0 ORDER BY fecha_pedido ASC LIMIT 1; 
    END IF;
	
	SELECT COUNT(1) INTO _contador FROM tm_detalle_pedido WHERE id_pedido = _id_pedido AND id_pres = _idprod AND estado <> 'i' AND cantidad < 0 ORDER BY fecha_pedido ASC LIMIT 1;
    end while;
			
	 
	
		IF _receta = 1 OR _controlstock = 1 THEN
			
			IF _tipopedido = 2 OR (_controlstock = 1 AND _tipopedido = 1) THEN
				
				INSERT INTO tm_inventario (id_tipo_ope,id_ope,id_tipo_ins,id_ins,cos_uni,cant,fecha_r) VALUES (2,_id_venta,2,_idprod,_precio1,_cantidad1,_fecha);
			
			ELSEIF _tipopedido = 1 THEN
				
				block2: BEGIN
				
						DECLARE donesegunda INT DEFAULT 0;
						DECLARE _tipoinsumo2 INT;
						DECLARE _idinsumo2 INT;
						DECLARE xx FLOAT;
						DECLARE _cantidad2 FLOAT;
						DECLARE _precio2 FLOAT;
						DECLARE tercera CURSOR FOR SELECT i.id_tipo_ins,i.id_ins,i.cant,v.ins_cos FROM tm_producto_ingr AS i INNER JOIN v_insprod AS v ON i.id_ins = v.id_ins AND i.id_tipo_ins = v.id_tipo_ins WHERE i.id_pres = _idinsumo2;
						DECLARE CONTINUE HANDLER FOR NOT FOUND SET donesegunda = 1;
					
					OPEN segunda;
					REPEAT
			
					FETCH segunda INTO _tipoinsumo2,_idinsumo2,_cantidad2, _precio2;
						IF NOT donesegunda THEN
						
							IF _tipoinsumo2 = 1 OR _tipoinsumo2 = 2 THEN
							
								SET xx = _cantidad2 * _cantidad1;
								INSERT INTO tm_inventario (id_tipo_ope,id_ope,id_tipo_ins,id_ins,cos_uni,cant,fecha_r) VALUES (2,_id_venta,_tipoinsumo2,_idinsumo2,_precio2,xx,_fecha);
							
							ELSEIF _tipoinsumo2 = 3 then
							
								block3: BEGIN
										DECLARE donetercera INT DEFAULT 0;
										DECLARE _tipoinsumo3 INT;
										DECLARE _idinsumo3 INT;
										DECLARE yy FLOAT;
										DECLARE _cantidad3 FLOAT;
										DECLARE _precio3 FLOAT;
										DECLARE CONTINUE HANDLER FOR NOT FOUND SET donetercera = 1;
							
									OPEN tercera;
									REPEAT
							
									FETCH tercera INTO _tipoinsumo3,_idinsumo3,_cantidad3,_precio3;
										IF NOT donetercera THEN
											
										SET yy = _cantidad1 * _cantidad2 * _cantidad3;
										INSERT INTO tm_inventario (id_tipo_ope,id_ope,id_tipo_ins,id_ins,cos_uni,cant,fecha_r) VALUES (2,_id_venta,_tipoinsumo3,_idinsumo3,_precio3,yy,_fecha);
									
										END IF;
									UNTIL donetercera END REPEAT;
									CLOSE tercera;
									
								END block3;
								
							end if;
							
						END IF;
							
					UNTIL donesegunda END REPEAT;
					CLOSE segunda;
					
				END block2;
				
			END IF;
		END IF;	
	END IF;
	UNTIL done END REPEAT;
	CLOSE primera;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restOpcionesMesa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restOpcionesMesa`(IN `_flag` INT(11), IN `_cod_mesa_origen` INT(11), IN `_cod_mesa_destino` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	if _flag = 1 then
			
			SELECT COUNT(*) INTO _filtro FROM tm_mesa WHERE id_mesa = _cod_mesa_origen AND estado = 'i';
		
		if _filtro = 1 then 
			SELECT id_pedido INTO @cod FROM v_listar_mesas WHERE id_mesa = _cod_mesa_origen;
			UPDATE tm_mesa SET estado = 'a' WHERE id_mesa = _cod_mesa_origen;
			UPDATE tm_mesa SET estado = 'i' WHERE id_mesa = _cod_mesa_destino;
			UPDATE tm_pedido_mesa SET id_mesa = _cod_mesa_destino WHERE id_pedido = @cod;
			
			SELECT _filtro AS cod;
		ELSE
			SELECT _filtro AS cod;
		end if;
	end if;
	
	IF _flag = 2 THEN
			
			SELECT COUNT(*) INTO _filtro FROM tm_mesa WHERE id_mesa = _cod_mesa_origen AND estado = 'i';
		
		IF _filtro = 1 THEN 
			SELECT id_pedido INTO @cod_1 FROM v_listar_mesas WHERE id_mesa = _cod_mesa_origen;
			SELECT id_pedido INTO @cod_2 FROM v_listar_mesas WHERE id_mesa = _cod_mesa_destino;
			UPDATE tm_detalle_pedido SET id_pedido = @cod_2 WHERE id_pedido = @cod_1;
			
				if _cod_mesa_origen = _cod_mesa_destino then
					UPDATE tm_mesa SET estado = 'i' WHERE id_mesa = _cod_mesa_origen;
				else
					UPDATE tm_mesa SET estado = 'a' WHERE id_mesa = _cod_mesa_origen;
					UPDATE tm_pedido SET estado = 'z' WHERE id_pedido = @cod_1;
				end if;
			
			SELECT _filtro AS cod;
		ELSE
			SELECT _filtro AS cod;
		END IF;
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restRegCliente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restRegCliente`(IN `_flag` INT(11), IN `_id_cliente` INT(11), IN `_tipo_cliente` INT(11), IN `_dni` VARCHAR(10), IN `_ruc` VARCHAR(13), IN `_nombres` VARCHAR(200), IN `_razon_social` VARCHAR(100), IN `_telefono` INT(11), IN `_fecha_nac` DATE, IN `_correo` VARCHAR(100), IN `_direccion` VARCHAR(100), IN `_referencia` VARCHAR(100))
BEGIN
	DECLARE _filtro INT DEFAULT 1;
	DECLARE _numero_documento INT DEFAULT 0;
	
	IF _flag = 1 THEN
	
		IF _tipo_cliente = 1 THEN
			SELECT COUNT(*) INTO _filtro FROM tm_cliente WHERE dni = _dni;
			SET _numero_documento = _dni;
		ELSEIF _tipo_cliente = 2 THEN
			SELECT COUNT(*) INTO _filtro FROM tm_cliente WHERE ruc = _ruc;
			SET _numero_documento = '2';
		END IF;
	
		IF _filtro = 0 OR _numero_documento = '00000000' THEN
		
			INSERT INTO tm_cliente (tipo_cliente,dni,ruc,nombres,razon_social,telefono,fecha_nac,correo,direccion,referencia) 
			VALUES (_tipo_cliente, _dni, _ruc, _nombres, _razon_social, _telefono, _fecha_nac, _correo, _direccion, _referencia);
			
			SELECT @@IDENTITY INTO @id;
			
			SELECT _filtro AS cod,@id AS id_cliente;
		ELSE
			SELECT _filtro AS cod;
		END IF;
	END IF;
	
	IF _flag = 2 THEN
	
		UPDATE tm_cliente SET tipo_cliente = _tipo_cliente, dni = _dni, ruc = _ruc, nombres = _nombres, 
		razon_social = _razon_social, telefono = _telefono, fecha_nac = _fecha_nac, correo = _correo, direccion = _direccion, referencia = _referencia
		WHERE id_cliente = _id_cliente;
		
		SELECT _id_cliente AS id_cliente;
		
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restRegDelivery` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restRegDelivery`(IN `_flag` INT(11), IN `_tipo_canal` INT(11), IN `_id_tipo_pedido` INT(11), IN `_id_apc` INT(11), IN `_id_usu` INT(11), IN `_fecha_pedido` DATETIME, IN `_id_cliente` INT(11), IN `_id_repartidor` INT(11), IN `_tipo_entrega` INT(11), IN `_tipo_pago` INT(11), IN `_pedido_programado` INT(11), IN `_hora_entrega` TIME, IN `_nombre_cliente` VARCHAR(100), IN `_telefono_cliente` VARCHAR(20), IN `_direccion_cliente` VARCHAR(100), IN `_referencia_cliente` VARCHAR(100), IN `_email_cliente` VARCHAR(200))
BEGIN
	DECLARE _filtro INT DEFAULT 1;
	
	IF _flag = 1 THEN
		
		INSERT INTO tm_pedido (id_tipo_pedido,id_apc,id_usu,fecha_pedido) VALUES (_id_tipo_pedido, _id_apc, _id_usu, _fecha_pedido);
		
		SELECT @@IDENTITY INTO @id;
		
		SELECT CONCAT(LPAD(count(t.nro_pedido)+1,5,'0')) AS codigo INTO @nro_pedido FROM tm_pedido_delivery AS t INNER JOIN tm_pedido AS p ON t.id_pedido = p.id_pedido WHERE p.id_tipo_pedido = 3 AND p.estado <> 'z'; 
		
			IF _id_cliente = 1 THEN
				INSERT INTO tm_cliente (tipo_cliente,nombres,telefono,direccion,referencia) VALUES (1,_nombre_cliente,_telefono_cliente,_direccion_cliente,_referencia_cliente);
				SELECT @@IDENTITY INTO @id_cliente;
				INSERT INTO tm_pedido_delivery (id_pedido,tipo_canal,id_cliente,id_repartidor,tipo_entrega,tipo_pago,pedido_programado,hora_entrega,nro_pedido,nombre_cliente,telefono_cliente,direccion_cliente,referencia_cliente,email_cliente) VALUES (@id, _tipo_canal, @id_cliente, _id_repartidor, _tipo_entrega, _tipo_pago, _pedido_programado, _hora_entrega, @nro_pedido, _nombre_cliente, _telefono_cliente, _direccion_cliente, _referencia_cliente, _email_cliente);
			ELSE
				UPDATE tm_cliente SET nombres = _nombre_cliente, telefono = _telefono_cliente, direccion = _direccion_cliente, referencia = _referencia_cliente WHERE id_cliente = _id_cliente; 		
				INSERT INTO tm_pedido_delivery (id_pedido,tipo_canal,id_cliente,id_repartidor,tipo_entrega,tipo_pago,pedido_programado,hora_entrega,nro_pedido,nombre_cliente,telefono_cliente,direccion_cliente,referencia_cliente,email_cliente) VALUES (@id, _tipo_canal, _id_cliente, _id_repartidor, _tipo_entrega, _tipo_pago, _pedido_programado, _hora_entrega, @nro_pedido, _nombre_cliente, _telefono_cliente, _direccion_cliente, _referencia_cliente, _email_cliente);
			END IF;
			
		SELECT _filtro AS fil, @id AS id_pedido;
	
	END IF;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restRegMesa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restRegMesa`(IN `_flag` INT(11), IN `_id_tipo_pedido` INT(11), IN `_id_apc` INT(11), IN `_id_usu` INT(11), IN `_fecha_pedido` DATETIME, IN `_id_mesa` INT(11), IN `_id_mozo` INT(11), IN `_nomb_cliente` VARCHAR(45), IN `_nro_personas` INT(11))
BEGIN
	DECLARE _filtro INT DEFAULT 0;
	
		IF _flag = 1 THEN
		
			SELECT COUNT(*) INTO _filtro FROM tm_mesa WHERE id_mesa = _id_mesa AND estado = 'a';
			
			if _filtro = 1 THEN
				
				INSERT INTO tm_pedido (id_tipo_pedido,id_apc,id_usu,fecha_pedido) VALUES (_id_tipo_pedido, _id_apc, _id_usu, _fecha_pedido);
				
				SELECT @@IDENTITY INTO @id;
				
				INSERT INTO tm_pedido_mesa (id_pedido,id_mesa,id_mozo,nomb_cliente,nro_personas) VALUES (@id, _id_mesa, _id_mozo, _nomb_cliente, _nro_personas);
				
				SELECT _filtro AS fil, @id AS id_pedido;
				
				UPDATE tm_mesa SET estado = 'i' WHERE id_mesa = _id_mesa;
			ELSE
				SELECT _filtro AS fil;
			END IF;
		END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_restRegMostrador` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_restRegMostrador`(IN `_flag` INT(11), IN `_id_tipo_pedido` INT(11), IN `_id_apc` INT(11), IN `_id_usu` INT(11), IN `_fecha_pedido` DATETIME, IN `_nomb_cliente` VARCHAR(45))
BEGIN
	DECLARE _filtro INT DEFAULT 1;
	
	IF _flag = 1 THEN
		
		INSERT INTO tm_pedido (id_tipo_pedido,id_apc,id_usu,fecha_pedido) VALUES (_id_tipo_pedido, _id_apc, _id_usu, _fecha_pedido);
		
		SELECT @@IDENTITY INTO @id;
		
		SELECT CONCAT(LPAD(count(t.nro_pedido)+1,5,'0')) AS codigo INTO @nro_pedido FROM tm_pedido_llevar AS t INNER JOIN tm_pedido AS p ON t.id_pedido = p.id_pedido WHERE p.id_tipo_pedido = 2 and p.estado <> 'z'; 
		
		INSERT INTO tm_pedido_llevar (id_pedido,nro_pedido,nomb_cliente) VALUES (@id, @nro_pedido, _nomb_cliente);
		
		SELECT _filtro AS fil, @id AS id_pedido;
	
	END IF;
	END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_tableroControl` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=CURRENT_USER PROCEDURE `usp_tableroControl`(IN `_flag` INT(11), IN `_codDia` INT(11), IN `_fecha` DATE, IN `_feSei` DATE, IN `_feCin` DATE, IN `_feCua` DATE, IN `_feTre` DATE, IN `_feDos` DATE, IN `_feUno` DATE)
BEGIN
	if _flag = 1 then
				SELECT dia,margen into @dia,@margen FROM tm_margen_venta WHERE cod_dia = _codDia;
				SELECT IFNULL(SUM(total-descuento),0) into @siete FROM tm_venta WHERE DATE(fecha_venta) = _fecha;
				SELECT IFNULL(SUM(total-descuento),0) into @seis FROM tm_venta WHERE DATE(fecha_venta) = _feSei;
				SELECT IFNULL(SUM(total-descuento),0) into @cinco FROM tm_venta WHERE DATE(fecha_venta) = _feCin;
				SELECT IFNULL(SUM(total-descuento),0) into @cuatro FROM tm_venta WHERE DATE(fecha_venta) = _feCua;
				SELECT IFNULL(SUM(total-descuento),0) into @tres FROM tm_venta WHERE DATE(fecha_venta) = _feTre;
				SELECT IFNULL(SUM(total-descuento),0) into @dos FROM tm_venta WHERE DATE(fecha_venta) = _feDos;
				SELECT IFNULL(SUM(total-descuento),0) into @uno FROM tm_venta WHERE DATE(fecha_venta) = _feUno;
		
		select @dia as dia,@margen as margen,@siete as siete,@seis as seis,@cinco as cinco,@cuatro as cuatro,@tres as tres,@dos as dos,@uno as uno;	
	end if;
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `v_caja_aper`
--

/*!50001 DROP VIEW IF EXISTS `v_caja_aper`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_caja_aper` AS select `apc`.`id_apc` AS `id_apc`,`apc`.`id_usu` AS `id_usu`,`apc`.`id_caja` AS `id_caja`,`apc`.`id_turno` AS `id_turno`,`apc`.`fecha_aper` AS `fecha_aper`,`apc`.`monto_aper` AS `monto_aper`,`apc`.`fecha_cierre` AS `fecha_cierre`,`apc`.`monto_cierre` AS `monto_cierre`,`apc`.`monto_sistema` AS `monto_sistema`,`apc`.`stock_pollo` AS `stock_pollo`,`apc`.`estado` AS `estado`,concat(`tp`.`nombres`,' ',`tp`.`ape_paterno`,' ',`tp`.`ape_materno`) AS `desc_per`,`tc`.`descripcion` AS `desc_caja`,`tt`.`descripcion` AS `desc_turno` from (((`tm_aper_cierre` `apc` join `tm_usuario` `tp` on(`apc`.`id_usu` = `tp`.`id_usu`)) join `tm_caja` `tc` on(`apc`.`id_caja` = `tc`.`id_caja`)) join `tm_turno` `tt` on(`apc`.`id_turno` = `tt`.`id_turno`)) order by `apc`.`id_apc` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_clientes`
--

/*!50001 DROP VIEW IF EXISTS `v_clientes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_clientes` AS select `tm_cliente`.`id_cliente` AS `id_cliente`,`tm_cliente`.`tipo_cliente` AS `tipo_cliente`,`tm_cliente`.`dni` AS `dni`,`tm_cliente`.`ruc` AS `ruc`,concat(ifnull(`tm_cliente`.`razon_social`,''),'',`tm_cliente`.`nombres`) AS `nombre`,`tm_cliente`.`telefono` AS `telefono`,`tm_cliente`.`fecha_nac` AS `fecha_nac`,`tm_cliente`.`direccion` AS `direccion`,`tm_cliente`.`referencia` AS `referencia`,`tm_cliente`.`estado` AS `estado` from `tm_cliente` order by `tm_cliente`.`id_cliente` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_cocina_de`
--

/*!50001 DROP VIEW IF EXISTS `v_cocina_de`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_cocina_de` AS select `dp`.`id_pedido` AS `id_pedido`,`vp`.`id_areap` AS `id_areap`,`vp`.`id_tipo` AS `id_tipo`,`dp`.`id_pres` AS `id_pres`,if(`dp`.`cantidad` < `dp`.`cant`,`dp`.`cant`,`dp`.`cantidad`) AS `cantidad`,`dp`.`comentario` AS `comentario`,`dp`.`fecha_pedido` AS `fecha_pedido`,`dp`.`fecha_envio` AS `fecha_envio`,`dp`.`estado` AS `estado`,`pd`.`nro_pedido` AS `nro_pedido`,`tp`.`id_usu` AS `id_usu`,`vp`.`pro_nom` AS `nombre_prod`,`vp`.`pro_pre` AS `pres_prod`,`vu`.`ape_paterno` AS `ape_paterno`,`vu`.`ape_materno` AS `ape_materno`,`vu`.`nombres` AS `nombres`,`tp`.`estado` AS `estado_pedido` from ((((`tm_detalle_pedido` `dp` join `tm_pedido_delivery` `pd` on(`dp`.`id_pedido` = `pd`.`id_pedido`)) join `tm_pedido` `tp` on(`dp`.`id_pedido` = `tp`.`id_pedido`)) join `v_productos` `vp` on(`dp`.`id_pres` = `vp`.`id_pres`)) join `v_usuarios` `vu` on(`tp`.`id_usu` = `vu`.`id_usu`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_cocina_me`
--

/*!50001 DROP VIEW IF EXISTS `v_cocina_me`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_cocina_me` AS select `dp`.`id_pedido` AS `id_pedido`,`vp`.`id_areap` AS `id_areap`,`vp`.`id_tipo` AS `id_tipo`,`dp`.`id_pres` AS `id_pres`,`dp`.`cantidad` AS `cantidad`,`dp`.`comentario` AS `comentario`,`dp`.`fecha_pedido` AS `fecha_pedido`,`dp`.`fecha_envio` AS `fecha_envio`,`dp`.`estado` AS `estado`,`pm`.`id_mesa` AS `id_mesa`,`pm`.`id_mozo` AS `id_mozo`,`vp`.`pro_nom` AS `nombre_prod`,`vp`.`pro_pre` AS `pres_prod`,`vm`.`nro_mesa` AS `nro_mesa`,`vm`.`desc_salon` AS `desc_salon`,`vu`.`ape_paterno` AS `ape_paterno`,`vu`.`ape_materno` AS `ape_materno`,`vu`.`nombres` AS `nombres`,`tp`.`estado` AS `estado_pedido` from (((((`tm_detalle_pedido` `dp` join `tm_pedido_mesa` `pm` on(`dp`.`id_pedido` = `pm`.`id_pedido`)) join `tm_pedido` `tp` on(`dp`.`id_pedido` = `tp`.`id_pedido`)) join `v_productos` `vp` on(`dp`.`id_pres` = `vp`.`id_pres`)) join `v_mesas` `vm` on(`pm`.`id_mesa` = `vm`.`id_mesa`)) join `v_usuarios` `vu` on(`pm`.`id_mozo` = `vu`.`id_usu`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_cocina_mo`
--

/*!50001 DROP VIEW IF EXISTS `v_cocina_mo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_cocina_mo` AS select `dp`.`id_pedido` AS `id_pedido`,`vp`.`id_areap` AS `id_areap`,`vp`.`id_tipo` AS `id_tipo`,`dp`.`id_pres` AS `id_pres`,if(`dp`.`cantidad` < `dp`.`cant`,`dp`.`cant`,`dp`.`cantidad`) AS `cantidad`,`dp`.`comentario` AS `comentario`,`dp`.`fecha_pedido` AS `fecha_pedido`,`dp`.`fecha_envio` AS `fecha_envio`,`dp`.`estado` AS `estado`,`pm`.`nro_pedido` AS `nro_pedido`,`tp`.`id_usu` AS `id_usu`,`vp`.`pro_nom` AS `nombre_prod`,`vp`.`pro_pre` AS `pres_prod`,`vu`.`ape_paterno` AS `ape_paterno`,`vu`.`ape_materno` AS `ape_materno`,`vu`.`nombres` AS `nombres`,`tp`.`estado` AS `estado_pedido` from ((((`tm_detalle_pedido` `dp` join `tm_pedido_llevar` `pm` on(`dp`.`id_pedido` = `pm`.`id_pedido`)) join `tm_pedido` `tp` on(`dp`.`id_pedido` = `tp`.`id_pedido`)) join `v_productos` `vp` on(`dp`.`id_pres` = `vp`.`id_pres`)) join `v_usuarios` `vu` on(`tp`.`id_usu` = `vu`.`id_usu`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_compras`
--

/*!50001 DROP VIEW IF EXISTS `v_compras`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_compras` AS select `c`.`id_compra` AS `id_compra`,`c`.`id_prov` AS `id_prov`,`c`.`id_tipo_compra` AS `id_tipo_compra`,`c`.`id_tipo_doc` AS `id_tipo_doc`,`c`.`fecha_c` AS `fecha_c`,`c`.`fecha_reg` AS `fecha_r`,`c`.`hora_c` AS `hora_c`,`c`.`serie_doc` AS `serie_doc`,`c`.`num_doc` AS `num_doc`,`c`.`igv` AS `igv`,`c`.`total` AS `total`,`c`.`estado` AS `estado`,`tc`.`descripcion` AS `desc_tc`,`td`.`descripcion` AS `desc_td`,`tp`.`razon_social` AS `desc_prov` from (((`tm_compra` `c` join `tm_tipo_compra` `tc` on(`c`.`id_tipo_compra` = `tc`.`id_tipo_compra`)) join `tm_tipo_doc` `td` on(`c`.`id_tipo_doc` = `td`.`id_tipo_doc`)) join `tm_proveedor` `tp` on(`c`.`id_prov` = `tp`.`id_prov`)) where `c`.`id_compra` <> 0 order by `c`.`id_compra` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_det_delivery`
--

/*!50001 DROP VIEW IF EXISTS `v_det_delivery`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_det_delivery` AS select `dp`.`id_pedido` AS `id_pedido`,`dp`.`id_pres` AS `id_pres`,if(`dp`.`cantidad` < `dp`.`cant`,`dp`.`cant`,`dp`.`cantidad`) AS `cantidad`,`dp`.`precio` AS `precio`,`dp`.`estado` AS `estado`,`vp`.`pro_nom` AS `nombre_prod`,`vp`.`pro_pre` AS `pres_prod` from (((`tm_detalle_pedido` `dp` join `tm_pedido_delivery` `pd` on(`dp`.`id_pedido` = `pd`.`id_pedido`)) join `tm_pedido` `tp` on(`dp`.`id_pedido` = `tp`.`id_pedido`)) join `v_productos` `vp` on(`dp`.`id_pres` = `vp`.`id_pres`)) where `dp`.`estado` <> 'z' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_det_llevar`
--

/*!50001 DROP VIEW IF EXISTS `v_det_llevar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_det_llevar` AS select `dp`.`id_pedido` AS `id_pedido`,`dp`.`id_pres` AS `id_pres`,if(`dp`.`cantidad` < `dp`.`cant`,`dp`.`cant`,`dp`.`cantidad`) AS `cantidad`,`dp`.`precio` AS `precio`,`dp`.`estado` AS `estado`,`vp`.`pro_nom` AS `nombre_prod`,`vp`.`pro_pre` AS `pres_prod` from (((`tm_detalle_pedido` `dp` join `tm_pedido_llevar` `pm` on(`dp`.`id_pedido` = `pm`.`id_pedido`)) join `tm_pedido` `tp` on(`dp`.`id_pedido` = `tp`.`id_pedido`)) join `v_productos` `vp` on(`dp`.`id_pres` = `vp`.`id_pres`)) where `dp`.`estado` <> 'z' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_gastosadm`
--

/*!50001 DROP VIEW IF EXISTS `v_gastosadm`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_gastosadm` AS select `ga`.`id_ga` AS `id_ga`,`ga`.`id_tipo_gasto` AS `id_tg`,`ga`.`id_per` AS `id_per`,`ga`.`id_usu` AS `id_usu`,`ga`.`id_apc` AS `id_apc`,`ga`.`importe` AS `importe`,`ga`.`responsable` AS `responsable`,`ga`.`motivo` AS `motivo`,`ga`.`fecha_registro` AS `fecha_re`,`ga`.`estado` AS `estado`,`tg`.`descripcion` AS `des_tg`,concat(`tu`.`nombres`,' ',`tu`.`ape_paterno`,' ',`tu`.`ape_materno`) AS `desc_usu`,if(`ga`.`id_per` = '0','',concat(`tus`.`nombres`,' ',`tus`.`ape_paterno`,' ',`tus`.`ape_materno`)) AS `desc_per` from (((`tm_gastos_adm` `ga` join `tm_tipo_gasto` `tg` on(`ga`.`id_tipo_gasto` = `tg`.`id_tipo_gasto`)) join `tm_usuario` `tu` on(`ga`.`id_usu` = `tu`.`id_usu`)) left join `tm_usuario` `tus` on(`ga`.`id_per` = `tus`.`id_usu`)) where `ga`.`id_ga` <> 0 order by `ga`.`id_ga` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_insprod`
--

/*!50001 DROP VIEW IF EXISTS `v_insprod`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_insprod` AS select 1 AS `id_tipo_ins`,`i`.`id_ins` AS `id_ins`,`i`.`id_med` AS `id_med`,`i`.`id_gru` AS `id_gru`,`i`.`ins_cod` AS `ins_cod`,`i`.`ins_nom` AS `ins_nom`,`i`.`ins_cat` AS `ins_cat`,`i`.`ins_med` AS `ins_med`,1 AS `ins_rec`,`i`.`ins_cos` AS `ins_cos`,`i`.`ins_sto` AS `ins_sto`,`i`.`ins_est` AS `est_a`,'a' AS `est_b`,'a' AS `est_c`,'' AS `crt_stock` from `v_insumos` `i` union select 2 AS `id_tipo_ins`,`p`.`id_pres` AS `id_pres`,'1' AS `1`,'1' AS `1`,`p`.`pro_cod` AS `pro_cod`,concat(`p`.`pro_nom`,' ',`p`.`pro_pre`) AS `pro_nom`,`p`.`pro_cat` AS `pro_cat`,'UNIDAD' AS `UNIDAD`,`p`.`pro_rec` AS `pro_rec`,`p`.`pro_cos` AS `pro_cos`,`p`.`pro_sto` AS `pro_sto`,`p`.`est_a` AS `est_a`,`p`.`est_b` AS `est_b`,`p`.`est_c` AS `est_c`,`p`.`crt_stock` AS `crt_stock` from `v_productos` `p` where `p`.`id_tipo` = 2 and `p`.`id_catg` <> 1 union select if(`p`.`crt_stock` = 1,2,3) AS `id_tipo_ins`,`p`.`id_pres` AS `id_pres`,'1' AS `1`,'1' AS `1`,`p`.`pro_cod` AS `pro_cod`,concat(`p`.`pro_nom`,' ',`p`.`pro_pre`) AS `pro_nom`,`p`.`pro_cat` AS `pro_cat`,'UNIDAD' AS `UNIDAD`,`p`.`pro_rec` AS `pro_rec`,`p`.`pro_cos` AS `pro_cos`,`p`.`pro_sto` AS `pro_sto`,`p`.`est_a` AS `est_a`,`p`.`est_b` AS `est_b`,`p`.`est_c` AS `est_c`,`p`.`crt_stock` AS `crt_stock` from `v_productos` `p` where `p`.`id_tipo` = 1 and `p`.`id_catg` <> 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_insumos`
--

/*!50001 DROP VIEW IF EXISTS `v_insumos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_insumos` AS select `i`.`id_ins` AS `id_ins`,`i`.`id_catg` AS `id_catg`,`i`.`id_med` AS `id_med`,`m`.`grupo` AS `id_gru`,`i`.`cod_ins` AS `ins_cod`,`i`.`nomb_ins` AS `ins_nom`,`i`.`stock_min` AS `ins_sto`,`i`.`cos_uni` AS `ins_cos`,`i`.`estado` AS `ins_est`,`ic`.`descripcion` AS `ins_cat`,`m`.`descripcion` AS `ins_med` from ((`tm_insumo` `i` join `tm_insumo_catg` `ic` on(`i`.`id_catg` = `ic`.`id_catg`)) join `tm_tipo_medida` `m` on(`i`.`id_med` = `m`.`id_med`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inventario`
--

/*!50001 DROP VIEW IF EXISTS `v_inventario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_inventario` AS select `e`.`id_tipo_ins` AS `id_tipo_ins`,`e`.`id_ins` AS `id_ins`,ifnull(`e`.`total`,0) AS `ent`,'0' AS `sal` from `v_inventario_ent` `e` union select `s`.`id_tipo_ins` AS `id_tipo_ins`,`s`.`id_ins` AS `id_ins`,'0' AS `ent`,ifnull(`s`.`total`,0) AS `sal` from `v_inventario_sal` `s` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inventario_ent`
--

/*!50001 DROP VIEW IF EXISTS `v_inventario_ent`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_inventario_ent` AS select `tm_inventario`.`id_tipo_ins` AS `id_tipo_ins`,`tm_inventario`.`id_ins` AS `id_ins`,if(`tm_inventario`.`id_tipo_ope` = 1 or `tm_inventario`.`id_tipo_ope` = 3,sum(`tm_inventario`.`cant`),0) AS `total` from `tm_inventario` where `tm_inventario`.`id_tipo_ope` <> 2 and `tm_inventario`.`id_tipo_ope` <> 4 and `tm_inventario`.`estado` <> 'i' group by `tm_inventario`.`id_tipo_ins`,`tm_inventario`.`id_ins` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_inventario_sal`
--

/*!50001 DROP VIEW IF EXISTS `v_inventario_sal`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_inventario_sal` AS select `tm_inventario`.`id_tipo_ins` AS `id_tipo_ins`,`tm_inventario`.`id_ins` AS `id_ins`,if(`tm_inventario`.`id_tipo_ope` = 2 or `tm_inventario`.`id_tipo_ope` = 4,sum(`tm_inventario`.`cant`),0) AS `total` from `tm_inventario` where `tm_inventario`.`id_tipo_ope` <> 1 and `tm_inventario`.`id_tipo_ope` <> 3 and `tm_inventario`.`estado` <> 'i' group by `tm_inventario`.`id_tipo_ins`,`tm_inventario`.`id_ins` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_listar_mesas`
--

/*!50001 DROP VIEW IF EXISTS `v_listar_mesas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_listar_mesas` AS select `vm`.`id_mesa` AS `id_mesa`,`vm`.`id_salon` AS `id_salon`,`vm`.`nro_mesa` AS `nro_mesa`,`vm`.`estado` AS `estado`,`vm`.`desc_salon` AS `desc_salon`,`vo`.`id_pedido` AS `id_pedido`,`vo`.`fecha_pedido` AS `fecha_pedido`,`vo`.`nro_personas` AS `nro_personas` from (`v_mesas` `vm` left join `v_pedido_mesa` `vo` on(`vm`.`id_mesa` = `vo`.`id_mesa`)) order by `vm`.`nro_mesa` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_mesas`
--

/*!50001 DROP VIEW IF EXISTS `v_mesas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_mesas` AS select `m`.`id_mesa` AS `id_mesa`,`m`.`id_salon` AS `id_salon`,`m`.`nro_mesa` AS `nro_mesa`,`m`.`estado` AS `estado`,`cm`.`descripcion` AS `desc_salon` from (`tm_mesa` `m` join `tm_salon` `cm` on(`m`.`id_salon` = `cm`.`id_salon`)) where `m`.`id_mesa` <> 0 and `cm`.`estado` <> 'i' order by `m`.`id_mesa` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedido_delivery`
--

/*!50001 DROP VIEW IF EXISTS `v_pedido_delivery`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedido_delivery` AS select `p`.`id_pedido` AS `id_pedido`,`p`.`id_tipo_pedido` AS `id_tipo_pedido`,`p`.`id_usu` AS `id_usu`,`pd`.`id_repartidor` AS `id_repartidor`,`p`.`fecha_pedido` AS `fecha_pedido`,`p`.`estado` AS `estado_pedido`,`pd`.`tipo_entrega` AS `tipo_entrega`,`pd`.`pedido_programado` AS `pedido_programado`,`pd`.`hora_entrega` AS `hora_entrega`,`pd`.`amortizacion` AS `amortizacion`,`pd`.`tipo_pago` AS `tipo_pago`,`pd`.`paga_con` AS `paga_con`,`pd`.`comision_delivery` AS `comision_delivery`,`pd`.`nro_pedido` AS `nro_pedido`,`pd`.`id_cliente` AS `id_cliente`,`c`.`tipo_cliente` AS `tipo_cliente`,`c`.`dni` AS `dni_cliente`,`c`.`ruc` AS `ruc_cliente`,`pd`.`nombre_cliente` AS `nombre_cliente`,`pd`.`telefono_cliente` AS `telefono_cliente`,`pd`.`direccion_cliente` AS `direccion_cliente`,`pd`.`referencia_cliente` AS `referencia_cliente`,`pd`.`email_cliente` AS `email_cliente`,`r`.`desc_repartidor` AS `desc_repartidor` from (((`tm_pedido` `p` join `tm_pedido_delivery` `pd` on(`p`.`id_pedido` = `pd`.`id_pedido`)) join `v_repartidores` `r` on(`pd`.`id_repartidor` = `r`.`id_repartidor`)) join `tm_cliente` `c` on(`pd`.`id_cliente` = `c`.`id_cliente`)) where `p`.`id_pedido` <> 0 order by `p`.`id_pedido` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedido_llevar`
--

/*!50001 DROP VIEW IF EXISTS `v_pedido_llevar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedido_llevar` AS select `p`.`id_pedido` AS `id_pedido`,`p`.`id_tipo_pedido` AS `id_tipo_pedido`,`p`.`id_usu` AS `id_usu`,`p`.`fecha_pedido` AS `fecha_pedido`,`p`.`estado` AS `estado_pedido`,`pl`.`nro_pedido` AS `nro_pedido`,`pl`.`nomb_cliente` AS `nombre_cliente` from (`tm_pedido` `p` join `tm_pedido_llevar` `pl` on(`p`.`id_pedido` = `pl`.`id_pedido`)) where `p`.`id_pedido` <> 0 order by `p`.`id_pedido` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedido_mesa`
--

/*!50001 DROP VIEW IF EXISTS `v_pedido_mesa`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedido_mesa` AS select `p`.`id_pedido` AS `id_pedido`,`p`.`id_tipo_pedido` AS `id_tipo_pedido`,`p`.`id_usu` AS `id_usu`,`pm`.`id_mesa` AS `id_mesa`,`p`.`fecha_pedido` AS `fecha_pedido`,`p`.`estado` AS `estado_pedido`,`pm`.`nomb_cliente` AS `nombre_cliente`,`pm`.`nro_personas` AS `nro_personas`,`vm`.`nro_mesa` AS `nro_mesa`,`vm`.`desc_salon` AS `desc_salon`,`vm`.`estado` AS `estado_mesa`,concat(`u`.`nombres`,' ',`u`.`ape_paterno`) AS `nombre_mozo` from (((`tm_pedido` `p` join `tm_pedido_mesa` `pm` on(`p`.`id_pedido` = `pm`.`id_pedido`)) join `v_mesas` `vm` on(`pm`.`id_mesa` = `vm`.`id_mesa`)) join `tm_usuario` `u` on(`pm`.`id_mozo` = `u`.`id_usu`)) where `p`.`id_pedido` <> 0 and `p`.`estado` = 'a' order by `p`.`id_pedido` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_agrupados`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_agrupados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_agrupados` AS select 1 AS `tipo_atencion`,`v_cocina_me`.`id_pedido` AS `id_pedido`,`v_cocina_me`.`id_areap` AS `id_areap`,`v_cocina_me`.`id_tipo` AS `id_tipo`,`v_cocina_me`.`id_pres` AS `id_pres`,sum(`v_cocina_me`.`cantidad`) AS `cantidad`,`v_cocina_me`.`comentario` AS `comentario`,`v_cocina_me`.`fecha_pedido` AS `fecha_pedido`,`v_cocina_me`.`fecha_envio` AS `fecha_envio`,`v_cocina_me`.`estado` AS `estado`,`v_cocina_me`.`nombre_prod` AS `nombre_prod`,`v_cocina_me`.`pres_prod` AS `pres_prod`,`v_cocina_me`.`nro_mesa` AS `nro_mesa`,`v_cocina_me`.`desc_salon` AS `desc_salon`,`v_cocina_me`.`ape_paterno` AS `ape_paterno`,`v_cocina_me`.`ape_materno` AS `ape_materno`,`v_cocina_me`.`nombres` AS `nombres`,`v_cocina_me`.`estado_pedido` AS `estado_pedido` from `v_cocina_me` group by `v_cocina_me`.`id_pedido`,`v_cocina_me`.`id_pres`,`v_cocina_me`.`fecha_pedido`,`v_cocina_me`.`comentario` union select 2 AS `tipo_atencion`,`v_cocina_mo`.`id_pedido` AS `id_pedido`,`v_cocina_mo`.`id_areap` AS `id_areap`,`v_cocina_mo`.`id_tipo` AS `id_tipo`,`v_cocina_mo`.`id_pres` AS `id_pres`,sum(`v_cocina_mo`.`cantidad`) AS `cantidad`,`v_cocina_mo`.`comentario` AS `comentario`,`v_cocina_mo`.`fecha_pedido` AS `fecha_pedido`,`v_cocina_mo`.`fecha_envio` AS `fecha_envio`,`v_cocina_mo`.`estado` AS `estado`,`v_cocina_mo`.`nombre_prod` AS `nombre_prod`,`v_cocina_mo`.`pres_prod` AS `pres_prod`,`v_cocina_mo`.`nro_pedido` AS `nro_pedido`,'MOSTRADOR' AS `MOSTRADOR`,`v_cocina_mo`.`ape_paterno` AS `ape_paterno`,`v_cocina_mo`.`ape_materno` AS `ape_materno`,`v_cocina_mo`.`nombres` AS `nombres`,`v_cocina_mo`.`estado_pedido` AS `estado_pedido` from `v_cocina_mo` group by `v_cocina_mo`.`id_pedido`,`v_cocina_mo`.`id_pres`,`v_cocina_mo`.`fecha_pedido`,`v_cocina_mo`.`comentario` union select 3 AS `tipo_atencion`,`v_cocina_de`.`id_pedido` AS `id_pedido`,`v_cocina_de`.`id_areap` AS `id_areap`,`v_cocina_de`.`id_tipo` AS `id_tipo`,`v_cocina_de`.`id_pres` AS `id_pres`,sum(`v_cocina_de`.`cantidad`) AS `cantidad`,`v_cocina_de`.`comentario` AS `comentario`,`v_cocina_de`.`fecha_pedido` AS `fecha_pedido`,`v_cocina_de`.`fecha_envio` AS `fecha_envio`,`v_cocina_de`.`estado` AS `estado`,`v_cocina_de`.`nombre_prod` AS `nombre_prod`,`v_cocina_de`.`pres_prod` AS `pres_prod`,`v_cocina_de`.`nro_pedido` AS `nro_pedido`,'DELIVERY' AS `DELIVERY`,`v_cocina_de`.`ape_paterno` AS `ape_paterno`,`v_cocina_de`.`ape_materno` AS `ape_materno`,`v_cocina_de`.`nombres` AS `nombres`,`v_cocina_de`.`estado_pedido` AS `estado_pedido` from `v_cocina_de` group by `v_cocina_de`.`id_pedido`,`v_cocina_de`.`id_pres`,`v_cocina_de`.`fecha_pedido`,`v_cocina_de`.`comentario` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_productos`
--

/*!50001 DROP VIEW IF EXISTS `v_productos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_productos` AS select `pp`.`id_pres` AS `id_pres`,`pp`.`id_prod` AS `id_prod`,`p`.`id_tipo` AS `id_tipo`,`p`.`id_catg` AS `id_catg`,`p`.`id_areap` AS `id_areap`,`cp`.`descripcion` AS `pro_cat`,`pp`.`cod_prod` AS `pro_cod`,`p`.`nombre` AS `pro_nom`,`pp`.`presentacion` AS `pro_pre`,ifnull(`pp`.`descripcion`,'') AS `pro_des`,`pp`.`precio` AS `pro_cos`,`pp`.`precio_delivery` AS `pro_cos_del`,`pp`.`receta` AS `pro_rec`,`pp`.`stock_min` AS `pro_sto`,`pp`.`impuesto` AS `pro_imp`,`pp`.`margen` AS `pro_mar`,`pp`.`igv` AS `pro_igv`,`pp`.`imagen` AS `pro_img`,`cp`.`delivery` AS `del_a`,`p`.`delivery` AS `del_b`,`pp`.`delivery` AS `del_c`,`cp`.`estado` AS `est_a`,`p`.`estado` AS `est_b`,`pp`.`estado` AS `est_c`,`pp`.`crt_stock` AS `crt_stock` from ((`tm_producto_pres` `pp` join `tm_producto` `p` on(`pp`.`id_prod` = `p`.`id_prod`)) join `tm_producto_catg` `cp` on(`p`.`id_catg` = `cp`.`id_catg`)) where `pp`.`id_pres` <> 0 order by `pp`.`id_pres` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_repartidores`
--

/*!50001 DROP VIEW IF EXISTS `v_repartidores`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_repartidores` AS select `tm_usuario`.`id_usu` AS `id_repartidor`,concat(`tm_usuario`.`nombres`,' ',`tm_usuario`.`ape_paterno`,' ',`tm_usuario`.`ape_materno`) AS `desc_repartidor` from `tm_usuario` where `tm_usuario`.`id_rol` = 6 union select `tm_repartidor`.`id_repartidor` AS `id_repartidor`,`tm_repartidor`.`descripcion` AS `desc_repartidor` from `tm_repartidor` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_stock`
--

/*!50001 DROP VIEW IF EXISTS `v_stock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_stock` AS (select `a`.`id_tipo_ins` AS `id_tipo_ins`,`a`.`id_ins` AS `id_ins`,sum(`a`.`ent`) AS `ent`,sum(`a`.`sal`) AS `sal`,`b`.`est_a` AS `est_a`,`b`.`est_b` AS `est_b`,if(`a`.`ent` - `a`.`sal` > `b`.`ins_sto`,1,0) AS `debajo_stock` from (`v_inventario` `a` join `v_insprod` `b` on(`a`.`id_tipo_ins` = `b`.`id_tipo_ins` and `a`.`id_ins` = `b`.`id_ins`)) where `b`.`est_a` = 'a' and `b`.`est_b` = 'a' group by `a`.`id_tipo_ins`,`a`.`id_ins`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_stock_pedido`
--

/*!50001 DROP VIEW IF EXISTS `v_stock_pedido`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_stock_pedido` AS (select `c`.`id_pres` AS `id_ins`,ifnull((select sum(`b`.`ent`) from `v_inventario` `b` where `b`.`id_ins` = `c`.`id_pres` group by `c`.`id_pres`),0) AS `ent`,ifnull((select sum(`a`.`cant`) from `tm_stock_pedidos` `a` where `a`.`id_pres` = `c`.`id_pres` and `a`.`estado` = 'a' group by `c`.`id_pres`),0) AS `sal`,(select `d`.`crt_stock` from `tm_producto_pres` `d` where `d`.`id_pres` = `c`.`id_pres` group by `c`.`id_pres`) AS `control` from `tm_producto_pres` `c` where `c`.`crt_stock` = 1 group by `c`.`id_pres`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_usuarios`
--

/*!50001 DROP VIEW IF EXISTS `v_usuarios`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_usuarios` AS select `u`.`id_usu` AS `id_usu`,`u`.`id_rol` AS `id_rol`,`u`.`id_areap` AS `id_areap`,`u`.`dni` AS `dni`,`u`.`ape_paterno` AS `ape_paterno`,`u`.`ape_materno` AS `ape_materno`,`u`.`nombres` AS `nombres`,`u`.`email` AS `email`,`u`.`usuario` AS `usuario`,`u`.`contrasena` AS `contrasena`,`u`.`estado` AS `estado`,`u`.`imagen` AS `imagen`,`r`.`descripcion` AS `desc_r`,`p`.`nombre` AS `desc_ap` from ((`tm_usuario` `u` join `tm_rol` `r` on(`u`.`id_rol` = `r`.`id_rol`)) left join `tm_area_prod` `p` on(`u`.`id_areap` = `p`.`id_areap`)) where `u`.`id_usu` <> 0 order by `u`.`id_usu` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_ventas_con`
--

/*!50001 DROP VIEW IF EXISTS `v_ventas_con`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=CURRENT_USER SQL SECURITY DEFINER */
/*!50001 VIEW `v_ventas_con` AS select `v`.`id_venta` AS `id_ven`,`v`.`id_pedido` AS `id_ped`,`v`.`id_tipo_pedido` AS `id_tped`,`v`.`id_cliente` AS `id_cli`,`v`.`id_tipo_doc` AS `id_tdoc`,`v`.`id_tipo_pago` AS `id_tpag`,`v`.`id_usu` AS `id_usu`,`v`.`id_apc` AS `id_apc`,`v`.`serie_doc` AS `ser_doc`,`v`.`nro_doc` AS `nro_doc`,`v`.`pago_efe` AS `pago_efe`,`v`.`pago_efe_none` AS `pago_efe_none`,`v`.`pago_tar` AS `pago_tar`,`v`.`descuento_monto` AS `desc_monto`,`v`.`descuento_tipo` AS `desc_tipo`,`v`.`descuento_personal` AS `desc_personal`,`v`.`descuento_motivo` AS `desc_motivo`,`v`.`comision_tarjeta` AS `comis_tar`,`v`.`comision_delivery` AS `comis_del`,`v`.`igv` AS `igv`,`v`.`total` AS `total`,`v`.`codigo_operacion` AS `codigo_operacion`,`v`.`fecha_venta` AS `fec_ven`,`v`.`estado` AS `estado`,`v`.`enviado_sunat` AS `enviado_sunat`,`v`.`code_respuesta_sunat` AS `code_respuesta_sunat`,`v`.`descripcion_sunat_cdr` AS `descripcion_sunat_cdr`,`v`.`name_file_sunat` AS `name_file_sunat`,`v`.`hash_cdr` AS `hash_cdr`,`v`.`hash_cpe` AS `hash_cpe`,`v`.`fecha_vencimiento` AS `fecha_vencimiento`,`td`.`descripcion` AS `desc_td`,`tp`.`descripcion` AS `desc_tp`,concat(`tu`.`ape_paterno`,' ',`tu`.`ape_materno`,' ',`tu`.`nombres`) AS `desc_usu` from (((`tm_venta` `v` join `tm_tipo_doc` `td` on(`v`.`id_tipo_doc` = `td`.`id_tipo_doc`)) join `tm_tipo_pago` `tp` on(`v`.`id_tipo_pago` = `tp`.`id_tipo_pago`)) join `tm_usuario` `tu` on(`v`.`id_usu` = `tu`.`id_usu`)) where `v`.`id_venta` <> 0 order by `v`.`id_venta` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-26 16:34:38
