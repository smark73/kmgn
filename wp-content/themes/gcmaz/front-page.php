<?php

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


<div class="row"><!-- front-page-->
    <section class="boxy row">
        <?php get_template_part('templates/content', 'page'); ?>
    </section>
    
    <section class="row indx-social hidden-xs">
        <div class="rbn-hdg">
            <span class="centered txtshdw gen-hdr">News and Social</span>
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
        <div class="fb-like-box hidden-xs" data-href="https://www.facebook.com/TheNew939" data-height="400" data-show-faces="false" data-colorscheme="light" data-stream="true" show-border="false" data-header="false" style="background-color:#fff !important;max-width:700px;margin:0 auto 4%;"></div>
    </section>
        
    <section class="row indx-social visible-xs" style="background:transparent;">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title hp-toggle-feed">
                        <a class="mobile-toggle-news" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">News Headlines <div class="toggle-arrow-up"></div></a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="col-md-12 indx-news">
                                <?php foreach ($items as $item) :  //main loop #1  thru results ?>
                                    <?php foreach ($item->get_categories() as $item_cat) :   //inner loop for Pinned results ?>
                                        <?php if ($item_cat->get_label() == 'Pinned') : ?>
                                            <?php $count_to_max2++; if( $count_to_max2<= $max_total_items) : ?>
                                                <?php  array_push($temp_store_feed_ids2, $item->get_id()) ; //store id in temp array to prevent duplication ?>

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
                                            <?php if (!in_array($item->get_id(), $temp_store_feed_ids2)) : // dont show posts already in our feed ?>
                                                <?php $count_to_max2++; if( $count_to_max2<= $max_total_items) : ?>
                                                    <?php  array_push($temp_store_feed_ids2, $item->get_id()) ; //store id in temp array to prevent duplication ?>

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
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title hp-toggle-feed">
                        <a class="collapsed mobile-toggle-fb" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Facebook Feed <div class="toggle-arrow-down"></div></a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <div class="fb-like-box" data-href="https://www.facebook.com/TheNew939" data-height="400" data-show-faces="false" data-colorscheme="light" data-stream="true" show-border="false" data-header="false" style="background-color:#fff !important;max-width:700px;margin:0 auto 4%;"></div>
                    </div>
                </div>
            </div>
    
        </div>
    </section>   
        
        
    <section class="indx-bnr-wrap row ">
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php echo adrotate_group(4); ?>
        </article>
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php echo adrotate_group(5); ?>
        </article>
    </section>
    <div class="clearfix"></div>
</div><!-- /front-page-->