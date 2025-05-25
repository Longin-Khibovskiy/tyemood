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
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
    $category = $_GET['category'] ?? null;
    $safe_category = $category ? mysqli_real_escape_string($link, $category) : null;
    if ($safe_category) {
        $query = "SELECT p.* FROM products p 
                  JOIN main_categories mc ON p.main_categories_id = mc.id 
                  WHERE mc.anchor = '$safe_category' 
                  LIMIT $limit OFFSET $offset";
    } else {
        $query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
    }
    $result = $link->query($query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($products as $product):
        $isFavorite = in_array($product['id'], $favorite_ids);
        ?>
        <a class="catalog_product" href="/product?id=<?= $product['id'] ?>">
            <svg class="catalog_product_like favorite <?= $isFavorite ? 'active' : '' ?>"
                 data-product-id="<?= $product['id'] ?>"
                 width="32" height="32" viewBox="0 0 32 32" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M10.3333 4C6.836 4 4 7.19059 4 11.1252C4 19 16 28 16 28C16 28 28 19 28 11.1252C28 6.25035 25.164 4 21.6667 4C19.1867 4 17.04 5.60376 16 7.93882C14.96 5.60376 12.8133 4 10.3333 4Z"
                      fill="#F2F2F2"
                      stroke="#F2F2F2"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <img src="<?= $product['image'] ?>" alt="" class="catalog_product_image">
            <div class="catalog_product_description">
                <p class="regular_03"><?= $product['name'] ?></p>
                <p class="regular_03"><?= $product['price'] ?> ₽</p>
            </div>
        </a>
    <?php endforeach;
    exit;
}
?>

<?php
$category_filter = $_GET['category'] ?? null;
$sql = "SELECT * FROM main_categories WHERE anchor = '$category_filter'";
$res = $link->query($sql);
$anchor = $res->fetch_assoc();

$offset = 0;
$limit = 12;

if ($category_filter) {
    $safe_category = mysqli_real_escape_string($link, $category_filter);
    $query = "SELECT p.* FROM products p 
              JOIN main_categories mc ON p.main_categories_id = mc.id 
              WHERE mc.anchor = '$safe_category' 
              LIMIT $limit OFFSET $offset";
} else {
    $query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
}

$result = $link->query($query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<section class="catalog">
    <div class="catalog_container">
        <div class="catalog_path_container">
            <a href="/catalog" class="medium_02 catalog_path_text">Каталог /</a>
            <p class="medium_02 catalog_path_pink_text"><?= $anchor['name'] ?? 'Все товары' ?></p>
        </div>
        <?php if (count($products) === 0): ?>
            <h2 class="catalog_none">Товаров в данной категории пока нет</h2>
        <?php else: ?>
            <div class="catalog_grid">
                <?php
                foreach ($products as $product):
                    $isFavorite = in_array($product['id'], $favorite_ids);
                    ?>
                    <a class="catalog_product" href="/product?id=<?= $product['id'] ?>">
                        <svg class="catalog_product_like favorite <?= $isFavorite ? 'active' : '' ?>"
                             data-product-id="<?= $product['id'] ?>"
                             width="32" height="32" viewBox="0 0 32 32" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.3333 4C6.836 4 4 7.19059 4 11.1252C4 19 16 28 16 28C16 28 28 19 28 11.1252C28 6.25035 25.164 4 21.6667 4C19.1867 4 17.04 5.60376 16 7.93882C14.96 5.60376 12.8133 4 10.3333 4Z"
                                  fill="#F2F2F2"
                                  stroke="#F2F2F2"
                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <img src="<?= $product['image'] ?>" alt="" class="catalog_product_image">
                        <div class="catalog_product_description">
                            <p class="regular_03"><?= $product['name'] ?></p>
                            <p class="regular_03"><?= $product['price'] ?> ₽</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (count($products) === $limit): ?>
            <div class="catalog_button_container">
                <button class="button_20" id="loadMoreBtn"
                        data-category="<?= $category_filter ?? '' ?>">показать ещё
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    let offset = 12;
    const limit = 12;
    const button = document.getElementById('loadMoreBtn');
    const grid = document.querySelector('.catalog_grid');
    const category = button.dataset.category || '';

    button.addEventListener('click', () => {
        fetch(`/catalog?ajax=1&offset=${offset}&limit=${limit}&category=${category}`)
            .then(response => {
                console.log('Response:', response);
                return response.text();
            })
            .then(html => {
                console.log('HTML:', html);
                if (html.trim() === '') {
                    button.style.display = 'none';
                } else {
                    grid.insertAdjacentHTML('beforeend', html);
                    offset += limit;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });
</script>