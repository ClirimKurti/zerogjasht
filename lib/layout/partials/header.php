<?php

add_action('genesis_header', 'custom_do_header', 1);

function custom_do_header()
{
    remove_action('genesis_header', 'genesis_header_markup_open', 5);
    remove_action('genesis_header', 'genesis_do_header', 10);
    remove_action('genesis_header', 'custom_remove_nav', 12);
    remove_action('genesis_header', 'genesis_header_markup_close', 15);
    remove_action('genesis_after_header', 'genesis_do_nav', 10);
    remove_action('genesis_after_header', 'genesis_do_subnav', 10);
    global $hc_settings;

    setlocale(LC_TIME, 'sq_AL.UTF-8');

    $formatter = new IntlDateFormatter(
        'sq_AL',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE
    );
    $timestamp = time();
    $formattedDate = $formatter->format($timestamp);

    $time = explode(',', $formattedDate);

    $header_ads = get_field('header_ads', 'option');
?>

    <header class="header<?= wp_is_mobile() ? ' header-mobile' : '' ?>">
        <div class="header-main-wrap">
            <div class="container">
                <div class="header-main">
                    <div class="today-date d-none d-lg-block">
                        <span class="font-oswald text-red mb-0" style="text-transform: uppercase;"><?= $time[0]; ?></span>
                        <p class="font-oswald mt-0" style="text-transform: capitalize;">
                            <?= $time[1]; ?>
                        </p>
                        <div class="social-share">
                            <a class="social-share-facebook" href="https://www.facebook.com/zerogjashtt" title="Facebook" target="_blank"><?= do_shortcode('[icon name="facebook"]'); ?></a>
                            <a class="social-share-instagram" href="https://www.instagram.com/zerogjashtcom/" title="Instagram" target="_blank"><?= do_shortcode('[icon name="instagram"]'); ?></a>
                            <a class="social-share-youtube" href="https://www.youtube.com/channel/UCXk0OMTrxnYK2AM9p3cqfVA" title="Youtube" target="_blank"><?= do_shortcode('[icon name="youtube "]'); ?></a>
                        </div>
                    </div>
                    <a href="<?= site_url(); ?>" class="header-logotype mx-xl-auto" title="<?= get_bloginfo('name'); ?>">
                        <picture>
                            <img src="<?= CHILD_URL ?>/assets/app/img/zero-gjasht.webp" alt="<?= get_bloginfo('name'); ?>" title="<?= get_bloginfo('name'); ?>" width="250" height="90">
                        </picture>
                    </a>
                    <button type="button" name="Menu" aria-label="Menu" title="Menu" class="burger">
                        <svg class="burger-svg" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="burger-icon" d="M10 15L40 15M10 25L40 25M10 35L40 35" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="burger-close" d="M15 15L35 35M35 15L15 35" stroke="transparent" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <?php if (!wp_is_mobile()) : ?>
                        <?php
                        $kush_ishte = get_field('kush_ishte', 'option');
                        if ($kush_ishte) {
                            $emri = get_field('emri_dhe_mbiemri', 'option');
                        }
                        if ($kush_ishte) {
                        ?>
                            <a href="<?= get_the_permalink($kush_ishte[0]->ID); ?>" class="biografi">
                                <div class="biografi-img">
                                    <img src="<?= get_the_post_thumbnail_url($kush_ishte[0]->ID, 'full'); ?>" alt="">
                                </div>
                                <div class="biografi-content">
                                    <p>Kush ishte?</p>
                                    <p class="small-title"><?= $emri; ?></h2>
                                </div>
                            </a>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="header-nav light-gray">
            <div class="container">
                <div class="header-menu">
                    <?php wp_nav_menu([
                        'menu' => 'Primary Menu',
                        'container_class' => 'genesis-nav-menu'
                    ]); ?>
                </div>
            </div>
        </div>
    </header>

<?php
}
