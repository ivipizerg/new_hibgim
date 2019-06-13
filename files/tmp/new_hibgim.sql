-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 10 2019 г., 12:14
-- Версия сервера: 5.7.26-0ubuntu0.18.04.1
-- Версия PHP: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `new_hibgim`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_blocks`
--

CREATE TABLE `oxs_blocks` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `system_name` text CHARACTER SET utf8 NOT NULL,
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `left_key` int(11) NOT NULL,
  `right_key` int(11) NOT NULL,
  `section` tinyint(1) NOT NULL,
  `defaultAction` tinytext CHARACTER SET utf8 NOT NULL,
  `type` tinytext CHARACTER SET utf8 NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `oxs_blocks`
--

INSERT INTO `oxs_blocks` (`id`, `create_data`, `update_data`, `status`, `name`, `description`, `system_name`, `pid`, `level`, `left_key`, `right_key`, `section`, `defaultAction`, `type`, `access`) VALUES
(1, 1527608228, 1527608228, 1, 'Корень', 'ROOT', 'ROOT', 0, 1, 1, 28, 1, 'ROOT', '', 0),
(2, 1527608228, 1527608228, 1, 'Блоки', 'Блок управления блоками данных', 'blocks', 5, 3, 3, 4, 0, 'display', 'tree', 1000),
(3, 1527608228, 1527608228, 1, 'Кнопки', 'Блок данных для управления кнопками для блоков данных', 'buttons', 5, 3, 5, 6, 0, 'display', 'tree', 1000),
(5, 0, 0, 1, 'Конструктор', 'Секция основного конструктора', 'constructor', 1, 2, 2, 13, 1, 'display', 'default', 1000),
(6, 1530531387, 1530531387, 1, 'Поля', 'Блок данных для управления полями', 'fields', 5, 3, 7, 8, 0, 'display', 'default', 1000),
(8, 1530635611, 1530635611, 1, 'Пользователи', 'Блок управления пользователями', 'users', 5, 3, 9, 10, 0, 'display', 'default', 1000),
(26, 1530874374, 1530874374, 1, 'Настройки', 'Настройки сайта', 'settings', 5, 3, 11, 12, 0, 'display', 'default', 1000),
(46, 1547472398, 0, 1, 'test', 'test', 'test', 1, 2, 26, 27, 0, 'display', 'default', 500),
(47, 1550756789, 0, 1, 'Документы', 'Корневой блок данных для документов', 'empty_docs', 1, 2, 14, 25, 1, 'display', 'default', 800),
(48, 1550756844, 1550842270, 1, 'Архив', 'Креновой блок данных для архива документов', 'empty_arch_doc', 47, 3, 21, 22, 0, 'display', 'default', 800),
(50, 1550842661, 0, 1, 'Категории', 'Категории документов', 'doc_cat', 47, 3, 19, 20, 0, 'display', 'tree', 800),
(51, 1550842883, 0, 1, 'Документы', 'Блок документов', 'docs', 47, 3, 15, 16, 0, 'display', 'default', 800),
(52, 1550842952, 0, 1, 'Теги', 'Блок тегов для документов', 'doc_tags', 47, 3, 17, 18, 0, 'display', 'tree', 800),
(53, 1550843015, 0, 1, 'Настройки', 'Блок настроек для загрузки документов', 'doc_settings', 47, 3, 23, 24, 0, 'display', 'default', 800);

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_buttons`
--

