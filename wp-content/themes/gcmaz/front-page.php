<?php
    // need to check if adrotate plugin is even active
    // include file needed to detect plugin - front end use only
    include_once( ABSPATH . 'wp-admin/includes/plugin.php');

    if (function_exists('fetch_feed') ) {
        //clear feed cache
        function clear_feed_cache(){
            //return 0;  //set to zero
            return 600;  //10 mins
        }
        add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
        $feed = fetch_feed('http://gcmaz.com/category/news/feed');
        //$feed = fetch_feed('https://gcmaz.net/nonexistentfeed/');
        if( ! is_wp_error( $feed ) ){
            $feed->enable_order_by_date(false);
            $limit = $feed->get_item_quantity(20); // specify large number of items - limit with the count_to_ten below
            $items = $feed->get_items(0, $limit); // create an array of items
            $got_feed = true;
        } else {
            $got_feed = false;
        }
        //remove feed cache filter
        remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
    }

    // create array to store post ID's of featured stories so we don't show them again below
    $temp_store_feed_ids = array();
    //top news categ = "Slider (KAFF News)"
    $count_top_news = 0;
    $max_top_news = 5;
    //more news items
    $count_news = 0;
    $max_news = 5;


    //init adrotate plugin check to display ads or not
    $show_adrotate_ads = false;
    if ( is_adrotate_plugin_active() === true ) {
        $show_adrotate_ads = true;
    }

?>


<div class="row">
    <section class="boxy row">
        <?php get_template_part('templates/content', 'page'); ?>
    </section>
    
    <section class="row indx-btm">
        <div class="col-md-6">

            <?php 
                //studio sponsor(group 14) sm & xs screen only -> see base.php for md & lg
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    if( substr( adrotate_group(14), 0, 5) === "<span" || substr( adrotate_group(14), 0, 2) === "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="studio-sponsor visible-xs visible-sm hidden-lg hidden-md">';
                        echo adrotate_group(14);
                        echo '</div>';
                    }
                }
            ?>
        
            <div class="indx-sm-btns">
                <a href="/song-requests" class="song-req">Request a Song on KMGN &nbsp; <span class="glyphicon glyphicon-music"></span></a>
            </div>
            <div class="indx-news">
                <h5>KAFF News | <a href="https://gcmaz.com/kaff-news" target="_blank" title="View All KAFF News Stories">View All &raquo;</a></h5>

                <?php if ($got_feed === true) : ?>

                    <?php foreach ($items as $item) : ?>
                        <?php foreach ($item->get_categories() as $item_cat) : ?>
                            <?php if ($item_cat->get_label() === 'Slider (KAFF News)') : ?>
                                <?php $count_top_news++; if( $count_top_news <= $max_top_news ) : ?>
                                    <?php  array_push($temp_store_feed_ids, $item->get_id()) ; //store id in temp array to prevent duplication ?>

                                    <div class="indx-news-feed-listing">
                                        <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank">
                                            <?php echo esc_html($item->get_title()); ?>
                                        </a>
                                        <?php echo "<p>" . shorten_and_strip_html( $item->get_content(), 120 ) . "</p>"; ?>
                                    <hr/>
                                    </div>

                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach;?>

                    <?php foreach ($items as $item) : ?>
                        <?php if (!in_array($item->get_id(), $temp_store_feed_ids)) : // dont show posts already in our feed ?>
                            <?php $count_news++; if( $count_news <= $max_news ) : ?>
                                <?php  array_push($temp_store_feed_ids, $item->get_id()) ; //store id in temp array to prevent duplication ?>

                                    <div class="indx-news-feed-listing">
                                        <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank">
                                            <?php echo esc_html($item->get_title()); ?>
                                        </a>
                                        <?php echo "<p>" . shorten_and_strip_html( $item->get_content(), 120 ) . "</p>"; ?>
                                    <hr/>
                                    </div>

                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else : ?>

                    <div class="indx-news-feed-listing">
                        <p>Sorry, there was an error getting the feed</p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-6">
<?php
                // homepage sidebar banners group (hidden lg, vis sm)(otherwise at very bottom and sales will complain)
                // group = 6
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    //check if group has ad
                    if( substr( adrotate_group(6), 0, 5) == "<span" || substr( adrotate_group(6), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="visible-xs hidden-md hidden-sm hidden-lg indx-sm-c2a">';
                        echo adrotate_group(6);
                        echo '</div>';
                    }
                }
            ?>

            <?php
                // NAU Games = 16
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    //check if group has ad
                    if( substr( adrotate_group(16), 0, 5) == "<span" || substr( adrotate_group(16), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="indx-sm-c2a">';
                        echo adrotate_group(16);
                        echo '</div>';
                    }
                }
            ?>
            
            <?php
                //indexbanner1 = 4
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    if( substr( adrotate_group(4), 0, 5) == "<span" || substr( adrotate_group(4), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="indx-sm-c2a">';
                        echo adrotate_group(4);
                        echo '</div>';
                    }
                }
            ?>
            
            <?php
                //indexbanner2 = 5
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    if( substr( adrotate_group(5), 0, 5) == "<span" || substr( adrotate_group(5), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="indx-sm-c2a">';
                        echo adrotate_group(5);
                        echo '</div>';
                    }
                }
            ?>

            <?php
                //indexbanner3 = 17
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    if( substr( adrotate_group(17), 0, 5) == "<span" || substr( adrotate_group(17), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        echo '<div class="indx-sm-c2a">';
                        echo adrotate_group(17);
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

</div>