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
        //get_template_part( 'templates/sum-prom-2016-modal' );
    ?>
    
  <div class="innerbg wrap container" role="document" <?php if( is_search() ){ echo 'style="margin-top:28px;"'; } //fix display bug on search pages ?>>
        <div class="row row1">
            <section class="col-md-4">

                <?php
                  // display the Summer Promo 2016 Casino Chip
                  // in custom functions
                  //display_sum_promo_casino_chip();
                ?>

                <a href="/" >
                    <img class="size-full wp-image-31 centered logo" alt="93-9 The Mountain Radio - Flagstaff and Prescott Radio" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-939themountain.png"/>
                </a>
                
                <?php //<div  class="sticker-logo">?>
                    <?php //<a href="http://gcmaz.com/info/sticker-on-and-win/">?>
                        <?php //<img alt="Play Sticker On and Win!" src="<?php echo get_stylesheet_directory_uri(); ? >/assets/img/kmgn-sticker-on.png" class="stickeron-img"/>?>
                    <?php //</a>?>
                <?php //</div>?>
                
            </section>
            <section class="col-md-8">

                <div style="margin:10px 20px; text-align: right;">
                    <?php
                        // USER 
                          if ( is_user_logged_in() ) {

                              // ===== LOGGED IN =====
                              $our_cur_user = wp_get_current_user();
                              $our_user_name = $our_cur_user->user_firstname;
                              //$our_user_name = $our_cur_user->user_nicename;
                              
                              echo '
                                  <div>
                                      <a href="/user" style="font-weight: 600; font-size:1.2em; color:#faaf40; text-shadow: 1px 1px 1px rgba(0,0,0,.25);" rel="nofollow">' . $our_user_name . '</a> | <a href="/logout" title="Logout" style="font-weight: 600; color:#bababa; text-shadow: 1px 1px 1px rgba(0,0,0,.5); font-size:0.8em; letter-spacing:-1px;" rel="nofollow">LOGOUT</a>
                                  </div>
                                  ';

                          } else {

                              // ===== NOT LOGGED IN =====
                              echo '
                                  <div>
                                      <a href="/login" style="font-weight: 600; font-size:1em; color:#faaf40; text-shadow: 1px 1px 2px rgba(0,0,0,.5);" rel="nofollow">
                                          LOGIN
                                      </a>
                                  </div>';

                          } // END USER
                    ?>
                </div>

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
                <?php
                    //studio sponsor(group 14) md & lg screen only -> see front-page.php for xs & sm
                    // check for plugin by using plugin name
                    if( is_plugin_active( 'adrotate/adrotate.php' ) ){
                        if( substr( adrotate_group(14), 0, 5) === "<span" || substr( adrotate_group(14), 0, 2) === "<!" ) {
                            //nothing to display
                        } else {
                            echo '<div class="hidden-xs hidden-sm studio-sponsor">';
                            echo adrotate_group(14);
                            echo '</div>';
                        }
                    }
                ?>
                <?php include roots_sidebar_path(); ?>
            </aside><!-- /.sidebar -->
          <?php endif; ?>
        </div><!-- /.content -->
</div><!-- /.wrap -->
  <?php get_template_part('templates/footer'); ?>

</body>
</html>