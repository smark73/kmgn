<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <a href="http://www.orpheumflagstaff.com/" target="_blank">
        <img src="/media/orpheum.jpg" alt="The Opheum - Live Music Venue" style="width:100%;height:auto;margin-top:-10px;" class="centered img-responsive"/>
    </a>
    <?php if (!have_posts()) : ?>
      <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'roots'); ?>
      </div>
    <?php endif; ?>

    <?php 
        //$current_year = date('Y');
        //$current_month = date('m');
        //$current_day = date('s');
        query_posts($query_string."&orderby=concert_date&order=ASC");
    ?>
    <?php while (have_posts()) : the_post();?>
        <section class="archv-pg-lstng row">
            <?php if(has_post_thumbnail()) :?>
                <div class="archv-thmb col-md-3 col-sm-4 hidden-xs">
                    <?php the_post_thumbnail('thumbnail');?>
                </div>
                <div class="centered visible-xs">
                    <?php the_post_thumbnail('thumbnail');?>
                </div>
            <?php endif;?>
            <div class="archv-info col-md-9 col-sm-8 col-xs-12">
                <span class='archv-date pull-right red'>
                  <?php $cdate = get_post_custom_values('concert_date'); echo $cdate[0]; ?>
                </span>
                <?php get_template_part('templates/content', get_post_format()); ?>
            </div>
            <div class="clearfix">
               <hr class="archv-pg-hr">
            </div>
        </section>
    <?php endwhile; ?>

    <?php if ($wp_query->max_num_pages > 1) : ?>
      <nav class="post-nav">
        <ul class="pager">
          <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
          <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
        </ul>
      </nav>
    <?php endif; ?>
</div>