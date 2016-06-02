<?php
/*
Template Name: Feed: Community
 * use WP functions to get and display feed
*/
include_once( ABSPATH . WPINC . '/feed.php' );
//error_reporting(0);
global $station;

//display errors instead of error message
$debug_page = false;

?>
<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <?php
        if (function_exists('fetch_feed') ) {
            //clear feed cache
            function clear_feed_cache($secs){
                //return 0;  //set to zero
                return 300;  //5 mins
            }
            add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');

            $feed = fetch_feed('http://gcmaz.com/?feed=community');
            //$feed->force_feed(true);

            if( ! is_wp_error( $feed ) ){
                //if no errors
                //$feed->set_timeout(60);
                $feed->enable_cache(false);
                $feed->set_cache_duration(0);
                $feed->force_feed(true);
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
    
    <?php foreach ($items as $item) : ?>
        <?php foreach ($item->get_categories() as $item_cat) : ?>
            <?php if ($item_cat->get_label() == $station) : ?>
                <?php $counter +=1;?>
    
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
    
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    
    <?php
            // if no listings, output this
            if($counter == 0){
                echo "<div style='margin:10% 4%'><div class='alert alert-warning'>No listings to display right now</div></div>" ;
            }
    ?>
</div>