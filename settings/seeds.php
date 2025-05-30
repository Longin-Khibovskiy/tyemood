<?php
## Команда для запуска — php config/seeds.php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'tyemood';
$port = 3306;
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock";
$conn = new mysqli($servername, $username, $password, '', $port, $socket);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$sql = "DROP DATABASE IF EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "База данных '$dbname' удалена\n";
} else {
    die("Ошибка удаления БД: " . $conn->error);
}

## Создаем БД, если её нет
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "База данных '$dbname' создана.\n";
} else {
    die("Ошибка создания БД: " . $conn->error);
}
$conn->select_db($dbname);

## Создание таблицы Pages
$sql = "CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    link VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица Pages создана успешно.\n"; else die("Ошибка создания таблицы Pages: " . $conn->error);

## Создание таблицы Основных категорий
$sql = "CREATE TABLE IF NOT EXISTS main_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    image VARCHAR(255),
    anchor VARCHAR(255),
    link VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица MainCategories создана успешно.\n"; else die("Ошибка создания таблицы MainCategories: " . $conn->error);

## Создание таблицы Дополнительных категорий
$sql = "CREATE TABLE IF NOT EXISTS additional_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    second_name VARCHAR(255),
    description VARCHAR(255),
    image VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица AdditionalCategories создана успешно.\n"; else die("Ошибка создания таблицы AdditionalCategories: " . $conn->error);

## Создание таблицы товаров
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    price INT,
    main_categories_id INT NOT NULL,
    additional_categories_id INT,
    FOREIGN KEY (main_categories_id) REFERENCES main_categories(id) ON DELETE CASCADE,
    FOREIGN KEY (additional_categories_id) REFERENCES additional_categories(id)
)";
if ($conn->query($sql) === TRUE) echo "Таблица Products создана успешно.\n"; else die("Ошибка создания таблицы Products: " . $conn->error);

## Создание таблицы Характеристик товаров
$sql = "CREATE TABLE IF NOT EXISTS characteristic_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    color VARCHAR(255),
    `type` VARCHAR(255),
    composition VARCHAR(255),
    `size` VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) echo "Таблица CharacteristicProducts создана успешно.\n"; else die("Ошибка создания таблицы CharacteristicProducts: " . $conn->error);

## Создание таблицы Избранных товаров
$sql = "CREATE TABLE IF NOT EXISTS guest_favorites (
    guest_token VARCHAR(64) NOT NULL,
    product_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);";
if ($conn->query($sql) === TRUE) echo "Таблица SelectedProducts создана успешно.\n"; else die("Ошибка создания таблицы SelectedProducts: " . $conn->error);


## Создание таблицы Корзины
$sql = "CREATE TABLE IF NOT EXISTS guest_cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_token VARCHAR(255),
    product_id INT,
    size VARCHAR(10),
    quantity INT DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) echo "Таблица BasketProducts создана успешно.\n"; else die("Ошибка создания таблицы BasketProducts: " . $conn->error);

## Feedback
$sql = "CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    phone_number VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица feedback создана успешно.\n"; else die("Ошибка создания таблицы BasketProducts: " . $conn->error);


$pagesData = [
    ['Главная', '', '/'],
    ['Каталог', '', '/catalog'],
    ['Портфолио', '', '/portfolio'],
    ['FAQ', '', '/faq'],
    ['Оформление заказа', '', '/checkout'],
    ['Избранное', '', '/favorites'],
    ['Корзина', '', '/basket'],
];

$mainCategories = [
    ['Футболки', 'Каждая — как дневник настроения. Тай-дай, роспись, детали — ты точно найдёшь свою.', '/images/main_category/tshirt.png', 'tshirts', '/catalog?category=tshirts'],
    ['Лонгсливы', 'Каждая — как дневник настроения. Тай-дай, роспись, детали — ты точно найдёшь свою.', '/images/main_category/tshirt.png', 'long_sleeves', '/catalog?category=long_sleeves'],
    ['Толстовки', 'Объёмные, уютные, расписанные вручную — такие вещи не греют, они говорят.', '/images/main_category/sweatshirt.png', 'hoodies', '/catalog?category=hoodies'],
    ['Аксессуары', 'Шопперы, носки, кепки и не только. Раскрась своё настроение до кончиков шнурков.', '/images/main_category/accessories.png', 'accessories', '/catalog?category=accessories'],
    ['Кастом под заказ', 'Мы создадим вещь по твоей идее. Просто опиши — и получи уникальный результат.', '/images/main_category/custom.png', 'custom', '/catalog?category=custom'],
    ['Штаны', '', '/images/main_category/trousers.png', 'trousers', '/catalog?category=trousers'],
    ['Наборы', '', '', 'sets', '/catalog?category=sets']
];

