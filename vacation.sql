-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 12 2019 г., 13:46
-- Версия сервера: 5.7.20
-- Версия PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vacation`
--
CREATE DATABASE IF NOT EXISTS `vacation` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `vacation`;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('boss', 1, 1548076115),
('employee', 2, 1548076115),
('employee', 3, 1548076115),
('employee', 4, 1548076115);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text NOT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('approvalVacation', 2, 'Разрешение на согласование отпуска.', 'approvalVacationRule', NULL, 1548076115, 1548076115),
('boss', 1, 'Начальник', NULL, NULL, 1548076115, 1548076115),
('employee', 1, 'Сотрудник', NULL, NULL, 1548076115, 1548076115),
('updateVacation', 2, 'Разрешение на редактирование отпуска.', 'updateVacationRule', NULL, 1548142689, 1548142689);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Содержит наследование role\\permission';

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('boss', 'approvalVacation'),
('boss', 'employee'),
('employee', 'updateVacation');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Содержит роли и разрешения';

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('approvalVacationRule', 'O:29:\"app\\rbac\\ApprovalVacationRule\":3:{s:4:\"name\";s:20:\"approvalVacationRule\";s:9:\"createdAt\";i:1548076115;s:9:\"updatedAt\";i:1548076115;}', 1548076115, 1548076115),
('updateVacationRule', 'O:27:\"app\\rbac\\UpdateVacationRule\":3:{s:4:\"name\";s:18:\"updateVacationRule\";s:9:\"createdAt\";i:1548142625;s:9:\"updatedAt\";i:1548142625;}', 1548142625, 1548142625);

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `clock_number` int(11) NOT NULL COMMENT 'табельный номер',
  `name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `boss_clock_number` int(11) NOT NULL COMMENT 'Табельный номер начальника',
  `password` varchar(255) NOT NULL COMMENT 'Пароль'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица сотрудников';

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`clock_number`, `name`, `second_name`, `middle_name`, `boss_clock_number`, `password`) VALUES
(1, 'Начальник', 'Начальник', 'Начальник', 1, '202cb962ac59075b964b07152d234b70'),
(2, 'Сотрудник1', 'Сотрудник1', 'Сотрудник1', 1, '202cb962ac59075b964b07152d234b70'),
(3, 'Имя', 'Фамилия', 'Отчество', 1, '202cb962ac59075b964b07152d234b70'),
(4, 'СОТРУДНИК 3', 'СОТРУДНИК 3', 'СОТРУДНИК 3', 3, '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Структура таблицы `vacations`
--

CREATE TABLE `vacations` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица отпусков';

--
-- Дамп данных таблицы `vacations`
--

INSERT INTO `vacations` (`id`, `employee_id`, `date_start`, `date_end`, `created_at`, `status`) VALUES
(1, 3, '2019-01-21', '2019-01-22', '2019-01-21 17:56:31', 2),
(2, 1, '2019-01-21', '2019-01-22', '2019-01-21 18:15:59', 2),
(3, 2, '2019-01-23', '2019-01-25', '2019-01-22 11:17:56', 1),
(4, 2, '2019-01-22', '2019-01-24', '2019-01-22 14:28:07', 2),
(5, 4, '2019-01-22', '2019-01-30', '2019-01-22 14:29:18', 1),
(6, 3, '2019-01-22', '2019-01-24', '2019-01-22 14:58:55', 2),
(7, 1, '2019-01-24', '2019-01-26', '2019-01-24 17:31:40', 1),
(8, 3, '2019-01-24', '2019-01-25', '2019-01-24 17:33:11', 1),
(9, 3, '2019-01-24', '2019-01-27', '2019-01-24 17:33:22', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `auth_item_child_ibfk_1` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`clock_number`),
  ADD KEY `boss_clock_number` (`boss_clock_number`);

--
-- Индексы таблицы `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `clock_number` int(11) NOT NULL AUTO_INCREMENT COMMENT 'табельный номер', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`clock_number`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`boss_clock_number`) REFERENCES `employees` (`clock_number`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `vacations`
--
ALTER TABLE `vacations`
  ADD CONSTRAINT `vacations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`clock_number`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
