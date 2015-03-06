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
            .takeover{background:$bgcolor;background-image: url('$bgimg');background-position:center 38px;background-repeat:no-repeat;}
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

/*
 * START Create pages programatically
 * @returns -1 if the post was never created, -2 if a post with the same title exists, or the ID of the post if successful.
 * 
 * pages on templates need to have tpl defined.  pages with their own page-asdf.php need tpl set null
 * pages we need to create are
 * ----------------- 
 * song requests
 * contact
 * advertise (x2)
 * weather
 * thank you - form redirect
 * whats
 * community
 * concerts
 * on air
 * 
 */
/* ONLY NEEDED FOR SETUP
$pages = array(
    $page_requests = array(
        'page_id' => -1,
        'slug' => 'song-requests',
        'author_id' => 1,
        'title' => 'Request a Song',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_contact = array(
        'page_id' => -1,
        'slug' => 'contact-radio',
        'author_id' => 1,
        'title' => 'Contact Radio',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_advertise = array(
        'page_id' => -1,
        'slug' => 'advertise-on-northern-arizona-radio',
        'author_id' => 1,
        'title' => 'Advertise On Northern Arizona Radio',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_adv_info = array(
        'page_id' => -1,
        'slug' => 'advertising-info',
        'author_id' => 1,
        'title' => 'Advertising Information',
        'tpl' => 'template-feed-advertising.php',
    ),
    $page_weather = array(
        'page_id' => -1,
        'slug' => 'weather',
        'author_id' => 1,
        'title' => 'Area Weather',
        'tpl' => '',
    ),
    $page_thanks = array(
        'page_id' => -1,
        'slug' => 'thank-you',
        'author_id' => 1,
        'title' => 'Thank You',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_whats = array(
        'page_id' => -1,
        'slug' => 'whats-happening-northern-arizona',
        'author_id' => 1,
        'title' => 'Whats Happening in Northern Arizona',
        'tpl' => 'template-feed-whats.php',
    ),
    $page_community = array(
        'page_id' => -1,
        'slug' => 'northern-arizona-community-info',
        'author_id' => 1,
        'title' => 'Northern Arizona Community Information',
        'tpl' => 'template-feed-community.php',
    ),
    $page_concerts = array(
        'page_id' => -1,
        'slug' => 'concerts-northern-arizona',
        'author_id' => 1,
        'title' => 'Concerts in Northern Arizona,
        'tpl' => 'template-feed-concerts.php',
    ),
    $page_onair = array(
        'page_id' => -1,
        'slug' => 'radio-shows',
        'author_id' => 1,
        'title' => 'On Air Shows',
        'tpl' => 'template-rbn-hdr.php',
    ),
);
foreach($pages as $pinfo){
    //print_r($pinfo);
    $page_id = $pinfo['page_id'];
    $slug = $pinfo['slug'];
    $author_id = $pinfo['author_id'];
    $title = $pinfo['title'];
    $tpl = $pinfo['tpl'];
    
    $pnum += 1;
    $programatically_create_pages = 'programatically_create_pages' + $pnum;
    $programatically_create_pages = function($page_id, $slug, $author_id, $title, $tpl) {
        $page_id = $page_id;
        $slug = $slug;
        $author_id = $author_id;
        $title = $title;
        $tpl = $tpl;
        $parent_id = 0; // default - no parent is 0
        //if page doesnt exist create it
        if(null == get_page_by_title($title)){
            //if one of adv info pages, get page id of parent so we can insert as the parent id
            if($tpl == 'template-adv-info.php'){
                $adv_pg = get_page_by_title('Advertise On Northern Arizona Radio');
                $parent_id = $adv_pg->ID;
            }
            //set post id so we know it was successfully created
            $page_id = wp_insert_post(array(
                'comment_status' => 'closed',
                'ping_status' =>'closed',
                'post_author' => $author_id,
                'post_name' => $slug,
                'post_title' => $title,
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_parent' => $parent_id,
                )
            );
            update_post_meta($page_id, '_wp_page_template', $tpl);
        } else {
            // use -2 to indicate the page exists
            $post_id = -2;
        }
    };
    
    add_filter('after_setup_theme', $programatically_create_pages($page_id, $slug, $author_id, $title, $tpl));
}
*/

/*
 * END Auto page creation
 */