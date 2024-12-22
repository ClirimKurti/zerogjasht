<?php

// add related widgets
add_action('genesis_after_loop', function(){

    global $hc_settings;
    global $in_single_content;
    global $post;

    // setting this global var to disable image captions
    $in_single_content = false;

    // show related only on single pages
    if(!is_singular('post') && !is_singular('page') && !is_single())
        return '';

    // pages - show related articles only if you have some taxonomies assigned on page
    if(is_singular('page') && !has_term('', $hc_settings['location_taxonomy']) && !has_term('', $hc_settings['faqs_category_taxonomy']))
        return '';

    // get taxonomy for pages or category for blog posts
    $cat = get_the_terms( $post->ID, 'category' ) ?
        get_the_terms( $post->ID, 'category' ) :
        (get_the_terms( $post->ID, $hc_settings['faqs_category_taxonomy'] ) ? get_the_terms( $post->ID, $hc_settings['faqs_category_taxonomy'] ) : false);

    // check if page has widget title meta field
    if(get_post_meta($post->ID, $hc_settings['location_widget_title'], true)) {
        $c = new stdClass();
        $c->name = get_post_meta($post->ID, $hc_settings['location_widget_title'], true);
        $cat = [$c];
    }

    // check if its custom post type with custom taxonomy - like News with News Categories, or Videos / Video Category
    if(!$cat && !is_singular('post') && !is_singular('page') && is_single()) {

        $taxes = get_post_taxonomies($post->ID);
        // ignoring "technical" taxonomies
        $tax_names = array_filter($taxes, function($t)use($post,$hc_settings){
            return !in_array($t, [
                    'post_tag',
                    'post_format',
                    $hc_settings['location_taxonomy']
                ]) && has_term('', $t, $post->ID);
        });

        foreach ($tax_names as $tax) {

            // ignore technical taxes - "publicity" check
            $tx_obj = get_taxonomy($tax);
            if(!$tx_obj->public) continue;


            $cat = get_the_terms($post->ID, $tax);
            // if have terms - setting cat and continue
            if($cat) {
                break;
            }
        }
    }

    if($cat) {
        // get single term from array
        $cat = current($cat);
    } else {

        // if no related terms - do not show anything
        return '';
    }


    // to avoid duplicate content on lot of pages - trying to get city from current page and get related articles based on page
    $city_term = false;
    if(has_term('', $hc_settings['location_taxonomy'])) {
        $city_terms = get_the_terms($post->ID, $hc_settings['location_taxonomy']);

        if($city_terms) {
            $city_term = current($city_terms);
        }
    }


    // feel free to set up post types, taxonomies and headers. This may be Video, News etc.
    // uncomment FAQs if you have FAQ Pages with tax assigned
    $taxes = [
        ['tax' => 'category', 'post_type'=>'post', 'header' => ' Postimet nga: ' .$cat->name],
//        ['tax'=>$hc_settings['faqs_category_taxonomy'], 'post_type' => 'page', 'header' => $cat->name.' FAQ:'],
    ];

    foreach($taxes as $key => $tx) {

        // adding city name to related header
        if($city_term) {
            $tx['header'] = $city_term->name . ' ' . $tx['header'];
        }

        /**

         * All of the Taxonomies on website should be the same naming as Location Widget Title on pages -
         * e.q.
         *
         * "Car Accidents" blog category,
         * "Car Accidents" faq category,
         * "Car Accidents" news category,
         * "Car Accidents" video category
         *
         * ALL should be same naming, THIS IS IMPORTANT!

         **/

        $args = [
            'post_type' => [
                $tx['post_type']
            ],
            'posts_per_page' => -1,
            'post__not_in' => [$post->ID],
            'tax_query' => [
                [
                    'taxonomy' => $tx['tax'],
                    'field' => 'name',
                    'terms' => $cat->name
                ]
            ],
            'orderby' => 'rand',
        ];

        $posts = get_posts($args);

        // if no posts - trying to get parent page as base for related articles
        if(!$posts && has_term('', $hc_settings['location_taxonomy']) && $tit = get_post_meta($post->post_parent, $hc_settings['location_widget_title'], true)){
            $args['tax_query'][0]['terms'] = $tit;
            $tx['header'] = str_replace($cat->name, $tit, $tx['header']);
            $posts = get_posts($args);
        }

        // if no posts and have city - just removing related term checking and trying to get posts by city
        if(!$posts && $city_term) {
            unset($args['tax_query']);
            $posts = get_posts($args);

            $tx['header'] = str_replace($cat->name, "", $tx['header']);
        }

        // here's getting posts by city in content
        if($posts && $city_term) {
            $posts_tmp = $posts;
            $posts = array_filter($posts, function($p)use($city_term){
                return strpos($p->post_content, $city_term->name) !== false;
            });

            // this was returning basic posts when no posts matched city term. This may cause issues - disabled for now
//            if(!$posts) {
//                $posts = $posts_tmp;
//
//                $tx['header'] = str_replace($city_term->name.' ', '', $tx['header']);
//            }
        }

        $post_count = 8;
        $posts = array_slice($posts, 0, $post_count);

        if($posts) {
            echo "<div class='related-articles'><span>{$tx['header']}</span><div class='row'>";
            foreach($posts as $p) {
                $thumb = get_the_post_thumbnail($p->ID, 'medium');?>
                <div class="col-12 mb-4">
                    <div class="related-item">
                        <div class="related-item-thumb">
                            <a href="<?=get_permalink($p->ID)?>" title="<?=$p->post_title?>">
                                <?php if ($thumb) { ?>
                                    <?php echo $thumb; ?>
                                <?php } else { ?>
                                    <img src="<?=CHILD_URL?>/assets/app/img/default-thumb.jpg" alt="<?=$p->post_title;?>" title="<?=$p->post_title;?>" width="300" height="250">
                                    <?php
                                } ?>
                            </a>
                        </div>
                        <div class="related-item-info">
                            <h3><a href="<?=get_permalink($p->ID)?>" title="<?=$p->post_title;?>"><?=$p->post_title;?></a></h3>
                            <p><?=preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($p->post_content), 0, 250)); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div></div>';
            wp_reset_query();
        }

    }


    unset($in_single_content);

}, 1);