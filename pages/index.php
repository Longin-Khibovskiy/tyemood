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
?>
<section class="section_title_container">
    <div class="title_container">
        <div class="title_left_container">
            <h1>Ничего случайного — только стиль, ручная роспись и характер.</h1>
            <p class="medium_03 title_container_text">Одежда с характером и ручной росписью. <br>
                Минимум шаблонов — максимум самовыражения. Тай-дай, вышивка, декор — всё, что ты носишь, говорит за
                тебя.</p>
            <button class="button_20" onclick="location.href = '/catalog'">Посмотреть коллекцию</button>
        </div>
        <div class="title_right_container">
            <img src="/images/home/text_circle.png" alt="" class="text_circle">
            <img src="/images/home/rotate_img.png" alt="" width="300px">
            <p class="regular_03">Толстовка «Революция цвета»</p>
            <p class="price_semibold">3 500 ₽</p>
        </div>
    </div>
</section>

<section class="section_about_container">
    <div class="about_container">
        <div class="about_top_container">
            <img src="/images/home/about_top.png" alt="" class="about_top_img">
            <div class="about_text_container">
                <p class="medium_03">TyeMood — это творческая мастерская, где одежда рождается вручную, с характером и
                    душой. Мы не гонимся за трендами — мы создаём вещи, в которых видно тебя.</p>
                <p class="medium_03">Футболки, толстовки, носки и лонгсливы — каждое изделие мы расписываем вручную:
                    тай-дай, кисти, вышивка, декор, немного безумия и много любви. У нас не бывает двух одинаковых вещей
                    — и в этом весь смысл.</p>
            </div>
        </div>
        <div class="about_down_container">
            <div class="about_text_container">
                <p class="medium_03">Мы смело смешиваем цвета, техники и идеи, будто рисуем настроение прямо на
                    ткани.</p>
                <p class="medium_03">TyeMood — для тех, кто устал от однотипных полок и хочет носить не логотип, а
                    смысл. Твоя одежда может быть громкой, спокойной, странной или дерзкой — главное, чтобы она была
                    твоей.</p>
            </div>
            <img src="/images/home/about_down.png" alt="" class="about_down_img">
        </div>
    </div>
</section>

<section class="section_bestsellers_container">
    <div class="bestsellers_container">
        <h2>Bestsellers</h2>
        <h3>популярное</h3>
        <div class="bestsellers_products_container">
            <?php
            $result = $link->query('SELECT * FROM products WHERE additional_categories_id = 1');
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($rows as $row):
                    $isFavorite = in_array($row['id'], $favorite_ids);
                    ?>
            <a class="catalog_product" href="/product?id=<?= $row['id'] ?>">
                <svg class="catalog_product_like favorite <?= $isFavorite ? 'active' : '' ?>"
                     data-product-id="<?= $row['id'] ?>"
                     width="32" height="32" viewBox="0 0 32 32" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.3333 4C6.836 4 4 7.19059 4 11.1252C4 19 16 28 16 28C16 28 28 19 28 11.1252C28 6.25035 25.164 4 21.6667 4C19.1867 4 17.04 5.60376 16 7.93882C14.96 5.60376 12.8133 4 10.3333 4Z"
                          fill="#F2F2F2"
                          stroke="#F2F2F2"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <img src="<?= $row['image'] ?>" alt="" class="catalog_product_image">
                <div class="catalog_product_description">
                    <p class="regular_03"><?= $row['name'] ?></p>
                    <p class="regular_03"><?= $row['price'] ?> ₽</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="bestsllers_button_container">
            <button class="button_20" onclick="location.href = '/catalog'">Выбери свою вещь
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <g clip-path="url(#clip0_288_1181)">
                        <path d="M13.2781 8.3336C13.0788 8.32477 12.8797 8.3558 12.6924 8.42488C12.5052 8.49396 12.3335 8.59969 12.1876 8.73589C12.0416 8.87208 11.9242 9.036 11.8424 9.21802C11.7605 9.40004 11.7158 9.59651 11.7108 9.79592C11.7058 9.99532 11.7407 10.1936 11.8134 10.3793C11.8861 10.5649 11.9952 10.734 12.1342 10.8769C12.2732 11.0197 12.4394 11.1333 12.623 11.211C12.8066 11.2886 13.004 11.3289 13.2035 11.3293L27.6099 11.6703L8.69857 28.6982C8.40293 28.9644 8.22496 29.3369 8.20383 29.7339C8.18269 30.1308 8.32011 30.5196 8.58586 30.8147C8.85161 31.1099 9.22391 31.2872 9.62087 31.3076C10.0178 31.3281 10.4069 31.1901 10.7026 30.9239L29.6169 13.8933L28.4499 28.2622C28.4294 28.4606 28.4488 28.6611 28.5069 28.8518C28.565 29.0425 28.6606 29.2197 28.7881 29.3728C28.9156 29.526 29.0724 29.6522 29.2494 29.7439C29.4264 29.8356 29.62 29.891 29.8188 29.9069C30.0177 29.9228 30.2177 29.8989 30.4073 29.8365C30.5969 29.7741 30.7722 29.6745 30.9229 29.5436C31.0736 29.4127 31.1967 29.253 31.285 29.074C31.3733 28.895 31.4249 28.7002 31.437 28.5011L32.8664 10.9057C32.9019 10.4689 32.7929 10.0327 32.5561 9.6644C32.4466 9.47244 32.2959 9.30715 32.1149 9.1804C31.7759 8.91247 31.3589 8.76188 30.9265 8.75125L13.2781 8.3336Z"
                              fill="#F2F2F2"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_288_1181">
                            <rect width="40" height="40" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </button>
        </div>
    </div>
