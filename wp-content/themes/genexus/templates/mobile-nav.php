<nav class="js-menu sliding-panel-content">

<?php

    //if ( has_nav_menu( 'mobile-menu' ) ) {

    	//wp_nav_menu( array(
    		//'theme_location' => 'mobile-menu',
    		//'menu_class' => 'mobile-menu'
    	//));
    	
    //}

    if ( has_nav_menu( 'primary' ) ) {

    	wp_nav_menu( array(
    		'theme_location' => 'primary-menu',
    		'menu_class' => 'mobile-menu'
    	));
    	
    }


?>

</nav>
<div class="js-menu-screen sliding-panel-fade-screen"></div>
