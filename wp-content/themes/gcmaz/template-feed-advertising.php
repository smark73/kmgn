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
 *  possible values for "show" = KAFF, KAFFAM, KNOT, KMGN, KTMG, KFSZ, Digital Marketing, Marketing Contacts
 * 
 */
// initilize our vars
// our custom query vars added to WP in custom.php otherwise ignored
// get 'show' query var, or set it to default
$show = (get_query_var('show')) ? get_query_var('show') : "Marketing Contacts";

$page_var = "Advertising Info";
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
    <div class="advinfo">
    <?php
        if (has_nav_menu('adv-info_navigation')) :
          wp_nav_menu(array('theme_location' => 'adv-info_navigation', 'menu_class' => 'nav nav-tabs nav-justified'));
        endif;
    ?>
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
    </div>
</div>