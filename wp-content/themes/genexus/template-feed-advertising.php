<?php
/*
Template Name: Feed:Advertising Info
 * use WP functions to get and display feed
 *
 * WHAT THIS PAGE DOES
 * gathers feed items from gcmaz.com/station-info/feed (Station Content posts)
 * checks to see if the feed item is ...
 * a) category of "Advertising Info" and ...
 * b) if yes to a. the query var is compared against the other categories to decide which content to show
 *  
 *  possible values for "show" = KAFF, KAFFAM, KNOT, KMGN, KTMG, KFSZ, Digital Advertising, Marketing Contacts
 * 
 */

// Content Area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop(){

    // initilize our vars
    // our custom query vars added to WP in custom.php otherwise ignored
    // get 'show' query var, or set it to default

    //$show = (get_query_var('show')) ? get_query_var('show') : "Marketing Contacts";
    $show = (get_query_var('show')) ? get_query_var('show') : "Digital Advertising";
    $page_var = "Advertising Info";

    //output Genesis standard components so page get styled
    echo "<article class='entry'>";
    genesis_entry_header_markup_open();
    genesis_do_post_title();
    genesis_entry_header_markup_close();
    echo "<div class='entry-content'>";


    if (function_exists('fetch_feed') ) {
        //clear feed cache
        function clear_feed_cache($secs){
            //return 0;  //set to zero
            return 600;  //10 mins
        }
        add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
        //$feed = fetch_feed('http://gcmaz.com/station-info/feed/');
        $feed = fetch_feed('http://gcmaz.com/feed/?post_type=station-content');
        $limit = $feed->get_item_quantity(999); // specify number of items
        $items = $feed->get_items(0, $limit); // create an array of items
        //remove feed cache filter
        remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
    }
    ?>

    <div class="adv-info">

        <div class="adv-info-logos-wrap">

            <div class="kaff-block adv-logo-block">
                <a href="/advertising-info/?show=KAFF">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/kaff-logo.png" alt="92.9 KAFF Country" class="adv-kaff-logo"/>
                </a>
            </div>
            
            <div class="kmgn-block adv-logo-block">
                <a href="/advertising-info/?show=KMGN">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/kmgn-logo.png" alt="93-9 The Mountain" class="adv-kmgn-logo"/>
                </a>
            </div>
            
            <div class="kzgl-block adv-logo-block">
                <a href="/advertising-info/?show=KZGL">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/eagle-square-whiteeagle.png" alt="The Eagle Rocks" class="adv-kzgl-logo"/>
                </a>
            </div>

            <div class="kfsz-block adv-logo-block">
                <a href="/advertising-info/?show=KFSZ">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/kfsz-logo.png" alt="Hits 106" class="adv-kfsz-logo"/>
                </a>
            </div>

            <div class="ktmg-block adv-logo-block">
                <a href="/advertising-info/?show=KTMG">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/ktmg-logo.png" alt="Magic 99.1" class="adv-ktmg-logo"/>
                </a>
            </div>
            
            <div class="kaffam-block adv-logo-block">
                <a href="/advertising-info/?show=KAFFAM">
                    <img src="//gcmaz.com/wp-content/themes/genexus/images/kaffam-logo.png" alt="KAFF Legends 93-5 AM930" class="adv-kaffam-logo"/>
                </a>
            </div>
  
            <div class="clearfix"></div>

        </div>

        <div class="adv-info-txt-links">
            <a href="/advertising-info/?show=Digital%20Advertising" title="Digital Advertising">Digital Advertising</a> &nbsp; | &nbsp; <a href="/advertising-info/?show=Marketing%20Contacts" title="Marketing Contacts">Marketing Contacts</a>
        </div>

        <?php foreach ($items as $item) : ?>
     
            <?php
                /* 
                 * get the feed item categories
                 */
                $i = 0;
                foreach ($item->get_categories() as $item_cat) {
                   $cats[$i] = $item_cat->get_label();
                    $i++;
                }
                //print_r($cats);
                //echo "<br/>";
                
                /*
                 * does the feed item have a category of "Advertising Info" ?
                 * if yes, continue
                 */
               if(in_array($page_var, $cats)) :
            ?>
                <?php
                    /*
                     * does the feed item have a category of KAFF, KAFFAM, KNOT, KMGN, KTMG, KFSZ, Digital Marketing, Marketing Contacts  ?
                     * if yes, continue
                     */
                    if(in_array($show, $cats)) :
                ?>

                    <article>
                      <div class="mediakits entry-content feed-listing">
                          <?php echo $item->get_content(); ?>
                      </div>
                      <div class="clearfix"></div>
                      <hr class="archv-pg-hr"/>
                    </article>
            
                <?php endif; ?>
            <?php endif; ?>

        <?php endforeach; ?>


    <?php

}

// genesis child theme
genesis();
