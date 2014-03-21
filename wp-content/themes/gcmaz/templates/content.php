<article <?php post_class(); ?>>
  <header>
    <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <!--?php get_template_part('templates/entry-meta'); ?-->
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
