<?php
/**
 * Functions
 * @package      genexus
 * @author       Stacy Mark <stacy.mark@kaff.com>
 * @copyright    Copyright (c) 2017
 * @license      All Rights Reserved
 *
 */


//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'genesis-sample', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'genesis-sample' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genexus (Genesis Child with Bourbon Neat' );
define( 'CHILD_THEME_URL', '' );
define( 'CHILD_THEME_VERSION', '2.2.4' );


/**********************************************************/
// Initialize - Theme Specific Globals

// Google Analytics ID UA-XXXXX-Y
define('GOOGLE_ANALYTICS_ID', 'UA-47756322-4');

global $station;
$station = 'KMGN';

global $listenlivelink;
$listenlivelink = "http://player.listenlive.co/36601";

global $fblink;
$fblink = "http://www.facebook.com/TheNew939";

global $twlink;
$twlink = "https://www.twitter.com/939TheMountain";

global $instagramlink;
$instagramlink = "https://instagram.com/939themountain/";



/**********************************************************/
//* Enqueue Scripts and Styles

//FRONTEND
function gx_enqueue_reqs() {

    //load the WP included jquery ... into head
    wp_enqueue_script( 'jquery');

    //wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700,900', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'dashicons' );

    //* Remove default stylesheet
    wp_deregister_style( 'genesis-sample-theme' );

    //* Add compiled stylesheet
    wp_register_style( 'gx-styles', get_stylesheet_directory_uri() . '/style.min.css', array(), CHILD_THEME_VERSION );
    wp_enqueue_style( 'gx-styles' );

    //wp_enqueue_script( 'gx-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
    //$output = array(
    //  'mainMenu' => __( '', 'genesis-sample' ),
    //  'subMenu'  => __( '', 'genesis-sample' ),
    //);
    //wp_localize_script( 'gx-responsive-menu', 'genesisSampleL10n', $output );

    //* Add compiled JS
    wp_enqueue_script( 'gx-scripts', get_stylesheet_directory_uri() . '/js/script.min.js', array(), CHILD_THEME_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'gx_enqueue_reqs' );

//BACKEND load scripts, styles, fonts
function gx_admin_reqs(){
    // Enqueue jQuery Datepicker + jQuery UI CSS
    //this fixes jquery ajax error
    wp_register_script( 'admin-scripts', get_stylesheet_directory_uri() . '/js/adminscripts.min.js' );
    wp_enqueue_script( 'admin-scripts' );
    //ready the WP included datepicker
    wp_enqueue_script( 'jquery-ui-datepicker', true );
    //ready the datepicker styles
    wp_register_style( 'jquery-ui-style', get_stylesheet_directory_uri() . '/js/jquery-ui-1.11.4.custom/jquery-ui.min.css', false, '1.11.4');
    wp_enqueue_style( 'jquery-ui-style' );
}
add_action( 'admin_enqueue_scripts', 'gx_admin_reqs');


// Google Analytics Script
function gx_google_analytics() {
    global $post;
    ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo GOOGLE_ANALYTICS_ID; ?>', 'auto');
      ga('send', 'pageview');
    </script>
<?php
}
if (GOOGLE_ANALYTICS_ID) {
    add_action('wp_head', 'gx_google_analytics', 20);
}



/**********************************************************/
// Add Genesis Supports and Tweaks

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
// add_theme_support( 'custom-header', array(
//  'width'           => 600,
//  'height'          => 160,
//  'header-selector' => '.site-title a',
//  'header-text'     => false,
//  'flex-height'     => true,
// ) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add Image Sizes
add_image_size( 'featured-image', 680, 400, TRUE );

//* Rename primary and secondary (footer) navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );



/** Unregister site layouts */
//genesis_unregister_layout( 'sidebar-content' );
//genesis_unregister_layout( 'full-width' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );


/**********************************************************/
// SIDEBARS

//* Unregister Genesis sidebars
// Remove default sidebar */
//remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
// Remove secondary sidebar */
//unregister_sidebar( 'header-right' );
//unregister_sidebar( 'sidebar' );
//unregister_sidebar( 'sidebar-alt' );

// Register Our Sidebars
// local pages (community/whats/concerts) sidebar
// genesis_register_sidebar( array(
//     'id' => 'sidebar-local',
//     'name' => 'Local Pages Sidebar',
//     'description' => 'Local Pages Sidebar',
// ));

// other sidebar
genesis_register_sidebar( array(
    'id' => 'sidebar-other',
    'name' => 'Other Sidebar',
    'description' => 'Other Sidebar',
));

// Home sidebar
// genesis_register_sidebar( array(
//     'id' => 'sidebar-homepage',
//     'name' => 'Home Page Sidebar',
//     'description' => 'Home Page Sidebar',
// ));

// Tell Genesis to use our custom sidebar based on category/page/etc
// the tpl file does all the work
function gx_custom_sidebar() {
    get_template_part( 'templates/sidebars' );
}
//add_action( 'genesis_before_sidebar_widget_area', 'gx_custom_sidebar' );



/**********************************************************/
// NAV

// REGISTER ADDITIONAL NAV MENUS 
function register_extra_menus() {
    register_nav_menu('mobile-menu',__( 'Mobile Menu' ));
    //register_nav_menu('adv-info_navigation',__( 'Advertising Menu' ));
}
add_action( 'init', 'register_extra_menus' );


//* Reduce the secondary navigation menu to one level depth
function genesis_sample_secondary_menu_args( $args ) {
    if ( 'secondary' != $args['theme_location'] ) {
        return $args;
    }
    $args['depth'] = 1;
    return $args;
}
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );


// Tell WP to use our Superfish JS arguments instead of defaults
/**
* Filter in URL for custom Superfish arguments.
* @author Gary Jones
* @link http://code.garyjones.co.uk/change-superfish-arguments
* @param string $url Existing URL.
* @return string Amended URL.
*/
function prefix_superfish_args_url( $url ) {
    return get_stylesheet_directory_uri() . '/js/superfish-args.min.js';
}
add_filter( 'genesis_superfish_args_url', 'prefix_superfish_args_url' );



/**********************************************************/
// ADD MORE BTNS TO EDITOR
function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'sub';
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");





/**********************************************************/
// ADD THINGS TO PAGE HEAD

//* Add SVG definitions to <head>.
function genesis_sample_include_svg_icons() {
    // Define SVG sprite file.
    $svg_icons = get_template_directory() . 'images/svg-icons.svg';
    // If it exsists, include it.
    if ( file_exists( $svg_icons ) ) {
        require_once( $svg_icons );
    }
}
add_action( 'wp_head', 'genesis_sample_include_svg_icons', 999 );


// copyright meta
function genexus_meta_info(){
    ?>
    <meta name="author" content="Great Circle Media">
    <meta name="dcterms.dateCopyrighted" content="2010">
    <meta name="dcterms.rights" content="All Rights Reserved">
    <meta name="dcterms.rightsHolder" content="Great Circle Media">
    <?php
}
//add_action( 'genesis_meta', 'genexus_meta_info' );
add_action('wp_head', 'genexus_meta_info');


//add animate to front page
function gx_add_to_head(){
    if( is_front_page() ){
        echo "<link type='text/css' rel='stylesheet' href='/wp-content/themes/genexus/assets/styles/animate/animate.min.css'>";
    }
}
//add_action('wp_head', 'gx_add_to_head');




/**********************************************************/
// ADD CPT'S TO ARCHIVES
// make archives include custom post types
function namespace_add_custom_types( $query ) {
    if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array(
            'post', 'nav_menu_item', 'whats-happening', 'concert', 'community-info', 'splash-post',
        ));
        return $query;
    }
}




/**********************************************************/
// CUSTOMIZE OUR HEADER
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//move prim menu above hdr
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_before_header', 'genesis_do_nav' );

// logo or text (chosen in theme customization)
// -- replaced with ours gx_site_title
//remove_action( 'genesis_site_title', 'genesis_seo_site_title' );

// tagline
//remove_action( 'genesis_site_description', 'genesis_seo_site_description');

