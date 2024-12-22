<?php
/*--------------------------------
Example Shortcode Wrapper
[icon
 name="#"
 class="#"
 full="true"]
---------------------------------*/

function hc_icon_shortcode($atts = [], $content = null) {

    extract( shortcode_atts( array(
        'name' => '',
        'width' => 30,
        'height' => 30,
        'class' => '',
        'full' => false,
    ), $atts ) );

    $full ? $path_sprite = 'sprite-full.svg?=#' : $path_sprite = 'sprite.svg?=#';

    ob_start();
    //BEGIN OUTPUT
    ?>

    <svg class="icon <?=$class;?>" width="<?=$width?>" height="<?=$height;?>"><use xlink:href="<?=CHILD_URL?>/assets/app/svg/symbol/<?=$path_sprite . $name;?>"></use></svg>

    <?php
    //END OUTPUT
    $output = ob_get_contents();
    ob_end_clean();
    return  $output;
}

add_shortcode('icon', 'hc_icon_shortcode');