<?php get_template_part('templates/head'); ?>
<body <?php body_class(''); ?> >
  <!--[if lt IE 8]><div class="alert alert-warning"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?></div><![endif]-->

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <?php
    // display the Page Take Over if it's enabled
    do_action('display_ptko');
  ?>

    <?php
        //MODALS

        // Summer Prom 2016 Modal
        get_template_part( 'templates/sum-prom-2016-modal' );
    ?>
    
  <div class="innerbg wrap container" role="document" <?php if( is_search() ){ echo 'style="margin-top:28px;"'; } //fix display bug on search pages ?>>
        <div class="row row1">
            <section class="col-md-4">

                <?php
                  // display the Summer Promo 2016 Casino Chip
                  // in custom functions
                  display_sum_promo_casino_chip();
                ?>

                <a href="/" >
                    <img class="size-full wp-image-31 centered logo" alt="93-9 The Mountain Radio - Flagstaff and Prescott Radio" src="/media/logo-939themountain.png"/>
                </a>
                
                <?php //<div  class="sticker-logo">?>
                    <?php //<a href="http://gcmaz.com/info/sticker-on-and-win/">?>
                        <?php //<img alt="Play Sticker On and Win!" src="<?php echo get_stylesheet_directory_uri(); ? >/assets/img/kmgn-sticker-on.png" class="stickeron-img"/>?>
                    <?php //</a>?>
                <?php //</div>?>
                
            </section>
            <section class="col-md-8">
                <?php  get_template_part('templates/exp-leaderboard'); ?>
                <?php  get_template_part('templates/listen-live'); ?>
            </section>
        </div>
        <div class="content row">
          <div class="main <?php echo roots_main_class(); ?>" role="main">
                <?php include roots_template_path(); ?>
          </div><!-- /.main -->
          <?php if (roots_display_sidebar()) : ?>
            <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
                <div class="hidden-xs studio-sponsor">
                    <?php echo adrotate_group(14);?>
                </div>
              <?php include roots_sidebar_path(); ?>
            </aside><!-- /.sidebar -->
          <?php endif; ?>
        </div><!-- /.content -->
</div><!-- /.wrap -->
  <?php get_template_part('templates/footer'); ?>

</body>
</html>