// custom header
function gx_custom_header() {
    global $post;

    //remove default page header
    remove_action( 'genesis_header', 'genesis_do_header' );

    function custom_header(){

        ?>
            <div class="hdr-grid-wrap">

                <div class="hdr-1 hdr-nav-logo">
                    <a href="/" title="93-9 The Mountain Radio"><img src="<?php echo get_stylesheet_directory_uri();?>/images/93-9-the-mountain.svg" class="logo" alt="93-9 The Mountain KMGN Radio"></a>
                </div>

                <div class="hdr-2 hdr-nav-extra-mid">
                    <?php 
                        // TEMPORARY HEADER THING HERE
                    ?>
                </div>

                <div class="hdr-3">

                    <?php //===== HDR NAV ICONS =====// ?>
                    <div class="hdr-nav-icons">
                        <?php get_template_part( 'templates/hdr-nav-icons' ); ?>
                    </div>

                    <?php //===== SEARCH SHOW/HIDE =====// ?>
                    <div class="searchbar search-hide hide-me">
                        <form class="searchbar-form hide-me" itemprop="" itemscope="" itemtype="http://schema.org/SearchAction" method="get" action="<?php echo home_url('/'); ?>" role="search">
                            <meta itemprop="target" content="<?php echo home_url('/'); ?>?s={s}">
                            <input itemprop="query-input" type="search" name="s" placeholder="Search" class="search-field">
                            <button type="submit" class="btn-search">Search</button>
                        </form>
                    </div>
                    <br class="clearfix">

                </div>

            </div>
        <?php

    }
    add_action( 'genesis_header', 'custom_header' );

}
add_action( 'wp', 'gx_custom_header' );


//!!!!!  NOT USED !!!!!!
// Change site title (logo / "header left") to ours
function gx_site_title(){
    global $post;
    //====== OTHER HDR ======//
    $some_test_condition = false;
    if( $some_test_condition === true ) :  ?>
        <div class="some-other-logo-header">
            <a href="/"><img src="<?php echo get_stylesheet_directory_uri(); //default as placeholder ?>/images/logo-kaff.png" class="logo"></a>
        </div>
    <?php else :
    //====== DEFAULT HDR ======// ?>
        <div class="title-area-inner">
            <div class="hdr-nav-logo">
                <a href="/"><img src="<?php echo get_stylesheet_directory_uri();?>/images/logo-kaff.png" class="logo"></a>
            </div>
            <div class="hdr-nav-listen">
                <a class="listenlive" href="<?php echo $listenlivelink; ?>" target="_blank" title="Listen Live">
                    Listen Live <i class="fa fa-volume-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    <?php endif;
}
//!!!!!  NOT USED !!!!!!
//add_action( 'genesis_site_title', 'gx_site_title' );

//!!!!!  NOT USED !!!!!!
// Customize genesis_header_right (shows above default stuff in genesis_header_right)
function gx_header_right(){
    global $post;
    ?>
    <?php //===== HDR NAV ICONS =====// ?>
    <div class="hdr-nav-icons">
        <?php get_template_part( 'templates/hdr-nav-icons' ); ?>
    </div>
    <?php //===== SEARCH SHOW/HIDE =====// ?>
    <div class="searchbar search-hide hide-me">
        <form class="searchbar-form hide-me" itemprop="" itemscope="" itemtype="http://schema.org/SearchAction" method="get" action="<?php echo home_url('/'); ?>" role="search">
            <meta itemprop="target" content="<?php echo home_url('/'); ?>?s={s}">
            <input itemprop="query-input" type="search" name="s" placeholder="Search" class="search-field">
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
    <br class="clearfix">
    <?php
}
//!!!!!  NOT USED !!!!!!
//add_action( 'genesis_header_right', 'gx_header_right' );


// ****** END ******************



/**********************************************************/
// PAGE TAKEOVER 2.0
/**********************************************************/

// get the ptko options array
$ptko_settings = get_option('ptko_settings');

// check if page take over is enabled and add display to layout
if( $ptko_settings['ptko_toggle'] === 1 ){
    add_action( 'genesis_before_header', 'display_pto_banner' );
    add_action( 'genesis_before_footer', 'display_pto_banner' );
}

