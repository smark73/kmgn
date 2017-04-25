<header class="banner container" role="banner">
  <div class="row">
    <div class="col-lg-12">
      <a class="brand" href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
      <nav class="nav-main" role="navigation">
        <?php
            if ( has_nav_menu( 'primary_navigation' ) ) {

                //check for transient
                if( false === ( $menu = get_transient( 'primary_menu' ) ) ){
                    ob_start();
                    wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills' ) );
                    $menu = ob_get_clean();
                    set_transient( 'primary_menu', $menu, 60*60*24 );
                }

                echo $menu;
            }
        ?>
      </nav>
    </div>
  </div>
</header>