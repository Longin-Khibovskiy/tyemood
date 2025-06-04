-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Июн 04 2025 г., 19:59
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
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `second_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `additional_categories`
--

INSERT INTO `additional_categories` (`id`, `name`, `second_name`, `description`, `image`) VALUES
(1, 'Bestsellers', 'Популярное', NULL, NULL),
(2, 'Вам может понравится', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `characteristic_products`
--

CREATE TABLE `characteristic_products` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `composition` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `characteristic_products`
--

INSERT INTO `characteristic_products` (`id`, `product_id`, `color`, `type`, `composition`, `size`) VALUES
(1, 1, 'лавандовый всплеск', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L'),
(2, 2, 'молоко с клубникой', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'),
(3, 3, 'цветные лучи', 'тай-дай', '85% хлопок, 10% полиамид, 5% эластан', 'XS/S/M'),
(4, 4, 'амур и хаос', 'тай-дай', 'экокожа', NULL),
(5, 5, 'лавандовый лёд', 'тай-дай', '80% хлопок, 20% полиэстер', 'XS/S/M/L/XL'),
(6, 6, 'тропическое солнце', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж.', 'XS/S/M/L/XL'),
(7, 7, 'розовая соль', 'тай-дай', '100% хлопок', 'XS/S /M/L'),
(8, 8, 'сиреневый вихрь', 'тай-дай', '80% хлопок, 20% полиэстер', 'XS/S/M/L/XL'),
(9, 9, 'туманный лес', 'тай-дай', '100% хлопок (плотность 250 г/м²)', NULL),
(10, 10, 'яблочный фреш', 'тай-дай', '100% хлопок,10% полиамид, 5% эластан', 'XS/S/M'),
(11, 11, 'вечерний закат', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'),
(12, 12, 'розовый мрамор', 'тай-дай', '80% хлопок, 20% полиэстер', 'S/M/L'),
(13, 13, 'лимон и небо', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'),
(14, 14, 'мшистая акварель', 'тай-дай', '100% хлопок (плотность 250 г/м²)', NULL),
(15, 15, 'цветные пряности', 'тай-дай', '85% хлопок, 10% полиамид, 5% эластан', 'XS/S/M/L'),
(16, 16, 'гранатовый шторм', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'),
(17, 17, 'коровка-арт', 'тай-дай', '80% хлопок, 20% полиэстер', 'S/M/L'),
(18, 18, 'бабл гам', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L'),
(19, 19, 'акварельный хаос', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L');

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `guest_cart`
--

CREATE TABLE `guest_cart` (
  `id` int NOT NULL,
  `guest_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `size` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `guest_favorites`
--

