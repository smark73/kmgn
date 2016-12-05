<div class="in-cnt-wrp row">
    <?php while (have_posts()) : the_post(); ?>
        <div class="centered rbn-hdg">
            <div class="page-header">
                <h3 class="txtshdw"><?php the_title(); ?></h3>
            </div>
        </div>
        <article class="entry-content">
            <?php if(has_post_thumbnail()){ the_post_thumbnail('large', array('class'=>'img-responsive'));}?>
            <?php the_content(); ?>
            <footer></footer>
        </article>
    <?php endwhile; ?>
</div>