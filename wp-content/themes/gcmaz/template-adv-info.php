<?php
/*
Template Name: Advertising Info
*/
?>
<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <div class="advinfo">
        <?php
        if (has_nav_menu('adv-info_navigation')) :
          wp_nav_menu(array('theme_location' => 'adv-info_navigation', 'menu_class' => 'nav nav-tabs nav-justified'));
        endif;
        ?>
    </div>
    <div class="mediakits">
        <?php get_template_part('templates/content', 'page'); ?>
    </div>
</div>
