<?php
/**
 * Custom functions
 */

global $station;
$station = 'KMGN';

// *** START Session for all *.gcmaz.com to set domain var (to keep track of which subdomain user started on)
function register_session( $lifetime = 600 ){
    if(!session_id()){
        session_set_cookie_params($lifetime, '/', '.gcmaz.com');
        session_name( 'gcmaz' );
        session_start();
    }
    //set the variable
    $_SESSION['startDomain'] = '939themountain';
}
add_action('init', 'register_session');

/*
 * Flush rewrite rules for custom post types
 * urls give a 404 otherwise
 */
add_action( 'after_switch_theme', 'bt_flush_rewrite_rules' );
function bt_flush_rewrite_rules() {
     flush_rewrite_rules();
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
function shorten($string, $length)
{
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

