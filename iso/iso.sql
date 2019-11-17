-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Ноя 17 2019 г., 18:05
-- Версия сервера: 5.7.24-0ubuntu0.18.04.1
-- Версия PHP: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pole`
--

-- --------------------------------------------------------

--
-- Структура таблицы `iso`
--

CREATE TABLE `iso` (
  `id` int(11) NOT NULL,
  `iso` varchar(6) NOT NULL,
  `region_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `iso`
--

INSERT INTO `iso` (`id`, `iso`, `region_name`) VALUES
(1, 'RU-AD', 'Республика Адыгея'),
(2, 'RU-BA', 'Республика Башкортостан'),
(3, 'RU-BU', 'Республика Бурятия'),
(4, 'RU-AL', 'Республика Алтай'),
(5, 'RU-DA', 'Республика Дагестан'),
(6, 'RU-IN', 'Республика Ингушетия'),
(7, 'RU-KB', 'Кабардино-Балкарская республика'),
(8, 'RU-KL', 'Республика Калмыкия'),
(9, 'RU-KC', 'Карачаево-Черкесская республика'),
(10, 'RU-KR', 'Республика Карелия'),
(11, 'RU-KO', 'Республика Коми'),
(12, 'RU-ME', 'Республика Марий Эл'),
(13, 'RU-MO', 'Республика Мордовия'),
(14, 'RU-SA', 'Республика Саха (Якутия)'),
(15, 'RU-SE', 'Республика Северная Осетия - Алания'),
(16, 'RU-TA', 'Республика Татарстан'),
(17, 'RU-TY', 'Республика Тыва'),
(18, 'RU-UD', 'Удмуртская республика'),
(19, 'RU-KK', 'Республика Хакасия'),
(21, 'RU-CU', 'Чувашская республика'),
(22, 'RU-ALT', 'Алтайский край'),
(23, 'RU-KDA', 'Краснодарский край'),
(24, 'RU-KYA', 'Красноярский край'),
(25, 'RU-PRI', 'Приморский край'),
(26, 'RU-STA', 'Ставропольский край'),
(27, 'RU-KHA', 'Хабаровский край'),
(28, 'RU-AMU', 'Амурская область'),
(29, 'RU-ARK', 'Архангельская область'),
(30, 'RU-AST', 'Астраханская область'),
(31, 'RU-BEL', 'Белгородская область'),
(32, 'RU-BRY', 'Брянская область'),
(33, 'RU-VLA', 'Владимирская область'),
(34, 'RU-VGG', 'Волгоградская область'),
(35, 'RU-VLG', 'Вологодская область'),
(36, 'RU-VOR', 'Воронежская область'),
(37, 'RU-IVA', 'Ивановская область'),
(38, 'RU-IRK', 'Иркутская область'),
(39, 'RU-KGD', 'Калининградская область'),
(40, 'RU-KLU', 'Калужская область'),
(41, 'RU-KAM', 'Камчатский край'),
(42, 'RU-KEM', 'Кемеровская область'),
(43, 'RU-KIR', 'Кировская область'),
(44, 'RU-KOS', 'Костромская область'),
(45, 'RU-KGN', 'Курганская область'),
(46, 'RU-KRS', 'Курская область'),
(47, 'RU-LEN', 'Ленинградская область'),
(48, 'RU-LIP', 'Липецкая область'),
(49, 'RU-MAG', 'Магаданская область'),
(50, 'RU-MOS', 'Московская область'),
(51, 'RU-MUR', 'Мурманская область'),
(52, 'RU-NIZ', 'Нижегородская область'),
(53, 'RU-NGR', 'Новгородская область'),
(54, 'RU-NVS', 'Новосибирская область'),
(55, 'RU-OMS', 'Омская область'),
(56, 'RU-ORE', 'Оренбургская область'),
(57, 'RU-ORL', 'Орловская область'),
(58, 'RU-PNZ', 'Пензенская область'),
(59, 'RU-PER', 'Пермский край'),
(60, 'RU-PSK', 'Псковская область'),
(61, 'RU-ROS', 'Ростовская область'),
(62, 'RU-RYA', 'Рязанская область'),
(63, 'RU-SAM', 'Самарская область'),
(64, 'RU-SAR', 'Саратовская область'),
(65, 'RU-SAK', 'Сахалинская область'),
(66, 'RU-SVE', 'Свердловская область'),
(67, 'RU-SMO', 'Смоленская область'),
(68, 'RU-TAM', 'Тамбовская область'),
(69, 'RU-TVE', 'Тверская область'),
(70, 'RU-TOM', 'Томская область'),
(71, 'RU-TUL', 'Тульская область'),
(72, 'RU-TYU', 'Тюменская область'),
(73, 'RU-ULY', 'Ульяновская область'),
(74, 'RU-CHE', 'Челябинская область'),
(75, 'RU-ZAB', 'Забайкальский край'),
(76, 'RU-YAR', 'Ярославская область'),
(77, 'RU-MOW', 'Москва'),
(78, 'RU-SPE', 'Санкт-Петербург'),
(79, 'RU-YEV', 'Еврейская автономная область'),
(82, 'RU-CR', 'Республика Крым'),
(83, 'RU-NEN', 'Ненецкий автономный округ'),
(86, 'RU-KHM', 'Ханты-Мансийский автономный округ - Югра'),
(87, 'RU-CHU', 'Чукотский автономный округ'),
(89, 'RU-YAN', 'Ямало-Ненецкий автономный округ'),
(92, 'RU-SEV', 'Севастополь'),
(95, 'RU-CE', 'Чеченская республика');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `iso`
--
ALTER TABLE `iso`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `iso` ADD FULLTEXT KEY `region_name` (`region_name`);
ALTER TABLE `iso` ADD FULLTEXT KEY `region` (`region_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `iso`
--
ALTER TABLE `iso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;