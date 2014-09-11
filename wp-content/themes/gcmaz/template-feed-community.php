<?php
/*
Template Name: Feed: Community
 * use WP functions to get and display feed
*/
global $station;
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
            $feed = fetch_feed('http://gcmaz.com/?feed=community');
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
                    <article>
                      <div class="entry-content feed-listing">
                          <a href="<?php echo esc_url($item->get_permalink());?>" title="<?php echo esc_html($item->get_title()); ?>" target="_blank">
                              <?php echo esc_html($item->get_title()); ?>
                          </a>
                          <?php echo $item->get_content(); ?>
                      </div>
                      <div class="clearfix"/></div>
                      <hr class="archv-pg-hr"/>
                    </article>
            <?php endif;?>
        <?php endforeach; ?>
  <?php endforeach; ?>
</div>