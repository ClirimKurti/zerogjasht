<?php

function sidebar_ads($atts = null)
{
    ob_start();
    $sidebar_ads = get_field('sidebar_ads', 'option');

    if ($sidebar_ads) : ?>
        <div>
            <?php foreach ($sidebar_ads as $ad) : ?>
                <?php if ($ad['url']) : ?>
                    <a href="<?php echo $ad['url']; ?>" target="_blank">
                        <img src="<?php echo $ad['image']['url']; ?>" alt="<?= bloginfo('name'); ?>" style="width: 100%; height: 270px; margin: 0 auto; display: block; object-fit: cover">
                    </a>
                <?php else : ?>
                    <img src="<?php echo $ad['image']['url']; ?>" alt="<?= bloginfo('name'); ?>" style="width: 100%; height: 270px; margin: 0 auto; display: block; object-fit: cover">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
<?php endif;

    // End output and return
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode('sidebar-ads', 'sidebar_ads');