</section>

<section class="section_services_container">
    <div class="services_container" id="services">
        <h2>Наши возможности</h2>
        <h3>услуги</h3>
        <div class="services_grid_container">
            <div class="service_container">
                <div class="service_title_container">
                    <p class="medium_03">Кастом под тебя</p>
                    <p class="medium_03">(01)</p>
                </div>
                <p class="regular_04">Создадим вещь по твоим ощущениям. Цвет, форма, техника — всё подбирается
                    интуитивно вместе с тобой.</p>
            </div>
            <div class="service_container">
                <div class="service_title_container">
                    <p class="medium_03">Артовый апгрейд</p>
                    <p class="medium_03">(02)</p>
                </div>
                <p class="regular_04">Роспись, тай-дай, вышивка — вручную и в одном экземпляре. Придаём твоей вещи
                    характер или создаём новую с нуля.</p>
            </div>
            <div class="service_container">
                <div class="service_title_container">
                    <p class="medium_03">Фирменный мерч</p>
                    <p class="medium_03">(03)</p>
                </div>
                <p class="regular_04">Коллекции по духу. От лимитированной партии для проекта до фирменной формы, в
                    которой хочется творить.</p>
            </div>
            <div class="service_container">
                <div class="service_title_container">
                    <p class="medium_03">Коллаб-союзы</p>
                    <p class="medium_03">(04)</p>
                </div>
                <p class="regular_04">Открыты к смелым коллаборациям: от совместных коллекций до артов и
                    мероприятий.</p>
            </div>
        </div>
    </div>
</section>