$additionalCategories = [
    ['Bestsellers', 'Популярное', '', ''],
    ['Вам может понравится', '', '', '']
];

$products = [
    // Популярное
    ['Штаны «лавандовый всплеск»', '', '/images/products/trousers/lavender_splash.png', 2500, 6, 1],
    ['Футболка «молоко с клубникой»', '', '/images/products/tshirts/milk_with_strawberry.png', 1800, 1, 1],
    ['Носки «цветные лучи»', '', '/images/products/accessories/colored_rays.png', 1000, 4, 1],
    ['Сумка «Амур и Хаос»', '', '/images/products/accessories/cupid_and_chaos.png', 3500, 4, 1],

    // Каталог
    ['Толстовка «лавандовый лёд»', '', '/images/products/sweetshirts/lavender_ice.png', 2800, 3, NULL],
    ['Футболка «тропическое солнце»', 'Базовая футболка из 100% хлопка, окрашенная вручную с использованием щадящих красителей. Техника тай-дай делает каждую вещь уникальной — рисунок на вашей футболке будет только у вас./Плотная, но мягкая ткань сохраняет форму и цвет даже после множества стирок.', '/images/products/tshirts/tropical_sun.png', 1200, 1, NULL],
    ['Джинсы «розовая соль»', '', '/images/products/trousers/pink_salt.png', 2500, 6, NULL],
    ['Лонгслив «сиреневый вихрь»', '', '/images/products/tshirts/lilac_wind.png', 1500, 2, NULL],
    ['Шоппер «туманный лес»', '', '/images/products/accessories/foggy_forest.png', 800, 4, NULL],
    ['Набор: носки и футболка «яблочный фреш»', '', '/images/products/sets/apple_fresh.png', 3000, 7, NULL],
    ['Футболка «вечерний закат»', '', '/images/products/tshirts/evening_sunset.png', 1300, 1, NULL],
    ['Кепка «розовый мрамор»', '', '/images/products/accessories/pink_marble.png', 1000, 4, NULL],
    ['Футболка «лимон и небо»', '', '/images/products/tshirts/lemon_and_sky.png', 1500, 1, NULL],
    ['Шоппер «мшистая акварель»', '', '/images/products/accessories/mossy_watercolor.png', 850, 4, NULL],
    ['Набор: носки 6.шт «цветные пряности»', '', '/images/products/sets/colored_spices.png', 2000, 7, NULL],

    // Вам может понравится
    ['Футболка «гранатовый шторм»', '', '/images/products/tshirts/garnet_storm.png', '1500', 1, 2],
    ['Кепка «коровка-арт»', '', '/images/products/accessories/cow_art.png', 1000, 4, 2],
    ['Толстовка «бабл гам»', '', '/images/products/sweetshirts/bubble_gum.png', 2500, 3, 2],
    ['Лонгслив «акварельный хаос»', '', '/images/products/tshirts/watercolor_chaos.png', 2000, 2, 2]
];

