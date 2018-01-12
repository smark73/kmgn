<?php
/*
Template Name: Mickis Free Ride
*/

// Remove page header for front page
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'skm_hdr_title' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


// Remove Page Title
//remove_action( 'genesis_post_title', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Content Area
//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action( 'genesis_loop', 'page_loop' );


function page_loop(){

    //output Genesis standard components so page get styled
    echo "<article class='entry'>";
    genesis_entry_header_markup_open();
    genesis_do_post_title();
    genesis_entry_header_markup_close();
    echo "<div class='entry-content'>";

    ?>
    <div class="">
        <?php echo do_shortcode( '[Advanced_Youtube_Channel_Pagination]' ); ?>
    </div>
    <?php
    echo "</div></article>"; // /div.entry-content article.entry
}

function show_videos(){
    echo do_shortcode( '[Advanced_Youtube_Channel_Pagination]' );
}
add_action( 'genesis_entry_footer', 'show_videos' );


// genesis child theme
genesis();
