<?php
/*
 * Template Name: FAQs Listing
 * */

add_action('genesis_entry_content', 'custom_faqs_content', 20);

function custom_faqs_content() {
    global $post;
    global $in_single_content;
    global $hc_settings;
    $in_single_content = false; ?>

    <div class="faq-wrap">
        <?php $terms = get_terms($hc_settings['faqs_category_taxonomy']);
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
            <div id="filters" class="faq-filter-terms">
                <?php echo '<a href="#" class="faq-filter-active" data-filter="all">All</a>';
                    foreach ( $terms as $term ) {
                        echo '<a href="#" data-filter="' . $term->slug . '">' . $term->name . '</a>';
                    }
                ?>
            </div>
            <?php
        } ?>

        <ul id="items" class="faq-page-items mt-5 mb-5">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'page',
                'tax_query' => array(
                    array(
                        'taxonomy' => $hc_settings['faqs_category_taxonomy'],
                        'operator' => "EXISTS"
                    ),
                ),
                'order' => 'DESC',
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $the_terms = get_the_terms($post->ID, $hc_settings['faqs_category_taxonomy']);
                if($the_terms) {
                    $the_terms = current($the_terms);
                    $term = $the_terms->slug;
                } else {
                    $term = '';
                } ?>
                <li class="faq-page-item" data-filter-item="<?=$term?>">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="faq-page-link">
                        <h2 class="faq-page-title"><?php the_title(); ?></h2>
                        <div class="faq-page-thumb">
                            <?php if ( get_the_post_thumbnail($post->ID) ) {
                                the_post_thumbnail('medium', ['alt' => get_the_title(), 'title' => get_the_title()]);
                            } else { ?>
                                <img src="<?=CHILD_URL?>/assets/app/img/default-thumb.jpg" alt="<?=the_title();?>" title="<?=the_title();?>" width="300" height="250">
                                <?php
                            } ?>
                        </div>
                    </a>
                </li>
            <?php endwhile; else : ?>
                <!-- IF NOTHING FOUND CONTENT HERE -->
            <?php endif; ?>
            <?php wp_reset_query(); ?>
        </ul>
    </div>

    <?php

    unset($in_single_content);

}

genesis();