<?php

// Breadcrumbs

// function filter_yoast_breadcrumb_items($link_output, $link) {
//     $current_url = home_url(strtok($_SERVER["REQUEST_URI"], '?'));

//     if (isset($link['url']) && isset($link['text'])) {
//         $link_markup = ($link['url'] === $current_url)
//             ? $link['text']
//             : '<a href="' . esc_url($link['url']) . '" itemprop="url">' . $link['text'] . '</a>';
//     } elseif (isset($link['text'])) {
//         $link_markup = $link['text'];
//     } else {
//         $link_markup = '';
//     }

//     return '<li>' . $link_markup . '</li>';
// }

// add_filter('wpseo_breadcrumb_single_link', 'filter_yoast_breadcrumb_items', 10, 2);

// function doublee_filter_yoast_breadcrumb_output($output)
// {

//     $output = preg_replace('/<span>(.*?)<\/span>/', '$1', $output);

//     return $output;
// }

// add_filter('wpseo_breadcrumb_output', 'doublee_filter_yoast_breadcrumb_output');

// if (function_exists('yoast_breadcrumb')) {
//     function custom_do_breadcrumbs()
//     {
//         remove_action('genesis_before_loop', 'genesis_do_breadcrumbs', 10);
//         yoast_breadcrumb('<ol class="breadcrumb" id="breadcrumbs">', '</ol>');
//     }

//     function wpseo_remove_breadcrumb_link($link_output, $link)
//     {
//         $breadcrumbsLinkToBeRemoved = ['Attorneys'];
//         if (in_array($link['text'], $breadcrumbsLinkToBeRemoved)) {
//             $link_output = str_replace('href="' . $link['url'] . '"', '', $link_output);
//             $link_output = str_replace('data-wpel-link="internal"', '', $link_output);
//         }

//         return $link_output;
//     }

// //    add_action('genesis_before_content_sidebar_wrap', 'custom_do_breadcrumbs', 5);
//     // Decomment this if you want to make specific breadcrumb links unclickable.
//     // add_filter('wpseo_breadcrumb_single_link', 'wpseo_remove_breadcrumb_link', 10, 2);
// }

// // Add proper breadcrumbs for location pages
// function filter_wpseo_breadcrumb_links($crumbs) {
//     global $hc_settings;

//     if(is_tax($hc_settings['faqs_category_taxonomy'])) {
//         $add_crumbs = [
//             [
//                 'text' => 'FAQs',
//                 'url' => site_url('/faqs/')
//             ]
//         ];
//         array_splice($crumbs, 1, 0, $add_crumbs);
//     }

//     if(is_paged() && !is_archive()) {
//         $paged = get_query_var('paged') ?: 0;
//         $add_crumbs = [
//             [
//                 'text' => 'Page ' . $paged,
//             ]
//         ];
//         array_splice($crumbs, 3, 0, $add_crumbs);
//     }

//     if(is_search()) {
//         if(is_paged()) {
//             $add_crumbs = [
//                 [
//                     'text' => 'Search Results'
//                 ]
//             ];
//             array_splice($crumbs, 1, -1, $add_crumbs);
//         } else {
//             $add_crumbs = [
//                 [
//                     'text' => 'Search Results'
//                 ]
//             ];
//             array_splice($crumbs, 1, 1, $add_crumbs);
//         }
//     }

//     return $crumbs;
// }
// add_filter( 'wpseo_breadcrumb_links', 'filter_wpseo_breadcrumb_links', 10, 1 );

// add_filter( 'wpseo_breadcrumb_links', 'hd_change_location_breadcrumbs' );
// function hd_change_location_breadcrumbs($links)
// {
//     global $hc_settings;
//     $count = 0;
//     foreach ($links as $k => $link) {
//         if (isset($link['id'])) {
//             if ($widget_title = get_field($hc_settings['location_widget_title'], $link['id'])) {
//                 $count++;
//                 if ($count > 2) {
//                     $links[$k] = [
//                         'url' => $links[$k]['url'],
//                         'text' => $widget_title
//                     ];
//                 }else{
//                     $city = get_the_terms($links[$k]['id'], $hc_settings['location_taxonomy']) ? current(get_the_terms($links[$k]['id'], $hc_settings['location_taxonomy'])) : false;
//                     if($city){
//                         $city = $city->name;
//                         $widget_title = "$city $widget_title Lawyer";
//                         $links[$k] = [
//                             'url' => $links[$k]['url'],
//                             'text' => $widget_title
//                         ];
//                     }
//                 }
//             }
//         }
//     }
//     return $links;
// }