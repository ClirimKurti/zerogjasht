<?php

// Remove auto p from Contact Form 7 shortcode output
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false()
{
    return false;
}


// remove <link rel='dns-prefetch' href='//s.w.org' />
remove_action('wp_head', 'wp_resource_hints', 2);

// Add HTML 5 Support
add_action(
    'after_setup_theme',
    function () {
        add_theme_support('html5', ['script', 'style']);
    }
);
add_filter('disable_wpseo_json_ld_search', '__return_true');

// Removed empty 'p' in widget and content
function remove_empty_p($content)
{
    $content = force_balance_tags($content);
    $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
    return $content;
}

add_filter('widget_text', 'remove_empty_p', 20, 1);
add_filter('the_content', 'remove_empty_p', 20, 1);

// deactivate new block editor
function phi_theme_support()
{
    remove_theme_support('widgets-block-editor');
}

add_action('after_setup_theme', 'phi_theme_support');

//DISABLE RSS FEED
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// allow shortcodes in text widgets
add_filter('widget_text', 'remove_empty_p');
add_filter('widget_text', 'do_shortcode');