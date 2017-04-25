<header class="banner navbar navbar-default navbar-fixed-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" border="0">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
        <?php
            if ( has_nav_menu( 'primary_navigation' ) ) {

                //check for transient
                if( false === ( $menu = get_transient( 'primary_menu' ) ) ){
                    ob_start();
                    wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav' ) );
                    $menu = ob_get_clean();
                    set_transient( 'primary_menu', $menu, 60*60*24 );
                }

                echo $menu;

            }
        ?>
        <?php get_template_part('templates/navbar-icons'); ?>
    </nav>
  </div>
</header>
