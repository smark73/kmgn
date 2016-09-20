<?php
    // need to check if adrotate plugin is even active
    // include file needed to detect plugin - front end use only
    include_once( ABSPATH . 'wp-admin/includes/plugin.php');

    if (function_exists('fetch_feed') ) {
        //clear feed cache
        function clear_feed_cache($secs){
            //return 0;  //set to zero
            return 300;  //5 mins
        }
        add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
        $feed = fetch_feed('http://gcmaz.com/category/news/feed');
        $feed->enable_order_by_date(false);
        $limit = $feed->get_item_quantity(100); // specify large number of items - limit with the count_to_ten below
        $items = $feed->get_items(0, $limit); // create an array of items
        //remove feed cache filter
        remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
    }

    // create array to store post ID's of featured stories so we don't show them again below
    //need 2 ... one for first loop, one for second (mobile)
    $temp_store_feed_ids = array();
    $temp_store_feed_ids2 = array();
    //max total items
    $max_total_items = 10;
    
    //count Total feed items with this
    $count_to_max = 0;
    $count_to_max2 = 0;
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
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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
                <h5>KAFF News | <a href="http://www.gcmaz.com/kaff-news" target="_blank" title="View All KAFF News Stories">View All &raquo;</a></h5>
                    <?php foreach ($items as $item) :  //main loop #1  thru results ?>
                        <?php foreach ($item->get_categories() as $item_cat) :   //inner loop for Pinned results ?>
                            <?php if ($item_cat->get_label() == 'Pinned') : ?>
                                <?php $count_to_max++; if( $count_to_max<= $max_total_items) : ?>
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

                    <?php foreach ($items as $item) :  //main loop #2 thru results ?>
                        <?php foreach ($item->get_categories() as $item_cat) : //inner loop for non-Pinned results ?>
                            <?php if ($item_cat->get_label() != 'Pinned') : ?>
                                <?php if (!in_array($item->get_id(), $temp_store_feed_ids)) : // dont show posts already in our feed ?>
                                    <?php $count_to_max++; if( $count_to_max<= $max_total_items) : ?>
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
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; //end main loop ?>
            </div>
        </div>
        <div class="col-md-6">
<?php
                // homepage sidebar banners group (hidden lg, vis sm)(otherwise at very bottom and sales will complain)
                // group = 6
                // check for plugin by using plugin name
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
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