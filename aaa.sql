/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : aaa

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-03-06 00:11:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cms_banners
-- ----------------------------
DROP TABLE IF EXISTS `cms_banners`;
CREATE TABLE `cms_banners` (
  `id_ban` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_ban` varchar(200) DEFAULT NULL COMMENT 'Nombre',
  `descripcion_ban` text COMMENT 'Descripcion',
  `imagen_ban` varchar(200) DEFAULT NULL COMMENT 'Imagen',
  `video_ban` text COMMENT 'Video',
  `activo_ban` smallint(6) DEFAULT NULL COMMENT 'Activo',
  PRIMARY KEY (`id_ban`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_banners
-- ----------------------------

-- ----------------------------
-- Table structure for cms_contenidos
-- ----------------------------
DROP TABLE IF EXISTS `cms_contenidos`;
CREATE TABLE `cms_contenidos` (
  `id_con` bigint(20) NOT NULL COMMENT 'ID',
  `titulo_con` varchar(255) DEFAULT NULL COMMENT 'Titulo',
  `descripcion_con` text COMMENT 'Descripcion',
  `imagen_con` varchar(255) DEFAULT NULL COMMENT 'Imagen',
  `tipocontenido_con` bigint(20) DEFAULT NULL COMMENT 'Tipo Contenido',
  `activo_con` smallint(6) DEFAULT '0' COMMENT 'Activo',
  PRIMARY KEY (`id_con`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_contenidos
-- ----------------------------

-- ----------------------------
-- Table structure for cms_tipocontenidos
-- ----------------------------
DROP TABLE IF EXISTS `cms_tipocontenidos`;
CREATE TABLE `cms_tipocontenidos` (
  `id_tcn` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_tcn` varchar(200) DEFAULT NULL COMMENT 'Nombre',
  `activo_tcn` smallint(1) DEFAULT '0' COMMENT 'Activo',
  PRIMARY KEY (`id_tcn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_tipocontenidos
-- ----------------------------

-- ----------------------------
-- Table structure for cnf_configuraciones
-- ----------------------------
DROP TABLE IF EXISTS `cnf_configuraciones`;
CREATE TABLE `cnf_configuraciones` (
  `variable_cnf` varchar(70) DEFAULT NULL,
  `valor_cnf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cnf_configuraciones
-- ----------------------------
INSERT INTO `cnf_configuraciones` VALUES ('logo', 'http://detail.herokuapp.com/img/logo.png');
INSERT INTO `cnf_configuraciones` VALUES ('nombre', 'axioma');
INSERT INTO `cnf_configuraciones` VALUES ('nombre_panel', 'axioma_system');

-- ----------------------------
-- Table structure for msc_archivos
-- ----------------------------
DROP TABLE IF EXISTS `msc_archivos`;
CREATE TABLE `msc_archivos` (
  `id_arc` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_arc` varchar(200) DEFAULT NULL COMMENT 'Nombre',
  `descripcion_acr` text COMMENT 'Descripcion',
  `imagen_arc` varchar(255) DEFAULT NULL COMMENT 'Imagen',
  `rutacompleta_arc` varchar(255) DEFAULT NULL COMMENT 'Ruta Completa',
  `tipoarchivo_arc` varchar(150) DEFAULT NULL COMMENT 'Tipo de archivo',
  `esimagen_arc` varchar(255) DEFAULT NULL COMMENT 'Es Imagen',
  `ancho_arc` int(11) DEFAULT NULL COMMENT 'Ancho',
  `alto_arc` varchar(255) DEFAULT NULL COMMENT 'Alto',
  `peso_arc` decimal(10,2) DEFAULT NULL COMMENT 'Peso en KB',
  PRIMARY KEY (`id_arc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of msc_archivos
-- ----------------------------

-- ----------------------------
-- Table structure for seg_menu
-- ----------------------------
DROP TABLE IF EXISTS `seg_menu`;
CREATE TABLE `seg_menu` (
  `id_men` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_men` varchar(200) DEFAULT NULL COMMENT 'Nombre',
  `icono_men` bigint(20) DEFAULT NULL COMMENT 'Icono',
  `activo_men` smallint(1) DEFAULT NULL COMMENT 'Activo',
  PRIMARY KEY (`id_men`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_menu
-- ----------------------------
INSERT INTO `seg_menu` VALUES ('1', 'Incio', '1', '1');
INSERT INTO `seg_menu` VALUES ('2', 'Web', '2', '1');
INSERT INTO `seg_menu` VALUES ('3', 'Seguridad', '3', '1');

-- ----------------------------
-- Table structure for seg_opciones
-- ----------------------------
DROP TABLE IF EXISTS `seg_opciones`;
CREATE TABLE `seg_opciones` (
  `id_opc` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_opc` varchar(200) DEFAULT NULL COMMENT 'Nombre',
  `menu_opc` bigint(20) DEFAULT NULL COMMENT 'Menu',
  `seguridad_opc` varchar(200) DEFAULT NULL COMMENT 'Cadena de seguridad',
  `esadmin_opc` smallint(1) DEFAULT NULL COMMENT 'Es Admin Menu',
  `espagina_opc` smallint(1) DEFAULT NULL COMMENT 'Es Pagina',
  `activo_opc` smallint(1) DEFAULT NULL COMMENT 'Activo',
  `url_opc` varchar(200) DEFAULT NULL COMMENT 'URL',
  `icono_opc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_opc`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_opciones
-- ----------------------------
INSERT INTO `seg_opciones` VALUES ('1', 'Seguridad', '0', 'seguridad', '1', '0', '1', '#', 'icon-home');
INSERT INTO `seg_opciones` VALUES ('2', 'Usuarios', '1', 'usuarios', '1', '1', '1', '#', 'icon-home');
INSERT INTO `seg_opciones` VALUES ('3', 'Roles', '1', 'roles', '1', '1', '1', '#', 'icon-home');
INSERT INTO `seg_opciones` VALUES ('4', 'Permisos', '1', 'permisos', '1', '1', '1', '#', 'icon-home');
INSERT INTO `seg_opciones` VALUES ('5', 'Inicio', '0', 'inicio', '1', '1', '1', 'panel/inicio', null);

-- ----------------------------
-- Table structure for seg_permisos
-- ----------------------------
DROP TABLE IF EXISTS `seg_permisos`;
CREATE TABLE `seg_permisos` (
  `id_per` bigint(20) NOT NULL AUTO_INCREMENT,
  `rol_per` bigint(20) DEFAULT NULL COMMENT 'Rol',
  `opcion_per` bigint(20) DEFAULT NULL COMMENT 'Opcion',
  PRIMARY KEY (`id_per`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_permisos
-- ----------------------------
INSERT INTO `seg_permisos` VALUES ('1', '1', '1');
INSERT INTO `seg_permisos` VALUES ('2', '1', '2');
INSERT INTO `seg_permisos` VALUES ('3', '1', '3');
INSERT INTO `seg_permisos` VALUES ('4', '1', '4');
INSERT INTO `seg_permisos` VALUES ('5', '1', '5');

-- ----------------------------
-- Table structure for seg_roles
-- ----------------------------
DROP TABLE IF EXISTS `seg_roles`;
CREATE TABLE `seg_roles` (
  `id_rol` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_rol` varchar(150) DEFAULT NULL COMMENT 'Nombre',
  `activo_rol` smallint(1) DEFAULT NULL COMMENT 'Activo',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_roles
-- ----------------------------
INSERT INTO `seg_roles` VALUES ('1', 'Super Admin', '1');
INSERT INTO `seg_roles` VALUES ('2', 'Gerencia', '1');
INSERT INTO `seg_roles` VALUES ('3', 'Marketing', '1');

-- ----------------------------
-- Table structure for seg_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `seg_usuarios`;
CREATE TABLE `seg_usuarios` (
  `id_usr` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nombre_usr` varchar(150) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nombres',
  `apellidos_usr` varchar(150) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Apellidos',
  `usuario_usr` varchar(150) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Nombre de Usuario',
  `password_usr` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Contraseña',
  `activo_usr` smallint(1) DEFAULT '0' COMMENT 'Activo',
  `creadoen` datetime DEFAULT NULL,
  `actualizadoen` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usr`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_usuarios
-- ----------------------------
INSERT INTO `seg_usuarios` VALUES ('1', 'Windsor', 'Suarez', 'nacho6786', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', null, '2014-03-05 00:44:59');

-- ----------------------------
-- Table structure for seg_usuariosroles
-- ----------------------------
DROP TABLE IF EXISTS `seg_usuariosroles`;
CREATE TABLE `seg_usuariosroles` (
  `id_uro` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `rol_uro` bigint(20) DEFAULT NULL COMMENT 'Rol',
  `usuario_uro` bigint(20) DEFAULT NULL COMMENT 'Usuario',
  PRIMARY KEY (`id_uro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seg_usuariosroles
-- ----------------------------
INSERT INTO `seg_usuariosroles` VALUES ('1', '1', '1');
