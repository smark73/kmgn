<?php
/*
Template Name: HungryFeed Template
 * use if just need to grab page content and display it
 * works with plugin such as HungryFeed
*/
?>
<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <footer>
            <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
        </footer>
      </article>
    <?php endwhile; ?>
</div>