function display_pto_banner(){
    //called where needed to display PTO banner
    $ptko_settings = get_option('ptko_settings');
    if( $ptko_settings['ptko_toggle'] === 1 ){
        ?>
            <div class="takeover" style="background:<?php echo esc_attr($ptko_settings['ptko_bgcolor']);?>">
                <a href="<?php echo esc_url( $ptko_settings['ptko_link'] );?>" target="_blank" rel="nofollow">
                    <img src="<?php echo esc_url( $ptko_settings['ptko_hdrimg'] );?>">
                </a>
            </div>
        <?php
    }
}



/**********************************************************/
// CUSTOMIZE THE FOOTER

// Reposition the secondary navigation menu (Footer Menu) above footer
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Remove the default footer and replace with ours
remove_action( 'genesis_footer', 'genesis_do_footer' );
function gx_footer() {
    if ( is_page( 'some-page-we-dont-want-this-ftr-on' ) ){
        //some other footer
        //wp_footer();
    } else {
    ?>
    <div class="ftr-txt">
        <p class="copyright" data-enhance="false" data-role="none">
            <?php echo do_shortcode( '[footer_copyright]');?> <a href="https://gcmaz.com" data-enhance="false" data-role="none" title="Great Circle Media Northern Arizona">Great Circle Media</a> and <a href="/" title="93-9 The Mountain KMGN Radio">93-9 The Mountain KMGN Radio</a> &middot; All Rights Reserved
        </p>
    </div>
    <div class="ftr-logos">
        <div class="ftr-logo-gcm">
            <a href="https://gcmaz.com" title="Great Circle Media of Northern Arizona">
                <img src="https://gcmaz.com/wp-content/themes/genexus/images/gcm-logo-white.svg" alt="Great Circle Media - Flagstaff, Prescott, Sedona, Grand Canyon">
            </a>
        </div>
        <div class="ftr-logo-station">
            <a href="/" title="93-9 The Mountain Radio Arizona">
                <img src="<?php echo get_stylesheet_directory_uri();?>/images/93-9-the-mountain.svg" alt="93-9 The Mountain Radio - Flagstaff - Prescott">
            </a>
        </div>
    </div>
    <?php
    }
}
add_action( 'genesis_footer', 'gx_footer' );




/**********************************************************/
// CUSTOM MOBILE MENU

// Add the template
function genexus_mobile_nav() {
    get_template_part( 'templates/mobile-nav' );
}
add_action( 'genesis_before_header', 'genexus_mobile_nav');


// Create the mobile menu 
//$menu_name = 'Mobile Menu';
//$menu_exists = wp_get_nav_menu_object( $menu_name );

//if doesn't exist, create it
//if( ! $menu_exists ){
//    $menu_id = wp_create_nav_menu( $menu_name );

    //set default items
    // Home Page (repeat for other items)
//    wp_update_nav_menu_item( $menu_id, 0, array(
//        'menu-item-title' => __('Home'),
//        'menu-item-classes' => 'home',
//        'menu-item-url' => home_url('/'),
//        'menu-item-status' => 'publish'
//        ));
//}

// Get the mobile menu and modify the items output
function modify_mobile_menu(){

    // transient of menu
    //purge('mobile_menu_trans');

    if ( false === ( $mobile_menu_trans = get_transient( 'mobile_menu_trans' ) ) ) {

        // start creating html
        $menu_list = '';
        $menu_list .= '<nav class="js-menu sliding-panel-content">';
        $menu_list .= '<div class="wrap">';
        $menu_list .= '<ul class="menu genesis-nav-menu mobile-menu">';

        // get the menu object and items
        $locations = get_nav_menu_locations();
        $menu = get_term($locations['mobile-menu']);
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        // cycle through items and add arrow
        foreach( $menu_items as $menu_item ){

            //print_r($menu_item);

            if($menu_item->menu_item_parent === '0') {
                $menu_list .= '<li class="menu-item menu-item-has-child">';
            } else {
                $menu_list .= '<li class="menu-item">';
            }

            $menu_list .= '<a href="' . $menu_item->url . '" itemprop="url"><span itemprop="name">' . $menu_item->title . '</span></a>';
            $menu_list .= '</li>';
        }

        // finish building html
        $menu_list .= '</ul>';
        $menu_list .= '</div>';
        $menu_list .= '</nav>';

        $mobile_menu_trans = $menu_list;

        //set transient for 1 day
        set_transient( 'mobile_menu_trans', $mobile_menu_trans, 60*60*24 );

    } else {

        $mobile_menu_trans = get_transient( 'mobile_menu_trans' );

    }

    $menu_list = $mobile_menu_trans;
    //print_r($menu_items);
    echo $menu_list;

}
add_action( 'genesis_before_content_sidebar_wrap', 'modify_mobile_menu', 5 );




