<?php
/**
 * Custom functions
 */

//debugging things
// opt A
//$e = new \Exception;
//var_dump($e->getTraceAsString());
// opt B
//var_dump(debug_backtrace());

global $station;
$station = 'KMGN';

// *** START Session for all *.gcmaz.com to set domain var (to keep track of which subdomain user started on)
/*function register_session( $lifetime = 600 ){
    if(!session_id()){
        session_set_cookie_params($lifetime, '/', '.gcmaz.com');
        session_name( 'gcmaz' );
        session_start();
    }
    //set the variable
    $_SESSION['startDomain'] = '939themountain';
}
add_action('init', 'register_session');*/

/*
 * Flush rewrite rules for custom post types
 * urls give a 404 otherwise
 */
add_action( 'after_switch_theme', 'our_flush_rewrite_rules' );
function our_flush_rewrite_rules() {
     flush_rewrite_rules();
}



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




// add more buttons to editor
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

/* change page title in admin (wrong for some reason) */
add_filter('admin_title', 'my_admin_title', 10, 2);
function my_admin_title($admin_title, $title){
    return get_bloginfo('name') . ' &bull; ' . $title;
}


// GCMAZ Enqueue
function gcmaz_enqueue() {

    global $post;
    
    //if( $post->post_name === '12-days-of-christmas-on-93-9-the-mountain' ){
        //  //jquery snowfall
        //wp_register_script('jquery-snowfall', get_template_directory_uri() . '/assets/js/JQuery-Snowfall/dist/snowfall.jquery.min.js', false, null, false);
        //wp_enqueue_script('jquery-snowfall');
    //}
}
add_action('wp_enqueue_scripts', 'gcmaz_enqueue');


/*
 * Add Custom Code to Page Head
 */
add_action('wp_head', 'gcmaz_add_to_head');
function gcmaz_add_to_head(){
    echo "<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>";
    //if( is_front_page() ){
        //echo "<link type='text/css' rel='stylesheet' href='/assets/css/animate/animate.min.css'>";
    //}
}

