<?php
/*
Template Name: Feed: Events & Info CPT
 * use WP functions to get and display feed
*/
include_once( ABSPATH . WPINC . '/feed.php' );

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


?>
<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <?php
        if (function_exists('fetch_feed') ) {
            //clear feed cache
            function clear_feed_cache($secs){
                //no cache for debugging
                if($debug_page == true){
                    return 0;
                } else {
                    return 300;  //5 mins
                }
            }
            add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');

            $feed = fetch_feed('http://gcmaz.com/?feed=events');
            //$feed = fetch_feed('http://dev.gcmaz.com/?feed=events');
            
            //$feed->force_feed(true);

            if( ! is_wp_error( $feed ) ){
                //if no errors
                //$feed->set_timeout(60);
                $feed->enable_cache(false);
                $feed->set_cache_duration(0);

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
            }

            //remove feed cache filter
            remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
        }
    ?>
    
    <?php $counter = 0;//set counter, if we have no listings for this station then display message below ?>

    <?php if($items) : ?>

        <?php foreach ($items as $item) : ?>

            <?php // make sure it has categories for us to filter
                if ( $item->get_categories() ) :
            ?>


                <?php
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

                                <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank" class="feed-wrap-link">
                                    
                                    <div class="entry-content feed-listing">
                                        <p class="listhdr">
                                            <?php echo esc_html($item->get_title()); ?>
                                        </p>
                                        <br/>
                                        <?php echo $item->get_content(); ?>
                                    </div>
                                    <div class="clearfix"/></div>

                                </a>
                                
                                <hr class="archv-pg-hr"/>
                            </article>

                        <?php
                    }
                    
                ?>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>
    
    <?php
            // if no listings, output this
            if($counter == 0){
                echo "<div style='margin:10% 4%'><div class='alert alert-warning'>No listings to display right now</div></div>" ;
            }
    ?>
</div>
