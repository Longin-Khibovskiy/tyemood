<section class="catalog">
    <div class="catalog_container">
        <div class="catalog_path_container">
            <p class="medium_02 catalog_path_text">Каталог /</p>
            <p class="medium_02 catalog_path_pink_text">Все товары</p>
        </div>
        <div class="catalog_grid">
            <?php
            $result = $link->query('SELECT * FROM products');
            $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
            usort($arr, function () {
                return rand(-1, 1);
            });
            $rows = array_slice($arr, 0, 12);
            foreach ($rows as $row):
                ?>
                <div class="catalog_product">
                    <img src="<?= $row['image'] ?>" alt="" class="catalog_product_image">
                    <div class="catalog_product_description">
                        <p class="regular_03"><?= $row['name'] ?></p>
                        <p class="regular_03"><?= $row['price'] ?> ₽</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="catalog_button_container">
            <button class="button_20">показать ещё</button>
        </div>
    </div>
</section>