/**********************************************************/
// CUSTOMIZE THE Login Screen

// Use your own external URL logo link
function gx_url_login(){
    return "/";
}
add_filter('login_headerurl', 'gx_url_login');

// change logo
function gx_login_logo() {
    ?>
    <style type="text/css">
        body { background: #333; }
        #login #nav a,
        #login #backtoblog a{ color: #ffffff; }
        #login{ width:500px !important; }
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri();?>/images/93-9-the-mountain.svg) !important;
            width:500px !important;
            height:100px !important;
            background-size:contain !important;
            background-position:center top !important;
        }
    </style>
    <?php
}
add_action( 'login_head', 'gx_login_logo' );




/**********************************************************/
// ADD USER CONTACT INFO
/*  Add more contact details for WP users in profile */
function gx_user_contactmethods($contactmethods){
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['googleplus'] = 'Google+';
    return $contactmethods;
}
add_filter('user_contactmethods', 'gx_user_contactmethods', 10, 1);




/**********************************************************/
// PAGINATION
/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
function base_pagination() {
    global $wp_query;

    $big = 999999999; // This needs to be an unlikely integer

    // For more options and info view the docs for paginate_links()
    // http://codex.wordpress.org/Function_Reference/paginate_links
    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo '<div class="pagination">';
        echo $paginate_links;
        echo '</div><!--// end .pagination -->';
    }
}




/**********************************************************/
// FEATURED IMAGE
//Custom fn to display featured image in posts *with* the caption if it has one
 
function featured_image_in_post( ) {
    global $post;
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $thumbnail_details = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
    $thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'category-thumb' );
    $thumbnail_width = $thumbnail_src[1];

    if ($thumbnail_src && isset($thumbnail_src[0])) {
        echo '<div class="featured-image">';
        the_post_thumbnail( 'large', array( 'class'=>'img-responsive' ) );
        if ( !empty( $thumbnail_details[0]->post_excerpt ) ) {
            echo '<p class="featured-image-caption">';
            echo $thumbnail_details[0]->post_excerpt;
            echo '</p>';
        }
        echo '</div>';
    }
}




/**********************************************************/
// FUNCTIONS CALLED THROUGHOUT SITE

// Live or Dev (.dev)
//check if  on DEV or LIVE site
function live_or_local(){
    if( strpos( $_SERVER['HTTP_HOST'], '.dv') !== false ){
        //on dev site
        $liveOrLocal = 'local';
    } else {
        $liveOrLocal = 'live';
    }
    return $liveOrLocal;
}


// Check current category for News
//  dynamically provide either the genexus or kaff news logo based on page
// function check_current_category_for_news(){
//     // Get the news category id by slug
//     $newsCategory = get_category_by_slug('news');
//     $news_cat_id = $newsCategory->term_id;

//     // get child categories of news
//     $cat_args = array('child_of' => $news_cat_id);
//     $news_cat_children = get_categories($cat_args);

//     //get the children cats ids
//     $news_cats = array();
//     $i = 0;
//     foreach($news_cat_children as $news_cat_child){
//         $news_cats[$i] = $news_cat_child->cat_ID;
//         $i += 1;
//     }

//     //add children and parent together in array
//     array_push($news_cats, $news_cat_id);
//     //print_r($news_cats);
//     return($news_cats);
// }

