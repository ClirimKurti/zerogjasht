<?php

// Head Scripts and Styles (Google Analytics etc)
add_action('wp_head', 'custom_head_scripts_and_styles');

function custom_head_scripts_and_styles()
{ ?>
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Lora-Regular.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Lora-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <!-- <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Lora-Medium.woff2" as="font" type="font/woff2" crossorigin="anonymous"> -->
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Lora-Semibold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Oswald-Regular.ttf" as="font" type="font/ttf" crossorigin="anonymous">
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Oswald-Bold.ttf" as="font" type="font/ttf" crossorigin="anonymous">
    <!-- <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Oswald-SemiBold.ttf" as="font" type="font/ttf" crossorigin="anonymous"> -->
    <!-- <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Oswald-Medium.ttf" as="font" type="font/ttf" crossorigin="anonymous"> -->
    <link rel="preload" href="<?= CHILD_URL ?>/assets/app/fonts/Oswald-Light.ttf" as="font" type="font/ttf" crossorigin="anonymous">

<?php
}

add_action('genesis_before', 'add_gtag_noscript');

// For GTM noscript
function add_gtag_noscript()
{
?>

<?php
}
