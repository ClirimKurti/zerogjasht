<?php
// TODO: rewrite whole script

//add_filter('the_content', function($html){
//    global $post;
//    $post_id = $post->ID;
//
//    if(strpos($html, ' alt=""') !== false) {
//        $html = str_replace(' alt=""', ' alt="'.get_the_title($post_id).'"', $html);
//    }
//
//    if(strpos($html, ' alt>') !== false || strpos($html, ' alt ') !== false) {
//        $html = str_replace(' alt', ' alt="'.get_the_title($post_id).'"', $html);
//    }
//
//    if(strpos($html, ' alt') === false) {
//        $html = str_replace('>', ' alt="'.get_the_title($post_id).'">', $html);
//    }
//
//
//    return $html;
//});