CREATE TABLE `oxs_buttons` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `left_key` int(11) NOT NULL,
  `right_key` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `bid` int(11) NOT NULL,
  `displayin` tinytext NOT NULL,
  `action` tinytext NOT NULL,
  `access` int(11) NOT NULL,
  `ui_class` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_buttons`
--

INSERT INTO `oxs_buttons` (`id`, `create_data`, `update_data`, `status`, `position`, `level`, `left_key`, `right_key`, `pid`, `name`, `bid`, `displayin`, `action`, `access`, `ui_class`) VALUES
(1, 1529253041, 1529253041, 1, 0, 1, 1, 274, 0, 'ROOT', 0, '', '', 1000, ''),
(4, 1529253041, 1529253041, 1, 0, 2, 2, 3, 1, 'Добавить', 2, 'blocks:display', 'blocks:add', 1000, ''),
(5, 1529253041, 1529253041, 1, 0, 2, 4, 5, 1, 'Удалить', 2, 'blocks:display', 'blocks:remove', 1000, ''),
(6, 1529253041, 1529253041, 1, 0, 2, 8, 9, 1, 'Создать', 2, 'blocks:add', 'blocks:add_end', 1000, ''),
(7, 1529253041, 1529253041, 1, 0, 2, 6, 7, 1, 'Добавить', 3, 'buttons:display', 'buttons:add', 1000, ''),
(15, 1529253041, 1529253041, 1, 0, 2, 10, 11, 1, 'Ок', 3, 'buttons:add', 'buttons:add_end', 1000, ''),
(17, 1529253041, 1529253041, 1, 0, 2, 12, 13, 1, 'Удалить', 3, 'buttons:display', 'buttons:remove', 1000, ''),
(18, 1529253075, 1529253075, 1, 0, 2, 14, 15, 1, 'Вкл/Выкл', 3, 'buttons:display', 'buttons:status', 1000, ''),
(35, 1529413485, 1529413485, 1, 0, 2, 16, 17, 1, 'Сохранить', 2, 'blocks:fix', 'blocks:fix_end', 1000, ''),
(36, 1529424996, 1529424996, 1, 0, 2, 18, 19, 1, 'Сохранить', 3, 'buttons:fix', 'buttons:fix_end', 1000, ''),
(37, 1529818047, 1529818047, 1, 0, 2, 20, 21, 1, 'Вкл/Выкл', 2, 'blocks:display', 'blocks:status', 1000, ''),
(38, 1530531387, 1530531387, 1, 0, 2, 22, 23, 1, 'Добавить', 6, 'fields:display', 'fields:add', 1000, ''),
(39, 1530531387, 1530531387, 1, 0, 2, 24, 25, 1, 'Удалить', 6, 'fields:display', 'fields:remove', 1000, ''),
(40, 1530531387, 1530531387, 1, 0, 2, 26, 27, 1, 'Вкл/Выкл', 6, 'fields:display', 'fields:status', 1000, ''),
(41, 1530531387, 1530531387, 1, 0, 2, 28, 29, 1, 'Ок', 6, 'fields:add', 'fields:add_end', 1000, ''),
(42, 1530531387, 1530531387, 1, 0, 2, 30, 31, 1, 'Отмена', 6, 'fields:add', 'fields:cancel', 1000, ''),
(43, 1530531387, 1530531387, 1, 0, 2, 32, 33, 1, 'Ок', 6, 'fields:fix', 'fields:fix_end', 1000, ''),
(44, 1530531387, 1530531387, 1, 0, 2, 34, 35, 1, 'Отмена', 6, 'fields:fix', 'fields:cancel', 1000, ''),
(52, 1530635611, 1530635611, 1, 0, 2, 36, 37, 1, 'Добавить', 8, 'users:display', 'users:add', 1000, ''),
(53, 1530635611, 1530635611, 1, 0, 2, 38, 39, 1, 'Удалить', 8, 'users:display', 'users:remove', 1000, ''),
(54, 1530635611, 1530635611, 1, 0, 2, 40, 41, 1, 'Вкл/Выкл', 8, 'users:display', 'users:status', 1000, ''),
(55, 1530635611, 1530635611, 1, 0, 2, 42, 43, 1, 'Ок', 8, 'users:add', 'users:add_end', 1000, ''),
(56, 1530635611, 1530635611, 1, 0, 2, 44, 45, 1, 'Отмена', 8, 'users:add', 'users:cancel', 1000, ''),
(57, 1530635611, 1530635611, 1, 0, 2, 46, 47, 1, 'Ок', 8, 'users:fix', 'users:fix_end', 1000, ''),
(58, 1530635611, 1530635611, 1, 0, 2, 48, 49, 1, 'Отмена', 8, 'users:fix', 'users:cancel', 1000, ''),
(171, 1530874374, 0, 1, 0, 2, 50, 51, 1, 'Добавить', 26, 'settings:display', 'settings:add', 1000, ''),
(172, 1530874374, 0, 1, 0, 2, 52, 53, 1, 'Удалить', 26, 'settings:display', 'settings:remove', 1000, ''),
(173, 1530874374, 0, 1, 0, 2, 54, 55, 1, 'Вкл/Выкл', 26, 'settings:display', 'settings:status', 1000, ''),
(174, 1530874374, 0, 1, 0, 2, 56, 57, 1, 'Ок', 26, 'settings:add', 'settings:add_end', 1000, ''),
(175, 1530874374, 0, 1, 0, 2, 58, 59, 1, 'Отмена', 26, 'settings:add', 'settings:cancel', 1000, ''),
(176, 1530874374, 0, 1, 0, 2, 60, 61, 1, 'Ок', 26, 'settings:fix', 'settings:fix_end', 1000, ''),
(177, 1530874374, 1531040086, 1, 0, 2, 62, 63, 1, 'Отмена', 26, 'settings:fix', 'settings:cancel', 1000, ''),
(220, 1534783306, 1534853683, 1, 0, 2, 64, 65, 1, 'Проверка', 3, 'buttons:display', 'buttons:check_base', 1000, ''),
(221, 1534853735, 0, 1, 0, 2, 66, 67, 1, 'Проверка', 2, 'blocks:display', 'blocks:check_base', 1000, ''),
(223, 1534861945, 0, 1, 0, 2, 68, 69, 1, 'cfg.php', 26, 'settings:display', 'settings:cfg', 1000, ''),
(224, 1534863219, 0, 1, 0, 2, 70, 71, 1, 'Сохранить', 26, 'settings:cfg', 'settings:cfg_end', 1000, ''),
(226, 1536164928, 0, 1, 0, 2, 72, 73, 1, 'Закрыть', 26, 'settings:cfg', 'settings:display', 1000, ''),
(413, 1547472398, 0, 1, 0, 2, 74, 75, 1, 'Добавить', 46, 'test:display', 'test:add', 1000, ''),
(414, 1547472398, 0, 1, 0, 2, 76, 77, 1, 'Удалить', 46, 'test:display', 'test:remove', 1000, ''),
(415, 1547472398, 0, 1, 0, 2, 78, 79, 1, 'Вкл/Выкл', 46, 'test:display', 'test:status', 1000, ''),
(416, 1547472398, 0, 1, 0, 2, 80, 87, 1, 'Правка', 46, 'test:display', '', 1000, 'oxs_buttons_fixing'),
(417, 1547472398, 0, 1, 0, 3, 81, 82, 416, 'Вырезать', 46, 'test:display', 'test:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(418, 1547472398, 0, 1, 0, 3, 83, 84, 416, 'Копировать', 46, 'test:display', 'test:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(419, 1547472398, 0, 1, 0, 3, 85, 86, 416, 'Вставить', 46, 'test:display', 'test:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(420, 1547472398, 0, 1, 0, 2, 88, 93, 1, 'Добавить', 46, 'test:add', 'test:add_end', 1000, ''),
(421, 1547472398, 0, 1, 0, 3, 89, 90, 420, '... и включить', 46, 'test:add', 'test:add_end?mode=1', 1000, ''),
(422, 1547472398, 0, 1, 0, 3, 91, 92, 420, '... и создать новый', 46, 'test:add', 'test:add_end?mode=2', 1000, ''),
(423, 1547472398, 0, 1, 0, 2, 94, 95, 1, 'Отмена', 46, 'test:add', 'test:cancel', 1000, ''),
(424, 1547472398, 0, 1, 0, 2, 96, 99, 1, 'Сохранить', 46, 'test:fix', 'test:fix_end', 1000, ''),
(425, 1547472398, 0, 1, 0, 3, 97, 98, 424, '... и не закрывать', 46, 'test:fix', 'test:fix_end?mode=1', 1000, ''),
(426, 1547472398, 0, 1, 0, 2, 100, 101, 1, 'Отмена', 46, 'test:fix', 'test:cancel', 1000, ''),
(427, 1550756789, 0, 1, 0, 2, 102, 103, 1, 'Добавить', 47, 'empty_docs:display', 'empty_docs:add', 1000, ''),
(428, 1550756789, 0, 1, 0, 2, 104, 105, 1, 'Удалить', 47, 'empty_docs:display', 'empty_docs:remove', 1000, ''),
(429, 1550756789, 0, 1, 0, 2, 106, 107, 1, 'Вкл/Выкл', 47, 'empty_docs:display', 'empty_docs:status', 1000, ''),
(430, 1550756789, 0, 1, 0, 2, 108, 115, 1, 'Правка', 47, 'empty_docs:display', '', 1000, 'oxs_buttons_fixing'),
(431, 1550756789, 0, 1, 0, 3, 109, 110, 430, 'Вырезать', 47, 'empty_docs:display', 'empty_docs:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(432, 1550756789, 0, 1, 0, 3, 111, 112, 430, 'Копировать', 47, 'empty_docs:display', 'empty_docs:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(433, 1550756789, 0, 1, 0, 3, 113, 114, 430, 'Вставить', 47, 'empty_docs:display', 'empty_docs:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(434, 1550756789, 0, 1, 0, 2, 116, 121, 1, 'Добавить', 47, 'empty_docs:add', 'empty_docs:add_end', 1000, ''),
(435, 1550756789, 0, 1, 0, 3, 117, 118, 434, '... и включить', 47, 'empty_docs:add', 'empty_docs:add_end?mode=1', 1000, ''),
(436, 1550756789, 0, 1, 0, 3, 119, 120, 434, '... и создать новый', 47, 'empty_docs:add', 'empty_docs:add_end?mode=2', 1000, ''),
(437, 1550756789, 0, 1, 0, 2, 122, 123, 1, 'Отмена', 47, 'empty_docs:add', 'empty_docs:cancel', 1000, ''),
(438, 1550756789, 0, 1, 0, 2, 124, 127, 1, 'Сохранить', 47, 'empty_docs:fix', 'empty_docs:fix_end', 1000, ''),
(439, 1550756789, 0, 1, 0, 3, 125, 126, 438, '... и не закрывать', 47, 'empty_docs:fix', 'empty_docs:fix_end?mode=1', 1000, ''),
(440, 1550756789, 0, 1, 0, 2, 128, 129, 1, 'Отмена', 47, 'empty_docs:fix', 'empty_docs:cancel', 1000, ''),
(441, 1550756844, 0, 1, 0, 2, 130, 131, 1, 'Добавить', 48, 'empty_arch_doc:display', 'empty_arch_doc:add', 1000, ''),
(442, 1550756844, 0, 1, 0, 2, 132, 133, 1, 'Удалить', 48, 'empty_arch_doc:display', 'empty_arch_doc:remove', 1000, ''),
(443, 1550756844, 0, 1, 0, 2, 134, 135, 1, 'Вкл/Выкл', 48, 'empty_arch_doc:display', 'empty_arch_doc:status', 1000, ''),
(444, 1550756844, 0, 1, 0, 2, 136, 143, 1, 'Правка', 48, 'empty_arch_doc:display', '', 1000, 'oxs_buttons_fixing'),
(445, 1550756844, 0, 1, 0, 3, 137, 138, 444, 'Вырезать', 48, 'empty_arch_doc:display', 'empty_arch_doc:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(446, 1550756844, 0, 1, 0, 3, 139, 140, 444, 'Копировать', 48, 'empty_arch_doc:display', 'empty_arch_doc:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(447, 1550756844, 0, 1, 0, 3, 141, 142, 444, 'Вставить', 48, 'empty_arch_doc:display', 'empty_arch_doc:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(448, 1550756844, 0, 1, 0, 2, 144, 149, 1, 'Добавить', 48, 'empty_arch_doc:add', 'empty_arch_doc:add_end', 1000, ''),
(449, 1550756844, 0, 1, 0, 3, 145, 146, 448, '... и включить', 48, 'empty_arch_doc:add', 'empty_arch_doc:add_end?mode=1', 1000, ''),
(450, 1550756844, 0, 1, 0, 3, 147, 148, 448, '... и создать новый', 48, 'empty_arch_doc:add', 'empty_arch_doc:add_end?mode=2', 1000, ''),
(451, 1550756844, 0, 1, 0, 2, 150, 151, 1, 'Отмена', 48, 'empty_arch_doc:add', 'empty_arch_doc:cancel', 1000, ''),
(452, 1550756844, 0, 1, 0, 2, 152, 155, 1, 'Сохранить', 48, 'empty_arch_doc:fix', 'empty_arch_doc:fix_end', 1000, ''),
(453, 1550756844, 0, 1, 0, 3, 153, 154, 452, '... и не закрывать', 48, 'empty_arch_doc:fix', 'empty_arch_doc:fix_end?mode=1', 1000, ''),
(454, 1550756844, 0, 1, 0, 2, 156, 157, 1, 'Отмена', 48, 'empty_arch_doc:fix', 'empty_arch_doc:cancel', 1000, ''),
(469, 1550842661, 0, 1, 0, 2, 158, 159, 1, 'Добавить', 50, 'doc_cat:display', 'doc_cat:add', 1000, ''),
(470, 1550842661, 0, 1, 0, 2, 160, 161, 1, 'Удалить', 50, 'doc_cat:display', 'doc_cat:remove', 1000, ''),
(471, 1550842661, 0, 1, 0, 2, 162, 163, 1, 'Вкл/Выкл', 50, 'doc_cat:display', 'doc_cat:status', 1000, ''),
(472, 1550842661, 0, 1, 0, 2, 164, 171, 1, 'Правка', 50, 'doc_cat:display', '', 1000, 'oxs_buttons_fixing'),
(473, 1550842661, 0, 1, 0, 3, 165, 166, 472, 'Выделить', 50, 'doc_cat:display', 'doc_cat:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(474, 1550842661, 0, 1, 0, 3, 167, 168, 472, 'Вставить', 50, 'doc_cat:display', 'doc_cat:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(475, 1550842661, 0, 1, 0, 3, 169, 170, 472, 'Вложить', 50, 'doc_cat:display', 'doc_cat:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(476, 1550842661, 0, 1, 0, 2, 172, 177, 1, 'Добавить', 50, 'doc_cat:add', 'doc_cat:add_end', 1000, ''),
(477, 1550842661, 0, 1, 0, 3, 173, 174, 476, '... и включить', 50, 'doc_cat:add', 'doc_cat:add_end?mode=1', 1000, ''),
(478, 1550842661, 0, 1, 0, 3, 175, 176, 476, '... и создать новый', 50, 'doc_cat:add', 'doc_cat:add_end?mode=2', 1000, ''),
(479, 1550842661, 0, 1, 0, 2, 178, 179, 1, 'Отмена', 50, 'doc_cat:add', 'doc_cat:cancel', 1000, ''),
(480, 1550842661, 0, 1, 0, 2, 180, 183, 1, 'Сохранить', 50, 'doc_cat:fix', 'doc_cat:fix_end', 1000, ''),
(481, 1550842661, 0, 1, 0, 3, 181, 182, 480, '... и не закрывать', 50, 'doc_cat:fix', 'doc_cat:fix_end?mode=1', 1000, ''),
(482, 1550842661, 0, 1, 0, 2, 184, 185, 1, 'Отмена', 50, 'doc_cat:fix', 'doc_cat:cancel', 1000, ''),
(483, 1550842661, 0, 1, 0, 2, 186, 187, 1, 'Проверка', 50, 'doc_cat:display', 'doc_cat:check_base', 1000, ''),
(484, 1550842883, 0, 1, 0, 2, 188, 189, 1, 'Добавить', 51, 'docs:display', 'docs:add', 1000, ''),
(485, 1550842883, 0, 1, 0, 2, 190, 191, 1, 'Удалить', 51, 'docs:display', 'docs:remove', 1000, ''),
(486, 1550842883, 0, 1, 0, 2, 192, 193, 1, 'Вкл/Выкл', 51, 'docs:display', 'docs:status', 1000, ''),
(487, 1550842883, 0, 1, 0, 2, 194, 201, 1, 'Правка', 51, 'docs:display', '', 1000, 'oxs_buttons_fixing'),
(488, 1550842883, 0, 1, 0, 3, 195, 196, 487, 'Вырезать', 51, 'docs:display', 'docs:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(489, 1550842883, 0, 1, 0, 3, 197, 198, 487, 'Копировать', 51, 'docs:display', 'docs:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(490, 1550842883, 0, 1, 0, 3, 199, 200, 487, 'Вставить', 51, 'docs:display', 'docs:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(491, 1550842883, 0, 1, 0, 2, 202, 207, 1, 'Добавить', 51, 'docs:add', 'docs:add_end', 1000, ''),
(492, 1550842883, 0, 1, 0, 3, 203, 204, 491, '... и включить', 51, 'docs:add', 'docs:add_end?mode=1', 1000, ''),
(493, 1550842883, 0, 1, 0, 3, 205, 206, 491, '... и создать новый', 51, 'docs:add', 'docs:add_end?mode=2', 1000, ''),
(494, 1550842883, 0, 1, 0, 2, 208, 209, 1, 'Отмена', 51, 'docs:add', 'docs:cancel', 1000, ''),
(495, 1550842883, 0, 1, 0, 2, 210, 213, 1, 'Сохранить', 51, 'docs:fix', 'docs:fix_end', 1000, ''),
(496, 1550842883, 0, 1, 0, 3, 211, 212, 495, '... и не закрывать', 51, 'docs:fix', 'docs:fix_end?mode=1', 1000, ''),
(497, 1550842883, 0, 1, 0, 2, 214, 215, 1, 'Отмена', 51, 'docs:fix', 'docs:cancel', 1000, ''),
(498, 1550842952, 0, 1, 0, 2, 216, 217, 1, 'Добавить', 52, 'doc_tags:display', 'doc_tags:add', 1000, ''),
(499, 1550842952, 0, 1, 0, 2, 218, 219, 1, 'Удалить', 52, 'doc_tags:display', 'doc_tags:remove', 1000, ''),
(500, 1550842952, 0, 1, 0, 2, 220, 221, 1, 'Вкл/Выкл', 52, 'doc_tags:display', 'doc_tags:status', 1000, ''),
(501, 1550842952, 0, 1, 0, 2, 222, 229, 1, 'Правка', 52, 'doc_tags:display', '', 1000, 'oxs_buttons_fixing'),
(502, 1550842952, 0, 1, 0, 3, 223, 224, 501, 'Выделить', 52, 'doc_tags:display', 'doc_tags:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(503, 1550842952, 0, 1, 0, 3, 225, 226, 501, 'Вставить', 52, 'doc_tags:display', 'doc_tags:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(504, 1550842952, 0, 1, 0, 3, 227, 228, 501, 'Вложить', 52, 'doc_tags:display', 'doc_tags:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(505, 1550842952, 0, 1, 0, 2, 230, 235, 1, 'Добавить', 52, 'doc_tags:add', 'doc_tags:add_end', 1000, ''),
(506, 1550842952, 0, 1, 0, 3, 231, 232, 505, '... и включить', 52, 'doc_tags:add', 'doc_tags:add_end?mode=1', 1000, ''),
(507, 1550842952, 0, 1, 0, 3, 233, 234, 505, '... и создать новый', 52, 'doc_tags:add', 'doc_tags:add_end?mode=2', 1000, ''),
(508, 1550842952, 0, 1, 0, 2, 236, 237, 1, 'Отмена', 52, 'doc_tags:add', 'doc_tags:cancel', 1000, ''),
(509, 1550842952, 0, 1, 0, 2, 238, 241, 1, 'Сохранить', 52, 'doc_tags:fix', 'doc_tags:fix_end', 1000, ''),
(510, 1550842952, 0, 1, 0, 3, 239, 240, 509, '... и не закрывать', 52, 'doc_tags:fix', 'doc_tags:fix_end?mode=1', 1000, ''),
(511, 1550842952, 0, 1, 0, 2, 242, 243, 1, 'Отмена', 52, 'doc_tags:fix', 'doc_tags:cancel', 1000, ''),
(512, 1550842952, 0, 1, 0, 2, 244, 245, 1, 'Проверка', 52, 'doc_tags:display', 'doc_tags:check_base', 1000, ''),
(513, 1550843015, 0, 1, 0, 2, 246, 247, 1, 'Добавить', 53, 'doc_settings:display', 'doc_settings:add', 1000, ''),
(514, 1550843015, 0, 1, 0, 2, 248, 249, 1, 'Удалить', 53, 'doc_settings:display', 'doc_settings:remove', 1000, ''),
(515, 1550843015, 0, 1, 0, 2, 250, 251, 1, 'Вкл/Выкл', 53, 'doc_settings:display', 'doc_settings:status', 1000, ''),
(516, 1550843015, 0, 1, 0, 2, 252, 259, 1, 'Правка', 53, 'doc_settings:display', '', 1000, 'oxs_buttons_fixing'),
(517, 1550843015, 0, 1, 0, 3, 253, 254, 516, 'Вырезать', 53, 'doc_settings:display', 'doc_settings:fixing?mode=1', 1000, 'oxs_buttons_fixing'),
(518, 1550843015, 0, 1, 0, 3, 255, 256, 516, 'Копировать', 53, 'doc_settings:display', 'doc_settings:fixing?mode=2', 1000, 'oxs_buttons_fixing'),
(519, 1550843015, 0, 1, 0, 3, 257, 258, 516, 'Вставить', 53, 'doc_settings:display', 'doc_settings:fixing?mode=3', 1000, 'oxs_buttons_fixing'),
(520, 1550843015, 0, 1, 0, 2, 260, 265, 1, 'Добавить', 53, 'doc_settings:add', 'doc_settings:add_end', 1000, ''),
(521, 1550843015, 0, 1, 0, 3, 261, 262, 520, '... и включить', 53, 'doc_settings:add', 'doc_settings:add_end?mode=1', 1000, ''),
(522, 1550843015, 0, 1, 0, 3, 263, 264, 520, '... и создать новый', 53, 'doc_settings:add', 'doc_settings:add_end?mode=2', 1000, ''),
(523, 1550843015, 0, 1, 0, 2, 266, 267, 1, 'Отмена', 53, 'doc_settings:add', 'doc_settings:cancel', 1000, ''),
(524, 1550843015, 0, 1, 0, 2, 268, 271, 1, 'Сохранить', 53, 'doc_settings:fix', 'doc_settings:fix_end', 1000, ''),
(525, 1550843015, 0, 1, 0, 3, 269, 270, 524, '... и не закрывать', 53, 'doc_settings:fix', 'doc_settings:fix_end?mode=1', 1000, ''),
(526, 1550843015, 0, 1, 0, 2, 272, 273, 1, 'Отмена', 53, 'doc_settings:fix', 'doc_settings:cancel', 1000, '');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_cookie_ban`
--

