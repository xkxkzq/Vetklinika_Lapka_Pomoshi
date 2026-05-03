-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 03 2026 г., 19:08
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vetklinika`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appointments`
--

CREATE TABLE `appointments` (
  `id_appointment` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `pet_type` varchar(50) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`id_appointment`, `user_id`, `service_id`, `appointment_date`, `appointment_time`, `pet_name`, `pet_type`, `phone`, `comment`, `status`, `created_at`) VALUES
(1, 6, 15, '2026-03-23', '12:00:00', 'Рекс', 'собака', '+79201234567', '', 'cancelled', '2026-03-22 18:04:00'),
(2, 6, 3, '2026-04-01', '15:00:00', 'Шрек', 'рептилия', '(920) 123-45-67', '', 'completed', '2026-03-22 18:36:06'),
(3, 6, 7, '2026-05-10', '14:00:00', 'Рекс', 'собака', '9201234567', '', 'pending', '2026-04-28 12:21:09');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id_service` int(11) NOT NULL,
  `service` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id_service`, `service`, `description`, `price`) VALUES
(1, 'Первичный прием', 'Осмотр, сбор анамнеза и первичная диагностика — важный шаг для оценки состояния питомца. На приёме врач ответит на вопросы, назначит обследования или лечение.', 0),
(3, 'УЗИ', 'УЗИ для домашних животных — это информативный и безболезненный методов диагностики, позволяющий выявить заболевания внутренних органов на ранних стадиях.', 500),
(4, 'Эхокардиография', 'Исследование сердца с оформлением протокола', 2000),
(5, 'ЭКГ', 'Исследование сердечной активности', 1000),
(6, 'Отоскапия', 'Осмотр ушных каналов и глазного дна', 350),
(7, 'Рентген', 'Цифровой рентген за одну проекцию', 700),
(8, 'Общий анализ крови', 'Классический анализ с лейкоцитарной формулой', 1000),
(9, 'Вакцинация (без стоимости вакцины)', 'Осмотр перед прививкой и введение вакцины', 500),
(10, 'Чипирование', 'Установка микрочипа и внесение данных в базу', 750),
(11, 'Кастрация кота', 'Стоимость может быть изменена с учетом веса и вакцинации животного', 2000),
(12, 'Стерелизация кошки', 'Стоимость может быть изменена с учетом веса и вакцинации животного', 4000),
(13, 'Кастрация собаки', 'Цена варьируется в зависимости от веса собаки', 12500),
(14, 'Капельница', 'Инфузионная терапия, цена может зависеть от длительности процедуры', 300),
(15, 'Госпитализация', 'Пребывание в стационаре', 1700);

-- --------------------------------------------------------

--
-- Структура таблицы `specialists`
--

CREATE TABLE `specialists` (
  `id_specialist` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `experience` int(11) DEFAULT 0,
  `education` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg',
  `is_active` tinyint(4) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `specialists`
--

INSERT INTO `specialists` (`id_specialist`, `full_name`, `specialty`, `description`, `experience`, `education`, `photo`, `is_active`, `sort_order`) VALUES
(1, 'Иванова Анна Сергеевна', 'Ветеринарный терапевт', 'Специалист по внутренним болезням животных. Проводит диагностику и лечение заболеваний ЖКТ, дыхательной и сердечно-сосудистой систем.', 12, 'Московская государственная академия ветеринарной медицины и биотехнологии', 'doctor1.jpg', 1, 1),
(2, 'Петров Дмитрий Алексеевич', 'Ветеринарный хирург', 'Проводит плановые и экстренные операции любой сложности. Более 2000 успешных операций.', 15, 'Санкт-Петербургская государственная академия ветеринарной медицины', 'doctor2.jpg', 1, 2),
(3, 'Смирнова Ольга Владимировна', 'Ветеринарный кардиолог', 'Диагностика и лечение сердечно-сосудистых заболеваний у кошек и собак. Проводит ЭХО-КГ, ЭКГ.', 8, 'Российский университет дружбы народов', 'doctor3.jpg', 1, 3),
(4, 'Котова Милана Дмитриевна', 'Ветеринарный дерматолог', 'Лечение кожных заболеваний, аллергий, грибковых инфекций у животных.', 10, 'Новосибирский государственный аграрный университет', 'doctor4.jpg', 1, 4),
(5, 'Морозова Ольга Павловна', 'Ветеринарный стоматолог', 'Лечение зубов, удаление зубного камня, челюстно-лицевые операции.', 7, 'Казанская государственная академия ветеринарной медицины', 'doctor5.jpg', 1, 5),
(6, 'Волков Андрей Николаевич', 'Ветеринарный офтальмолог', 'Диагностика и лечение заболеваний глаз у животных. Проводит офтальмологические операции.', 9, 'Уральский государственный аграрный университет', 'doctor6.jpg', 1, 6),
(7, 'Кузнецова Ольга Дмитриевна', 'Ветеринарный кардиолог', 'Специалист по диагностике и лечению заболеваний сердечно-сосудистой системы у мелких домашних животных. ', 0, NULL, 'kuznetsova.png', 1, 5),
(8, 'Морозов Игорь Анатольевич', 'Ортопед-травматолог', 'Занимается лечением переломов, вывихов, дисплазии суставов и других патологий опорно-двигательного аппарата. Практикует современные методы остеосинтеза.', 0, NULL, 'morozov.jpg', 1, 6),
(9, 'Федорова Марина Викторовна', 'Ветеринарный дерматолог', 'Диагностирует и лечит кожные заболевания, аллергии, паразитарные инфекции у кошек, собак и экзотических животных. ', 0, NULL, 'fedorova.jpg', 1, 7),
(10, 'Григорьев Сергей Павлович', 'Ветеринарный офтальмолог', 'Проводит диагностику и лечение глазных болезней: катаракта, глаукома, травмы глаз. Выполняет микрохирургические операции.', 0, NULL, 'grigoriev.jpg', 1, 8),
(11, 'Белова Анна Игоревна', 'Ветеринарный эндокринолог', 'Специализируется на заболеваниях щитовидной железы, сахарном диабете, нарушениях обмена веществ. Консультирует по вопросам диетологии и контроля веса.', 0, NULL, 'belova.jpg', 1, 9),
(12, 'Тихонов Павел Николаевич', 'Ветеринарный реабилитолог', 'Проводит восстановительную терапию после операций и травм, физиопроцедуры, массаж, гидротерапию. Помогает питомцам вернуться к активной жизни.', 0, NULL, 'tihonov.jpg', 1, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `surname`, `name`, `birthday`, `phone`, `password`) VALUES
(2, 'Петрова', 'Анастасия', '1993-03-19', '9201123456', 'user1'),
(3, 'Свиридова', 'Кира', '1995-06-22', '9251125821', 'user2'),
(4, 'Иванов', 'Тимур', '0000-00-00', '9251134920', 'user3'),
(6, 'Смирнова', 'Евгения', '2000-05-13', '9201234567', 'user4');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id_appointment`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

--
-- Индексы таблицы `specialists`
--
ALTER TABLE `specialists`
  ADD PRIMARY KEY (`id_specialist`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id_appointment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `specialists`
--
ALTER TABLE `specialists`
  MODIFY `id_specialist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id_service`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
