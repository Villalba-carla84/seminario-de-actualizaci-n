-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP PROCEDURE IF EXISTS `add_User_ToGroup`;;
CREATE PROCEDURE `add_User_ToGroup`(IN `idUser` int(11), IN `idGroup` int(11))
INSERT INTO `control-access-component`.group_user_members(id_user,id_group)
VALUES (idUser,idGroup);;

DROP PROCEDURE IF EXISTS `auth_user`;;
CREATE PROCEDURE `auth_user`(IN `username` varchar(45), IN `password` varchar(45))
SELECT id FROM `user`
WHERE user.name= username AND user.password=password;;

DROP PROCEDURE IF EXISTS `create_group`;;
CREATE PROCEDURE `create_group`(IN `nam` varchar(45), IN `descrip` varchar(45))
INSERT INTO `group` (name, descripcion) VALUES (nam,descrip);;

DROP PROCEDURE IF EXISTS `create_user`;;
CREATE PROCEDURE `create_user`(IN `nam` varchar(45), IN `passw` varchar(45))
INSERT INTO `user` (name,password)
VALUES(nam,passw);;

DROP PROCEDURE IF EXISTS `create_userSession`;;
CREATE PROCEDURE `create_userSession`(IN `id_user` varchar(45), IN `token` varchar(256))
INSERT INTO  `user_session`(token,created,expires,id_user)
VALUES (token,NOW(),DATE_ADD( NOW(), INTERVAL 10 DAY), id_user);;

DROP PROCEDURE IF EXISTS `delete_group`;;
CREATE PROCEDURE `delete_group`(IN `id` int(11))
DELETE FROM `group` WHERE id = id;;

DROP PROCEDURE IF EXISTS `delete_user`;;
CREATE PROCEDURE `delete_user`(IN `id` int(11))
DELETE FROM user WHERE id=id;;

DROP PROCEDURE IF EXISTS `edit_group`;;
CREATE PROCEDURE `edit_group`(IN `id` int(11), IN `nam` varchar(45), IN `descrip` varchar(45))
UPDATE `group` SET name = nam, descripcion = descrip WHERE id = id;;

DROP PROCEDURE IF EXISTS `edit_user`;;
CREATE PROCEDURE `edit_user`(IN `id` int(11), IN `nam` varchar(45), IN `passw` varchar(45))
UPDATE `user`
SET name=nam,password=passw WHERE id=id;;

DROP PROCEDURE IF EXISTS `get_group`;;
CREATE PROCEDURE `get_group`()
SELECT name, descripcion FROM `group`;;

DROP PROCEDURE IF EXISTS `get_membersFromGroup`;;
CREATE PROCEDURE `get_membersFromGroup`(IN `idGroup` int, IN `id` int)
SELECT name FROM `user` 
INNER JOIN `group_user_members` 
WHERE id_group = idGroup AND id_user =id;;

DROP PROCEDURE IF EXISTS `get_user`;;
CREATE PROCEDURE `get_user`()
BEGIN
   SELECT * FROM `control-access-component`.user;
END;;

DROP PROCEDURE IF EXISTS `remove_userFromGroup`;;
CREATE PROCEDURE `remove_userFromGroup`(IN `idUser` int(11), IN `idGroup` int(11))
DELETE FROM `group_user_members`
WHERE id_user = idUser AND id_group = idGroup;;

DELIMITER ;

DROP TABLE IF EXISTS `action`;
CREATE TABLE `action` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `group_permissions`;
CREATE TABLE `group_permissions` (
  `id_group` int unsigned NOT NULL,
  `id_action` int unsigned NOT NULL,
  KEY `id_group` (`id_group`),
  KEY `id_action` (`id_action`),
  CONSTRAINT `group_permissions_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`),
  CONSTRAINT `group_permissions_ibfk_2` FOREIGN KEY (`id_action`) REFERENCES `action` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `group_user_members`;
CREATE TABLE `group_user_members` (
  `id_user` int unsigned NOT NULL,
  `id_group` int unsigned NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `id_group` (`id_group`),
  CONSTRAINT `group_user_members_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_user_members_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `user_informacion`;
CREATE TABLE `user_informacion` (
  `user_id` int unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_informacion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `user_session`;
CREATE TABLE `user_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(256) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `expires` datetime NOT NULL,
  `id_user` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


-- 2022-11-15 13:06:03
