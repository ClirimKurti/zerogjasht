<?php
$last_post_query = get_posts(array(
    'posts_per_page' => 1,
    'order' => 'DESC',
));

$dynamic_posts_query = get_posts(array(
    'posts_per_page' => 15,
    'oderby' => 'menu_order',
    'order' => 'DESC',
    'post__not_in' => array($last_post_query[0]->ID)
));
$title = get_field('pa_titull', $last_post_query['0']->ID);
if ($last_post_query): ?>
    <a class="<?php if (!$title): ?> row light-gray p-3 <?php endif; ?>" href="<?php echo get_permalink($last_post_query[0]->ID); ?>" title="<?php echo $last_post_query[0]->post_title; ?>">
        <?php if ($title): ?>
            <div class="col-lg-12">
                <img src="<?php echo get_the_post_thumbnail_url($last_post_query[0]->ID); ?>" alt="<?= $last_post_query[0]->post_title; ?>" style="100%; max-height: 400px; object-fit: cover" data-no-lazy>
            </div>
        <?php else: ?>
            <div class="col-lg-7">
                <img src="<?php echo get_the_post_thumbnail_url($last_post_query[0]->ID); ?>" alt="<?= $last_post_query[0]->post_title; ?>" style="100%; max-height: 300px; object-fit: cover" data-no-lazy>
            </div>
            <div class="col-lg-5">
                <h2 class="mt-3"><?php echo $last_post_query[0]->post_title; ?></h2>
            </div>
        <?php endif; ?>
    </a>
<?php endif; ?>
<div class="swiper mySwiper frontpageSlider">
    <p class="title text-red">Lajme te tjera</p>
    <div class="swiper-wrapper">
        <?php foreach ($dynamic_posts_query as $post): ?>
            <div class="swiper-slide">
                <a href="<?= get_permalink($post->ID); ?>" title="<?= $post->post_title; ?>">
                    <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="<?= $post->post_title; ?>" data-no-lazy>
                    <h2><?= $post->post_title; ?></h2>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>