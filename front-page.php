<?php

/*
 * Template Name: Home Page Template
*/

remove_action('genesis_loop', 'genesis_do_loop', 10);
remove_action('genesis_before_content_sidebar_wrap', 'custom_do_breadcrumbs', 5);
add_action('genesis_loop', 'custom_homepage_content', 10);

function custom_homepage_content()
{

    $dynamic_posts_query = new WP_Query(array(
        'posts_per_page' => 15,
        'orderby' => 'rand',
        'order' => 'DESC',
    ));
    $dynamic_posts = $dynamic_posts_query->posts;


    $random_posts_query = new WP_Query(array(
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
    $random_posts = $random_posts_query->posts;
?>
    <div class="main-news mt-4">
        <div class="container">
            <?php
            get_template_part('lib/parts/last-and-dynamic-posts');
            fetchPostsByCategory('shëndetësi', 9, true, 'DESC', 'date');
            ?>
            <hr class="mt-4">
            <div class="random-posts p-3">
                <a href="<?= site_url(); ?>" class="m-auto " title="<?= get_bloginfo('name'); ?>">
                    <picture>
                        <img src="<?= CHILD_URL ?>/assets/app/img/zero-gjasht.webp" alt="<?= get_bloginfo('name'); ?>" title="<?= get_bloginfo('name'); ?>" width="250" height="90" class="mt-1 mb-3">
                    </picture>
                </a>
                <div class="row">
                    <?php foreach ($random_posts as $post): ?>
                        <a href="<?= get_permalink($post->ID); ?>" title="<?= $post->post_title; ?>" class="col-lg-3 mb-4">
                            <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="<?= $post->post_title; ?>" class="small-image">
                            <h2 class="small-title"><?= wp_trim_words($post->post_title, 15, '...') ?></h2>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php videoDisplay(); ?>
            <div class="ngjarje-te-ndryshme">
                <p class="title text-red">Ngjarje te ndryshme</p>
                <div class="swiper ngjarjeSlider frontpageSlider">
                    <div class="swiper-wrapper">
                        <?php foreach ($dynamic_posts as $post): ?>
                            <div class="swiper-slide">
                                <a href="<?= get_permalink($post->ID); ?>" title="<?= $post->post_title; ?>">
                                    <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="<?= $post->post_title; ?>">
                                    <h2><?= $post->post_title; ?></h2>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr>
            <?php fetchPostsByCategory('opinione', 9, true, 'DESC', 'date'); ?>
            <hr>
            <?php fetchPostsByCategory('sport', 9, true, 'DESC', 'date'); ?>
            <hr>
            <?php fetchPostsByCategory('moti', 9, true, 'DESC', 'date'); ?>
            <hr>
            <?php fetchPostsByCategory('kuriozitete', 9, false, 'DESC', 'date'); ?>
            <hr>
            <?php fetchPostsByCategory('showbiz', 9, true, 'DESC', 'date'); ?>
            <hr>
            <?php fetchPostsByCategory('marketing', 9, false, 'DESC', 'date'); ?>
            <hr>
        </div>
    </div>
<?php
    wp_reset_postdata();
}


genesis();
