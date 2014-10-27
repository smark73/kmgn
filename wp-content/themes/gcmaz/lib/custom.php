<?php
/**
 * Custom functions
 */

global $station;
$station = 'KMGN';

// *** START Session for all *.gcmaz.com to set domain var (to keep track of which subdomain user started on)
function register_session($ses_name = 'gcmaz', $lifetime = 600){
    if(!session_id()){
        session_set_cookie_params($lifetime, '/', '.gcmaz.com');
        session_name($ses_name);
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
 * START Create pages programatically
 * @returns -1 if the post was never created, -2 if a post with the same title exists, or the ID of the post if successful.
 * 
 * pages on templates need to have tpl defined.  pages with their own page-asdf.php need tpl set null
 * pages we need to create are
 * ----------------- 
 * on air
 * song requests
 * photos
 * weather
 * contact
 * jobs
 * advertise
 *   - sales marketing contacts
 *   - internet info
 *   - kaff media kit
 *   - kaff am media kit
 *   - mtn media kit
 *   - hits media kit
 *   - magic media kit
 *   - oldies media kit
 * thank you - form redirect
 */
$pages = array(
    $page_onair = array(
        'page_id' => -1,
        'slug' => 'radio-shows',
        'author_id' => 1,
        'title' => 'On Air Shows',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_requests = array(
        'page_id' => -1,
        'slug' => 'song-requests',
        'author_id' => 1,
        'title' => 'Request a Song on 93-9 The Mountain',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_photos = array(
        'page_id' => -1,
        'slug' => 'photos',
        'author_id' => 1,
        'title' => '93-9 The Mountain Photos',
        'tpl' => '',
    ),
    $page_weather = array(
        'page_id' => -1,
        'slug' => 'weather',
        'author_id' => 1,
        'title' => 'Area Weather',
        'tpl' => '',
    ),
    $page_contact = array(
        'page_id' => -1,
        'slug' => 'contact-93-9-rock-radio',
        'author_id' => 1,
        'title' => 'Contact 93-9 The Mountain Radio',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_jobs = array(
        'page_id' => -1,
        'slug' => 'employment',
        'author_id' => 1,
        'title' => 'Employment at 93-9 The Mountain Radio',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_advertise = array(
        'page_id' => -1,
        'slug' => 'advertise-on-northern-arizona-radio',
        'author_id' => 1,
        'title' => 'Advertise On Northern Arizona Radio',
        'tpl' => 'template-rbn-hdr.php',
    ),
    $page_sales = array(
        'page_id' => -1,
        'slug' => 'sales-and-marketing-contacts',
        'author_id' => 1,
        'title' => 'Sales and Marketing Contacts',
        'tpl' => 'template-adv-info.php',
    ),
    $page_internet = array(
        'page_id' => -1,
        'slug' => 'internet-and-digital-advertising',
        'author_id' => 1,
        'title' => 'Internet and Digital Advertising',
        'tpl' => 'template-adv-info.php',
    ),
    $page_kaffmk = array(
        'page_id' => -1,
        'slug' => 'kaff',
        'author_id' => 1,
        'title' => '92.9 KAFF Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_kaffammk = array(
        'page_id' => -1,
        'slug' => 'kaff-am',
        'author_id' => 1,
        'title' => 'Flagstaff Country 93.5 AM 930 (KAFF AM) Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_kmgnmk = array(
        'page_id' => -1,
        'slug' => 'kmgn',
        'author_id' => 1,
        'title' => '93-9 The Mountain (KMGN) Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_kfszmk = array(
        'page_id' => -1,
        'slug' => 'kfsz',
        'author_id' => 1,
        'title' => 'Hits 106 (KFSZ) Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_ktmgmk = array(
        'page_id' => -1,
        'slug' => 'ktmg',
        'author_id' => 1,
        'title' => 'Magic 99.1 (KTMG) Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_knotmk = array(
        'page_id' => -1,
        'slug' => 'knot',
        'author_id' => 1,
        'title' => 'Fun Oldies 100.9 1450AM (KNOT) Media Kit',
        'tpl' => 'template-adv-info.php',
    ),
    $page_thanks = array(
        'page_id' => -1,
        'slug' => 'thank-you',
        'author_id' => 1,
        'title' => 'Thank You',
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

/*
 * END 
 */

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

/*
 * Add Custom Query Vars for the Media Kits, Adv Info, Etc where I append them in the url's
 */
function add_query_vars_filter($vars){
    $vars[] = 'show';
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');