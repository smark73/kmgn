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
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop(){

    //output Genesis standard components so page get styled
    echo "<article class='entry'>";
    genesis_entry_header_markup_open();
    genesis_do_post_title();
    genesis_entry_header_markup_close();
    echo "<div class='entry-content'>";

    ?>

<div class="" style="background:#000000;">

       <div id="MickiFreeClips"></div>



</div>

<script type="text/javascript">
//  jQuery(function($) {
//    $(document).ready(function() {
      document.addEventListener("DOMContentLoaded", function(event) {
      	var controller = new YTV('MickiFreeClips', {
         		//channelId: 'UCzhV348cX1pFjZzNXVwGT8Q'
         		playlist: 'PLOJW20xKwaRCMTPpnLDgZxlEhCVlt0zKr'
      	});
      	//manually hide the video titles - they show even thow showinfo=0
//      	$hideYtpTitle = $(document).find('.ytp-title');
//      	$hideYtpTitle.hide();
      });
//    });
//  });
</script>

<?php

    echo "</div></article>"; // /div.entry-content article.entry

}

// genesis child theme
genesis();