// id товара, цвет, тип окрашивания, состав, размеры
// Популярное
$characterisctics0fProducts = [
    [1, 'лавандовый всплеск', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L'],
    [2, 'молоко с клубникой', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'],
    [3, 'цветные лучи', 'тай-дай', '85% хлопок, 10% полиамид, 5% эластан', 'XS/S/M'],
    [4, 'амур и хаос', 'тай-дай', 'экокожа', ''],
    [5, 'лавандовый лёд', 'тай-дай', '80% хлопок, 20% полиэстер', 'XS/S/M/L/XL'],
    [6, 'тропическое солнце', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж.', 'XS/S/M/L/XL'],
    [7, 'розовая соль', 'тай-дай', '100% хлопок', 'XS/S /M/L'],
    [8, 'сиреневый вихрь', 'тай-дай', '80% хлопок, 20% полиэстер', 'XS/S/M/L/XL'],
    [9, 'туманный лес', 'тай-дай', '100% хлопок (плотность 250 г/м²)', ''],
    [10, 'яблочный фреш', 'тай-дай', '100% хлопок,10% полиамид, 5% эластан', 'XS/S/M'],
    [11, 'вечерний закат', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'],
    [12, 'розовый мрамор', 'тай-дай', '80% хлопок, 20% полиэстер', 'S/M/L'],
    [13, 'лимон и небо', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'],
    [14, 'мшистая акварель', 'тай-дай', '100% хлопок (плотность 250 г/м²)', ''],
    [15, 'цветные пряности', 'тай-дай', '85% хлопок, 10% полиамид, 5% эластан', 'XS/S/M/L'],
    [16, 'гранатовый шторм', 'тай-дай', '100% хлопок, мягкий и плотный трикотаж', 'XS/S/M/L/XL'],
    [17, 'коровка-арт', 'тай-дай', '80% хлопок, 20% полиэстер', 'S/M/L'],
    [18, 'бабл гам', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L'],
    [19, 'акварельный хаос', 'тай-дай', '95% хлопок, 5% эластан', 'XS/S/M/L'],
];

foreach ($pagesData as $data) {
    $name = $conn->real_escape_string($data[0]);
    $description = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $pages_link = $data[2] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";

    $sql = "INSERT INTO pages (name, description, link) 
            VALUES ('$name', $description, $pages_link)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в pages: " . $conn->error . "\n";
    }
}

foreach ($mainCategories as $data) {
    $name = $conn->real_escape_string($data[0]);
    $description = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $image = $data[2] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";
    $anchor = $data[3] ? "'" . $conn->real_escape_string($data[3]) . "'" : "NULL";
    $link = $data[4] ? "'" . $conn->real_escape_string($data[4]) . "'" : "NULL";

    $sql = "INSERT INTO main_categories (name, description, image, anchor, link) 
            VALUES ('$name', $description, $image, $anchor, $link)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в main_categories: " . $conn->error . "\n";
    }
}

foreach ($additionalCategories as $data) {
    $name = $conn->real_escape_string($data[0]);
    $second_name = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $description = $data[2] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $image = $data[3] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";

    $sql = "INSERT INTO additional_categories (name, second_name, description, image) 
            VALUES ('$name',$second_name, $description, $image)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в main_categories: " . $conn->error . "\n";
    }
}

foreach ($products as $data) {
    $name = $conn->real_escape_string($data[0]);
    $description = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $image = $data[2] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";
    $price = $data[3] ? "'" . $conn->real_escape_string($data[3]) . "'" : "NULL";
    $main_categories_id = $data[4] ? "'" . $conn->real_escape_string($data[4]) . "'" : "NULL";
    $additional_categories_id = $data[5] ? "'" . $conn->real_escape_string($data[5]) . "'" : "NULL";

    $sql = "INSERT INTO products (name, description, image, price, main_categories_id, additional_categories_id) 
            VALUES ('$name', $description, $image, $price, $main_categories_id, $additional_categories_id)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в products: " . $conn->error . "\n";
    }
}

foreach ($characterisctics0fProducts as $data) {
    $product_id = $conn->real_escape_string($data[0]);
    $color = $data[1] ? "'" . $conn->real_escape_string($data[1]) . "'" : "NULL";
    $type = $data[2] ? "'" . $conn->real_escape_string($data[2]) . "'" : "NULL";
    $composition = $data[3] ? "'" . $conn->real_escape_string($data[3]) . "'" : "NULL";
    $size = $data[4] ? "'" . $conn->real_escape_string($data[4]) . "'" : "NULL";

    $sql = "INSERT INTO characteristic_products (product_id, color, `type`, composition, `size`) 
            VALUES ($product_id, $color, $type, $composition, $size)";

    if (!$conn->query($sql)) {
        echo "Ошибка вставки в pages: " . $conn->error . "\n";
    }
}
?>