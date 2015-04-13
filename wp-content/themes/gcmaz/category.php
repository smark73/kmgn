<div class="in-cnt-wrp row">
    <section>
        <div class="centered rbn-hdg">
            <?php get_template_part('templates/page', 'header'); ?>
        </div>
        <?php
            $the_category = get_query_var('cat');
            $the_query = new WP_Query(array(
                'cat' => $the_category,
                'posts_per_page' => get_option('posts_per_page'),
                'paged' => $paged,
            ));
        ?>
        <?php if($the_query->have_posts()) : ?>
        
            <?php while($the_query->have_posts()) : $the_query->the_post(); ?>
                <section class="archv-pg-lstng row">
                    <span class="archv-date"><?php echo get_the_date() . ", " . get_the_time();?></span>
                        <div class="archv-info col-md-12 col-sm-12 col-xs-12">
                            <?php get_template_part('templates/content', get_post_format());?>
                        </div>
                    <div class="clearfix"></div>
                    <hr class="archv-pg-hr">
                </section>
            <?php endwhile;?>
        
        <?php if ( function_exists('base_pagination') ) { base_pagination(); } else if ( is_paged() ) { ?>
            <div class="navigation clearfix">
                <div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
                <div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
            </div>
        <?php } ?>

            <?php
                /* Restore original Post Data */
                wp_reset_postdata();
            ?>
        
        <?php else: ?>
            <div class="alert alert-warning">
                <?php _e('Sorry, no results were found.', 'roots'); ?>
            </div>
        <?php endif;?>
    </section>
        
</div>