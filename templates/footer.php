<footer>
    <div class="footer_container">
        <div class="footer_left_container">
            <div class="footer_left_politicka_container">
                <p class="regular_04">© 2025. TyeMood</p>
                <p class="regular_04">Политика конфиденциальности</p>
            </div>
            <p class="regular_04 footer_left_text">Хочешь создать свой уникальный дизайн или кастомизировать вещь
                по‑своему? Заполни форму, и мы свяжемся с тобой для консультации</p>
            <a class="footer_consultation_container" href="/">
                <p class="navigation_semibold">Получить консультацию</p>
                <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.32391 0.425432C3.1844 0.416572 3.04553 0.435714 2.91547 0.481733C2.7854 0.527752 2.66674 0.599722 2.56645 0.693427C2.46616 0.787132 2.38625 0.900684 2.33141 1.02743C2.27656 1.15417 2.24789 1.29156 2.24708 1.43153C2.24626 1.5715 2.27331 1.71125 2.32664 1.84257C2.37997 1.9739 2.45851 2.09416 2.55766 2.19631C2.65681 2.29846 2.77456 2.38044 2.90403 2.43745C3.03349 2.49446 3.17206 2.52535 3.31161 2.5283L13.3934 2.95969L0.391813 14.6663C0.188561 14.8494 0.0690388 15.1086 0.0595401 15.3871C0.0500429 15.6656 0.151347 15.9404 0.341166 16.1513C0.530985 16.3621 0.793769 16.4916 1.07171 16.5112C1.34965 16.5309 1.61999 16.4391 1.82324 16.2561L14.8268 4.54761L14.2019 14.6232C14.1903 14.7623 14.2065 14.9033 14.2497 15.038C14.2928 15.1728 14.362 15.2984 14.4533 15.4077C14.5445 15.517 14.6559 15.6077 14.7809 15.6745C14.9059 15.7412 15.0421 15.7827 15.1814 15.7965C15.3207 15.8104 15.4603 15.7962 15.5921 15.7549C15.7239 15.7136 15.8452 15.646 15.9488 15.5561C16.0525 15.4661 16.1365 15.3556 16.1959 15.2311C16.2552 15.1065 16.2888 14.9704 16.2945 14.8308L17.06 2.4927C17.0791 2.1864 16.997 1.87864 16.8265 1.61681C16.7473 1.48054 16.6397 1.36246 16.5114 1.27103C16.2707 1.07835 15.977 0.967035 15.6744 0.95381L3.32391 0.425432Z"
                          fill="#2A2A2C"/>
                </svg>
            </a>
        </div>
        <div class="footer_right_container">
            <div class="footer_right_catalog_container">
                <p class="regular_04">( КАТАЛОГ )</p>
                <div class="footer_right_catalog">
                    <?php
                    $result = $link->query('SELECT * FROM main_categories');
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($rows as $row):
                        ?>
                        <a href="/" class="regular_04"><?= $row['name'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="footer_right_address_container">
                <p class="regular_04">( АДРЕС )</p>
                <p class="regular_04">г.Москва, ул.Большая Почтовая,д.28, стр.1</p>
            </div>
            <div class="footer_right_contacts_container">
                <p class="regular_04">( КОНТАКТЫ )</p>
                <div class="footer_right_contacts">
                    <p class="regular_04">+7 999 123-45-67</p>
                    <p class="regular_04">hi@tyemood.ru</p>
                </div>
            </div>
            <div class="footer_right_social_container">
                <p class="regular_04">( СОЦ.СЕТИ )</p>
                <div class="footer_right_social">
                    <a href="" class="regular_04">INSTAGRAM</a>
                    <a href="" class="regular_04">TELEGRAM</a>
                    <a href="" class="regular_04">WHATSAPP</a>
                    <a href="" class="regular_04">PINTEREST</a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>