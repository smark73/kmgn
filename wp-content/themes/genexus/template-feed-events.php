<?php
/*
Template Name: Feed: Events & Info CPT
 * use WP functions to get and display feed
*/
include_once( ABSPATH . WPINC . '/feed.php' );

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


	//INIT
	global $station;

	//display errors instead of error message
	$debug_page = false;

	// --- Check Slug and Set Event Type ---
	// use the slug to set the event type
	// check it for "community", "what", "concert"
	$cpt_slug = get_permalink();

	// for the $event_type ... text here must match the text passed in the rss feed for the category label

	if ( stripos( $cpt_slug, 'community' ) !== false ){
	    $event_type = "Community Info";

	} elseif ( stripos( $cpt_slug, 'concert' ) !== false ){
	    $event_type = "Concerts";

	} elseif ( stripos( $cpt_slug, 'what' ) !== false ){
	    $event_type = "Whats Happening";

	} else {
	    // not a correct slug/page for this tpl
	}
	// --- End ---

    if (function_exists('fetch_feed') ) {
        //clear feed cache
        function clear_feed_cache($debug_page){
            //no cache for debugging
            if($debug_page === true){
                return 0;
            } else {
                return 600;  //10 mins
            }
        }
        add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');

        $feed = fetch_feed('http://gcmaz.com/?feed=events');
        //$feed = fetch_feed('http://dev.gcmaz.com/?feed=events');
        
        //$feed->force_feed(true);

        if( ! is_wp_error( $feed ) ){
            //if no errors
            //$feed->set_timeout(60);
            //$feed->enable_cache(false);
            //$feed->set_cache_duration(0);

            $feed->enable_order_by_date(false);
            $limit = $feed->get_item_quantity(999); // specify number of items
            $items = $feed->get_items(0, $limit); // create an array of items
        } else {
            //show errors or error message
            if($debug_page === true){
                print_r($feed);
                echo "<br/>";
                print_r($feed->error());
            } else {
                echo "Sorry, there was an error getting the feed.";
            }
            $items = '';
        }

        //remove feed cache filter
        remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
    }
    
    //set counter, if we have no listings for this station then display message below
    $counter = 0;

    if($items) {

        foreach ($items as $item) {

			// make sure it has categories for us to filter
            if ( $item->get_categories() ) {

                $cat_array = array();
                foreach ($item->get_categories() as $item_cat) {

                    $cat_term = $item_cat->get_label();
                    array_push($cat_array, $cat_term);
                    //echo $counter . ": " . $cat_term . "<br/>";

                }

                //echo "<br/>all pushed: <br/>";
                //print_r($cat_array);


                //if ($item_cat->get_label() == $station) :
                
                if(in_array($station, $cat_array) && in_array($event_type, $cat_array)) {
                
                    $counter +=1;
                    ?>
                        
                        <article class="feed-article">

                            <div class="entry-content feed-listing">
                                <p class="listhdr">
                                	<a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank">
                                    	<?php echo esc_html($item->get_title()); ?>
                                    </a>
                                </p>
                                <br/>
                                <?php echo $item->get_content(); ?>
                            </div>
                            <div class="clearfix"></div>

                            <hr/>
                        </article>

                    <?php
                }

            }

        }

    }
    
    // if no listings, output this
    if($counter == 0){
        echo "<div style='margin:10% 4%'><div class='alert alert-warning'>No listings to display right now</div></div>" ;
    }

    echo "</div></article>"; // /div.entry-content article.entry

}

// genesis child theme
genesis();
