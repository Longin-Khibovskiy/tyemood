-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Май 24 2025 г., 20:43
-- Версия сервера: 8.0.40
-- Версия PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tyemood`
--

-- --------------------------------------------------------

--
-- Структура таблицы `additional_categories`
--

CREATE TABLE `additional_categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `additional_categories`
--

INSERT INTO `additional_categories` (`id`, `name`, `second_name`, `description`, `image`) VALUES
(1, 'Bestsellers', 'Популярное', NULL, NULL),
(2, 'Вам может понравится', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `basket_products`
--

CREATE TABLE `basket_products` (
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `saved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `characteristic_products`
--

CREATE TABLE `characteristic_products` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `composition` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `characteristic_products`
--

INSERT INTO `characteristic_products` (`id`, `product_id`, `color`, `type`, `composition`, `size`) VALUES
(1, 6, 'тропическое солнце', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж.', 'XS/S/M/L/XL');

-- --------------------------------------------------------

--
-- Структура таблицы `main_categories`
--

CREATE TABLE `main_categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'Футболки, лонгсливы', 'Каждая — как дневник настроения. Тай-дай, роспись, детали — ты точно найдёшь свою.', '/images/main_category/tshirt.png'),
(2, 'Толстовки', 'Объёмные, уютные, расписанные вручную — такие вещи не греют, они говорят.', '/images/main_category/sweatshirt.png'),
(3, 'Аксессуары', 'Шопперы, носки, кепки и не только. Раскрась своё настроение до кончиков шнурков.', '/images/main_category/accessories.png'),
(4, 'Кастом под заказ', 'Мы создадим вещь по твоей идее. Просто опиши — и получи уникальный результат.', '/images/main_category/custom.png'),
(5, 'Штаны', NULL, '/images/main_category/trousers.png'),
(6, 'Наборы', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `name`, `description`, `link`) VALUES
(1, 'Главная', NULL, '/'),
(2, 'Каталог', NULL, '/'),
(3, 'Портфолио', NULL, '/'),
(4, 'FAQ', NULL, '/'),
(5, 'Оформление заказа', NULL, '/'),
(6, 'Избранное', NULL, '/'),
(7, 'Корзина', NULL, '/');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `main_categories_id` int NOT NULL,
  `additional_categories_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `main_categories_id`, `additional_categories_id`) VALUES
(1, 'Штаны «лавандовый всплеск»', NULL, '/images/products/trousers/lavender_splash.png', 2500, 5, 1),
(2, 'Футболка «молоко с клубникой»', NULL, '/images/products/tshirts/milk_with_strawberry.png', 1800, 1, 1),
(3, 'Носки «цветные лучи»', NULL, '/images/products/accessories/colored_rays.png', 1000, 3, 1),
(4, 'Сумка «Амур и Хаос»', NULL, '/images/products/accessories/cupid_and_chaos.png', 3500, 3, 1),
(5, 'Толстовка «лавандовый лёд»', NULL, '/images/products/sweetshirts/lavender_ice.png', 2800, 2, NULL),
(6, 'Футболка «тропическое солнце»', NULL, '/images/products/tshirts/tropical_sun.png', 1200, 1, NULL),
(7, 'Джинсы «розовая соль»', NULL, '/images/products/trousers/pink_salt.png', 2500, 5, NULL),
(8, 'Лонгслив «сиреневый вихрь»', NULL, '/images/products/tshirts/lilac_wind.png', 1500, 1, NULL),
(9, 'Шоппер «туманный лес»', NULL, '/images/products/accessories/foggy_forest.png', 800, 3, NULL),
(10, 'Набор: носки и футболка «яблочный фреш»', NULL, '/images/products/sets/apple_fresh.png', 3000, 6, NULL),
(11, 'Футболка «вечерний закат»', NULL, '/images/products/tshirts/evening_sunset.png', 1300, 1, NULL),
(12, 'Кепка «розовый мрамор»', NULL, '/images/products/accessories/pink_marble.png', 1000, 3, NULL),
(13, 'Футболка «лимон и небо»', NULL, '/images/products/tshirts/lemon_and_sky.png', 1500, 1, NULL),
(14, 'Шоппер «мшистая акварель»', NULL, '/images/products/accessories/mossy_watercolor.png', 850, 3, NULL),
(15, 'Набор: носки 6.шт «цветные пряности»', NULL, '/images/products/sets/colored_spices.png', 2000, 6, NULL),
(16, 'Футболка «гранатовый шторм»', NULL, '/images/products/tshirts/garnet_storm.png', 1500, 1, 2),
(17, 'Кепка «коровка-арт»', NULL, '/images/products/accessories/cow_art.png', 1000, 3, 2),
(18, 'Толстовка «бабл гам»', NULL, '/images/products/sweetshirts/bubble_gum.png', 2500, 2, 2),
(19, 'Лонгслив «акварельный хаос»', NULL, '/images/products/watercolor_chaos.png', 2000, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `selected_products`
--

CREATE TABLE `selected_products` (
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `saved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `additional_categories`
--
ALTER TABLE `additional_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `basket_products`
--
ALTER TABLE `basket_products`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `characteristic_products`
--
ALTER TABLE `characteristic_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_categories_id` (`main_categories_id`),
  ADD KEY `additional_categories_id` (`additional_categories_id`);

--
-- Индексы таблицы `selected_products`
--
ALTER TABLE `selected_products`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `additional_categories`
--
ALTER TABLE `additional_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `characteristic_products`
--
ALTER TABLE `characteristic_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket_products`
--
ALTER TABLE `basket_products`
  ADD CONSTRAINT `basket_products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `basket_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `characteristic_products`
--
ALTER TABLE `characteristic_products`
  ADD CONSTRAINT `characteristic_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`main_categories_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`additional_categories_id`) REFERENCES `additional_categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `selected_products`
--
ALTER TABLE `selected_products`
  ADD CONSTRAINT `selected_products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `selected_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