// PAGE TAKE OVER FUNCTIONS CALLED BY ADMIN OPTIONS
// get the ptko options array
$ptko_settings = get_option('ptko_settings');
// check if page take over is enabled 
if($ptko_settings['ptko_toggle'] == 1){
    // create new styles and put in head
    add_action('wp_head', 'ptko_styles');
    function ptko_styles(){
        $ptko_settings = get_option('ptko_settings');
        $bgcolor = esc_attr($ptko_settings['ptko_bgcolor']);
        $bgimg = esc_url($ptko_settings['ptko_bgimg']);
        $newstyles = "
            <style type='text/css'>
            .takeover{background:$bgcolor;background-image: url('$bgimg');background-position:center 58px;background-repeat:no-repeat;}
            @media (max-width: 767px) { .takeover{background:$bgcolor;}
            </style>
        ";
        echo $newstyles;
    }
    // add takeover class to body
    add_filter('body_class', 'add_takeover_body_class');
    function add_takeover_body_class($classes){
        $classes[] = 'takeover';
        return $classes;
    }
    // add takeover header
    add_action('display_ptko', 'ptko_inc_hdr');
    function ptko_inc_hdr($ptko_settings){
        get_template_part('templates/takeover-hdr');
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

/*
 * Add Custom Query Vars for the Media Kits, Adv Info, Etc where I append them in the url's
 */
function add_query_vars_filter($vars){
    $vars[] = 'show';
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');

/*
 *  function to convert object to array
 */
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
 * redirect Advertising Info gravity form to sales contacts
 */
add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
    // id 3 => advertising info
    if( $form['id'] == '3' ) {
        $confirmation = array( 'redirect' => '/advertising-info' );
    }
    return $confirmation;
}




//check if  on DEV (VAG) or LIVE site
function live_or_local(){
    if( strpos( $_SERVER['HTTP_HOST'], '.vag') !== false ){
        //on .vag (dev) site
        $liveOrLocal = 'local';
    } else {
        $liveOrLocal = 'live';
    }
    return $liveOrLocal;
}




// Summer Promotion 2016 Casino Chip
// goal - check "hour" and pick a page to display
// function called in base.php
function display_sum_promo_casino_chip() {

    global $post;

    // get current day of week check for Tuesday
    $cur_day = date('D');
    //print_r ($cur_day);

    // Only on Tuesdays
    if ( $cur_day === 'Tue' ) {

        // get current hour 24 format
        $cur_hour = intval( date('H') );

        //print_r ($cur_hour);

        // slugs aren't consistent or permanent - use keywords in slugs instead
        $cur_slug = get_permalink();

        $simplified_slugs = array();
        if ( stripos( $cur_slug, 'community' ) !== false ){
            $simplified_slugs[] = "community";

        } elseif ( stripos( $cur_slug, 'concert' ) !== false ){
            $simplified_slugs[] = "concerts";

        } elseif ( stripos( $cur_slug, 'what' ) !== false ){
            $simplified_slugs[]= "whats";

        } elseif ( stripos( $cur_slug, 'about' ) !== false ){
            $simplified_slugs[]= "about";

        } elseif ( stripos( $cur_slug, 'weather' ) !== false ){
            $simplified_slugs[]= "weather";

        } elseif ( stripos( $cur_slug, 'radio-shows' ) !== false ){
            $simplified_slugs[]= "radio-shows";

        } elseif ( stripos( $cur_slug, 'contact' ) !== false ){
            $simplified_slugs[]= "contact";

        } elseif ( stripos( $cur_slug, 'request' ) !== false ){
            $simplified_slugs[]= "request";

        } elseif ( stripos( $cur_slug, 'home' ) !== false ){
            $simplified_slugs[]= "home";

        }

        // Set Pages to display by hour
        // $pages_to_show_chip = array(
        //     'about',
        //     'weather',
        //     'community',
        //     'concerts',
        //     'radio-shows',
        //     'contact',
        //     'whats',
        //     'request',
        // );

        if ( $cur_hour === 0 || $cur_hour === 6 || $cur_hour === 12 || $cur_hour === 18 || $cur_hour === 24 ) {
            $pages_to_show_chip = array(
                'about',
            );

        } elseif ( $cur_hour === 1 || $cur_hour === 7 || $cur_hour === 13 || $cur_hour === 19 ) {
            $pages_to_show_chip = array(
                'community',
            );
            
        } elseif ( $cur_hour === 2 || $cur_hour === 8 || $cur_hour === 14 || $cur_hour === 20 ) {
            $pages_to_show_chip = array(
                'concerts',
            );
            
        } elseif ( $cur_hour === 3 || $cur_hour === 9 || $cur_hour === 15 || $cur_hour === 21 ) {
            $pages_to_show_chip = array(
                'whats',
            );
            
        } elseif ( $cur_hour === 4 || $cur_hour === 10 || $cur_hour === 16 || $cur_hour === 22 ) {
            $pages_to_show_chip = array(
                'radio-shows',
            );
            
        } elseif ( $cur_hour === 5 || $cur_hour === 11 || $cur_hour === 17 || $cur_hour === 23 ) {
            $pages_to_show_chip = array(
                'request',
            );
            
        } else {
            // shouldn't ever happen (all possible hours handled above)
            // just in case
            $pages_to_show_chip = array(
                'home',
            );
        }

        // if the arrays intersect, display the chip
        if( array_intersect( $simplified_slugs , $pages_to_show_chip ) ) : ?>

            <div  class="sum-promo-casino-chip">
                <a href="#" class="chip-click">
                    <img alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sum-prom-casino-chip-kmgn.png" class="sum-prom-casino-chip"/>
                </a>
            </div>
            <!-- js notices -->
            
            <div class="js-notice" style="background:#ff0;">
                <noscript>JavaScript Must Be Enabled To Enter The Game!</noscript>
                <p><a href="https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=enable%20javascript%20in%20browser" style="font-size:18px;font-weight:600;" target="_blank">How To Enable JavaScript &raquo;</a></p>
            </div>

        <?php endif;

    } // if Tuesday

}




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




