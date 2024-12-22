    <?php

    global $hc_settings;

    $hc_settings = [
        'location_taxonomy' => 'hc_city_location',
        'state_taxonomy' => 'hc_state_location',
        'location_widget_title' => 'practice_area',
        'parent_location_widget_title' => 'parent_practice_area',
        'faqs_category_taxonomy' => 'hc_faqs',
        'state' => '',
        'stateabbr' => '',
        'phone_number' => '',
        'primary_menu' => "Primary Menu",
        'practice_areas_menu_item' => "",
        'main_practice_area' => 'Personal Injury',
        'main_practice_area_es' => 'Lesiones Personales',
        'is_multiple_state' => false,
        'has_spanish_language' => false
    ];


    /*
    *
    * AUTO INCLUDE - BE CAREFUL!
    *
    * */

    $autoiclude_folders = [
        '/lib/snippets/',
        '/lib/shortcodes/',
    ];

    foreach ($autoiclude_folders as $folder) {
        foreach (scandir(dirname(__FILE__) . $folder) as $filename) {
            $path = dirname(__FILE__) . $folder . $filename;
            if (is_file($path)) {
                require_once $path;
            }
        }
    }

    // include layout
    require_once 'lib/layout/layout.php';
    // include frontend assets
    require_once 'assets/assets.php';

    // Increment post clicks on view
    function increment_post_clicks($post_id)
    {
        if (is_single()) {
            $clicks = get_post_meta($post_id, 'post_clicks', true);
            $clicks = $clicks ? $clicks + 1 : 1;
            update_post_meta($post_id, 'post_clicks', $clicks);
        }
    }
    add_action('wp_head', function () {
        if (is_single()) {
            increment_post_clicks(get_the_ID());
        }
    });



    // Return EN on the lang
    add_filter('locale', function ($default_locale) {
        return 'en';
    });

    function strict_transport_security_hsts()
    {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }

    add_action('send_headers', 'strict_transport_security_hsts');


    function getCategoryQuery($category_name, $posts_per_page, $order = 'DESC', $orderby = 'date')
    {
        if (empty($category_name) || !is_string($category_name)) {
            throw new InvalidArgumentException('Category name is required and must be a string.');
        }

        if (!is_int($posts_per_page) || $posts_per_page < 1) {
            throw new InvalidArgumentException('Posts per page must be a positive integer.');
        }

        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'], true)) {
            throw new InvalidArgumentException('Invalid order. Must be "ASC" or "DESC".');
        }
        $valid_orderby = ['date', 'ID', 'author', 'title', 'modified', 'parent', 'rand', 'comment_count', 'menu_order', 'relevance'];
        if (!in_array($orderby, $valid_orderby, true)) {
            throw new InvalidArgumentException('Invalid orderby. Must be one of: ' . implode(', ', $valid_orderby));
        }


        $args = [
            'category_name'  => sanitize_text_field($category_name),
            'posts_per_page' => $posts_per_page,
            'order'          => strtoupper($order),
            'orderby'        => $orderby
        ];

        return get_posts($args);
    }


    function fetchPostsByCategory($category_name, $posts_per_page, $single = false, $order = 'DESC', $orderby = 'date')
    {
        if (empty($category_name) || !is_string($category_name)) {
            throw new InvalidArgumentException('Category name is required and must be a string.');
        }

        if (!is_int($posts_per_page) || $posts_per_page < 1) {
            throw new InvalidArgumentException('Posts per page must be a positive integer.');
        }

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Invalid order. Must be "ASC" or "DESC".');
        }

        $valid_orderby = ['date', 'ID', 'author', 'title', 'modified', 'parent', 'rand', 'comment_count', 'menu_order', 'relevance'];
        if (!in_array($orderby, $valid_orderby, true)) {
            throw new InvalidArgumentException('Invalid orderby. Must be one of: ' . implode(', ', $valid_orderby));
        }
        $args = [
            'category_name'  => sanitize_text_field($category_name),
            'posts_per_page' => $posts_per_page,
            'order'          => $order,
            'orderby'        => $orderby,
        ];

        $posts = get_posts($args);

        if (empty($posts)) {
            echo '<p>No posts found in this category.</p>';
            return;
        }

    ?>
        <div class="category-1 mt-4">
            <h2 class="text-red title"><?= esc_html(get_category_by_slug($category_name)->name); ?></h2>
            <div class="category-1-feature">
                <?php if ($single == true) : ?>
                    <a class="row light-gray p-3" href="<?= esc_url(get_permalink($posts[0]->ID)); ?>" title="<?= esc_attr($posts[0]->post_title); ?>">
                        <div class="col-lg-7">
                            <img src="<?= esc_url(get_the_post_thumbnail_url($posts[0]->ID)); ?>" alt="<?= wp_trim_words(esc_html($posts[0]->post_title), 15, '...') ?>" width="100%">
                        </div>
                        <div class="col-lg-5">
                            <h2><?= esc_html($posts[0]->post_title); ?></h2>
                        </div>
                    </a>
                <?php endif; ?>
                <div class="row mt-3">
                    <?php if ($single == false) : ?>
                        <?php foreach ($posts as $post): ?>
                            <a href="<?= esc_url(get_permalink($post->ID)); ?>" title="<?= esc_attr($post->post_title); ?>" class="col-lg-3 mb-4 p-lg-1">
                                <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)); ?>" alt="<?= wp_trim_words($post->post_title, 15, '...'); ?>" class="small-image">
                                <h2 class="small-title"><?= wp_trim_words(esc_html($post->post_title), 15, '...') ?></h2>
                            </a>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach (array_slice($posts, 1) as $post): ?>
                            <a href="<?= esc_url(get_permalink($post->ID)); ?>" title="<?= esc_attr($post->post_title); ?>" class="col-lg-3 mb-4 p-lg-1">
                                <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)); ?>" alt="<?= wp_trim_words($post->post_title, 15, '...'); ?>" class="small-image">
                                <h2 class="small-title"><?= wp_trim_words(esc_html($post->post_title), 15, '...') ?></h2>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Displays 2 posts with video on the homepage.
     *
     * This function fetches 2 posts that have a youtube_id or video field and displays them on the homepage.
     * The first post is displayed with a larger image and the rest of the posts are displayed with a smaller image.
     *
     * @since 1.0.0
     */
    function videoDisplay()
    {
        $video_posts = array(
            'posts_per_page' => 7,
            'post_type' => 'post',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'youtube_id',
                    'value' => '',
                    'compare' => '!=',
                ),
                array(
                    'key' => 'video',
                    'value' => '',
                    'compare' => '!=',
                ),
            )
        );

        $postsFetched = get_posts($video_posts);
        if ($postsFetched) {
            $images = [];
            foreach ($postsFetched as $post) {
                $video_id = get_field('youtube_id', $post->ID);
                $video_mp4 = get_field('video', $post->ID);
                if (has_post_thumbnail($post->ID)) {
                    $thumbnail_url = get_the_post_thumbnail_url($post->ID);
                } elseif ($video_id) {
                    $maxres_thumbnail = @getimagesize("https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg");

                    if (!$video_id || is_archive() || is_search() || is_home() || is_404()) {
                        return;
                    }
                    if ($maxres_thumbnail) {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
                    } else {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                    }
                } elseif ($video_mp4) {
                    $thumbnail_url = $video_mp4['sizes']['large'];
                }
                $images[$post->ID] = $thumbnail_url;
            }

        ?>

            <div class="category-1 mt-4">
                <h2 class="text-red title"><?= bloginfo('name') ?></h2>
                <div class="category-1-feature">
                    <a class="row light-gray p-3" href="<?= esc_url(get_permalink($postsFetched[0]->ID)); ?>" title="<?= esc_attr($postsFetched[0]->post_title); ?>">
                        <div class="col-lg-7">
                            <img src="<?= $images[$postsFetched[0]->ID]; ?>" alt="<?= wp_trim_words(esc_html($postsFetched[0]->post_title), 15, '...') ?>" width="100%">
                            <img src="<?= CHILD_URL; ?>/assets/app/svg/play-icon.svg" alt="Play icon" class="play-icon">
                        </div>
                        <div class="col-lg-5">
                            <h2><?= esc_html($postsFetched[0]->post_title); ?></h2>
                        </div>
                    </a>
                    <div class="row mt-3">
                        <?php foreach (array_slice($postsFetched, 1) as $post): ?>
                            <a href="<?= esc_url(get_permalink($post->ID)); ?>" title="<?= esc_attr($post->post_title); ?>" class="col-lg-4 mb-4 p-lg-1">
                                <div class="image">
                                    <img src="<?= $images[$post->ID]; ?>" alt="<?= wp_trim_words($post->post_title, 15, '...'); ?>" class="medium-image">
                                    <img src="<?= CHILD_URL; ?>/assets/app/svg/play-icon.svg" alt="Play icon" class="play-icon">
                                </div>
                                <h2 class="small-title"><?= wp_trim_words(esc_html($post->post_title), 15, '...') ?></h2>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php }
    }

    // Customize the search form in Genesis.
    add_filter('genesis_search_form', 'custom_genesis_search_form');

    function custom_genesis_search_form($form)
    {
        $form = '
        <form method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
            <input type="search" name="s" placeholder="Kërko këtu..." class="search-input" />
            <button type="submit" class="search-button">
                <img src="' . CHILD_URL . '/assets/app/svg/search.svg" alt="Search Icon" style="width: 20px; height: 20px;">
            </button>
        </form>';
        return $form;
    }


    function mgid()
    { ?>
        <script src="https://jsc.mgid.com/site/733609.js" async>
        </script>

    <?php }

    add_action('wp_head', 'mgid');

    add_action('genesis_after_header', 'social_banner');

    function social_banner()
    { ?>
        <div class="social-banner">
            <div class="social-share">
                <span class="title-single w-fit m-0 p-0">Na ndiqni: </span>
                <a class="social-share-facebook" href="https://www.facebook.com/zerogjashtt" title="Facebook" target="_blank"><?= do_shortcode('[icon name="facebook"]'); ?></a>
                <a class="social-share-instagram" href="https://www.instagram.com/zerogjashtcom/" title="Instagram" target="_blank"><?= do_shortcode('[icon name="instagram"]'); ?></a>
                <a class="social-share-youtube" href="https://www.youtube.com/channel/UCXk0OMTrxnYK2AM9p3cqfVA" title="Youtube" target="_blank"><?= do_shortcode('[icon name="youtube"]'); ?></a>
            </div>
        </div>
    <?php }
