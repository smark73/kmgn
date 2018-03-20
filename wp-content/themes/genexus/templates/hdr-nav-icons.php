<?php

    global $post;
    global $listenlivelink;
    global $fblink;
    global $twlink;
    global $instagramlink;

    echo '
        <div class="listen-nav" title="Listen Live">
            <a class="icon-listen" title="Listen Live" href="' . $listenlivelink . '" target="_blank">
                <span class="listen-txt">Listen Live</span><i class="fa fa-volume-up" aria-hidden="true"></i>
            </a>
        </div>
        ';

    // USER ICON & DROPDOWN

    //get appropriate user links (if plugin active it's different)
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active('ultimate-member/index.php')){
        //ult mem active
        $is_um_active = true;
        $our_login_link = "/login";
        $our_logout_link = "/logout";
        $our_user_link = "/user";
    } else {
        //default wp
        $is_um_active = false;
        $our_cur_user = wp_get_current_user();
        $our_user_link = get_edit_user_link( $our_cur_user->ID );
    }

    if ( is_user_logged_in() ) {

        // ===== LOGGED IN =====
        $our_cur_user = wp_get_current_user();
        //$our_user_name = $our_cur_user->user_firstname;
        $our_user_name = $our_cur_user->user_nicename;
        
        echo '
            <div class="user-nav">
                <a class="icon-user" title="User">
                    <i class="fa fa-user"></i>
                </a>

                <ul class="dropdown hide-me">
                    <li>';
                        //need to display appropriate logout link - storing in var doesn't seem to work right if using wp default
                        if($is_um_active === true) {
                            echo '<a href="' . $our_logout_link . '" title="Logout" rel="nofollow">Logout</a>';
                        } else {
                            echo '<a href="' . wp_logout_url() . '" title="Logout" rel="nofollow">Logout</a>';
                        }
                    echo '</li>
                    <li><a href="' . $our_user_link . '" title="Profile" rel="nofollow">' . $our_user_name . '</a></li>
                </ul>

            </div>
            ';

    } else {

        // ===== NOT LOGGED IN =====
        echo '
            <div class="user-nav" title="Login">';
                //need to display appropriate logout link - storing in var doesn't seem to work right if using wp default
                if($is_um_active === true) {
                    echo '<a href="' . $our_login_link . '" class="icon-user" rel="nofollow" title="Login"><i class="fa fa-user"></i></a>';
                } else {
                    echo '<a href="' . wp_login_url( get_permalink() ) . '" class="icon-user" rel="nofollow" title="Login"><i class="fa fa-user"></i></a>';
                }
            echo '</div>';

    } // END USER



    // SEARCH ICON & DROPDOWN
    ?>
    <div class="search-nav">
        <a class="icon-search" title="Search" rel="nofollow">
            <i class="fa fa-search"></i>
        </a>
    </div>

    <?php



    // SOCIAL ICONS
    // (checks and displays KAFF News social icons on kaff news pages)
    if( !empty( $post ) ){

        //if( $post->post_name == 'kaff-news' || in_category( check_current_category_for_news() ) ) {
        ?>
        
            <a href="<?php echo $fblink; ?>" target="_blank" class="icon-fb" title="KAFF Facebook" rel="nofollow">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="<?php echo $twlink; ?>" target="_blank" class="icon-tw" title="KAFF Twitter" rel="nofollow">
                <i class="fa fa-twitter"></i>
            </a>
        
        <?php
        //}

    }


    // MOBILE NAV BTN
    // shows on sm screens (< md-screen) when regular nav hides
    ?>
    <button type="button" class="mobile-nav-btn js-menu-trigger">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <?php


