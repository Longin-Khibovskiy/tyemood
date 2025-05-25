<?php
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    echo "Товар не найден.";
    exit;
}

$query = "SELECT p.*, mc.name as category_name 
          FROM products p
          JOIN main_categories mc ON p.main_categories_id = mc.id
          WHERE p.id = $product_id";

$result = $link->query($query);
$product = $result->fetch_assoc();

$result_char = $link->query("SELECT * FROM characteristic_products WHERE product_id = $product_id");
$char = $result_char->fetch_assoc();

$result_like = $link->query("SELECT * FROM products WHERE additional_categories_id = 2");
$like = mysqli_fetch_all($result_like, MYSQLI_ASSOC);
if (!$product) {
    echo "Товар не найден.";
    exit;
}
?>

<section class="product">
    <div class="product_container">
        <div class="product_grid">
            <img src="<?= $product['image'] ?>" alt="" class="product_image">
            <div class="product_characteristics_container">
                <div class="product_characteristics_title_container">
                    <p class="bold_02"><?= $product['name'] ?? 'Нет названия'; ?></p>
                    <p class="bold_02"><?= $product['price'] ?? 'Нет цены'; ?> ₽</p>
                </div>
                <div class="product_characteristics_main_container">
                    <div class="product_characteristics_main">
                        <p class="semibold_03">Цвет:</p>
                        <p class="regular_03"><?= $char['color'] ?? 'Без цвета'; ?></p>
                    </div>
                    <div class="product_characteristics_main">
                        <p class="semibold_03">Тип окрашивания:</p>
                        <p class="regular_03"><?= $char['type'] ?? 'Без типа'; ?></p>
                    </div>
                    <div class="product_characteristics_main">
                        <p class="semibold_03">Состав:</p>
                        <p class="regular_03"><?= $char['composition'] ?? 'Без состава'; ?></p>
                    </div>
                    <div class="product_characteristics_main_sizes">
                        <p class="semibold_03">Размеры:</p>
                        <div class="product_characteristics_main_size">
                            <?php
                            if (!empty($char['size'])) {
                                $sizes = explode('/', $char['size']);
                                foreach ($sizes as $size) {
                                    echo '<p class="regular_03">' . htmlspecialchars(trim($size)) . '</p>';
                                }
                            } else {
                                echo '<p class="regular_03">Нет размеров</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="product_basket_like">
                    <button class="button_18 product_basket">Добавить в корзину</button>
                    <svg class="product_like" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         viewBox="0 0 32 32" fill="none">
                        <path d="M10.3333 4C6.836 4 4 7.19059 4 11.1252C4 19 16 28 16 28C16 28 28 19 28 11.1252C28 6.25035 25.164 4 21.6667 4C19.1867 4 17.04 5.60376 16 7.93882C14.96 5.60376 12.8133 4 10.3333 4Z"
                              stroke="#2A2A2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <hr class="product_hr">
                <div class="product_characteristics_description">
                    <?php
                    if (!empty($product['description'])) {
                        $descs = explode('/', $product['description']);
                        foreach ($descs as $desc) :?>
                            <p class="medium_03"><?= $desc ?></p>
                        <?php endforeach;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="faq">
            <div class="faq-section">
                <div class="faq-item">
                    <button class="faq-question medium_02">Как ухаживать за изделием?</button>
                    <div class="faq-answer regular_04">
                        <p>Рекомендуем машинную стирку при 30°C, без отбеливателей и сушки в барабане.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question medium_02">Каковы сроки пошива?</button>
                    <div class="faq-answer regular_04">
                        <p>Срок пошива — 3–5 рабочих дней.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question medium_02">Можно ли вернуть футболку?</button>
                    <div class="faq-answer regular_04">
                        <p>Да, возврат возможен в течение 14 дней при сохранении товарного вида.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question medium_02">Как примерить перед покупкой?</button>
                    <div class="faq-answer regular_04">
                        <p>Рекомендуем машинную стирку при 30°C, без отбеливателей и сушки в барабане.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question medium_02">Если не подошёл размер?</button>
                    <div class="faq-answer regular_04">
                        <p>Вы можете обменять товар бесплатно один раз.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question medium_02">Как заказать с индивидуальным дизайном/принтом?</button>
                    <div class="faq-answer regular_04">
                        <p>Свяжитесь с нами через форму обратной связи или Telegram.</p>
                    </div>
                </div>
            </div>
            <img src="/images/faq/faq.png" alt="">
        </div>
        <div class="product_like_you">
            <h3>Вам может понравится</h3>
            <div class="catalog_grid">
            <?php foreach ($like as $likes): ?>
                <a class="catalog_product" href="/product?id=<?= $likes['id'] ?>">
                    <img src="<?= $likes['image'] ?>" alt="" class="catalog_product_image">
                    <div class="catalog_product_description">
                        <p class="regular_03"><?= $likes['name'] ?></p>
                        <p class="regular_03"><?= $likes['price'] ?> ₽</p>
                    </div>
                </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const item = button.parentElement;
            item.classList.toggle('active');
        });
    });
</script>