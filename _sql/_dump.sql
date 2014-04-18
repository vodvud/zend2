-- Adminer 4.0.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+03:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `adverts`;
CREATE TABLE `adverts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `location` int(10) unsigned NOT NULL DEFAULT '0',
  `name` char(150) NOT NULL,
  `description` text NOT NULL,
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `currency` int(10) unsigned NOT NULL DEFAULT '0',
  `status` enum('y','n') NOT NULL DEFAULT 'n',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `contact_name` char(100) NOT NULL DEFAULT '',
  `counter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `top` enum('y','n') NOT NULL DEFAULT 'n',
  `timestamp` decimal(20,4) unsigned NOT NULL DEFAULT '0.0000',
  `lifetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `top_lifetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mark_lifetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `timestamp` (`timestamp`),
  KEY `user_id` (`user_id`),
  KEY `category` (`category`),
  KEY `type` (`type`),
  KEY `location` (`location`),
  KEY `currency` (`currency`),
  CONSTRAINT `adverts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_ibfk_2` FOREIGN KEY (`category`) REFERENCES `adverts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_ibfk_3` FOREIGN KEY (`type`) REFERENCES `adverts_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_ibfk_4` FOREIGN KEY (`location`) REFERENCES `adverts_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_ibfk_5` FOREIGN KEY (`currency`) REFERENCES `adverts_currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts` (`id`, `category`, `type`, `location`, `name`, `description`, `price`, `currency`, `status`, `user_id`, `contact_name`, `counter`, `top`, `timestamp`, `lifetime`, `created`, `top_lifetime`, `mark_lifetime`) VALUES
