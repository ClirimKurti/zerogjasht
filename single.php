<?php

remove_action('genesis_entry_header', 'genesis_post_info', 12);
remove_action('genesis_after_header', 'custom_inner_page_after_header', 10);
remove_action('genesis_entry_content', 'custom_do_thumbnail', 8);
remove_action('genesis_loop', 'genesis_do_loop', 10);
add_action('genesis_loop', 'custom_inner_location', 10);

function video_modal()
{
    $content = '';
    $video_id = get_field('youtube_id');
    $video_mp4 = get_field('video');
    // var_dump($video_mp4);

    if ($video_id) {
        $maxres_thumbnail = @getimagesize("https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg");

        if (!$video_id || is_archive() || is_search() || is_home() || is_404()) {
            return;
        }
        if ($maxres_thumbnail) {
            $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
        } else {
            $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
        }


        $content .= "<div class='video-modal'>";
        $content .= do_shortcode('
                             [modal 
                                 video="' . $video_id . '" 
                                 title="" 
                                 type="youtube" 
                                 class="modal-video" 
                                 cta="Watch Now" 
                                 src = "' . $thumbnail_url . '"
                                 src_mobile = ""
                                 img_width="600" 
                                 img_height="400" 
                                 webp="true" 
                                 mobile="true" 
                                 svg="true" 
                                 single="false" 
                             ]');
        $content .= "</div>";
    } elseif ($video_mp4) {
        $thumbnail_url = $video_mp4['sizes']['large'];
        $content .= "<div class='video-modal'>";
        $content .= do_shortcode('
                             [modal 
                                 video="' . $video_mp4['url'] . '" 
                                 title="" 
                                 type="mp4" 
                                 class="modal-video mt-5" 
                                 cta="Watch Now" 
                                 src = "' . $thumbnail_url . '"
                                 src_mobile = ""
                                 img_width="600" 
                                 img_height="400" 
                                 webp="true" 
                                 mobile="true" 
                                 svg="true" 
                                 single="false" 
                             ]');
        $content .= "</div>";
    }

    return $content;
}

function custom_inner_location()
{
?>
    <div class="container">
        <div class="row">
            <h1 class="ps-0 mb-0 ps-4 title-single"><?php the_title(); ?></h1>
            <div class="socials-links border-none">
                <div class="container">
                    <div class="row">
                        <div class="mt-4 d-none d-xl-flex justify-content-between">
                            <div class="post-meta date">
                                <span class="post-time">
                                    <?php
                                    $formatter = new IntlDateFormatter(
                                        'sq_AL',
                                        IntlDateFormatter::FULL,
                                        IntlDateFormatter::NONE
                                    );
                                    $timestamp = strtotime(get_the_date());
                                    echo $formatter->format($timestamp);
                                    ?>
                                </span>
                                |
                                <span class="post-category">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        $translated_categories = array_map(function ($category) {
                                            return __($category->name, 'text-domain');
                                        }, $categories);
                                        echo implode(', ', $translated_categories);
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="social-share w-fit mb-2">
                                <a class="social-share-facebook" href="https://www.facebook.com/zerogjashtt" title="Facebook" target="_blank"><?= do_shortcode('[icon name="facebook"]'); ?></a>
                                <a class="social-share-instagram" href="https://www.instagram.com/zerogjashtcom/" title="Instagram" target="_blank"><?= do_shortcode('[icon name="instagram"]'); ?></a>
                                <a class="social-share-youtube" href="https://www.youtube.com/channel/UCXk0OMTrxnYK2AM9p3cqfVA" title="Youtube" target="_blank"><?= do_shortcode('[icon name="youtube "]'); ?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            if (video_modal()) {
                echo video_modal();
            } else {
                the_post_thumbnail('full',  array('class' => 'post-image'));
            }
            ?>

            <div class="paragraph">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
<?php }

genesis();