CREATE TABLE `oxs_cookie_ban` (
  `id` int(11) NOT NULL,
  `cookie` tinytext NOT NULL,
  `dateunbam` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_docs`
--

CREATE TABLE `oxs_docs` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `desc` text NOT NULL,
  `cat` int(11) NOT NULL,
  `tags` text NOT NULL,
  `death_time` tinyint(4) NOT NULL,
  `files` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_docs`
--

INSERT INTO `oxs_docs` (`id`, `create_data`, `update_data`, `status`, `position`, `name`, `desc`, `cat`, `tags`, `death_time`, `files`) VALUES
(2, 1553266214, 0, 1, 2, 'asd', 'asd', 3, '[\"2\"]', 0, ''),
(3, 1553268504, 0, 1, 3, 'Тестовый документ', 'Тестовый', 3, '[\"2\",\"3\"]', 0, ''),
(4, 1554815086, 0, 1, 4, 'wdad', 'awd', 3, '[\"2\",\"3\",\"4\"]', 0, ''),
(5, 1554815097, 0, 1, 5, 'dawd', 'dd', 3, '[\"2\"]', 0, ''),
(6, 1554815101, 0, 1, 6, 'sss', '', 2, '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_doc_cat`
--

CREATE TABLE `oxs_doc_cat` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `left_key` int(11) NOT NULL,
  `right_key` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_doc_cat`
--

INSERT INTO `oxs_doc_cat` (`id`, `create_data`, `update_data`, `status`, `position`, `level`, `left_key`, `right_key`, `pid`, `name`) VALUES
(1, 0, 0, 1, 0, 1, 1, 6, 0, 'ROOT'),
(2, 1550842734, 0, 1, 2, 2, 2, 3, 1, 'Без категории'),
(3, 1550842771, 0, 1, 3, 2, 4, 5, 1, 'Для новостей');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_doc_settings`
--

CREATE TABLE `oxs_doc_settings` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `value` text NOT NULL,
  `meta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_doc_settings`
--

INSERT INTO `oxs_doc_settings` (`id`, `create_data`, `update_data`, `status`, `position`, `name`, `value`, `meta`) VALUES
(1, 1550843391, 0, 1, 1, 'Максимальный размер файла(мб)', '20', ''),
(2, 1550843423, 0, 1, 2, 'Количество файлов за раз', '10', ''),
(3, 1550843520, 0, 1, 3, 'Разрешенные форматы', 'pdf,doc,docx,xls,xlsx,ppt,ppt,zip,rar,7z', '');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_doc_tags`
--

CREATE TABLE `oxs_doc_tags` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `left_key` int(11) NOT NULL,
  `right_key` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_doc_tags`
--

INSERT INTO `oxs_doc_tags` (`id`, `create_data`, `update_data`, `status`, `position`, `level`, `left_key`, `right_key`, `pid`, `name`) VALUES
(1, 0, 0, 1, 0, 1, 1, 8, 0, 'ROOT'),
(2, 1550845804, 1554830822, 1, 2, 2, 2, 3, 1, 'Муниц. задание'),
(3, 1550845883, 0, 1, 3, 2, 4, 5, 1, 'Русский язык'),
(4, 1550845889, 0, 1, 4, 2, 6, 7, 1, 'Математика');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_empty_arch_doc`
--

CREATE TABLE `oxs_empty_arch_doc` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_empty_docs`
--

CREATE TABLE `oxs_empty_docs` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_fields`
--

CREATE TABLE `oxs_fields` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `block_name` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `system_name` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  `db_type` tinytext NOT NULL,
  `form_name` tinytext NOT NULL,
  `description` text NOT NULL,
  `filters` tinytext NOT NULL,
  `access` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_fields`
--

INSERT INTO `oxs_fields` (`id`, `create_data`, `update_data`, `status`, `position`, `block_name`, `name`, `system_name`, `type`, `db_type`, `form_name`, `description`, `filters`, `access`) VALUES
(1, 1529253041, 1529253041, 1, 0, 'blocks', 'Название', 'name', 'text', 'tinytext', 'Название блока', 'Введите название блока данных, для отображения в меню', 'show_level /field level /correct -1,fill', 1000),
(2, 1529253041, 1529253041, 1, 2, 'blocks', 'Описание', 'description', 'text', 'tinytext', 'Описание', 'Введите описание блока данных, оно будет видно в его шапке', 'fill', 1000),
(3, 1529253041, 1529253041, 1, 0, 'blocks', 'Системное имя', 'system_name', 'text', 'tinytext', 'Системное имя', 'Уникальное системное имя блока, используется системой', 'fill', 1000),
(4, 1529253041, 1545380943, 1, 0, 'blocks', 'Не активна', 'section', 'checkbox', 'boolean', 'Блок неактивный', 'На неактивный блок нельзя кликнуть в меню', 'boolean /mode 1', 1000),
(5, 1529253041, 1529253041, 1, 1, 'blocks', 'Доступ', 'access', 'text', 'int', 'Права доступа', 'Укажите необходимый уровень доступа', 'default_value /v 500,fill', 1000),
(6, 1529253041, 1529253041, 1, 3, 'blocks', 'Блок родитель', 'pid', 'block_parent', 'int', 'Блок родитель', 'Выберите блок родитель', '', 1000),
(7, 1529253041, 1529253041, 1, 4, 'blocks', 'Действие по умолчанию', 'defaultAction', 'text', 'tinytext', 'Действие по умолчанию', 'Введите действие для блока по умолчанию', 'default_value /v display', 1000),
(9, 1529253041, 1543988742, 1, 6, 'buttons', 'Текст', 'name', 'text', 'tinytext', 'Текст кнопки', 'Введите текст кнопки', 'fill,show_level /field level /correct -2', 1000),
(10, 1529253041, 1529253041, 1, 7, 'buttons', 'Блок', 'bid', 'blocks_list', 'int', 'Блок', 'Выберите блок которому будет принадлежать кнопка', '', 1000),
(11, 1529253041, 1545287046, 1, 8, 'buttons', 'Отображение', 'displayin', 'button_displayin_text', 'tinytext', 'Отображение', 'Введите блок и действие в котором будет отображаться данная кнопка', 'fill', 1000),
(12, 1529253041, 1545287054, 1, 9, 'buttons', 'Действие', 'action', 'button_action_text', 'tinytext', 'Действие', 'Введите действие которое будет выполнено по нажатию на кнопку', '', 1000),
(13, 1529253041, 1529253041, 1, 10, 'buttons', 'Доступ', 'access', 'text', 'int', 'Доступ', 'Введите необходимый уровень доступа', 'default_value /v 500,integer /min 0 /max 1000', 1000),
(14, 0, 0, 1, 11, 'blocks', 'Тип блока', 'type', 'text', 'tinytext', 'Тип блока', 'Введите тип блока, по типу будет подбираться defalt обработчики и действия', 'fill,default_value /v default', 1000),
(15, 0, 0, 1, 12, 'fields', 'Блок', 'block_name', 'blocks_list', 'tinytext', 'Выберите блок', 'Выберите блок данных к которому добавить поле', 'no_change', 1000),
(16, 0, 0, 1, 13, 'fields', 'Название поля', 'name', 'text', 'tinytext', 'Название поля', 'Введите название поля', '', 1000),
(17, 0, 1554829899, 1, 14, 'fields', 'Системное имя поля', 'system_name', 'text', 'tinytext', 'Системное имя', 'Введите уникальное системное имя поля', 'style /f \"width:150px;\"', 1000),
(18, 0, 0, 1, 15, 'fields', 'Тип поля', 'type', 'text', 'tinytext', 'Введите тип поля', 'Для каждого типа поля выполняться советующий код', '', 1000),
(19, 0, 0, 1, 16, 'fields', 'Вывод на форме', 'form_name', 'text', 'tinytext', 'Вывод на поле', 'Данный текст будет выводиться на форме', 'no_display', 1000),
(20, 0, 0, 1, 17, 'fields', 'Описание', 'description', 'text', 'tinytext', 'Описание поля', 'Введите описание поля', 'no_display', 1000),
(21, 0, 1543988692, 1, 18, 'fields', 'Филльтры', 'filters', 'text', 'tinytext', 'Фильтры', 'Введите фильтры через запятую', 'overflow_ellipsis', 1000),
(22, 0, 0, 1, 19, 'fields', 'Доступ', 'access', 'text', 'int', 'Доступ', 'Необходимый уровень доступа', '', 1000),
(23, 0, 1543988660, 1, 20, 'fields', 'Выберите типа БД', 'db_type', 'fileds_type', 'tinytext', 'Тип поля в базе данных', 'Выберите типа БД', '', 1000),
(25, 0, 0, 1, 22, 'users', 'Имя пользователя', 'username', 'text', 'tinytext', 'Введите имя пользователя', 'Введите уникальное имя пользователя', 'unique,fill', 1000),
(26, 0, 0, 1, 23, 'users', 'Пароль', 'password', 'user_password', 'tinytext', 'Пароль', 'Введите пароль(если оставить пустым пароль не будет изменен)', 'fill,max_lenght /v 30,no_display', 1000),
(27, 0, 0, 1, 24, 'users', 'Блок по умолчанию', 'default_block', 'blocks_list_names', 'tinytext', 'Выберите блок по умолчанию', 'Выберите блок который для пользователя будет стандартный', 'fill', 1000),
(28, 0, 0, 1, 25, 'users', 'Последний вход', 'last_enter', 'text', 'int', 'Дата последнего входа', 'Дата последнего входа', 'no_change,data /m 1', 1000),
(29, 0, 0, 1, 26, 'users', 'Права пользователя', 'power', 'text', 'int', 'Права пользователя', 'Права пользователя на доступ к элементам', 'fill,default_value /v 500', 1000),
(49, 1530874426, 0, 1, 46, 'settings', 'Название параметра', 'name', 'text', 'tinytext', 'Название параметра', 'Название парамтера', 'fill', 1000),
(50, 1530874462, 0, 1, 47, 'settings', 'Значаение', 'value', 'text', 'text', 'Значение', 'Значение', 'fill', 1000),
(51, 1530892303, 1530894368, 1, 48, 'settings', 'Системное имя', 'system_name', 'text', 'tinytext', 'Системное имя', 'Системное имя', 'fill,unique', 1000),
(73, 1545724725, 0, 1, 71, 'buttons', 'Уникальный класс', 'ui_class', 'text', 'tinytext', 'Введите уникальный класс', 'Введите уникальный класс', '', 100),
(76, 1547472435, 1547472456, 1, 74, 'test', 'test', 'text', 'text', 'text', 'test', 'test', '', 0),
(77, 1550842661, 1550846375, 1, 75, 'doc_cat', 'Название', 'name', 'text', 'tinytext', 'Название', 'Введите название', 'show_level /field level /correct -1', 700),
(78, 0, 0, 1, 76, 'doc_cat', 'Родитель', 'pid', 'tree_parent', 'int', 'Родитель', 'Выберите родителя', '', 700),
(79, 1550842952, 1550847962, 1, 78, 'doc_tags', 'Название', 'name', 'text', 'tinytext', 'Название', 'Введите название', 'show_level /field level /correct -2,rename_root /v  /f name,unique', 700),
(80, 0, 0, 1, 79, 'doc_tags', 'Родитель', 'pid', 'tree_parent', 'int', 'Родитель', 'Выберите родителя', '', 700),
(81, 1550843275, 0, 1, 81, 'doc_settings', 'Описание', 'name', 'text', 'tinytext', 'Описание настройки', 'Описание', 'fill', 800),
(82, 1550843319, 0, 1, 82, 'doc_settings', 'Значение', 'value', 'text', 'text', 'Значение настройки', 'Значение настройки', '', 800),
(83, 1550843359, 0, 1, 83, 'doc_settings', 'Метаданные', 'meta', 'textarea', 'text', 'Метаданные настройки', 'Метаданные настройки', '', 800),
(84, 1550843641, 0, 1, 84, 'docs', 'Название', 'name', 'text', 'tinytext', 'Название', 'Название', 'fill', 800),
(85, 1550843678, 0, 1, 85, 'docs', 'Описание', 'desc', 'textarea', 'text', 'Описание', 'Описание', 'no_display', 800),
(87, 1550843851, 1553267932, 1, 87, 'docs', 'Категория', 'cat', 'cat_tree', 'int', 'Категория файла', 'Категория файла', 'default_value /v 2,field_set /table doc_cat,show_level /field level /correct 0', 800),
(88, 1550843919, 1554829907, 1, 88, 'docs', 'Теги', 'tags', 'tags_selector', 'text', 'Теги', 'Теги', 'style /f \"width:300px;\"', 800),
(89, 1550843984, 0, 0, 89, 'docs', 'Срок годности', 'death_time', 'data', 'tinyint', 'Срок годности', 'Срок годности', '', 800),
(93, 1556813869, 1556814163, 1, 93, 'docs', 'Файлы', 'files', 'files_board', 'text', '', 'Файлы', '', 900);

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_ip_bans`
--

CREATE TABLE `oxs_ip_bans` (
  `id` int(11) NOT NULL,
  `ip` tinytext NOT NULL,
  `dataunban` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_settings`
--

CREATE TABLE `oxs_settings` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `value` text NOT NULL,
  `system_name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_settings`
--

INSERT INTO `oxs_settings` (`id`, `create_data`, `update_data`, `status`, `position`, `name`, `value`, `system_name`) VALUES
(1, 1530874480, 1549378365, 1, 1, 'Сайт включен', '1', 'enable_site'),
(2, 1530892000, 1549378367, 1, 2, 'Режим отладки', '1', 'debug_mode');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_templates`
--

CREATE TABLE `oxs_templates` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `system_name` tinytext NOT NULL,
  `inuse` tinyint(1) NOT NULL,
  `type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_templates`
--

INSERT INTO `oxs_templates` (`id`, `name`, `system_name`, `inuse`, `type`) VALUES
(1, 'Стандартный', 'default', 1, 'admin'),
(2, 'ap-dveri', 'apdveri', 1, 'front');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_test`
--

CREATE TABLE `oxs_test` (
  `id` int(11) NOT NULL,
  `create_data` int(11) NOT NULL,
  `update_data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_test`
--

INSERT INTO `oxs_test` (`id`, `create_data`, `update_data`, `status`, `position`, `text`) VALUES
(1, 1547472462, 0, 1, 1, 'asdasd'),
(2, 1547473013, 0, 1, 3, 'ddddd'),
(3, 1547473017, 1547474114, 1, 4, 'asdasdasd'),
(4, 1547473447, 0, 1, 6, 'ddddd'),
(5, 1549374550, 0, 1, 6, 'tttttttttttt'),
(6, 1549374563, 0, 0, 5, 'ddddd'),
(7, 1551364153, 0, 1, 7, 'ssss');

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_users`
--

CREATE TABLE `oxs_users` (
  `id` int(11) NOT NULL,
  `create_data` tinytext NOT NULL,
  `update_data` tinytext NOT NULL,
  `status` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `last_enter` int(11) NOT NULL,
  `default_block` int(11) NOT NULL,
  `power` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_users`
--

INSERT INTO `oxs_users` (`id`, `create_data`, `update_data`, `status`, `position`, `username`, `password`, `last_enter`, `default_block`, `power`) VALUES
(1, '1527536857', '1533748374', 1, 1, 'admin', '0261fe1458e0aba999af038d72d270ebf7bebf66', 1557369542, 2, 1000);

-- --------------------------------------------------------

--
-- Структура таблицы `oxs_users_login_try`
--

CREATE TABLE `oxs_users_login_try` (
  `id` int(11) NOT NULL,
  `ip` tinytext NOT NULL,
  `cookie` tinytext NOT NULL,
  `data_try` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oxs_users_login_try`
--

INSERT INTO `oxs_users_login_try` (`id`, `ip`, `cookie`, `data_try`) VALUES
(291, '192.168.0.3', 'fe12b13c-d530-4c00-ade8-a357daa20124', '1557369538'),
(292, '192.168.0.3', 'fe12b13c-d530-4c00-ade8-a357daa20124', '1557369542');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oxs_blocks`
--
ALTER TABLE `oxs_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_buttons`
--
ALTER TABLE `oxs_buttons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_cookie_ban`
--
ALTER TABLE `oxs_cookie_ban`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_docs`
--
ALTER TABLE `oxs_docs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_doc_cat`
--
ALTER TABLE `oxs_doc_cat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_doc_settings`
--
ALTER TABLE `oxs_doc_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_doc_tags`
--
ALTER TABLE `oxs_doc_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_empty_arch_doc`
--
ALTER TABLE `oxs_empty_arch_doc`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_empty_docs`
--
ALTER TABLE `oxs_empty_docs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_fields`
--
ALTER TABLE `oxs_fields`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_settings`
--
ALTER TABLE `oxs_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_templates`
--
ALTER TABLE `oxs_templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_test`
--
ALTER TABLE `oxs_test`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_users`
--
ALTER TABLE `oxs_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oxs_users_login_try`
--
ALTER TABLE `oxs_users_login_try`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oxs_blocks`
--
ALTER TABLE `oxs_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT для таблицы `oxs_buttons`
--
ALTER TABLE `oxs_buttons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=527;

--
-- AUTO_INCREMENT для таблицы `oxs_cookie_ban`
--
ALTER TABLE `oxs_cookie_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oxs_docs`
--
ALTER TABLE `oxs_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `oxs_doc_cat`
--
ALTER TABLE `oxs_doc_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `oxs_doc_settings`
--
ALTER TABLE `oxs_doc_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `oxs_doc_tags`
--
ALTER TABLE `oxs_doc_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `oxs_empty_arch_doc`
--
ALTER TABLE `oxs_empty_arch_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oxs_empty_docs`
--
ALTER TABLE `oxs_empty_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oxs_fields`
--
ALTER TABLE `oxs_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT для таблицы `oxs_settings`
--
ALTER TABLE `oxs_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `oxs_templates`
--
ALTER TABLE `oxs_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `oxs_test`
--
ALTER TABLE `oxs_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `oxs_users`
--
ALTER TABLE `oxs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `oxs_users_login_try`
--
ALTER TABLE `oxs_users_login_try`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
