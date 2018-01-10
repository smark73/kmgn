<?php

// !!! FALSE UNLESS DEBUGGING !!!
$debug_sidebar = false;

global $post;

// if ( check_if_in_news() === true ) {
//     $show_news_sidebar = true;
// } else {
//     $show_news_sidebar = false;
// }


// INIT VARS
//local pages (comm, whats, concert & cats)
// $local_pages_array = array(
//     'events-whats-happening',
//     'events-community-info',
//     'events-concerts',
// );
//local cats
// $local_pages_cats = array(
//     'events',
//     'community-info',
//     'concert',
//     'whats-happening',
// );
// news related pages
// $news_pages_array = array(
//     'kaff-news',
//     'about-kaff-news',
//     'contact-kaff-news',
// );





// SEARCH
// need to keep is_search check first ... otherwise gets wrong sidebar
// as search info moves into post->info (a search for "concerts" calls the concerts sidebar)
if( is_search() ) {
    if ($debug_sidebar === true) {
        echo "<div style=''>search</div>";
    }
    genesis_widget_area( 'sidebar-primary' );





// FRONT PAGE
} elseif(is_front_page()){
    // no sidebar 
    if ($debug_sidebar === true) {
        echo "<div style=''>front page</div>";
    }
    genesis_widget_area( 'sidebar-homepage' );


// ...
} elseif( !empty( $post ) ){


    // LOCAL PAGES
    // if ( in_array( $post->post_name, $local_pages_array ) || in_category( $local_pages_cats ) || is_category( $local_pages_cats ) ) {

    //     if ( $debug_sidebar === true ) {
    //         echo "<div style=''>sidebar-local</div>";
    //     }
    //     genesis_widget_area( 'sidebar-local' );

        



    // NEWS
    // } elseif( in_array( $post->post_name, $news_pages_array ) ) {
    //     if ( $debug_sidebar === true ) {
    //         echo "<div style=''>sidebar-news (home)</div>";
    //     }
    //     // check if were on the kaff news main page
    //     genesis_widget_area('sidebar-news');

    // } elseif( $show_news_sidebar === true ) {
    //     // KAFF News subpages
    //     if ( $debug_sidebar === true ) {
    //         echo "<div style=''>sidebar-news (subp)</div>";
    //     }
    //     genesis_widget_area('sidebar-news');






    // ETC
    //} else {

        if ( $debug_sidebar === true ) {
            echo "<div style=''>primary-sidebar(1)</div>";
        }
        genesis_widget_area('sidebar-primary');

    //}




} else {

    if ( $debug_sidebar === true ) {
        echo "<div style=''>primary-sidebar(2)</div>";
    }
    genesis_widget_area('sidebar-primary');

    
}