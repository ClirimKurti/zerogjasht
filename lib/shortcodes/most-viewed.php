<?php

function most_viewed_shortcode($atts = null)
{
    ob_start();
?>
    <?php

    $most_clicked_query = new WP_Query(array(
        'post_type'      => 'post',
        'meta_key'       => 'post_clicks',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'posts_per_page' => 5,
    ));

    $latest_posts_query = new WP_Query(array(
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => 5,
    ));

    $image = get_field('sidebar_reklam_2', 'option');
    $url = get_field('sidebar_reklam_2_url', 'option');
    ?>
    <?php if ($image && $url): ?>
        <a href="<?= esc_url($url); ?>">
            <img src="<?php echo $image['url']; ?>" class="sidebar-reklam" alt="reklama">
        </a>
    <?php elseif ($image): ?>
        <img src="<?php echo $image['url']; ?>" class="sidebar-reklam" alt="reklama">
    <?php endif; ?>
    <div class="tabs">
        <ul class="tabs__links">
            <li class="tabs__link-item tabs__link-item--active">
                <span class="tabs__link">MË TË SHIKUARAT</span>
            </li>
            <li class="tabs__link-item">
                <span class="tabs__link">TË FUNDIT</span>
            </li>
        </ul>

        <div class="tabs__content">
            <div id="most-clicked" class="tabs__tab tabs__tab--active">
                <ul class="tabs__list">
                    <?php if ($most_clicked_query->have_posts()) : ?>
                        <?php while ($most_clicked_query->have_posts()) : $most_clicked_query->the_post(); ?>
                            <li class="tabs__list-item">
                                <a href="<?php the_permalink(); ?>" class="tabs__list-link">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'tabs__thumbnail']); ?>
                                    <h4 class="tabs__title small-title"><?php echo wp_trim_words(get_the_title(), 10, '...') ?></h4>
                                </a>
                            </li>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p class="tabs__message">Ska postime të shikuara.</p>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="latest" class="tabs__tab">
                <ul class="tabs__list">
                    <?php if ($latest_posts_query->have_posts()) : ?>
                        <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
                            <li class="tabs__list-item">
                                <a href="<?php the_permalink(); ?>" class="tabs__list-link">
                                    <?php the_post_thumbnail('large', ['class' => 'tabs__thumbnail']); ?>
                                    <h4 class="tabs__title small-title"><?php echo wp_trim_words(get_the_title(), 10, '...') ?></h4>
                                </a>
                            </li>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p class="tabs__message">Ska postime të fundit.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
  
<?php

    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}

add_shortcode('most-viewed', 'most_viewed_shortcode');
