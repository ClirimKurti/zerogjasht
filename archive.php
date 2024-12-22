<?php

add_action('genesis_before_loop', 'wpb_change_home_loop');
remove_action('genesis_after_header', 'custom_inner_page_after_header', 10);
add_action('genesis_after_header', 'custom_release_header', 10);

function custom_release_header()
{
    remove_entry_header_actions();
    $heading = get_internal_hero_heading(get_page_number()); ?>

    <div class="release-header archive">
        <div class="container">
            <h1 class="my-1 my-xl-3 title-single"><?= $heading; ?></h1>
        </div>
    </div>

    <?php
}

function wpb_change_home_loop()
{
    if (is_archive()) {
        remove_action('genesis_loop', 'genesis_do_loop');
        add_action('genesis_loop', 'wpb_custom_loop');
        function wpb_custom_loop()
        {
            $index = 0;
            if (have_posts()) :
                do_action('genesis_before_while');
                echo '<div class="releases "><div class="row mb-3">';
                while (have_posts()) : the_post();
                    do_action('genesis_before_entry');
                    $thumb = get_the_post_thumbnail_url('', 'medium');
                    if (!$thumb) {
                        $thumb = 'default-thumb.jpg';
                    }
                    $index++;
                    if ($index == 1) {
    ?>
                        <div class="category-1 mt-4">
                            <div class="category-1-feature">
                                <a class="row light-gray p-3" href="<?= get_the_permalink(); ?>">
                                    <div class="col-lg-6">
                                        <img src="<?= esc_url(get_the_post_thumbnail_url()); ?>" alt="<?= esc_attr(get_the_title()); ?>" width="100%">
                                    </div>
                                    <div class="col-lg-6">
                                        <h2><?= esc_html(get_the_title()); ?></h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    } else {
                        $categories = get_the_category();
                    ?>
                        <div class="col-xl-3 col-sm-6 mb-4 mt-3">
                            <a href="<?= get_the_permalink(); ?>" title="<?= get_the_title(); ?>" class="release">
                                <img src="<?= $thumb; ?>" alt="" class="small-image">
                                <div class="release-meta text-center">
                                    <h3 class="text-black small-title"><?= get_the_title(); ?></h3>
                                </div>
                            </a>
                        </div>
<?php }
                    do_action('genesis_after_entry_content');
                    do_action('genesis_entry_footer');
                    do_action('genesis_after_entry');
                endwhile;
                do_action('genesis_after_endwhile');
                echo '</div></div>';
            else :
                do_action('genesis_loop_else');
            endif;
        }
    }
}

genesis();