<section class="section_categories_container">
    <div class="categories_container">
        <h2>Категории твоего стиля</h2>
        <div class="categories_grid">
            <?php
            $result = $link->query('SELECT * FROM main_categories');
            $rows = array_slice(mysqli_fetch_all($result, MYSQLI_ASSOC), 0, 5);
            foreach ($rows as $row):
                if ($row['name'] != 'Лонгсливы'):
                    ?>
                    <div class="category_container" style="background-image: url(<?= $row['image'] ?>);">
                        <p class="semibold_01"><?= $row['name'] ?></p>
                        <p class="regular_03"><?= $row['description'] ?></p>
                        <div class="category_svg_container">
                            <svg xmlns="http://www.w3.org/2000/svg" onclick="location.href = '<?= $row['link'] ?>'" width="40" height="40" viewBox="0 0 40 40"
                                 fill="none">
                                <g clip-path="url(#clip0_288_1146)">
                                    <path d="M13.2781 8.3336C13.0788 8.32477 12.8797 8.3558 12.6924 8.42488C12.5052 8.49396 12.3335 8.59969 12.1876 8.73589C12.0416 8.87208 11.9242 9.036 11.8424 9.21802C11.7605 9.40004 11.7158 9.59651 11.7108 9.79592C11.7058 9.99532 11.7407 10.1936 11.8134 10.3793C11.8861 10.5649 11.9952 10.734 12.1342 10.8769C12.2732 11.0197 12.4394 11.1333 12.623 11.211C12.8066 11.2886 13.004 11.3289 13.2035 11.3293L27.6099 11.6703L8.69857 28.6982C8.40293 28.9644 8.22496 29.3369 8.20383 29.7339C8.18269 30.1308 8.32011 30.5196 8.58586 30.8147C8.85161 31.1099 9.22391 31.2872 9.62087 31.3076C10.0178 31.3281 10.4069 31.1901 10.7026 30.9239L29.6169 13.8933L28.4499 28.2622C28.4294 28.4606 28.4488 28.6611 28.5069 28.8518C28.565 29.0425 28.6606 29.2197 28.7881 29.3728C28.9156 29.526 29.0724 29.6522 29.2494 29.7439C29.4264 29.8356 29.62 29.891 29.8188 29.9069C30.0177 29.9228 30.2177 29.8989 30.4073 29.8365C30.5969 29.7741 30.7722 29.6745 30.9229 29.5436C31.0736 29.4127 31.1967 29.253 31.285 29.074C31.3733 28.895 31.4249 28.7002 31.437 28.5011L32.8664 10.9057C32.9019 10.4689 32.7929 10.0327 32.5561 9.6644C32.4466 9.47244 32.2959 9.30715 32.1149 9.1804C31.7759 8.91247 31.3589 8.76188 30.9265 8.75125L13.2781 8.3336Z"
                                          fill="#2A2A2C"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_288_1146">
                                        <rect width="40" height="40" rx="20" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
    </div>
</section>

