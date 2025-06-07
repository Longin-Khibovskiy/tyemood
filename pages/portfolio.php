<section class="portfolio">
    <div class="portfolio_cont">
        <div class="portfolio_main_cont">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <?php if ($i % 2): ?>
                    <div class="portfolio_row">
                        <img src="/images/portfolio/img_<?= ($i - 1) * 5 ?>.png" alt="" class="portfolio_main_img">
                        <div class="portfolio_row_right">
                            <?php for ($j = (($i - 1) * 5) + 1; $j <= ($i * 5) - 1; $j++): ?>
                                <img src="/images/portfolio/img_<?= $j ?>.png" alt="">
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="portfolio_row">
                        <div class="portfolio_row_right">
                            <?php for ($j = ($i - 1) * 5; $j <= (($i - 1) * 5) + 3; $j++): ?>
                                <img src="/images/portfolio/img_<?= $j ?>.png" alt="">
                            <?php endfor; ?>
                        </div>
                        <img src="/images/portfolio/img_<?= ($i * 5) - 1 ?>.png" alt="" class="portfolio_main_img">
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
            <div class="portfolio_button_container" style="display:none;">
                <button class="button_20">показать ещё</button>
            </div>
        </div>
    </div>
</section>