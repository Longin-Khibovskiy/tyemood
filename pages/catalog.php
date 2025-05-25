<?php
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
    $category = $_GET['category'] ?? null;

    if ($category) {
        $safe_category = mysqli_real_escape_string($link, $category);
        $query = "SELECT p.* FROM products p 
                  JOIN main_categories mc ON p.main_categories_id = mc.id 
                  WHERE mc.anchor = '$safe_category' 
                  LIMIT $limit OFFSET $offset";
    } else {
        $query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
    }

    $result = $link->query($query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($products as $product): ?>
        <a class="catalog_product" href="/product?id=<?= $product['id'] ?>">
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

        <div class="catalog_grid">
            <?php foreach ($products as $product): ?>
                <a class="catalog_product" href="/product?id=<?= $product['id'] ?>">
                    <img src="<?= $product['image'] ?>" alt="" class="catalog_product_image">
                    <div class="catalog_product_description">
                        <p class="regular_03"><?= $product['name'] ?></p>
                        <p class="regular_03"><?= $product['price'] ?> ₽</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="catalog_button_container">
            <button class="button_20" id="loadMoreBtn"
                    data-category="<?=$category_filter ?? '', ENT_QUOTES, 'UTF-8' ?>">показать ещё
            </button>
        </div>
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