<?php

// Remove page header for front page
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'skm_hdr_title' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


// Remove Page Title
remove_action( 'genesis_post_title', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Content Area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop(){

    global $listenlivelink;

    //get KAFF News feed
    if (function_exists('fetch_feed') ) {
        //clear feed cache
        function clear_feed_cache(){
            //return 0;  //set to zero
            return 600;  //10 mins
        }
        //add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
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
        //remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
    }

    // create array to store post ID's of featured stories so we don't show them again below
    $temp_store_feed_ids = array();
    //top news categ = "Slider (KAFF News)"
    $count_top_news = 0;
    $max_top_news = 7;

    //Init Adrotate plugin check to display ads or not
    $show_adrotate_ads = false;
    if ( is_adrotate_plugin_active() === true ) {
        $show_adrotate_ads = true;
    }

    //first include FB sdk in page
    ?>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=100319983507036";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div class="home-row-main">

        <div class="main-slider-wrap">
            <div class="c2a-main-slider">
                <?php
                    //display home page content
                    $home_post_args = array(
                        'post_type' => 'page',
                        'pagename' => 'home',
                    );
                    $hp_query = new WP_Query( $home_post_args );
                    if( $hp_query->have_posts() ){
                        while ( $hp_query->have_posts() ) {
                            $hp_query->the_post();
                            global $post;
                            the_content();
                        }
                    }
                 ?>
            </div>
        </div>

        <div class="main-aside">
            <div class="stream-studio-wrap">

                <section class="stream-sect">

                    <a class="listen-live" href="<?php echo $listenlivelink;?>" target="_blank" title="Listen Live">
                        Listen Live <i class="fa fa-volume-up" aria-hidden="true"></i>
                    </a>

                    <?php
                        // group = 15
                        // check for plugin by using plugin name
                        $stream_has_sponsor = false;
                        if( $show_adrotate_ads === true ){
                            //check if group has ad
                            if( substr( adrotate_group(15), 0, 5) == "<span" || substr( adrotate_group(15), 0, 2) == "<!" ) {
                                // no ads, show default
                                $stream_has_sponsor = false;
                            } else {
                                $stream_has_sponsor = true;
                            }
                        }
                    ?>

                    <div class="stream-inner-wrap">
                        <?php
                            if( $stream_has_sponsor === true ){
                                echo '
                                    <div class="stream-sponsor-hdr">
                                        <span class="stream-sponsor-txt txt-nobreak">Stream Sponsored By:</span>
                                        <!--span class="stream-sponsor-bizname txt-nobreak">Sponsor Name</span-->
                                    </div>
                                ';
                            } else {
                                echo '
                                    <div class="stream-sponsor-hdr">
                                        <span class="stream-sponsor-txt txt-nobreak">STATUS: ONLINE</span>
                                    </div>
                                ';
                            }
                        ?>
                        <div class="stream-sponsor">
                            <?php
                                if($stream_has_sponsor === true){
                                    //echo '<div class="">';
                                    echo adrotate_group(15);
                                    //echo '</div>';
                                } else {
                                    echo '
                                        <a class="listen-live-big" href="' . $listenlivelink . '" target="_blank" title="Listen Live">
                                          Stream KAFF <span class="txt-nobreak">Country <i class="fa fa-volume-up" aria-hidden="true"></i></span>
                                        </a>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                </section>

                <section class="studio-sect">

                    <a href="/song-requests" class="song-request">
                        Request A Song <i class="fa fa-music" aria-hidden="true"></i>
                    </a>

                    <div class="studio-inner-wrap">
                        <div class="cur-show-hdr">
                            <span class="in-the-studio txt-nobreak">IN THE STUDIO:</span>
                            <span class="show-name txt-nobreak"><?php echo whos_in_the_studio();?></span>
                        </div>
                        <div class="studio-sponsor">
                            <?php
                                // group = 14
                                // check for plugin by using plugin name
                                if( $show_adrotate_ads === true ){
                                    //check if group has ad
                                    if( substr( adrotate_group(14), 0, 5) == "<span" || substr( adrotate_group(14), 0, 2) == "<!" ) {
                                        //nothing to display
                                    } else {
                                        //echo '<div class="">';
                                        echo adrotate_group(14);
                                        //echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div>

                </section>

            </div>
        </div>

    </div>

    <div class="home-row-mid-slider">

        <div class="home-mid-slider">

            <?php
                if (live_or_local() === 'live') {
                    //live slider
                    echo do_shortcode("[metaslider id=3001]");
                } else {
                    //local
                    echo do_shortcode("[metaslider id=729]");
                }
            ?>

        </div>

    </div>

    <div class="home-row-3col">

        <?php // !!! ADD CHECK HERE - DISPLAY SOMETHING ELSE IF NO BAN ADS ?>
        <div class="home-thirds-col ad-ban">
            <?php
                // group = 6
                // check for plugin by using plugin name
                if( $show_adrotate_ads === true ){
                    //check if group has ad
                    if( substr( adrotate_group(6), 0, 5) == "<span" || substr( adrotate_group(6), 0, 2) == "<!" ) {
                        //nothing to display
                    } else {
                        //echo '<div class="">';
                        echo adrotate_group(6);
                        //echo '</div>';
                    }
                }
            ?>
        </div>

        <div class="home-thirds-col kaff-news-feed">

            <div class="news-hdr-wrap">
                <a href="https://gcmaz.com/kaff-news" target="_blank" title="Latest KAFF News Stories" class="news-hdr">Latest from KAFF News</a>
            </div>

            <div class="kaff-news">

                <?php if ($got_feed === true) : ?>

                    <?php foreach ($items as $item) : ?>
                        <?php foreach ($item->get_categories() as $item_cat) : ?>
                            <?php if ($item_cat->get_label() === 'Slider (KAFF News)') : ?>
                                <?php $count_top_news++; if( $count_top_news <= $max_top_news ) : ?>
                                    <?php  array_push($temp_store_feed_ids, $item->get_id()) ; //store id in temp array to prevent duplication ?>

                                    <div class="kaff-news-feed-listing">
                                        <ul>
                                            <li>
                                                <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank">
                                                    <?php echo esc_html($item->get_title()); ?>
                                                </a>
                                                <?php //echo "<p>" . shorten_and_strip_html( $item->get_content(), 120 ) . "</p>"; ?>
                                            </li>
                                        </ul>
                                    </div>

                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach;?>

                <?php else : ?>

                    <div class="kaff-news-feed-listing">
                        <p>Sorry, there was an error getting the feed</p>
                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="home-thirds-col fb-box">
            <div class="fb-page" data-href="https://www.facebook.com/KAFFcountry" data-show-facepile="true" data-width="500" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/KAFFcountry" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/KAFFcountry">92.9 KAFF Country</a></blockquote></div>
        </div>

    </div>

    <?php
}



// genesis child theme
genesis();