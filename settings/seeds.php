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
    image VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица MainCategories создана успешно.\n"; else die("Ошибка создания таблицы MainCategories: " . $conn->error);

## Создание таблицы Дополнительных категорий
$sql = "CREATE TABLE IF NOT EXISTS additional_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    image VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) echo "Таблица AdditionalCategories создана успешно.\n"; else die("Ошибка создания таблицы AdditionalCategories: " . $conn->error);

## Создание таблицы пользователя
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) echo "Таблица Users создана успешно.\n"; else die("Ошибка создания таблицы Users: " . $conn->error);

## Создание таблицы товаров
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
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
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) echo "Таблица CharacteristicProducts создана успешно.\n"; else die("Ошибка создания таблицы CharacteristicProducts: " . $conn->error);

## Создание таблицы Избранных товаров
$sql = "CREATE TABLE IF NOT EXISTS selected_products (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) echo "Таблица SelectedProducts создана успешно.\n"; else die("Ошибка создания таблицы SelectedProducts: " . $conn->error);


## Создание таблицы Корзины
$sql = "CREATE TABLE IF NOT EXISTS basket_products (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) echo "Таблица BasketProducts создана успешно.\n"; else die("Ошибка создания таблицы BasketProducts: " . $conn->error);


$pagesData = [
    ['Главная', '', '/'],
    ['Каталог', '', '/'],
    ['Портфолио', '', '/'],
    ['FAQ', '', '/'],
    ['Оформление заказа', '', '/'],
    ['Избранное', '', '/'],
    ['Корзина', '', '/'],
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
?>