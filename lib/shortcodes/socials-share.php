<?php

add_shortcode('social-share', function () {
    if (!is_author()) {
        wp_reset_postdata();
        global $post;
        $content = '';
        // Get current page URL
        $sb_url = urlencode(get_the_permalink($post->ID));

        // Get current page title
        $sb_title = str_replace(' ', '%20', get_the_title($post->ID));

        // Get Post Thumbnail for pinterest
        $sb_thumb = get_the_post_thumbnail_url($post->ID, 'full');

        // Add variable with social share url
        $twitterURL = 'https://twitter.com/intent/tweet?url=' . $sb_url;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $sb_url;
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $sb_url . '&amp;title=' . $sb_title;
        if ($sb_thumb) {
            $pinterestURL = 'https://www.pinterest.com/pin/create/button/?url=' . $sb_url . '&amp;media=' . $sb_thumb . '&amp;description=' . $sb_title;
        } else {
            $pinterestURL = 'https://www.pinterest.com/pin/create/button/?url=' . $sb_url . '&amp;description=' . $sb_title;
        }

        $content .= '<div class="social-share">';
        $content .= '<a class="social-share-twitter" href="' . $twitterURL . '" title="Twitter" target="_blank">' . do_shortcode('[icon name="twitter"]') . '</a>';
        $content .= '<a class="social-share-facebook" href="' . $facebookURL . '" title="Facebook" target="_blank">' . do_shortcode('[icon name="facebook"]') . '</a>';
        $content .= '<a class="social-share-linkedin" href="' . $linkedInURL . '" title="Linkedin" target="_blank">' . do_shortcode('[icon name="linkedin"]') . '</a>';
        $content .= '<a class="social-share-pinterest" href="' . $pinterestURL . '" title="Pinterest" target="_blank">' . do_shortcode('[icon name="pinterest"]') . '</a>';
        $content .= '</div>';

        echo $content;
    }
});
