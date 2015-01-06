<div class="row"><!-- front-page-->
    <section class="boxy row">
        <?php get_template_part('templates/content', 'page'); ?>
    </section>
    <section class="row indx-social">
        <div class="rbn-hdg">
            <span class="centered txtshdw gen-hdr">News and Social</span>
        </div>
        <div class="col-md-12 indx-news">
            <h4><a href="http://www.gcmaz.com/kaff-news" target="_blank" title="View All KAFF News Stories">KAFF News | View All &raquo;</a></h4>
            <?php $feed = get_post_custom_values('feed_info'); echo do_shortcode($feed[0]); ?>
        </div>
        <div class="fb-like-box hidden-xs" data-href="http://www.facebook.com/TheNew939" data-height="400" data-show-faces="false" data-colorscheme="light" data-stream="true" show-border="false" data-header="false" style="background-color:#fff !important;max-width:700px;margin:0 auto 4%;"></div>
    </section>
    <section class="indx-bnr-wrap row ">
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php echo adrotate_group(4); ?>
        </article>
        <article class="indx-bnr col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <?php echo adrotate_group(5); ?>
        </article>
    </section>
    <div class="clearfix"></div>
</div><!-- /front-page-->