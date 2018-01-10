<?php

// Content Area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop() {

    global $post;
    global $paged;

    ?>

    <div class="entry archive-page search-results-page">

        <div class="searchbar">
            <form class="searchbar-form" itemprop="potentialAction" itemscope="" itemtype="http://schema.org/SearchAction" method="get" action="<?php echo home_url('/'); ?>" role="search">
                <meta itemprop="target" content="<?php echo home_url('/'); ?>?s={s}">
                <input itemprop="query-input" type="search" name="s" placeholder="Search" class="search-field">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>
        <br class="clearfix">

        <?php if( have_posts() ) : ?>

            <?php while( have_posts() ) : the_post(); ?>

                <section class="archive-listing <?php if( has_post_thumbnail() ) { echo 'has-img'; } ?>">
                    
                    <div class="archive-listing-text">
                        <a href="<?php the_permalink();?>" title="<?php the_title();?>" class="archive-listing-title">
                            <?php the_title(); ?>
                        </a>
                        <?php the_excerpt(); ?>
                    </div>

                    <?php if( has_post_thumbnail() ) : ?>
                        <div class="archive-listing-image">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('thumbnail');?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="clearfix"></div>
                    <hr>

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

            <div class="alert">
                <?php _e('Sorry, no results were found.'); ?>
            </div>

        <?php endif;?>

    </div>

<?php
}


// genesis child theme
genesis();