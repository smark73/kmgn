<div class="in-cnt-wrp row">
    <?php while (have_posts()) : the_post(); ?>
        <div class="centered rbn-hdg">
            <div class="page-header">
                <h4 class="txtshdw"><?php the_title(); ?></h4>
            </div>
        </div>
        <article class="entry-content">
            <?php if(has_post_thumbnail()){ the_post_thumbnail('large', array('class'=>'img-responsive'));}?>
            <?php the_content(); ?>
            <footer></footer>
        </article>
    <?php endwhile; ?>
</div>