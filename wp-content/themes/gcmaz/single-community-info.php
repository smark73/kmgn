<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <div class="page-header">
            <h4 class="txtshdw"><a href='/community-info/' style='color:#fff;text-decoration:none;padding-top:5px;display:block;'>« Northern Arizona Community Info</a></h4>
        </div>
    </div>
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('sngl-info'); ?>>
          <div class="pull-right hidden-xs hidden-sm">
            <?php if(has_post_thumbnail()){ the_post_thumbnail('medium', array('class'=>'info-img'));}?>
          </div>
          <div class="centered visible-xs visible-sm">
              <?php if(has_post_thumbnail()){ the_post_thumbnail('medium', array('class'=>'info-img'));}?>
          </div>
        <header>
            <h3 class='blue'><?php the_title(); ?></h3>
            <span class='red' style='font-size:1.3em'><?php $cdate = get_post_custom_values('community_date'); echo $cdate[0]; ?></span>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
        <footer>
          <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
        </footer>
        <?php comments_template('/templates/comments.php'); ?>
      </article>
    <?php endwhile; ?>
</div>