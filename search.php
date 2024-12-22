<?php

add_filter('wpseo_title', 'change_title_for_seo');
add_filter('wpseo_opengraph_title', 'change_title_for_seo');
add_filter('wpseo_twitter_title', 'change_title_for_seo');
function change_title_for_seo($title)
{
    $paged = get_query_var('paged') ?: 0;
    if (is_search() && $paged >= 2) {
        $title = 'Search Results - Page ' . $paged . ' of ' . $GLOBALS['wp_query']->max_num_pages . ' - ' . get_bloginfo('name');
    } else {
        $title = 'Search Results - ' . get_bloginfo('name');
    }
    return $title;
}

add_action('genesis_before_loop', function () { ?>

    <form class="search-form mt-0 mb-5" method="get" action="<?= site_url(); ?>" role="search">
        <label>
            <input class="search-form-input" type="search" name="s" placeholder="Search this website" value="<?= get_search_query() ?>">
        </label>
        <input class="search-form-submit" type="submit" value="Kërko">
    </form>

<?php
}, 3);


genesis();
