<?php
/*
Template Name: Mickis Free Ride 2
*/
?>

<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <div class="pg-content">
        <?php get_template_part('templates/content', 'page'); ?>
        <?php echo do_shortcode( '[Advanced_Youtube_Channel_Pagination]' ); ?>
    </div>
</div>

