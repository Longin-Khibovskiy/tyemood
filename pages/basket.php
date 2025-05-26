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

$sql = 'SELECT * FROM products';
$result = mysqli_query($link, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

$summ = 0;
?>
<section class="basket">
    <div class="baskets_container">
        <h3>Избранное</h3>
        <hr>
        <?php
        $stmt = $link->prepare("
    SELECT 
        gc.product_id,
        gc.quantity,
        gc.size,
        p.* FROM guest_cart gc JOIN products p ON gc.product_id = p.id WHERE gc.guest_token = ?
");
        $stmt->bind_param("s", $guest_token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            echo "<p>Ваша корзина пуста.</p>";
        } else {
            echo "<div class='cart_items'>";
            while ($product = $result->fetch_assoc()):
                $prod_id = $product['id'];
                $sql = $link->query("SELECT * FROM characteristic_products WHERE product_id = $prod_id");
                $row = $sql->fetch_assoc();
                $cart_quantity = 0;
                $selected_size = null;

                $stmt = $link->prepare("SELECT quantity, size FROM guest_cart WHERE guest_token = ? AND product_id = ?");
                $stmt->bind_param("si", $_SESSION['guest_token'], $product['id']);
                $stmt->execute();
                $cart_result = $stmt->get_result();
                if ($cart = $cart_result->fetch_assoc()) {
                    $cart_quantity = $cart['quantity'];
                    $selected_size = $cart['size'];
                }
                $summ += $product['price'] * $cart_quantity;
                ?>
                <div class="favorite_container" data-product-id="<?= $product['id'] ?>">
                    <img src="<?= $product['image'] ?>" alt="" class="favorite_img">
                    <div class="favorite_description_container">
                        <p class="bold_02">Футболка из органического хлопка с вышевкой</p>
                        <div class="favorite_description">
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Тип окрашивания:</p>
                                <p class="regular_03"><?= $row['type'] ?? 'Без типа'; ?></p>
                            </div>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Состав:</p>
                                <p class="regular_03"><?= $row['composition'] ?? 'Без состава'; ?></p>
                            </div>
                            <div class="product_characteristics_main">
                                <p class="semibold_03">Размер:</p>
                                <p class="regular_03"><?= $selected_size ?></p>
                            </div>
                        </div>
                        <div class="favorite_cart_container">
                            <?php if ($cart_quantity > 0): ?>
                                <button class="button_18 product_basket" style="display: none;"
                                        data-product-id="<?= $product['id'] ?>">Добавить в корзину
                                </button>
                                <button class="button_18 product_basket active cartActions" style="display: flex;"
                                        data-product-id="<?= $product['id'] ?>" data-size="<?= $selected_size ?>">
                                    <p class="product_basket_minus">–</p>
                                    <p class="product_basket_count"><?= $cart_quantity ?></p>
                                    <p class="product_basket_plus">+</p>
                                </button>
                            <?php else: ?>
                                <button class="button_18 product_basket" style="display: block;"
                                        data-product-id="<?= $product['id'] ?>">Добавить в корзину
                                </button>
                                <button class="button_18 product_basket active cartActions" style="display: none;"
                                        data-product-id="<?= $product['id'] ?>" data-size="">
                                    <p class="product_basket_minus">–</p>
                                    <p class="product_basket_count">1</p>
                                    <p class="product_basket_plus">+</p>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="favorite_right_container">
                        <svg class="favorite <?= $isFavorite ? 'active' : '' ?>"
                             data-product-id="<?= $product['id'] ?>" onclick="location.reload()" width="28" height="28"
                             viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.31062 9.14458C9.45371 9.00641 9.64582 8.93073 9.8447 8.9342C10.0436 8.93767 10.2329 9.02001 10.3711 9.16309L14.0181 12.9396L17.7946 9.29267C17.9377 9.15449 18.1298 9.07882 18.3287 9.08229C18.5276 9.08576 18.7169 9.1681 18.8551 9.31118C18.9933 9.45427 19.069 9.64638 19.0655 9.84526C19.062 10.0441 18.9797 10.2335 18.8366 10.3717L15.0601 14.0186L18.707 17.7952C18.8452 17.9383 18.9209 18.1304 18.9174 18.3293C18.9139 18.5281 18.8316 18.7175 18.6885 18.8557C18.5454 18.9938 18.3533 19.0695 18.1544 19.0661C17.9555 19.0626 17.7662 18.9802 17.628 18.8372L13.9811 15.0606L10.2045 18.7076C10.0614 18.8458 9.86932 18.9214 9.67044 18.918C9.47156 18.9145 9.2822 18.8322 9.14402 18.6891C9.00585 18.546 8.93017 18.3539 8.93364 18.155C8.93711 17.9561 9.01945 17.7667 9.16253 17.6286L12.9391 13.9816L9.29211 10.2051C9.15393 10.062 9.07826 9.86988 9.08173 9.671C9.0852 9.47212 9.16754 9.28276 9.31062 9.14458Z"
                                  fill="#95979D"/>
                            <circle cx="14" cy="14" r="13.5" stroke="#95979D"/>
                        </svg>
                        <p class="price_semibold"><?= $product['price'] * $cart_quantity ?> ₽</p>
                    </div>
                </div>
            <?php endwhile;
        } ?>
        <hr class="basket_summ_hr">
        <div class="basket_summ_container">
            <p class="semibold_01">Сумма:</p>
            <p class="price_semibold"><?= $summ ?> ₽</p>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".product_basket_plus, .product_basket_minus, .favorite").forEach(el => {
            el.addEventListener("click", (e) => e.stopPropagation());
        });

        document.querySelectorAll(".favorite_container").forEach(container => {
            container.addEventListener("click", () => {
                const productId = container.dataset.productId;
                window.location.href = `/product?id=${productId}`;
            });
        });

        document.querySelectorAll(".product_basket").forEach(button => {
            const productId = button.dataset.productId;

            button.addEventListener("click", (e) => {
                e.stopPropagation();
                const cartWrapper = button.parentElement;
                const cartActions = cartWrapper.querySelector(".cartActions");
                const addBtn = cartWrapper.querySelector(".product_basket:not(.active)");
                const selectedSize = cartActions.dataset.size || "Без размера";

                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({
                        action: "add",
                        product_id: productId,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            addBtn.style.display = "none";
                            cartActions.querySelector(".product_basket_count").textContent = "1";
                            cartActions.style.display = "flex";
                            cartActions.classList.add("active");
                        } else {
                            alert("Ошибка добавления в корзину.");
                        }
                    });
            });
        });

        document.querySelectorAll(".cartActions").forEach(container => {
            const productId = container.dataset.productId;
            const selectedSize = container.dataset.size || "Без размера";

            container.querySelector(".product_basket_plus").addEventListener("click", (e) => {
                e.stopPropagation();
                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({
                        action: "plus",
                        product_id: productId,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            container.querySelector(".product_basket_count").textContent = data.count;
                        }
                    });
            });

            container.querySelector(".product_basket_minus").addEventListener("click", (e) => {
                e.stopPropagation();
                fetch("/pages/update_cart.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({
                        action: "minus",
                        product_id: productId,
                        size: selectedSize
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.count === 0) {
                                container.classList.remove("active");
                                container.style.display = "none";
                                container.parentElement.querySelector(".product_basket:not(.active)").style.display = "block";
                            } else {
                                container.querySelector(".product_basket_count").textContent = data.count;
                            }
                        }
                    });
            });
        });

        document.querySelectorAll(".favorite").forEach(svg => {
            svg.addEventListener("click", (e) => {
                e.stopPropagation();
                const productId = svg.dataset.productId;
                const size = svg.closest(".favorite_container").querySelector(".cartActions")?.dataset.size || "Без размера";

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
                            svg.closest(".favorite_container").remove();
                        }
                    });
            });
        });
    });
</script>

