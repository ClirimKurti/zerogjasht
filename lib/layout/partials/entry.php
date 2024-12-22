<?php

//* Customize the post info function
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
    global $post;

    if ( !is_single() && !is_page() ) {

        $cat_list = get_the_category_list(', ');

        if(!trim($cat_list)) {
            $q_obj = get_queried_object();
            $tax_name = !empty($q_obj->taxonomy) ? $q_obj->taxonomy : (!empty($q_obj->taxonomies) ? current($q_obj->taxonomies) : '');
            if($tax_name) {
                $cat_list = get_the_term_list($post->ID, $tax_name, '', ', ');
            }
        }

        if($cat_list) {
            $cat_list = " Category: " . $cat_list;
        }

        $post_info = 'Posted on: [post_date].' . $cat_list;
        return $post_info;
    }

    if(is_single()) {
        $post_info = 'Posted on: [post_date]';
        return $post_info;
    }
}

function custom_remove_post_meta() {
    remove_action('genesis_entry_footer', 'genesis_entry_footer_markup_open', 5);
    remove_action('genesis_entry_footer', 'genesis_post_meta', 10);
    remove_action('genesis_entry_footer', 'genesis_entry_footer_markup_close', 15);
}

add_action('genesis_before_entry', 'custom_remove_post_meta', 5);


//replace default thumbnail
function custom_do_thumbnail(){
    the_post_thumbnail('medium');
}

add_action('genesis_entry_content', 'custom_do_thumbnail', 8);

/**
 * Replaces the excerpt "more" text
 */
if ( ! function_exists( 'dyad_excerpt_continue_reading' ) ) {
    function dyad_excerpt_continue_reading() {

        // to disable read more link:
        return " ...";

        // to enable read more link:
        //return ' ... <a href="' . esc_url( get_permalink() ) . '">' . sprintf( esc_html__( 'Read More', 'dyad' ), '<span class="screen-reader-text"> "' . get_the_title() . '"</span>' ) . '</a>';
    }
}

add_filter( 'excerpt_more', 'dyad_excerpt_continue_reading' );

function custom_do_post_excerpt(){
    return the_excerpt();
}

//show excerpts on archive templates, remove default thumbnails
add_action('genesis_before', function(){
    if(!is_single() && !is_page()) {

        remove_action('genesis_entry_content', 'genesis_do_post_image', 8);
        remove_action('genesis_entry_content', 'genesis_do_singular_image', 8);

        remove_action('genesis_entry_content', 'genesis_do_post_content', 10);
        add_action('genesis_entry_content', 'custom_do_post_excerpt', 10);
    }
});

add_action('genesis_before_content', 'text_widget', 1);

function text_widget() {
    if( !wp_is_mobile() && !is_page_template(['page-faqs.php']) && (is_single() || is_page() )) {
        // echo do_shortcode('[hd_blog_sidebar]');
    }
}