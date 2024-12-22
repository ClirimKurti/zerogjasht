<?php

add_action( 'wp_enqueue_scripts', 'custom_include_assets' );

function custom_include_assets() {
    $jsArray = [
       CHILD_URL . '/assets/libs/swiper/js/swiper-bundle.min.js'
    ];

    $cssArray = [
       CHILD_URL . '/assets/libs/swiper/css/swiper-bundle.min.css'
    ];

    foreach($cssArray as $css_asset) {
        wp_enqueue_style( basename($css_asset), $css_asset);
    }

    foreach($jsArray as $js_asset) {
        wp_enqueue_script( basename($js_asset), $js_asset, array('jquery'), '1.0.0', true);
    }


    // include general theme files
    wp_enqueue_style( 'theme-main', CHILD_URL . '/assets/app/css/main.min.css' , array(), filemtime(__DIR__ . '/app/css/main.min.css'));
    wp_enqueue_script( 'theme-main', CHILD_URL . '/assets/app/js/main.min.js', array('jquery'), filemtime(__DIR__ . '/app/js/main.min.js'), true );

}
