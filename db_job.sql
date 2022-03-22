-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 21 2022 г., 18:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_job`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advertise`
--

CREATE TABLE IF NOT EXISTS `advertise` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Title` tinytext NOT NULL,
  `Content` text NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `advertise`
--

INSERT INTO `advertise` (`ID`, `UserID`, `Title`, `Content`, `DateTime`) VALUES
(1, 13, 'Продаётся корова с телёнком', 'Новая, брендовая...', '2018-06-11 11:36:58');

-- --------------------------------------------------------

--
-- Структура таблицы `advertisers`
--

CREATE TABLE IF NOT EXISTS `advertisers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Name` tinytext NOT NULL,
  `AdvertiserTypeID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`AdvertiserTypeID`),
  KEY `AdvertiserTypeID` (`AdvertiserTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `advertisers`
--

INSERT INTO `advertisers` (`ID`, `UserID`, `Name`, `AdvertiserTypeID`) VALUES
(1, 14, 'Громкое слово', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `advertisertypes`
--

CREATE TABLE IF NOT EXISTS `advertisertypes` (
  `ID` int(11) NOT NULL,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advertisertypes`
--

INSERT INTO `advertisertypes` (`ID`, `Name`) VALUES
(1, 'Рекламное агентство'),
(2, 'Фирма, рекламирующая собственный товар');

-- --------------------------------------------------------

--
-- Структура таблицы `aspirants`
--

CREATE TABLE IF NOT EXISTS `aspirants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Age` int(11) NOT NULL,
  `LimitsID` int(11) NOT NULL,
  `DriverStateID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`LimitsID`,`DriverStateID`),
  KEY `DriverStateID` (`DriverStateID`),
  KEY `LimitsID` (`LimitsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `aspirants`
--

INSERT INTO `aspirants` (`ID`, `UserID`, `Age`, `LimitsID`, `DriverStateID`) VALUES
(4, 12, 30, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cv`
--

CREATE TABLE IF NOT EXISTS `cv` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `Title` tinytext NOT NULL,
  `Content` text NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`SectionID`),
  KEY `UserID_2` (`UserID`),
  KEY `SectionID` (`SectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cv`
--

INSERT INTO `cv` (`ID`, `UserID`, `SectionID`, `Title`, `Content`, `DateTime`) VALUES
(2, 13, 2, 'Системный программист', 'Системное программирование и администрирование ', '2018-06-11 11:24:04');

-- --------------------------------------------------------

--
-- Структура таблицы `driverstates`
--

CREATE TABLE IF NOT EXISTS `driverstates` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `driverstates`
--

INSERT INTO `driverstates` (`ID`, `Name`) VALUES
(1, 'Есть'),
(2, 'Нет');

-- --------------------------------------------------------

--
-- Структура таблицы `educations`
--

CREATE TABLE IF NOT EXISTS `educations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `EducationTypeID` int(11) NOT NULL,
  `Name` tinytext NOT NULL,
  `Year` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `AspirantID` (`UserID`),
  KEY `EducationTypeID` (`EducationTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `educations`
--

INSERT INTO `educations` (`ID`, `UserID`, `EducationTypeID`, `Name`, `Year`) VALUES
(10, 12, 1, 'ЮУрГУ, Информационные технологии в экономике', 2014),
(11, 12, 2, 'ЧелГУ, Экономика', 2017);

-- --------------------------------------------------------

--
-- Структура таблицы `educationtypes`
--

CREATE TABLE IF NOT EXISTS `educationtypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `educationtypes`
--

INSERT INTO `educationtypes` (`ID`, `Name`) VALUES
(1, 'Высшее: бакалавриат'),
(2, 'Высшее: магистратура'),
(3, 'Высшее: специалитет'),
(4, 'Среднее профессиональное');

-- --------------------------------------------------------

--
-- Структура таблицы `employers`
--

CREATE TABLE IF NOT EXISTS `employers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Name` tinytext NOT NULL,
  `Tpi` varchar(15) NOT NULL,
  `OfID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`OfID`),
  KEY `OfID` (`OfID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `employers`
--

INSERT INTO `employers` (`ID`, `UserID`, `Name`, `Tpi`, `OfID`) VALUES
(1, 13, 'Промсвязь', '1234567890123', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `limits`
--

CREATE TABLE IF NOT EXISTS `limits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `limits`
--

INSERT INTO `limits` (`ID`, `Name`) VALUES
(1, 'Есть'),
(2, 'Нет');

-- --------------------------------------------------------

--
-- Структура таблицы `ofs`
--

CREATE TABLE IF NOT EXISTS `ofs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `ofs`
--

INSERT INTO `ofs` (`ID`, `Name`) VALUES
(1, 'ООО'),
(2, 'ОАО'),
(3, 'СРО'),
(4, 'ИП'),
(5, 'ЗАО');

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`ID`, `Name`) VALUES
(1, 'Ремонт электроники'),
(2, 'Программирование'),
(3, 'Финансовый анализ'),
(4, 'Бухучёт');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` tinytext NOT NULL,
  `Login` tinytext NOT NULL,
  `Password` tinytext NOT NULL,
  `RoleID` int(11) DEFAULT NULL,
  `State` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `RoleID` (`RoleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `UserName`, `Login`, `Password`, `RoleID`, `State`) VALUES
(12, 'Созыкин Иван Петрович', 'aspirant@mail.ru', '827ccb0eea8a706c4c34a16891f84e7b', 2, 0),
(13, 'Раскольников Игорь Васильевич', 'employe@mail.ru', '827ccb0eea8a706c4c34a16891f84e7b', 3, 0),
(14, 'Речкалов Сергей Сергеевич', 'advertiser@mail.ru', '827ccb0eea8a706c4c34a16891f84e7b', 4, 0),
(15, 'Админов Иван Николаевич', 'admin@mail.ru', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `ID` int(11) NOT NULL,
  `Name` tinytext NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`ID`, `Name`) VALUES
(1, 'Админ'),
(2, 'Соискатель'),
(3, 'Работодатель'),
(4, 'Рекламодатель');

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy`
--

CREATE TABLE IF NOT EXISTS `vacancy` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `Title` tinytext NOT NULL,
  `Content` text NOT NULL,
  `Salary` int(11) NOT NULL,
  `Experience` int(11) NOT NULL,
  `IsMain` int(11) NOT NULL DEFAULT '0',
  `IsPartnership` int(11) NOT NULL DEFAULT '0',
  `IsRemote` int(11) NOT NULL DEFAULT '0',
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`,`SectionID`),
  KEY `SectionID` (`SectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`ID`, `UserID`, `SectionID`, `Title`, `Content`, `Salary`, `Experience`, `IsMain`, `IsPartnership`, `IsRemote`, `DateTime`) VALUES
(6, 13, 2, 'Web-программист', 'Дизайн, вёрстка, программирование', 20000, 2, 1, 0, 0, '2018-06-11 11:03:35'),
(7, 13, 1, 'Наладчик железа', 'Паять и лудить', 10000, 3, 1, 1, 0, '2018-06-11 11:05:38'),
(8, 13, 2, 'C++ программист', 'Разработка ПО для Embeded систем', 20000, 2, 1, 1, 0, '2018-06-12 16:34:52'),
(9, 13, 3, 'Финансовый аналитик', 'Анализировать всё', 20000, 10, 1, 1, 1, '2018-06-12 16:35:26'),
(10, 13, 2, 'C# программист', 'Разработчик ПО на самой модной платформе', 27000, 2, 1, 0, 0, '2018-06-12 16:36:33'),
(11, 13, 4, 'Бухгалтер', 'Бухгалтерия в сельской фирме', 10000, 1, 1, 0, 0, '2018-06-12 16:37:10');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `advertise`
--
ALTER TABLE `advertise`
  ADD CONSTRAINT `advertise_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `advertisers`
--
ALTER TABLE `advertisers`
  ADD CONSTRAINT `advertisers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `advertisers_ibfk_2` FOREIGN KEY (`AdvertiserTypeID`) REFERENCES `advertisertypes` (`ID`);

--
-- Ограничения внешнего ключа таблицы `aspirants`
--
ALTER TABLE `aspirants`
  ADD CONSTRAINT `aspirants_ibfk_1` FOREIGN KEY (`DriverStateID`) REFERENCES `driverstates` (`ID`),
  ADD CONSTRAINT `aspirants_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirants_ibfk_3` FOREIGN KEY (`LimitsID`) REFERENCES `limits` (`ID`);

--
-- Ограничения внешнего ключа таблицы `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `cv_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `cv_ibfk_2` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`ID`);

--
-- Ограничения внешнего ключа таблицы `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_ibfk_2` FOREIGN KEY (`EducationTypeID`) REFERENCES `educationtypes` (`ID`),
  ADD CONSTRAINT `educations_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `employers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `employers_ibfk_2` FOREIGN KEY (`OfID`) REFERENCES `ofs` (`ID`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `user_roles` (`ID`);

--
-- Ограничения внешнего ключа таблицы `vacancy`
--
ALTER TABLE `vacancy`
  ADD CONSTRAINT `vacancy_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `vacancy_ibfk_2` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
