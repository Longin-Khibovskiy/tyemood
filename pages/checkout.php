<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$guest_token = $_SESSION['guest_token'] ?? null;
$products_in_cart = [];

if ($guest_token) {
    $stmt = $link->prepare("
        SELECT 
            gc.product_id,
            gc.quantity,
            gc.size,
            p.id,
            p.name,
            p.image,
            p.price,
            cp.type,
            cp.composition
        FROM guest_cart gc
        JOIN products p ON gc.product_id = p.id
        LEFT JOIN characteristic_products cp ON cp.product_id = p.id
        WHERE gc.guest_token = ?
    ");
    $stmt->bind_param("s", $guest_token);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products_in_cart[] = [
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'name' => $row['name'],
            'image' => $row['image'],
            'price' => (int)$row['price'],
            'quantity' => (int)$row['quantity'],
            'size' => $row['size'],
            'type' => $row['type'] ?? 'Без типа',
            'composition' => $row['composition'] ?? 'Без состава',
        ];
    }
}
$summ = 0;
?>
<section class="checkout">
    <div class="checkout_container">
        <div class="checkout_return_to_basket">
            <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.9445 21.6614C11.0601 21.7713 11.1971 21.8579 11.3478 21.916C11.4984 21.9741 11.6595 22.0026 11.8217 21.9998C11.9839 21.997 12.1439 21.963 12.2923 21.8998C12.4407 21.8365 12.5745 21.7453 12.6859 21.6315C12.7973 21.5177 12.884 21.3836 12.9411 21.2369C12.9981 21.0903 13.0242 20.9342 13.0179 20.7777C13.0116 20.6213 12.973 20.4676 12.9044 20.3257C12.8358 20.1838 12.7385 20.0565 12.6183 19.9514L4.10498 12.1781L24.7813 12.1781C25.1045 12.1781 25.4145 12.0542 25.643 11.8335C25.8716 11.6129 26 11.3136 26 11.0016C26 10.6895 25.8716 10.3903 25.643 10.1696C25.4145 9.94895 25.1045 9.82499 24.7813 9.82499L4.10173 9.82499L12.6183 2.04859C12.7385 1.94346 12.8358 1.81622 12.9044 1.67433C12.973 1.53243 13.0116 1.37874 13.0179 1.22226C13.0242 1.06578 12.9981 0.90966 12.9411 0.763054C12.884 0.616447 12.7973 0.482302 12.6859 0.368483C12.5745 0.254663 12.4407 0.163456 12.2923 0.100214C12.1439 0.036972 11.9839 0.00296593 11.8217 0.000185013C11.6595 -0.00259399 11.4984 0.0259094 11.3478 0.0840263C11.1971 0.142143 11.0601 0.228704 10.9445 0.338634L0.515387 9.86107C0.256432 10.0974 0.0851415 10.4094 0.0278921 10.749C-0.0103638 10.9186 -0.00925383 11.0944 0.0311422 11.2636C0.0901871 11.5982 0.260107 11.9054 0.515387 12.1389L10.9445 21.6614Z"
                      fill="#95979D"/>
            </svg>
            <a href="/basket" class="medium_03">Вернуться к корзине</a>
        </div>
        <h2>Оформление заказа</h2>
        <div class="checkout_grid_container">
            <div class="checkout_left_container">
                <form action="" class="checkout_user_form">
                    <p class="semibold_01">Покупатель</p>
                    <input class="regular_03" type="text" placeholder="Фамилия и Имя">
                    <input class="regular_03" type="text" placeholder="+7 999 999-99-99">
                    <input class="regular_03" type="text" placeholder="E-mail">
                    <div class="checkout_user_politicka">
                        <div class="checkout_user_politicka_check">
                            <input type="checkbox" id="cbx2" style="display: none;">
                            <label for="cbx2" class="check">
                                <svg width="18px" height="18px" viewBox="0 0 18 18">
                                    <path d="M 1 9 L 1 9 c 0 -5 3 -8 8 -8 L 9 1 C 14 1 17 5 17 9 L 17 9 c 0 4 -4 8 -8 8 L 9 17 C 5 17 1 14 1 9 L 1 9 Z"></path>
                                    <polyline points="1 9 7 14 15 4"></polyline>
                                </svg>
                            </label>
                        </div>
                        <p class="regular_04">Я соглашаюсь с политикой конфиденциальности</p>
                    </div>
                </form>
                <form action="" class="checkout_address_form">
                    <p class="semibold_01">Адрес доставки</p>
                    <input class="regular_03" type="text" placeholder="Город">
                    <input class="regular_03" type="text" placeholder="Адрес">
                    <input class="regular_03" type="text" placeholder="Почтовый индекс">
                    <div class="checkout_user_politicka">
                        <div class="checkout_user_politicka_check">
                            <input type="checkbox" id="cbx3" style="display: none;">
                            <label for="cbx3" class="check3">
                                <svg width="18px" height="18px" viewBox="0 0 18 18">
                                    <path d="M 1 9 L 1 9 c 0 -5 3 -8 8 -8 L 9 1 C 14 1 17 5 17 9 L 17 9 c 0 4 -4 8 -8 8 L 9 17 C 5 17 1 14 1 9 L 1 9 Z"></path>
                                    <polyline points="1 9 7 14 15 4"></polyline>
                                </svg>
                            </label>
                        </div>
                        <p class="regular_04"> Заберу сам из студии</p>
                    </div>
                    <p class="regular_04">*Вы можете забрать заказ лично из нашей студии, как он будет готов. Мы заранее
                        сообщим о готовности. г.Москва, ул.Большая Почтовая,д.28, стр.1 (м. Курская)</p>
                </form>
                <div class="checkout_button_container">
                    <button type="submit" class="button_20" onclick="location.href = '/checkout'">оформить заказ
                    </button>
                </div>
                <p class="regular_04 checkout_none">*После оформления заказа вы получите всю необходимую информацию на
                    указанную электронную почту. <br>
                    Если у вас возникнут вопросы — вы всегда можете написать нам в директ в социальных сетях. Мы на
                    связи</p>
            </div>
            <div class="checkout_right_container">
                <?php foreach ($products_in_cart as $product):
                    $summ += $product['price'] * $product['quantity'] ?>
                    <div class="checkout_product_container" data-product-id="<?= $product['id'] ?>">
                        <img src="<?=$product['image']?>" alt="">
                        <div class="checkout_product_description">
                            <p class="bold_02"><?=$product['name']?></p>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Тип окрашивания:</p>
                                <p class="regular_03"><?=$product['type']?></p>
                            </div>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Состав:</p>
                                <p class="regular_03"><?=$product['composition']?></p>
                            </div>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Размер:</p>
                                <p class="regular_03"><?=$product['size']?></p>
                            </div>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Количество:</p>
                                <p class="regular_03"><?=$product['quantity']?></p>
                            </div>
                            <div class="checkout_product_price_container">
                                <p class="price_semibold"><?=$product['price'] * $product['quantity']?> ₽</p>
                                <p class="regular_04 checkout_delete_product" data-product-id="<?= $product['id'] ?>" data-size="<?= $product['size'] ?>">Удалить товар</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="checkout_product_summ">
                    <p class="semibold_01">Сумма</p>
                    <p class="price_semibold"><?= $summ ?> ₽</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".checkout_delete_product").forEach(svg => {
            svg.addEventListener("click", (e) => {
                e.stopPropagation();
                const productId = svg.dataset.productId;
                const size = svg.closest(".checkout_product_container").querySelector(".checkout_delete_product")?.dataset.size || "Без размера";

                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({
                        action: "delete_from_cart",
                        product_id: productId,
                        size: size
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            svg.closest(".checkout_product_container").remove();
                            location.reload();
                        }
                    });
            });
        });
    });
</script>