(11,	2,	2,	5,	'sdfasdfasdfasdfsd',	'xcf asdf asdfasdf asdfasdf asdf asdf asdff asdf s',	20,	1,	'y',	1,	'',	2,	'n',	1390924467.4976,	'0000-00-00 00:00:00',	'2014-01-28 15:54:27',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(12,	6,	2,	5,	'sdfsdafasdfasdf',	'fasdfasd fasdf asdf asdf asdf asdf',	23423,	1,	'y',	1,	'',	40,	'n',	1390924483.6692,	'0000-00-00 00:00:00',	'2014-01-28 15:54:43',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `adverts_categories`;
CREATE TABLE `adverts_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` char(50) DEFAULT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `adverts_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `adverts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_categories` (`id`, `name`, `url`, `parent_id`) VALUES
(1,	NULL,	'all',	1),
(2,	'Деловые услуги',	'delovie-uslugi',	18),
(3,	'Доставка еды / воды',	'dostavka-edi-vodi',	18),
(4,	'Спорт',	'sport',	18),
(5,	'Красота и здоровье',	'krasota-i-zdorove',	18),
(6,	'Курсы и репетиторство',	'kursi-i-repetitorstvo',	18),
(7,	'Обслуживание автомобилей',	'obsluzhivanie-avtomobiley',	18),
(8,	'Обслуживание компьютеров / телефонов',	'obsluzhivanie-kompyuterov-telefonov',	18),
(9,	'Отдых и развлечения',	'otdih-i-razvlecheniya',	18),
(10,	'Прочие услуги',	'prochie-uslugi',	18),
(11,	'Ремонт и установка бытовой техники',	'remont-i-ustanovka-bitovoy-tehniki',	18),
(12,	'Свадьбы и праздники',	'svadbi-i-prazdniki',	18),
(13,	'Туризм / путешествия',	'turizm-puteshestviya',	18),
(14,	'Уборка и чистка',	'uborka-i-chistka',	18),
(15,	'Услуги домашнего мастера',	'uslugi-domashnego-mastera',	18),
(16,	'Заведения',	'zavedeniya',	4),
(17,	'Тренеры',	'treneri',	4),
(18,	'Услуги',	'uslugi',	1),
(27,	'Недвижемость',	'nedvizhemost',	1),
(28,	'Авто',	'avto',	1),
(29,	'test1',	'test1',	27),
(30,	'test auto',	'test-auto',	28);

DROP TABLE IF EXISTS `adverts_currency`;
CREATE TABLE `adverts_currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_currency` (`id`, `name`) VALUES
(1,	'тг');

DROP TABLE IF EXISTS `adverts_gallery`;
CREATE TABLE `adverts_gallery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `advert_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `advert_id` (`advert_id`),
  CONSTRAINT `adverts_gallery_ibfk_1` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `adverts_location`;
CREATE TABLE `adverts_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `region_id` (`region_id`),
  CONSTRAINT `adverts_location_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `adverts_location_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_location` (`id`, `name`, `region_id`) VALUES
(1,	'Караганда',	1),
(2,	'Темиртау',	1),
(3,	'Шахтинск',	1),
(4,	'Сарань',	1),
(5,	'Абай',	1),
(6,	'Топар',	1);

DROP TABLE IF EXISTS `adverts_location_regions`;
CREATE TABLE `adverts_location_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_location_regions` (`id`, `name`) VALUES
(1,	'Карагандинская');

DROP TABLE IF EXISTS `adverts_options`;
CREATE TABLE `adverts_options` (
  `advert_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `option_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  UNIQUE KEY `advert_id_option_id` (`advert_id`,`option_id`),
  KEY `advert_id` (`advert_id`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `adverts_options_ibfk_1` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_options_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `category_to_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_options` (`advert_id`, `option_id`, `value`) VALUES
(11,	1,	'5'),
(11,	3,	'sdfsdf');

DROP TABLE IF EXISTS `adverts_phone`;
CREATE TABLE `adverts_phone` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone` char(50) NOT NULL,
  `advert_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mask_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `advert_id` (`advert_id`),
  KEY `mask_id` (`mask_id`),
  CONSTRAINT `adverts_phone_ibfk_1` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `adverts_phone_ibfk_2` FOREIGN KEY (`mask_id`) REFERENCES `phone_mask` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `adverts_statistics`;
CREATE TABLE `adverts_statistics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `advert_id` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `action` enum('view','up','top','mark') NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `advert_id` (`advert_id`),
  CONSTRAINT `adverts_statistics_ibfk_2` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_statistics` (`id`, `advert_id`, `date`, `action`, `count`) VALUES
(1,	12,	'2014-04-09 14:46:56',	'view',	1),
(4,	12,	'2014-04-11 09:46:39',	'view',	6),
(5,	12,	'2014-04-11 12:11:17',	'view',	15),
(6,	12,	'2014-04-14 14:35:34',	'view',	3);

DROP TABLE IF EXISTS `adverts_type`;
CREATE TABLE `adverts_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `catalog` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `catalog` (`catalog`),
  CONSTRAINT `adverts_type_ibfk_1` FOREIGN KEY (`catalog`) REFERENCES `adverts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `adverts_type` (`id`, `name`, `catalog`) VALUES
(1,	'Услуги',	18),
(2,	'Заявки',	18);

DROP TABLE IF EXISTS `advert_to_message`;
CREATE TABLE `advert_to_message` (
  `advert_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  KEY `advert_id` (`advert_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `advert_to_message_ibfk_3` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `advert_to_message_ibfk_4` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `image` char(255) NOT NULL,
  `url` char(100) NOT NULL,
  `height` enum('240','400') NOT NULL DEFAULT '240',
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `category_to_option`;
CREATE TABLE `category_to_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_id_option_id` (`cat_id`,`option_id`),
  KEY `cat_id` (`cat_id`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `category_to_option_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `adverts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category_to_option_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category_to_option` (`id`, `cat_id`, `option_id`) VALUES
(1,	2,	1),
(3,	2,	3),
(22,	4,	6),
(17,	5,	2),
(21,	17,	7);

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE `contact_us` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `email` char(100) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
(1,	'Спасибо за регистрацию!',	'Здравствуйте ! <br>Поздравляем с регистрацией на портале<strong> Usluga.kz</strong><br><br>Имя пользователя:&nbsp; ##login##<br><br>Теперь вы можете воспользоваться всеми преимуществами и возможностями портала для управления своими объявлениями:<br>\r\n<ul style=\"list-style-type: circle;\">\r\n<li>Топ &ndash; объявление</li>\r\n<li>Выделить объявление</li>\r\n<li>Срочное объявление</li>\r\n<li>VIP комплект</li>\r\n</ul>\r\nКонтролируйте свой Бизнес!<br><br>Команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . . ',	'registration'),
(2,	'Изменение личных данных.',	'Поздравляем!<br><br>Ваши личные данные были успешно обновлёны на портале, просьба, не передавайте их третьим лицам!<br><br>Имя пользователя: ##login##<br>Пароль: ##password##<br><br>Чтобы перейти в личный кабинет нажмите на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##loginUrl##\"><span style=\"color: #000080;\"><strong>&laquo;Перейти в личный кабинет&raquo;</strong></span></a></div>\r\n<br><br>Всегда готовы помочь Вам <br>Команда портала Usluga.kz<br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .',	'change_data'),
(3,	'Добавление объявления.',	'Вы успешно добавили объявление ##title##.',	'add_advert'),
(4,	'Удаление объявления',	'Здравствуйте !<br><br><br>Ваше объявление \"##title## \" было полностью удалено с портала Usluga.kz<br><br><br>Администрация портала Usluga.kz дарит вам 1000 бонусных тенге на развитие вашего бизнеса!<br>Все бонусы доступны в Личном Кабинете пользователя!<br><br><br>С уважением команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . . ',	'delete_advert'),
(5,	'Активация объявления.',	'<h3><span style=\"font-size: 11px;\">. . . . . <strong>поздравляем!</strong></span></h3>\r\nВаше объявление <strong>\"&nbsp;##title## \"</strong>&nbsp;##message## модератором и успешно добавлено в рубрику . . .<br>\r\n<div style=\"text-align: center;\">&nbsp;<span style=\"color: #333399;\"><strong><br><a href=\"##advUrl##\" target=\"_blank\">&laquo;Посмотреть объявление&raquo;</a><br></strong></span></div>\r\n<br>Вы можете воспользоваться дополнительными услугами портала&nbsp;в любое время:<br>\r\n<ul style=\"list-style-type: circle;\">\r\n<li>Увеличить количество клиентов</li>\r\n<li>Топ объявление</li>\r\n<li>Выделить объявление</li>\r\n<li>Срочное объявление</li>\r\n<li>VIP комплект</li>\r\n</ul>\r\nОзнакомиться со всеми услугами портала вы можете нажав на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##uslugi##\"><span style=\"color: #333399;\"><strong>&laquo;Услуги портала&raquo;</strong></span></a></div>\r\n<br>С уважением команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .',	'activation_advert'),
(6,	'Объявление выделено.',	'Поздравляем !<br><br>Ваше объявление <strong>\"</strong> <strong>##title## \"</strong> успешно <strong>##type##</strong> на <strong>##days##</strong> ##days_text##<br><br>\r\n<div>Благодарим за то, что вы выбираете портал <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .</div> ',	'extend_time'),
(7,	'Истечение срока дейстия.',	'Здравствуйте . . . !<br><br>Срок действия вашего объявления \"##title## \"на сайте, истечёт через&nbsp;##num## ##days_text##.<br><br>Вы можете продлить срок размещения вашего объявления в личном кабинете, для того, чтобы перейти в личный кабинет нажмите на кнопку ниже:<br><br><strong>&laquo;Продлить срок действия&raquo;</strong> ',	'expiry_time'),
(8,	'Счет пополнен! ',	'Здравствуйте !<br><br>Вы успешно пополнили баланс Личного кабинета на ##num## тг.<br><br>Теперь Вы можете воспользоваться всеми сервисами портала <strong>Usluga.kz</strong><br>\r\n<ul style=\"list-style-type: circle;\">\r\n<li>Увеличить количество клиентов</li>\r\n<li>Топ объявление</li>\r\n<li>Выделить объявление</li>\r\n<li>Срочное объявление</li>\r\n<li>VIP комплект</li>\r\n</ul>\r\n<br>Вы можете, ознакомиться с подробным списком услуг нажав на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\">&laquo;Цены и условия&raquo;</div>\r\n<br>Контролируйте свой бизнес!<br>Команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . . ',	'refill'),
(9,	'Восстановление пароля',	'Здравствуйте !<br><br>Ваш новый пароль: ##new_password##<br><br>Всегда готовы помочь Вам команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .',	'forgot'),
(10,	'Активация аккаунта!',	'Здравствуйте!<br><br>Подтвердите, пожалуйста, свой e-mail, который Вы указали при регистрации на портале Usluga.kz После подтверждения Вы сможете пользоваться всеми услугами портала.<br><br>Чтобы подтвердить вашу почту и закончить процесс регистрации, нажмите на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##link##\"><strong><span style=\"color: #333399;\">&laquo;Подтвердить E-mail&raquo;</span></strong></a></div>\r\n<br>После подтверждения e-mail станут доступны такие функции:<br><br>\r\n<ul style=\"list-style-type: circle;\">\r\n<li>использовать имя пользователя и пароль для входа на сайт</li>\r\n<li>контролировать Свой бизнес в личном кабинете</li>\r\n<li>анализ количества просмотров при использовании сервисов портала</li>\r\n<li>добавление объявлений</li>\r\n<li>подписка на рассылку о свежих объявлениях</li>\r\n<li>исключение возможности мошенничества с использованием Вашей электронной почты</li>\r\n</ul>\r\n<br><br><br><strong>Usluga.kz</strong> &ndash; <strong>Решения</strong> на все случаи жизни!<br>Каждый день мы предлагаем что-то новое: рестораны, салоны красоты<br>прокат авто, аренда недвижимости. И все это только на <strong>Usluga.kz</strong>.',	'activation_user'),
(11,	'Изменение электронной почты.',	'Здравствуйте !<br><br>Мы отправили это письмо, потому что кто-то запросил изменение адреса электронной почты для Личного кабинета зарегистрированного на портале <strong>Usluga.kz</strong><br><br>Если вы не делали данный запрос, то просто проигнорируйте и удалите это письмо.<br><br>Если Вы действительно хотите изменить адрес электронной почты, нажмите на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##link##\"><span style=\"background-color: #ffffff; color: #000080;\"><strong>&laquo;Подтвердить изменение email&raquo;</strong></span></a></div>\r\n<br>Всегда готовы помочь Вам <br>Команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . ..<br><a href=\"##link##\"><br></a> ',	'change_email'),
(12,	'Успешное изменение электронной почты.',	'Смена электронной почты прошла успешно. <br><br>Ваш новый логин: ##login##<br><br>Спасибо за то, что вы с нами<br>Команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .',	'change_email_success'),
(13,	'Подтверждение аккаунта!',	'Здравствуйте!<br><br>Мы сгенерировали для вас пароль для быстрого входа на сайт, вы можете изменить ваш пароль в разделе \"Профиль\" личного кабинета.<br><br>Имя пользователя: ##login##<br>Пароль:&nbsp;##password##<br><br>Подтвердите, пожалуйста, свой e-mail, который Вы указали при регистрации на портале Usluga.kz После подтверждения Вы сможете пользоваться всеми услугами портала.<br><br>Чтобы подтвердить вашу почту и закончить процесс регистрации, нажмите на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##link##\"><strong>&laquo;Подтвердить E-mail&raquo;</strong></a></div>\r\n<div style=\"text-align: left;\">После подтверждения e-mail станут доступны такие функции:</div> \r\n<div style=\"text-align: left;\">\r\n<ul style=\"list-style-type: circle;\">\r\n<li><span style=\"color: #000080;\">Увеличить количество клиентов</span></li>\r\n<li><span style=\"color: #000080;\">Выделить объявление</span></li>\r\n<li><span style=\"color: #000080;\">Срочное объявление</span></li>\r\n<li><span style=\"color: #000080;\">VIP комплект</span></li>\r\n</ul>\r\n<span style=\"color: #000000;\">Контролируйте свой Бизнес!</span></div>\r\n<br><br>Команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .',	'email_for_guest'),
(14,	'Подтверждение восстановления пароля',	'Здравствуйте . . . !<br><br>Мы отправили это письмо, потому что кто-то запросил восстановление пароля для аккаунта, зарегистрированного по данному e-mail адресу<br><br>Если Вы не делали данный запрос по восстановлению пароля, то просто проигнорируйте и удалите это письмо.<br><br>Если Вам действительно требуется восстановление пароля, нажмите на кнопку ниже:<br><br>\r\n<div style=\"text-align: center;\"><a href=\"##recovery_url##\"><span style=\"color: #000080;\"><strong>&laquo;Восстановить пароль&raquo;</strong></span></a></div>\r\n<br><br>После того как Вы это сделаете, Ваш пароль будет обновлён и отправлен Вам обратным письмом на данный адрес email<br><br>Всегда готовы помочь Вам команда портала <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях : ',	'confirm_recovery'),
(15,	'Помещено в ТОП.',	'Поздравляем !<br><br>Ваше объявление <strong>\"</strong> <strong>##title## \"</strong> успешно <strong>##type##</strong> на <strong>##days##</strong> ##days_text##<br><br>\r\n<div>Благодарим за то, что вы выбираете портал <strong>Usluga.kz</strong><br>Телефон службы поддержки . . . <br>Почта . . .<br>Группы в соц. Сетях . . .</div> ',	'extend_time_top');

DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `faq` (`id`, `title`, `content`) VALUES
(1,	'Почему стоит разместить обьявление у нас?',	'<strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Usluga.kz<br><br></strong>Единый источник, объединяющий в себе все преимущества электронных и бумажных вариантов рекламы вашего бизнеса<br>Возможность дать точное и подробное описание своего бизнеса с цветными, полноценными фотографиями<br>Привлечь больше клиентов, чем ваши потенциальные конкуренты<br>Возможность контролировать свой бизнес и вести аналитикуИспользовать Возможности которых нет не в одном печатном издании: Объявления сохраняются на сайте на протяжении всего срока действия личного кабинета, поднятие объявление вверх списка, VIP комплекты и др.<br>Возможность дать несколько объявлений в различные категории при этом клиент будет получать полную информацию о вашем бизнесе путём автоматического перенаправления клиента на ваш личный кабинет<br>Стоимость месячного размещения на сайте сравнима со стоимостью подачи объявления в газету или журнал сроком 1 неделя.'),
(2,	'Как работает сервис?',	'В среде веб-дизайнеров используется как заполнитель для текста в целях имитации законченного вида. Смысловое содержание нагрузки не имеет — здесь важно именно оформление. Рыба используется, поскольку дизайнер не всегда может взять осмысленный текст (и часто это не нужно). Кроме этого, подобный текст используется для демонстрации шрифтов, для этого даже была изобретена фраза (Съешь ещё этих мягких французских булок, да выпей же чаю, англоязычный вариант The quick brown fox jumps over the lazy dog). Также используется для Фильтрация электронной почты. У студентов некоторых вузов рыбой называется курсовая или дипломная работа, расчетный проект и прочее, выполненные ранее другим студентом и которые можно использовать для выполнения своей работы - \"Я получил задание на курсовой проект. Нет ли у кого готовой рыбы?\".\r\nТекст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. '),
(3,	'Что такое ТОП объявления?',	'Текст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. В среде веб-дизайнеров …\r\nТекст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. В среде веб-дизайнеров'),
(4,	'Почему лучше размещать ТОП объявления?',	'В среде веб-дизайнеров используется как заполнитель для текста в целях имитации законченного вида. Смысловое содержание нагрузки не имеет — здесь важно именно оформление. Рыба используется, поскольку дизайнер не всегда может взять осмысленный текст (и часто это не нужно). Кроме этого, подобный текст используется для демонстрации шрифтов, для этого даже была изобретена фраза (Съешь ещё этих мягких французских булок, да выпей же чаю, англоязычный вариант The quick brown fox jumps over the lazy dog). Также используется для Фильтрация электронной почты. У студентов некоторых вузов рыбой называется курсовая или дипломная работа, расчетный проект и прочее, выполненные ранее другим студентом и которые можно использовать для выполнения своей работы - \"Я получил задание на курсовой проект. Нет ли у кого готовой рыбы?\".\r\nТекст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. В среде веб-дизайнеров'),
(5,	'Как разместить объявление в ТОП?',	'Текст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. В среде веб-дизайнеров …\r\nТекст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, , написанный Цицероном на латинском языке в 45 году до н. э. В среде веб-дизайнеров');

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `advert_id` bigint(20) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
(17,	'Описание',	'Дополнительная информация.',	'description'),
(18,	'Категория',	'Дополнительная информация.',	'category'),
(19,	'Контактное лицо',	'Дополнительная информация по контактному лицу.',	'contact_name'),
(20,	'E-mail',	'Дополнительная информация по электронной почте.',	'email');

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `text` text NOT NULL,
  `from_user_id` int(10) unsigned NOT NULL,
  `to_user_id` int(10) unsigned NOT NULL,
  `archive_from` enum('y','n') NOT NULL DEFAULT 'n',
  `archive_to` enum('y','n') NOT NULL DEFAULT 'n',
  `delete_from` enum('y','n') NOT NULL DEFAULT 'n',
  `delete_to` enum('y','n') NOT NULL DEFAULT 'n',
  `was_read` enum('y','n') NOT NULL DEFAULT 'n',
  `timestamp` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_ibfk_4` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('select','checkbox','text','radio','multi') NOT NULL DEFAULT 'text',
  `name` char(100) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `options` (`id`, `type`, `name`, `value`) VALUES
(1,	'select',	'select test1',	'[{\"name\":\"asdasdasd\",\"value\":\"4\",\"selected\":\"n\"},{\"name\":\"asdasdasd\",\"value\":\"5\",\"selected\":\"y\"},{\"name\":\"sdadasd\",\"value\":\"6\",\"selected\":\"n\"},{\"name\":\"asdasdsa\",\"value\":\"7\",\"selected\":\"n\"},{\"name\":\"asdasd\",\"value\":\"8\",\"selected\":\"n\"}]'),
(2,	'text',	'test text',	'test'),
(3,	'text',	'sfsdf',	'sdfsdf'),
(6,	'multi',	'Мультиселект',	'[{\"name\":\"test1\",\"selected\":\"n\",\"value\":\"test1\"},{\"name\":\"test2\",\"selected\":\"y\",\"value\":\"test2\"},{\"name\":\"test3\",\"selected\":\"y\",\"value\":\"test3\"},{\"name\":\"test4\",\"selected\":\"y\",\"value\":\"test4\"},{\"name\":\"test5\",\"selected\":\"n\",\"value\":\"test5\"}]'),
(7,	'select',	'select test2',	'[{\"name\":\"val1\",\"selected\":\"n\",\"value\":\"val1\"},{\"name\":\"val2\",\"selected\":\"n\",\"value\":\"val2\"},{\"name\":\"val3\",\"selected\":\"n\",\"value\":\"val3\"},{\"name\":\"val4\",\"selected\":\"n\",\"value\":\"val4\"},{\"name\":\"val5\",\"selected\":\"n\",\"value\":\"val5\"},{\"name\":\"val6\",\"selected\":\"n\",\"value\":\"val6\"},{\"name\":\"val7\",\"selected\":\"n\",\"value\":\"val7\"},{\"name\":\"val8\",\"selected\":\"n\",\"value\":\"val8\"},{\"name\":\"val9\",\"selected\":\"n\",\"value\":\"val9\"},{\"name\":\"val10\",\"selected\":\"y\",\"value\":\"val10\"},{\"name\":\"val11\",\"selected\":\"n\",\"value\":\"val11\"},{\"name\":\"val12\",\"selected\":\"n\",\"value\":\"val12\"},{\"name\":\"val13\",\"selected\":\"n\",\"value\":\"val13\"},{\"name\":\"val14\",\"selected\":\"n\",\"value\":\"val14\"},{\"name\":\"val15\",\"selected\":\"n\",\"value\":\"val15\"},{\"name\":\"val16\",\"selected\":\"n\",\"value\":\"val16\"},{\"name\":\"val17\",\"selected\":\"n\",\"value\":\"val17\"},{\"name\":\"val18\",\"selected\":\"n\",\"value\":\"val18\"},{\"name\":\"val19\",\"selected\":\"n\",\"value\":\"val19\"},{\"name\":\"val20\",\"selected\":\"n\",\"value\":\"val20\"},{\"name\":\"val21\",\"selected\":\"n\",\"value\":\"val21\"},{\"name\":\"val22\",\"selected\":\"n\",\"value\":\"val22\"},{\"name\":\"val23\",\"selected\":\"n\",\"value\":\"val23\"},{\"name\":\"val24\",\"selected\":\"n\",\"value\":\"val24\"},{\"name\":\"val25\",\"selected\":\"n\",\"value\":\"val25\"},{\"name\":\"val26\",\"selected\":\"n\",\"value\":\"val26\"},{\"name\":\"val27\",\"selected\":\"n\",\"value\":\"val27\"},{\"name\":\"val28\",\"selected\":\"n\",\"value\":\"val28\"},{\"name\":\"val29\",\"selected\":\"n\",\"value\":\"val29\"},{\"name\":\"val30\",\"selected\":\"n\",\"value\":\"val30\"},{\"name\":\"val31\",\"selected\":\"n\",\"value\":\"val31\"},{\"name\":\"val32\",\"selected\":\"n\",\"value\":\"val32\"},{\"name\":\"val33\",\"selected\":\"n\",\"value\":\"val33\"},{\"name\":\"val34\",\"selected\":\"n\",\"value\":\"val34\"},{\"name\":\"val35\",\"selected\":\"n\",\"value\":\"val35\"},{\"name\":\"val36\",\"selected\":\"n\",\"value\":\"val36\"}]');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `status` enum('y','n') NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`, `title`, `content`) VALUES
(1,	'O проекте',	'Текст-«рыба» (также текст-заполнитель или текст-манекен) — на жаргоне дизайнеров текст, вставляемый в макет и не несущий смысловой нагрузки. Обладает некоторыми свойствами осмысленного текста, но является случайно сгенерированным, либо взятым из открытых источников (не путать с плагиатом). Некоторые тексты вошли в историю, например, отрывок из текста Lorem ipsum, написанный Цицероном на латинском языке в 45 году до н. э.'),
(2,	'Обратная связь',	'Мы находимся по адрессу ...'),
(3,	'Пользовательское соглашение',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas dapibus eros mauris, non dictum elit vulputate eu. Etiam eget venenatis magna. Cras et leo non sapien lobortis semper. Curabitur semper, justo convallis eleifend eleifend, odio enim euismod lorem, id luctus erat tellus at nibh. Phasellus aliquam vel lorem in interdum. Curabitur laoreet ipsum a ipsum pretium eleifend. Donec tincidunt, orci in semper vulputate, sem orci malesuada orci, venenatis pretium velit tellus ac sem. Nulla sed velit posuere, laoreet magna a, vulputate leo. Etiam mattis, orci quis varius dignissim, mi metus vestibulum justo, in porttitor lorem erat at mi.\r\n\r\nMaecenas a tellus nisl. Duis dapibus nisl sit amet arcu pretium ornare. Phasellus in pellentesque libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam placerat sem in placerat pellentesque. Etiam quis erat suscipit, sodales velit quis, pulvinar nibh. Sed imperdiet ultricies vehicula. Fusce vel justo et nisl pellentesque ornare ultricies et diam. Donec ut cursus quam.\r\n\r\nSed et sodales sem, non luctus justo. Duis euismod, purus vitae egestas vestibulum, massa felis fermentum ante, ut fermentum turpis nisl vel mi. Ut tincidunt felis et arcu molestie, eget gravida odio iaculis. Quisque ut odio pellentesque, viverra ligula vitae, feugiat odio. Cras sit amet aliquet lacus. Duis sit amet congue nisi. Praesent condimentum mi eget laoreet volutpat. Nunc interdum dolor vel eleifend commodo. In hac habitasse platea dictumst. Etiam a magna a ante auctor mollis in non nisi. Proin semper euismod est et tincidunt.\r\n\r\nMaecenas mi nibh, varius nec ultrices venenatis, adipiscing in mauris. Sed augue eros, ullamcorper ut scelerisque non, dapibus pellentesque libero. Fusce quis vestibulum est. Nullam turpis sapien, euismod eu iaculis vel, iaculis quis lorem. Sed ut cursus leo. Donec blandit ante id turpis aliquam bibendum id nec ligula. Quisque convallis nulla vitae augue iaculis egestas. Nam dapibus aliquet convallis. Nulla facilisi.\r\n\r\nMaecenas convallis, sem at iaculis blandit, odio arcu semper felis, quis viverra tellus lectus ut dolor. Cras a libero ligula. Proin in ipsum vel ante placerat tristique. Aenean sit amet malesuada erat. Aliquam gravida luctus scelerisque. Cras vitae rhoncus enim. Fusce ut eleifend purus. Duis faucibus imperdiet nunc eget molestie. Donec pulvinar felis urna, ut sagittis lorem aliquet blandit. Mauris euismod, justo in pulvinar pretium, dolor nunc facilisis orci, in feugiat tortor enim eget nibh. Duis dapibus arcu mi, sed ultrices mi rhoncus ac. Cras tempus est id purus rutrum, quis molestie metus cursus. Aenean sem mauris, porta vitae felis sed, dapibus sollicitudin sem. Aenean tristique, tortor non dictum fringilla, sapien odio ultricies turpis, vitae aliquam diam mauris id sapien. Donec placerat accumsan lorem ac rutrum'),
(4,	'Договор об оплате',	'Тема: «Турбулентный глей в XXI веке»\r\n\r\nЛипкость гомогенно вызывает микроагрегат, что лишний раз подтверждает правоту Докучаева. Фраджипэн, как бы это ни казалось парадоксальным, ненаблюдаемо трансформирует глинистый водоупор даже в том случае, если непосредственное наблюдение этого явления затруднительно. В случае смены водного режима кротовина адсорбирует чернозём, что лишний раз подтверждает правоту Докучаева. Спектральная отражательная способность воспроизводима в лабораторных условиях. Однако, при увеличении выборки коллембола вымывает в легкосуглинистый гумус в полном соответствии с законом Дарси. Монолит, как того требуют законы термодинамики, вымывает в турбулентный режим, все дальнейшее далеко выходит за рамки текущего исследования и не будет здесь рассматриваться.\r\n\r\nОпределение восстанавливает чернозём, однозначно свидетельствуя о неустойчивости процесса в целом. Педон поглощает турбулентный горизонт, все дальнейшее далеко выходит за рамки текущего исследования и не будет здесь рассматриваться. Как мы уже знаем, тензиометр усиливает агробиогеоценоз, хотя этот факт нуждается в дальнейшей тщательной экспериментальной проверке. Очевидно, что воздухосодержание лабильно. Агрегат неустойчиво отражает коллоид, что лишний раз подтверждает правоту Докучаева.\r\n\r\nКак показывает практика режимных наблюдений в полевых условиях, гистерезис ОГХ снижает показатель адсорбируемости натрия одинаково по всем направлениям. Агробиогеоценоз, в сочетании с традиционными агротехническими приемами, нагревает песок, и этот процесс может повторяться многократно. Осушение периодически эволюционирует в турбулентный песок при любом их взаимном расположении. Солифлюкция, в сочетании с традиционными агротехническими приемами, принципиально неизмерима. Бурозём горизонтально вызывает турбулентный монолит в полном соответствии с законом Дарси. В ходе почвенно-мелиоративного исследования территории было установлено, что неорганическое соединение поглощает подпахотный шурф, и этот процесс может повторяться многократно. ');

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

DROP TABLE IF EXISTS `require_params`;
CREATE TABLE `require_params` (
  `category_id` int(10) unsigned NOT NULL,
  `fields` text NOT NULL,
  KEY `category_id` (`category_id`),
  CONSTRAINT `require_params_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `adverts_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `email` char(100) NOT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `type` enum('grate','advice','complaint') NOT NULL DEFAULT 'grate',
  `timestamp` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reviews` (`id`, `name`, `email`, `message`, `rating`, `type`, `timestamp`) VALUES
(2,	'sdfgdfsgdfsg',	'test@test.com',	'sdf gsdfgsdfg sdfg sdfg sdfds fdf asdf sd',	2,	'advice',	'2014-02-17 15:32:42');

DROP TABLE IF EXISTS `search_log`;
CREATE TABLE `search_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` char(100) NOT NULL,
  `count` bigint(20) unsigned NOT NULL DEFAULT '1',
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `text` (`text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `search_log` (`id`, `text`, `count`, `timestamp`) VALUES
(1,	'qwerty',	13,	'2014-02-13 15:15:53'),
(2,	'test',	2,	'2014-02-13 15:12:17'),
(3,	'ADDA',	1,	'2014-02-13 15:12:19');

DROP TABLE IF EXISTS `subscribe_emails`;
CREATE TABLE `subscribe_emails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` char(100) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `email` char(100) NOT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `type` enum('grate','advice','complaint','advert') NOT NULL DEFAULT 'grate',
  `active` enum('y','n') NOT NULL DEFAULT 'n',
  `timestamp` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `testimonials_to_advert`;
CREATE TABLE `testimonials_to_advert` (
  `advert_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `testimonial_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  KEY `advert_id` (`advert_id`),
  KEY `testimonial_id` (`testimonial_id`),
  CONSTRAINT `testimonials_to_advert_ibfk_1` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `testimonials_to_advert_ibfk_2` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(100) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(10) NOT NULL,
  `status` enum('y','n') NOT NULL DEFAULT 'n',
  `key` varchar(32) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user',
  `name` char(100) NOT NULL DEFAULT '',
  `balance` decimal(20,0) unsigned NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`username`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `status`, `key`, `level`, `name`, `balance`, `timestamp`) VALUES
(1,	'admin',	'd77688a8658ed92bbf9b3270f18587f8',	'sdw3wr',	'y',	'',	'admin',	'',	0,	'2013-09-02 19:42:24');

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


-- 2014-04-18 13:50:07
