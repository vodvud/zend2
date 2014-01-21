-- Adminer 3.7.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `email_notifications`;
CREATE TABLE `email_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `url` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `email_notifications` (`id`, `title`, `text`, `url`) VALUES
(1,	'Спасибо за регистрацию!',	'Вы были успешно зарегистрированы на нашем сайте.<br>Ваш логин: ##login##<br>Пароль: ##password##',	'registration'),
(2,	'Изменение личных данных.',	'Ваши личные данные были изменены.<br>Ваш логин: ##login##<br>Пароль: ##password##',	'change_data'),
(3,	'Добавление объявления.',	'Вы успешно добавили объявление ##title##.',	'add_advert'),
(4,	'Удаление объявления',	'Ваше объявление ##title## было удалено.',	'delete_advert'),
(5,	'Активация объявления.',	'<h2>5-zvezd.kz</h2><br>Ваше объявление ##title## ##message##.',	'activation_advert'),
(6,	'Срок продлен.',	'Срок действия объявления ##title## успешно продлен.',	'extend_time'),
(7,	'Истечение срока дейстия.',	'Действие объявления(й)<br>##title##<br>истечет через ##num## ##days_text##.',	'expiry_time'),
(8,	'Счет пополнен! ',	'Вы успешно пополнили свой счет на ##num## ##stars##.',	'refill'),
(9,	'Восстановление пароля',	'Ваш новый пароль: ##new_password##',	'forgot');

DROP TABLE IF EXISTS `helps`;
CREATE TABLE `helps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `url` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `helps` (`id`, `title`, `text`, `url`) VALUES
(3,	'Тип',	'Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;Дополнительная информация.&nbsp;',	'type'),
(5,	'Название',	'Дополнительная информация.',	'name'),
(6,	'Телефон',	'Дополнительная информация.',	'phone'),
(9,	'Местонахождение',	'Дополнительная информация.',	'location'),
(12,	'Цена',	'Дополнительная информация.',	'price'),
(17,	'Описание',	'Дополнительная информация.',	'description');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content1` text NOT NULL,
  `content2` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`, `title`, `content1`, `content2`) VALUES
(1,	'О Нас',	'Наша цель &ndash; лидирующие позиции на рынке услуг такси по высочайшим стандартам качества, с максимально выгодными, комфортными и удобными условиями для всех наших клиентов.',	''),
(2,	'Контакты',	'Мы находимся по адрессу ...',	'');

DROP TABLE IF EXISTS `phone_mask`;
CREATE TABLE `phone_mask` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mask` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `phone_mask` (`id`, `mask`) VALUES
(1,	'd (ddd) ddd-dd-dd'),
(2,	'd (dddd) dd-dd-dd'),
(3,	'd (ddddd) d-dd-dd');

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `is_verified` enum('y','n') NOT NULL DEFAULT 'n',
  `timestamp` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(100) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(10) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user',
  `name` char(100) NOT NULL DEFAULT '',
  `star` int(10) unsigned NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`username`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `level`, `name`, `star`, `timestamp`) VALUES
(1,	'admin',	'd77688a8658ed92bbf9b3270f18587f8',	'sdw3wr',	'admin',	'',	0,	'2013-09-02 19:42:24');

DROP TABLE IF EXISTS `user_phone`;
CREATE TABLE `user_phone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `phone` char(50) NOT NULL,
  `mask` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mask` (`mask`),
  CONSTRAINT `user_phone_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_phone_ibfk_2` FOREIGN KEY (`mask`) REFERENCES `phone_mask` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `_sql_updates`;
CREATE TABLE `_sql_updates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2013-12-04 21:11:05
