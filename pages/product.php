<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$favorite_ids = [];
$sql = "SELECT product_id FROM guest_favorites WHERE guest_token = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $_SESSION['guest_token']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $favorite_ids[] = $row['product_id'];
}

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    echo "Товар не найден.";
    exit;
}

$query = "SELECT p.*, mc.name as category_name 
          FROM products p
          JOIN main_categories mc ON p.main_categories_id = mc.id
          WHERE p.id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Товар не найден.";
    exit;
}

$selected_size = null;
$cart_quantity = 0;

$stmt = $link->prepare("SELECT size, quantity FROM guest_cart WHERE guest_token = ? AND product_id = ?");
$stmt->bind_param("si", $_SESSION['guest_token'], $product_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $selected_size = $row['size'];
    $cart_quantity = $row['quantity'];
}

$result_char = $link->query("SELECT * FROM characteristic_products WHERE product_id = $product_id");
$char = $result_char->fetch_assoc();

$result_like = $link->query("SELECT * FROM products WHERE additional_categories_id = 2");
$like = mysqli_fetch_all($result_like, MYSQLI_ASSOC);
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
                                    $size = htmlspecialchars(trim($size));
                                    echo '<button type="button" class="regular_03 product_size">' . $size . '</button>';
                                }
                            } else {
                                echo '<p class="regular_03">Нет размеров</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="product_basket_like">
                    <?php if ($cart_quantity > 0): ?>
                        <button id="addToCart" class="button_18 product_basket" style="display: none;">Добавить в корзину</button>
                        <button id="cartActions" class="button_18 product_basket active" style="display: flex;">
                            <p class="product_basket_minus">–</p>
                            <p class="product_basket_count"><?= $cart_quantity ?></p>
                            <p class="product_basket_plus">+</p>
                        </button>
                    <?php else: ?>
                        <button id="addToCart" class="button_18 product_basket" style="display: block;">Добавить в корзину</button>
                        <button id="cartActions" class="button_18 product_basket active" style="display: none;">
                            <p class="product_basket_minus">–</p>
                            <p class="product_basket_count">1</p>
                            <p class="product_basket_plus">+</p>
                        </button>
                    <?php endif; ?>
                    <svg class="product_like favorite <?= in_array($product['id'], $favorite_ids) ? 'active' : '' ?>"
                         data-product-id="<?= $product['id'] ?>"
                         xmlns="http://www.w3.org/2000/svg" width="32" height="32"
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
                            <p class="medium_03"><?= htmlspecialchars($desc) ?></p>
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
            <h3>Вам может понравиться</h3>
            <div class="catalog_grid">
                <?php foreach ($like as $likes):
                    $isFavorite = in_array($likes['id'], $favorite_ids);
                    ?>
                    <a class="catalog_product" href="/product?id=<?= $likes['id'] ?>">
                        <svg class="catalog_product_like favorite <?= $isFavorite ? 'active' : '' ?>"
                             data-product-id="<?= $likes['id'] ?>" width="32" height="32"
                             viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.3333 4C6.836 4 4 7.19059 4 11.1252C4 19 16 28 16 28C16 28 28 19 28 11.1252C28 6.25035 25.164 4 21.6667 4C19.1867 4 17.04 5.60376 16 7.93882C14.96 5.60376 12.8133 4 10.3333 4Z"
                                  fill="#F2F2F2"
                                  stroke="#F2F2F2"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
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
    document.addEventListener("DOMContentLoaded", () => {
        let selectedSize = null;
        const addBtn = document.getElementById("addToCart");
        const activeBtn = document.getElementById("cartActions");

        const serverSelectedSize = "<?= $selected_size ?>";
        if (serverSelectedSize) {
            document.querySelectorAll(".product_size").forEach(s => {
                if (s.textContent.trim() === serverSelectedSize) {
                    s.classList.add("selected-size");
                    selectedSize = serverSelectedSize;
                }
            });
        }

        document.querySelectorAll(".product_size").forEach(size => {
            size.addEventListener("click", () => {
                document.querySelectorAll(".product_size").forEach(s => s.classList.remove("selected-size"));
                size.classList.add("selected-size");
                selectedSize = size.textContent.trim();
            });
        });

        if (addBtn) {
            addBtn.addEventListener("click", () => {
                if (!selectedSize) {
                    alert("Пожалуйста, выберите размер.");
                    return;
                }

                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "add",
                        product_id: <?= $product['id'] ?>,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            addBtn.style.display = "none";
                            activeBtn.querySelector(".product_basket_count").textContent = "1";
                            activeBtn.style.display = "flex";
                            activeBtn.classList.add("active");
                        } else {
                            alert("Ошибка добавления в корзину.");
                        }
                    });
            });
        }

        if (activeBtn) {
            activeBtn.querySelector(".product_basket_plus").addEventListener("click", () => {
                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "plus",
                        product_id: <?= $product['id'] ?>,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            activeBtn.querySelector(".product_basket_count").textContent = data.count;
                        }
                    });
            });

            activeBtn.querySelector(".product_basket_minus").addEventListener("click", () => {
                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "minus",
                        product_id: <?= $product['id'] ?>,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.count === 0) {
                                activeBtn.classList.remove("active");
                                activeBtn.style.display = "none";
                                addBtn.style.display = "block";
                            } else {
                                activeBtn.querySelector(".product_basket_count").textContent = data.count;
                            }
                        }
                    });
            });
        }
    });
</script>