<section class="section_portfolio_container">
    <div class="portfolio_container">
        <h2>Портфолио — как журнал</h2>
        <h2>настроений в красках</h2>
        <div class="portfolio_main_container">
            <img src="/images/portfolio_video.png" alt="" class="portfolio_video">
            <div class="portfolio_right_container">
                <p class="medium_03">Загляни внутрь процесса, вдохновись формами и найди тот самый вайб, который
                    рождается из красок, ткани и интуиции.</p>
                <div class="portfolio_right_img_container">
                    <img src="/images/portfolio_img.png" alt="">
                    <svg width="81" height="80" viewBox="0 0 81 80" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="location.href = '/portfolio'">
                        <circle cx="40.5" cy="40" r="40" fill="#E70B87"/>
                        <g clip-path="url(#clip0_379_1047)">
                            <path d="M30.9277 22.0518C30.6211 22.0382 30.3148 22.0859 30.0267 22.1922C29.7386 22.2985 29.4746 22.4611 29.25 22.6707C29.0254 22.8802 28.8449 23.1324 28.7189 23.4124C28.593 23.6924 28.5242 23.9947 28.5165 24.3015C28.5089 24.6083 28.5626 24.9134 28.6744 25.1989C28.7863 25.4845 28.9541 25.7448 29.1679 25.9645C29.3818 26.1842 29.6375 26.3589 29.92 26.4785C30.2024 26.598 30.506 26.6599 30.8129 26.6606L52.9767 27.1852L23.8823 53.3819C23.4275 53.7915 23.1537 54.3646 23.1212 54.9752C23.0887 55.5859 23.3001 56.184 23.7089 56.6381C24.1178 57.0922 24.6905 57.365 25.3012 57.3964C25.9119 57.4279 26.5106 57.2156 26.9654 56.806L56.0644 30.6052L54.2689 52.7111C54.2375 53.0164 54.2673 53.3248 54.3567 53.6182C54.446 53.9116 54.5931 54.1842 54.7893 54.4198C54.9854 54.6555 55.2267 54.8496 55.499 54.9907C55.7713 55.1318 56.0691 55.217 56.375 55.2415C56.6809 55.266 56.9887 55.2291 57.2804 55.1332C57.5721 55.0372 57.8417 54.884 58.0736 54.6825C58.3055 54.4811 58.4948 54.2355 58.6306 53.9601C58.7664 53.6846 58.8459 53.385 58.8645 53.0787L61.0636 26.0088C61.1183 25.3368 60.9505 24.6658 60.5862 24.0992C60.4177 23.8038 60.186 23.5495 59.9074 23.3545C59.3858 22.9423 58.7443 22.7107 58.0791 22.6943L30.9277 22.0518Z"
                                  fill="#F2F2F2"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_379_1047">
                                <rect width="61.5385" height="61.5385" fill="white"
                                      transform="translate(10.5 9.23096)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section_idea_container">
    <div class="ideas_container" id="about">
        <h2>Идея, воплощённая в ткани</h2>
        <h3>преимущества</h3>
        <div class="idea_grid_container">
            <div class="idea_container">
                <p class="medium_03">(01)</p>
                <p class="medium_03 idea_text_center">Искренность</p>
                <p class="regular_04">Мы идём на ощупь, полагаясь на интуицию, играем с цветом и создаём с чистого
                    листа.</p>
            </div>
            <div class="idea_container">
                <p class="medium_03">(02)</p>
                <p class="medium_03 idea_text_center">Чувствующее</p>
                <p class="regular_04">Тай-дай, вышивка, роспись, всё вручную, всё с настроением и своей историей.</p>
            </div>
            <div class="idea_container">
                <p class="medium_03">(03)</p>
                <p class="medium_03 idea_text_center">Уникальность</p>
                <p class="regular_04">Ни одной копии, ни одного повтора — только ты, только твоё отражение в ткани.</p>
            </div>
            <div class="idea_container">
                <p class="medium_03">(04)</p>
                <p class="medium_03 idea_text_center">Вдохновение</p>
                <p class="regular_04">Создаём не одежду, а поле для самовыражения — честно и без лишнего.</p>
            </div>
        </div>
    </div>
</section>

<section class="section_contacts_container">
    <div class="contacts_container" id="contacts">
        <h2>Контакты для связи и вдохновения</h2>
        <div class="contact_container">
            <div class="contact_left_container">
                <p class="medium_03">Мы на связи в мессенджерах и по почте — пишите, если появились идеи или вопросы. А
                    если хочется живого общения, приходите в студию: обсудим дизайн, покажем ткани и вдохновимся
                    вместе.</p>
                <div class="contact_phone_and_email_container">
                    <div class="contact_phone_container">
                        <p class="semibold_03">Телефон:</p>
                        <p class="regular_03">+7 999 123-45-67</p>
                    </div>
                    <div class="contact_email_container">
                        <p class="semibold_03">Электронная почта:</p>
                        <p class="regular_03">hi@tyemood.ru</p>
                    </div>
                </div>
                <div class="contact_address_container">
                    <p class="semibold_03">Адрес студии:</p>
                    <p class="regular_03">г. Москва, м.Курская, арт-пространство на территории завода, ул. Большая
                        Почтовая, д. 28, стр. 1</p>
                </div>
            </div>
            <form class="contact_right_container" method="POST" action="/">
                <p class="medium_02">Форма для индивидуального запроса</p>
                <p class="regular_04">Хочешь создать свой уникальный дизайн или кастомизировать вещь по‑своему? Заполни
                    форму, и мы свяжемся с тобой для консультации</p>
                <input type="text" placeholder="Фамилия и Имя" class="regular_03">
                <input type="text" placeholder="+7 999 999-99-99" class="regular_03">
                <button class="button_18">Получить консультацию</button>
            </form>
        </div>
    </div>
</section>