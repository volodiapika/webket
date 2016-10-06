-- phpMyAdmin SQL Dump
-- version 4.2.9.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 02 2016 г., 02:00
-- Версия сервера: 5.6.30-0ubuntu0.15.10.1
-- Версия PHP: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `webket`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(11) NOT NULL,
  `idfrom` int(11) NOT NULL,
  `idto` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `idfrom`, `idto`, `title`, `message`) VALUES
(10, 99, 99, 'dfgsdfg', 'sdfgfgs'),
(11, 99, 98, 'dfgsdfg', 'sdfgfgs'),
(12, 99, 98, 'dfgsdfg', 'sdfgfgs'),
(13, 99, 100, 'fghdfgh', 'fghdfg'),
(14, 98, 100, 'ghfg', 'fdgh');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `firstname` varchar(500) NOT NULL,
  `lastname` varchar(500) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `firstname`, `lastname`, `password`, `role`) VALUES
(98, 'member', 'member', 'member', 'aa08769cdcb26674c6706093503ff0a3', 1),
(99, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`), ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