// Convert Object to Array
// Fn to convert Objects of stdClass to Arrays
function object_to_array($object_to_array) {
    if (is_object($object_to_array)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $object_to_array = get_object_vars($object_to_array);
    }
    if (is_array($object_to_array)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $object_to_array);
    } else {
        // Return array
        return $object_to_array;
    }
}

/*
 * SimplePie function to shorten feed 
 */
function shorten($string, $length){
    // By default, an ellipsis will be appended to the end of the text.
    $suffix = '&hellip;';
 
    // Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
    // and convert all tabs and line-break characters to single spaces.
    //$short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
    // STACY mod - don't strip html !
    $short_desc = trim(str_replace(array("\r","\n", "\t" ), ' ', $string));
 
    // Cut the string to the requested length, and strip any extraneous spaces 
    // from the beginning and end.
    $desc = trim(mb_substr($short_desc, 0, $length));
 
    // Find out what the last displayed character is in the shortened string
    $lastchar = substr($desc, -1, 1);
 
    // If the last character is a period, an exclamation point, or a question 
    // mark, clear out the appended text.
    if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
 
    // Append the text.
    $desc .= $suffix;
 
    // Send the new description back to the page.
    return $desc;
}
function shorten_and_strip_html($string, $length){
    // By default, an ellipsis will be appended to the end of the text.
    $suffix = '&hellip;';
 
    // Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
    // and convert all tabs and line-break characters to single spaces.
    $short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
 
    // Cut the string to the requested length, and strip any extraneous spaces 
    // from the beginning and end.
    $desc = trim(mb_substr($short_desc, 0, $length));
 
    // Find out what the last displayed character is in the shortened string
    $lastchar = substr($desc, -1, 1);
 
    // If the last character is a period, an exclamation point, or a question 
    // mark, clear out the appended text.
    if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
 
    // Append the text.
    $desc .= $suffix;
 
    // Send the new description back to the page.
    return $desc;
}

// Add Post Categories to Body Classes
function gx_add_cat_to_body_classes( $classes ) {
    // Only proceed if we're on a single post page
    if ( !is_single() ) {
        return $classes;
    }
    // Get the categories that are assigned to this post
    $post_categories = get_the_category();
    // Loop over each category in the $categories array
    foreach( $post_categories as $current_category ) {
        // Add the current category's slug to the $body_classes array
        $classes[] = 'category-' . $current_category->slug;
    }
    // $body_classes array
    return $classes;
}
add_filter( 'body_class', 'gx_add_cat_to_body_classes' );

/***************** END FUNCTIONS ************************************


/**********************************************************/
// JETPACK TWEAKS
/* JetPack Publicize custom on/off chosen in Settings/GCMAZ */
// get current user id and compare it against stored id's in our gcmaz_publicize option value
function cust_jetpack_pub_fn(){
    $current_user = wp_get_current_user();
    $gcmaz_settings = get_option( 'gcmaz_settings' );
    if( !in_array( $current_user->ID, $gcmaz_settings['gcmaz_publicize'] ) ){
        // set auto post to unchecked
        add_filter( 'publicize_checkbox_default', '__return_false' );
        //echo "<script> alert('Booo');</script>";
        //print_r($gcmaz_settings['gcmaz_publicize']);
    }   
}
//add_action( 'after_setup_theme', 'cust_jetpack_pub_fn');


/* remove JetPack sharing buttons from excerpts */
function gcmaz_remove_filters_func() {
     remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
//add_action( 'init', 'gcmaz_remove_filters_func' );



/**********************************************************/
// GRAVITY FORMS
// Gravity Forms Custom Activation Template
// http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
function custom_maybe_activate_user() {

    $template_path = STYLESHEETPATH . '/gfur-activate-template/activate.php';
    $is_activate_page = isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation';

    if( ! file_exists( $template_path ) || ! $is_activate_page  )
        return;

    require_once( $template_path );

    exit();
}
add_action('wp', 'custom_maybe_activate_user', 9);

// Add Body Class to GF Activation Page
function wp_body_classes( $classes ) {
    // check if is gf_activation page via url
    if( isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation') {

        $classes[] = 'gfactivate';
        //print_r($classes);
        //body_class( 'gfactivate' );

    }
    error_reporting(0);
    return $classes;
}
add_filter( 'body_class','wp_body_classes' );


// redirect Advertising Info gravity form to sales contacts
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
    // id 3 => advertising info
    if( $form['id'] == '3' ) {
        $confirmation = array( 'redirect' => '/advertising-info' );
    }
    return $confirmation;
}
add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );


/**********************************************************/
// META SLIDER
// Restrict Meta Slider to admins
function metaslider_permissions($capability) {
    $capability = 'administrator';
    return $capability;
}
add_filter( "metaslider_capability", "metaslider_permissions" );


/**********************************************************/
// ADROTATE
// need to check if adrotate plugin is even active
// include file needed to detect plugin - front end use only
function is_adrotate_plugin_active() {

    include_once( ABSPATH . 'wp-admin/includes/plugin.php');

    if ( is_plugin_active( 'adrotate/adrotate.php' ) ) {
        return true;
    } else {
        return false;
    }

}



/**********************************************************/
// BREADCRUMBS
//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
    $args['home'] = 'Home';
    $args['sep'] = ' / ';
    $args['list_sep'] = ', '; // Genesis 1.5 and later
    $args['prefix'] = '<div class="breadcrumb">';
    $args['suffix'] = '</div>';
    $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
    $args['heirarchial_categories'] = true; // Genesis 1.5 and later
    $args['display'] = true;
    $args['labels']['prefix'] = '';
    $args['labels']['author'] = 'Archives for ';
    $args['labels']['category'] = 'Archives for '; // Genesis 1.6 and later
    $args['labels']['tag'] = 'Archives for ';
    $args['labels']['date'] = 'Archives for ';
    $args['labels']['search'] = 'Search for ';
    $args['labels']['tax'] = 'Archives for ';
    $args['labels']['post_type'] = 'Archives for ';
    $args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later
return $args;
}


/**********************************************************/
// CUSTOM QUERY VARS
// Add Custom Query Vars for the Media Kits, Adv Info, Etc where I append them in the url's
 
function add_query_vars_filter($vars){
    $vars[] = 'show';
    $vars[] = 'uid';
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');



/**********************************************************/
// ON-AIR STAFF / IN THE STUDIO

function whos_in_the_studio() {

    // set the default timezone in case not set in server
    date_default_timezone_set('America/Phoenix');

    // get current day of week
    $cur_day = date('D');
    // get current hour 24 format
    $cur_hour = intval( date('H') );
    // get current min
    //$cur_min = intval( date('i') );

    $current_show = '';

    // Weekdays
    if ( $cur_day === 'Mon' || $cur_day === 'Tue' || $cur_day === 'Wed' || $cur_day === 'Thu' || $cur_day === 'Fri') {

        if ( $cur_hour >= 6 &&  $cur_hour < 10 ) {
            //morning 6:00a-9:59a
            $current_show = 'Eddie Miller';

        } elseif ( $cur_hour >= 10 && $cur_hour < 14 ) {
            //midday 10:00a-1:59p
            $current_show = 'Leza';

        } elseif( $cur_hour >= 14 && $cur_hour < 19 ) {
            //afternoon 2:00p-7:00p
            $current_show = 'Mike Menter';
            
        } else {
            $current_show = '93-9 The Mountain';
        }

    } elseif ( $cur_day === 'Fri' ) {
        //Fri
        if ( $cur_hour >= 9 && ( $cur_hour < 12 ) ) {
            //9-midnight
            $current_show = 'The House of Hair';
        } else {
            $current_show = '93-9 The Mountain';
        }

    } elseif ( $cur_day === 'Sat' ) {
        //Sat
        if ( $cur_hour >= 7 && ( $cur_hour < 10 ) ) {
            //Micki Free
            $current_show = 'Micki Free';
        } else {
            $current_show = '93-9 The Mountain';
        }

    } else {
        //Default
        $current_show = '93-9 The Mountain';
    }

    return $current_show;

}