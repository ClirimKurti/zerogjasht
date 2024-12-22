<?php

function custom_shortcode_taxonomy_list() {
    global $post;
    global $hc_settings;

    $taxes = get_post_taxonomies($post->ID);

    $tax_names = [];

    if(is_single() || is_page()) {
        $tax_names = array_filter($taxes, function($t)use($post,$hc_settings){
            return !in_array($t, [
                    'post_tag',
                    'post_format',
                    $hc_settings['location_taxonomy']
                ]) && has_term('', $t, $post->ID);
        });
    }

    if(!is_tax() && !is_category() && !$tax_names && !is_home() && !is_archive() && !is_post_type_archive()) {
        return;
    }

    if(is_home() || is_category()) {
        $tax_names = ['category'];
    }
    if(is_tax() && get_query_var('taxonomy')) {
        $tax_names = [get_query_var('taxonomy')];
    }

    if(is_post_type_archive()) {
        $post_type = get_queried_object();
        $tax_names = get_object_taxonomies($post_type->name);
    }

    ob_start();

    foreach($tax_names as $tax) {
        $tax_obj = get_taxonomy($tax);
        $widget_header = $tax_obj->label;

        $terms = get_terms($tax);

        if($terms):

            ?>
            <div class="widget-wrap">
                <h4 class="widget-title widgettitle"><?=$widget_header?></h4>
                <ul>
                    <?php wp_list_categories(['taxonomy' => $tax, 'title_li' => null, 'hide_title_if_empty' => true]); ?>
                </ul>
            </div>
        <?php
        endif;

    }

    $content = ob_get_contents();
    ob_clean();

    return $content;

}

add_shortcode('taxonomy-list', 'custom_shortcode_taxonomy_list');