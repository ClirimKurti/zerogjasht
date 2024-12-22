<?php

add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
remove_action('genesis_entry_header', 'genesis_post_info', 12);
remove_action('genesis_after_header', 'custom_inner_page_after_header', 10);
remove_action('genesis_entry_content', 'custom_do_thumbnail', 8);
add_action('genesis_after_header', 'custom_release_header', 10);

function custom_release_header() {
    remove_entry_header_actions();
    $thumb = get_the_post_thumbnail('', 'large');?>

    <div class="release-header">
        <div class="container">
            <div class="release-header-main">
                <div class="release-header-thumb">
                    <?=$thumb;?>
                </div>
                <div class="release-header-title">
                    <h1><?=get_the_title();?></h1>
                </div>
            </div>
        </div>
    </div>

    <?php
}

genesis();