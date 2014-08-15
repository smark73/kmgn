<?php
/*
Template Name: Feed: Whats
 * use WP functions to get and display feed
*/
?>
<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <?php
        if (function_exists('fetch_feed') ) {
            //clear feed cache
            function clear_feed_cache($secs){
                return 0;  //set to zero
            }
            add_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
            $feed = fetch_feed('http://www.gcmaz.com/whats-happening/feed');
            $feed->set_cache_duration(0);
            $limit = $feed->get_item_quantity(50); // specify number of items
            $items = $feed->get_items(0, $limit); // create an array of items
            //remove feed cache filter
            remove_filter('wp_feed_cache_transient_lifetime', 'clear_feed_cache');
        }
    ?>
    <?php foreach ($items as $item) : ?>
        <?php foreach ($item->get_categories() as $item_cat) : ?>
            <?php if ($item_cat->get_label() == $station) : ?>
                <?php
                    // compare date to today to 1) dont show past date posts 2) order them (?? NOT SET UP YET)
                    // using the data array ... print_r($item) to see it
                    $event_date = $item->data['child']['']['whats_date'][0]['data'];
                    $event_fulldate = $item->data['child']['']['whats_fulldate'][0]['data'];
                    if(($event_fulldate == null) || (strtotime($event_fulldate)) >= (strtotime('now'))) :
                ?>
                    <article>
                      <div class="entry-content feed-listing">
                          <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>">
                              <?php echo esc_html($item->get_title()); ?>
                          </a>
                          <span class="archv-date pull-right red">
                                <?php echo $event_date; ?>
                          </span>
                          <?php echo $item->get_content(); ?>
                      </div>
                      <div class="clearfix"/></div>
                      <hr class="archv-pg-hr"/>
                    </article>
                <?php endif; ?>
            <?php endif;?>
        <?php endforeach; ?>
  <?php endforeach; ?>
</div>