CREATE TABLE `guest_favorites` (
  `guest_token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` int NOT NULL,
  `saved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `main_categories`
--

CREATE TABLE `main_categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anchor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `description`, `image`, `anchor`, `link`) VALUES
(1, 'Футболки', 'Каждая — как дневник настроения. Тай-дай, роспись, детали — ты точно найдёшь свою.', '/images/main_category/tshirt.png', 'tshirts', '/catalog?category=tshirts'),
(2, 'Лонгсливы', 'Каждая — как дневник настроения. Тай-дай, роспись, детали — ты точно найдёшь свою.', '/images/main_category/tshirt.png', 'long_sleeves', '/catalog?category=long_sleeves'),
(3, 'Толстовки', 'Объёмные, уютные, расписанные вручную — такие вещи не греют, они говорят.', '/images/main_category/sweatshirt.png', 'hoodies', '/catalog?category=hoodies'),
(4, 'Аксессуары', 'Шопперы, носки, кепки и не только. Раскрась своё настроение до кончиков шнурков.', '/images/main_category/accessories.png', 'accessories', '/catalog?category=accessories'),
(5, 'Кастом под заказ', 'Мы создадим вещь по твоей идее. Просто опиши — и получи уникальный результат.', '/images/main_category/custom.png', 'custom', '/catalog?category=custom'),
(6, 'Штаны', NULL, '/images/main_category/trousers.png', 'trousers', '/catalog?category=trousers'),
(7, 'Наборы', NULL, NULL, 'sets', '/catalog?category=sets');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `name`, `description`, `link`) VALUES
(1, 'Главная', NULL, '/'),
(2, 'Каталог', NULL, '/catalog'),
(3, 'Портфолио', NULL, '/portfolio'),
(4, 'FAQ', NULL, '/faq'),
(5, 'Оформление заказа', NULL, '/checkout'),
(6, 'Избранное', NULL, '/favorites'),
(7, 'Корзина', NULL, '/basket');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `main_categories_id` int NOT NULL,
  `additional_categories_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `main_categories_id`, `additional_categories_id`) VALUES
(1, 'Штаны «лавандовый всплеск»', NULL, '/images/products/trousers/lavender_splash.png', 2500, 6, 1),
(2, 'Футболка «молоко с клубникой»', NULL, '/images/products/tshirts/milk_with_strawberry.png', 1800, 1, 1),
(3, 'Носки «цветные лучи»', NULL, '/images/products/accessories/colored_rays.png', 1000, 4, 1),
(4, 'Сумка «Амур и Хаос»', NULL, '/images/products/accessories/cupid_and_chaos.png', 3500, 4, 1),
(5, 'Толстовка «лавандовый лёд»', NULL, '/images/products/sweetshirts/lavender_ice.png', 2800, 3, NULL),
(6, 'Футболка «тропическое солнце»', 'Базовая футболка из 100% хлопка, окрашенная вручную с использованием щадящих красителей. Техника тай-дай делает каждую вещь уникальной — рисунок на вашей футболке будет только у вас./Плотная, но мягкая ткань сохраняет форму и цвет даже после множества стирок.', '/images/products/tshirts/tropical_sun.png', 1200, 1, NULL),
(7, 'Джинсы «розовая соль»', NULL, '/images/products/trousers/pink_salt.png', 2500, 6, NULL),
(8, 'Лонгслив «сиреневый вихрь»', NULL, '/images/products/tshirts/lilac_wind.png', 1500, 2, NULL),
(9, 'Шоппер «туманный лес»', NULL, '/images/products/accessories/foggy_forest.png', 800, 4, NULL),
(10, 'Набор: носки и футболка «яблочный фреш»', NULL, '/images/products/sets/apple_fresh.png', 3000, 7, NULL),
(11, 'Футболка «вечерний закат»', NULL, '/images/products/tshirts/evening_sunset.png', 1300, 1, NULL),
(12, 'Кепка «розовый мрамор»', NULL, '/images/products/accessories/pink_marble.png', 1000, 4, NULL),
(13, 'Футболка «лимон и небо»', NULL, '/images/products/tshirts/lemon_and_sky.png', 1500, 1, NULL),
(14, 'Шоппер «мшистая акварель»', NULL, '/images/products/accessories/mossy_watercolor.png', 850, 4, NULL),
(15, 'Набор: носки 6.шт «цветные пряности»', NULL, '/images/products/sets/colored_spices.png', 2000, 7, NULL),
(16, 'Футболка «гранатовый шторм»', NULL, '/images/products/tshirts/garnet_storm.png', 1500, 1, 2),
(17, 'Кепка «коровка-арт»', NULL, '/images/products/accessories/cow_art.png', 1000, 4, 2),
(18, 'Толстовка «бабл гам»', NULL, '/images/products/sweetshirts/bubble_gum.png', 2500, 3, 2),
(19, 'Лонгслив «акварельный хаос»', NULL, '/images/products/tshirts/watercolor_chaos.png', 2000, 2, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `additional_categories`
--
ALTER TABLE `additional_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `characteristic_products`
--
ALTER TABLE `characteristic_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `guest_cart`
--
ALTER TABLE `guest_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `guest_favorites`
--
ALTER TABLE `guest_favorites`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `guest_cart`
--
ALTER TABLE `guest_cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `characteristic_products`
--
ALTER TABLE `characteristic_products`
  ADD CONSTRAINT `characteristic_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `guest_cart`
--
ALTER TABLE `guest_cart`
  ADD CONSTRAINT `guest_cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `guest_favorites`
--
ALTER TABLE `guest_favorites`
  ADD CONSTRAINT `guest_favorites_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`main_categories_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`additional_categories_id`) REFERENCES `additional_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
