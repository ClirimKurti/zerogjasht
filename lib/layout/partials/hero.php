<?php

add_filter('get_the_archive_title', 'custom_archive_title');

function custom_archive_title($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = "Tag: " . single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = sprintf(__('%1$s'), single_term_title('', false));
    }
    return $title;
}

add_action('genesis_after_header', 'custom_inner_page_after_header', 10);

function custom_inner_page_after_header()
{
    if (is_front_page()) return "";

    remove_entry_header_actions();

    $heading = get_internal_hero_heading(get_page_number());

?>

    <div class="internal-hero-wrap">
        <div class="container">
            <h1 class="text-center text-red"><?= esc_html($heading) ?></h1>
        </div>
    </div>
<?php
}

function remove_entry_header_actions()
{
    if (!is_archive() && !is_home() && !is_category() && !is_search()) {
        remove_action('genesis_entry_header', 'genesis_do_post_format_image', 4);
        remove_action('genesis_entry_header', 'genesis_entry_header_markup_open', 5);
        remove_action('genesis_entry_header', 'genesis_do_post_title', 10);
        remove_action('genesis_entry_header', 'genesis_do_post_info', 12);
        remove_action('genesis_entry_header', 'genesis_entry_header_markup_close', 15);
    }
}

function get_page_number()
{
    $page = '';

    if (is_paged()) {
        $paged = get_query_var('paged') ?: 0;
        if ($paged) {
            $page = ' - Faqe ' . $paged;
        }
    }

    return $page;
}

function get_internal_hero_heading($page)
{
    if (is_single() || is_page()) {
        ob_start();
        the_title();
        $heading = ob_get_clean();
        return $heading . $page;
    } else {
        $heading = "Blog";

        if (is_404()) {
            $heading = "Faqja që kerkuat nuk egziston";
        } elseif (is_archive()) {
            $heading = get_the_archive_title();
        } elseif (is_search()) {
            $heading = "Rezultatet e kërkimit";
        }

        return $heading . $page;
    }
}
