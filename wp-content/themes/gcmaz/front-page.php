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
    
    <section class="row indx-social">
        <div class="rbn-hdg">
            <span class="centered txtshdw gen-hdr">Area News</span>
        </div>
        <div class="col-md-12 indx-news">
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
    </section>
        
    <section class="indx-bnr-wrap row ">
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php
                // check for plugin by using plugin name
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
                    echo adrotate_group(4);
                }
                ?>
        </article>
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php
                // check for plugin by using plugin name
                if( is_plugin_active( 'adrotate/adrotate.php' ) ){
                    echo adrotate_group(5);
                }
            ?>
        </article>
    </section>
    <div class="clearfix"></div>
</div>