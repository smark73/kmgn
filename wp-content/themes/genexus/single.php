<?php

// Content Area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop() {

    global $post;
    global $paged;

    ?>

    <article class="entry">

        <?php if( have_posts() ) : the_post(); ?>

        <div class="entry-content" itemprop="text">

            <?php if( has_post_thumbnail() ) : ?>

                <div class="featured-image">
                    <?php
                        //get image details
                        $img_id = get_post_thumbnail_id( $post->ID );
                        $img_details = get_posts( array( 'p' => $img_id, 'post_type' => 'attachment' ) );
                        $img_src = wp_get_attachment_image_src( $img_id, 'full' );
                        $img_width = $img_src[1];
                    ?>
                    <a href="<?php echo $img_src[0]; ?>" title="<?php the_title_attribute(); ?>" target="_blank">
                        <?php the_post_thumbnail('large'); ?>
                    </a>
                    <?php
                        //show caption if exists
                        if ( !empty( $img_details[0]->post_excerpt ) ) {
                            echo '<p class="featured-image-caption">';
                            echo $img_details[0]->post_excerpt;
                            echo '</p>';
                        }
                    ?>
                </div>

            <?php endif; ?>

            <header class="entry-header">
                <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
            </header>

            <?php the_content(); ?>

        </div>

        <?php else: ?>

            <div class="alert">
                <?php _e('Sorry, no results were found.'); ?>
            </div>

        <?php endif;?>

    </article>

<?php
}


// genesis child theme
genesis();