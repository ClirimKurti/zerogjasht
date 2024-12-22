<?php

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_action('genesis_before_loop', 'wpb_change_home_loop');
remove_action('genesis_after_header', 'custom_inner_page_after_header', 10);
add_action('genesis_after_header', 'custom_release_header', 10);

function custom_release_header() {
    remove_entry_header_actions();
    $heading = get_internal_hero_heading(get_page_number()); ?>

    <div class="release-header archive">
        <div class="container">
            <h1><?=$heading;?></h1>
        </div>
    </div>

    <?php
}

function wpb_change_home_loop() {
    if ( is_archive() ) {
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        add_action( 'genesis_loop', 'wpb_custom_loop' );
        function wpb_custom_loop() {
            if ( have_posts() ) :
                do_action( 'genesis_before_while' );
                echo '<div class="releases"><div class="row mb-3">';
                while ( have_posts() ) : the_post();
                    do_action('genesis_before_entry');
                    $thumb = get_the_post_thumbnail_url('', 'medium');
                    if(!$thumb) {
                        $thumb = 'default-thumb.jpg';
                    } ?>
                    <div class="col-xl-3 col-sm-6 mb-4">
                        <a href="<?=get_the_permalink();?>" title="<?=get_the_title();?>" class="release">
                            <div class="release-thumb">
                                <?=do_shortcode('[image src="'.$thumb.'" alt="'.get_the_title().'" width="300" height="250" single="true"]');?>
                            </div>
                            <div class="release-meta">
                                <span><?php the_time('F j, Y'); ?></span>
                                <h2><?=get_the_title();?></h2>
                                <p><?=wp_trim_words( get_the_content(), 25, '...' );?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                    do_action( 'genesis_after_entry_content' );
                    do_action( 'genesis_entry_footer' );
                    do_action( 'genesis_after_entry' );
                endwhile;
                do_action( 'genesis_after_endwhile' );
                echo '</div></div>';
            else :
                do_action( 'genesis_loop_else' );
            endif;
        }
    }
}

genesis();