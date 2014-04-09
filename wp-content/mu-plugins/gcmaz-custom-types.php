<?php

/*
Plugin Name: GCMAZ Custom Post Types
Plugin URI: http://www.gcmaz.com
Description: Creates the custom post types for gcmaz wp sites
Author: Stacy Mark
Version: 1.0
Author URI: http://www.gcmaz.com/
*/

add_action('init', 'whats_post_type');
add_action('init', 'community_post_type');
add_action('init', 'concert_post_type');

// custom post types
function whats_post_type(){
    $args = array(
            'labels' => array(
                'name' => __("What's Happening in Northern Arizona"),
                'singular_name' => __('Whats Post'),
                'menu_name' => __('Whats Post'),
                'all_items' => __('See All Posts'),
                'add_new' => __('Add New Post'),
                'add_new_item' => __('Add New Whats Post'),
                'edit' => __('Edit'),
                'edit_item' => __('Edit Post'),
                'new_item' => __('New Post'),
                'view' => __('View Post'),
                'view_item' => __('View Post'),
                'search_items' => __('Search Whats'),
                'not_found' => __('No Whats Posts'),
                'not_found_in_trash' => __('No Whats posts in the trash'),
            ),
            'hierarchichal' => false,
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => plugins_url( 'icon_gcmaz.png', __FILE__ ),
            'has_archive' => true,
            'rewrite' => array('slug' => 'whats-happening'),
            'capability_type' => 'post',
            'supports' => array('title', 'excerpt', 'editor', 'author', 'thumbnail'),
            'description' => "A 'whats' post is a blurb for the Whats Happening page.",
    );
    register_post_type('whats-happening', $args);
}
function community_post_type(){
    $args = array(
            'labels' => array(
                'name' => __('Northern Arizona Community Info'),
                'singular_name' => __('Community Post'),
                'menu_name' => __('Community Post'),
                'all_items' => __('See All Posts'),
                'add_new' => __('Add New Post'),
                'add_new_item' => __('Add New Community Post'),
                'edit' => __('Edit'),
                'edit_item' => __('Edit Post'),
                'new_item' => __('New Post'),
                'view' => __('View Post'),
                'view_item' => __('View Post'),
                'search_items' => __('Search Community'),
                'not_found' => __('No Community Posts'),
                'not_found_in_trash' => __('No Community posts in the trash'),
            ),
            'hierarchichal' => false,
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => plugins_url( 'icon_gcmaz.png', __FILE__ ),
            'query_var' => true,
            'can_export' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'community-info'),
            'capability_type' => 'post',
            'supports' => array('title', 'excerpt', 'editor', 'author', 'thumbnail'),
            'description' => "A 'community' post is a blurb for the Community Info page.",
    );
    register_post_type('community-info', $args);
}
function concert_post_type(){
    $args = array(
            'labels' => array(
                'name' => __('Concerts Near You'),
                'singular_name' => __('Concert Post'),
                'menu_name' => __('Concert Post'),
                'all_items' => __('See All Concerts'),
                'add_new' => __('Add New Concert'),
                'add_new_item' => __('Add New Concert'),
                'edit' => __('Edit'),
                'edit_item' => __('Edit Post'),
                'new_item' => __('New Post'),
                'view' => __('View Post'),
                'view_item' => __('View Post'),
                'search_items' => __('Search Concerts'),
                'not_found' => __('No Concert Posts'),
                'not_found_in_trash' => __('No Concert posts in the trash'),
            ),
            'hierarchichal' => false,
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => plugins_url( 'icon_gcmaz.png', __FILE__ ),
            'has_archive' => true,
            'rewrite' => array('slug' => 'concerts'),
            'capability_type' => 'post',
            'supports' => array('title', 'excerpt', 'editor', 'author', 'thumbnail'),
            'description' => "A 'concert' post is a listing for the Concert page.",
    );
    register_post_type('concert', $args);
}

//place custom fields on admin screen
add_action( 'admin_init', 'add_whats_box' );
add_action('admin_init', 'add_community_box');
add_action('admin_init', 'add_concert_box');

function add_whats_box(){
    add_meta_box('whats_info', 'Date', 'whats_fields', 'whats-happening', 'normal', 'core');
}
function add_community_box(){
    add_meta_box('community_info', 'Date', 'community_fields', 'community-info', 'normal', 'core');
}
function add_concert_box(){
    add_meta_box('concert_info', 'Date', 'concert_fields', 'concert', 'normal', 'core');
}

// Enqueue Datepicker + jQuery UI CSS
wp_enqueue_script( 'jquery-ui-datepicker' );
wp_enqueue_style( 'jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

//create custom fields 
function whats_fields (){
    global $post;
    $custom = get_post_custom($post->ID);
    $whats_date = $custom['whats_date'][0];
    $whats_fulldate = $custom['whats_fulldate'][0];
    ?>
    <p>
        <label>Date (leave blank for ongoing)</label><br />
        <input size="45" name="whats_date" id="whats_date" value="<?php echo $whats_date; ?>" />
        <input type="hidden" name="whats_fulldate" id="whats_fulldate"/>
    </p>
    <script>
        jQuery(document).ready(function(){
            jQuery('#whats_date').datepicker({
                dateFormat : 'D, M d',
                altFormat: 'yy-mm-dd',
                altField: '#whats_fulldate'
            });
        });
    </script>
    <?php
}
function community_fields (){
    global $post;
    $custom = get_post_custom($post->ID);
    $community_date = $custom['community_date'][0];
    ?>
    <p>
        <label>Date (leave blank for ongoing)</label><br />
        <input size="45" name="community_date" id="community_date" value="<?php echo $community_date; ?>" />
    </p>
    <script>
        jQuery(document).ready(function(){
            jQuery('#community_date').datepicker({
                dateFormat : 'D, M d'
            });
        });
    </script>
    <?php
}
function concert_fields (){
    global $post;
    $custom = get_post_custom($post->ID);
    $concert_date = $custom['concert_date'][0];
    ?>
    <p>
        <label>Date (leave blank for ongoing)</label><br />
        <input size="45" name="concert_date" id="concert_date" value="<?php echo $concert_date; ?>" />
    </p>
    <script>
        jQuery(document).ready(function(){
            jQuery('#concert_date').datepicker({
                dateFormat : 'D, M d'
            });
        });
    </script>
    <?php
}

// save action
add_action('save_post', 'save_whats_attributes');
add_action('save_post', 'save_community_attributes');
add_action('save_post', 'save_concert_attributes');
add_action('publish_post', 'save_whats_attributes');
add_action('publish_post', 'save_community_attributes');
add_action('publish_post', 'save_concert_attributes');

function save_whats_attributes(){
    global $post;
    update_post_meta($post->ID, "whats_date", $_POST["whats_date"]);
    update_post_meta($post->ID, "whats_fulldate", $_POST["whats_fulldate"]);
}
function save_community_attributes(){
    global $post;
    update_post_meta($post->ID, "community_date", $_POST["community_date"]);
}
function save_concert_attributes(){
    global $post;
    update_post_meta($post->ID, "concert_date", $_POST["concert_date"]);
}

//add taxonomy
add_action('init', 'create_location_taxonomy', 0);

function create_location_taxonomy(){
    $loc_labels = array(
        'name' => 'Location',
        'singular_name' => 'location',
        'search_items' => 'Search location',
        'popular_items' => 'Popular locations',
        'all_items' => 'All locations',
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Edit location',
        'update_item' => 'Update location',
        'add_new_item' => 'Add new location',
        'new_item_name' => 'New location name',
        'separate_items_with_commas' => 'Separate locations with commas',
        'add_or_remove_items' => 'Add or remove locations',
        'choose_from_most_used' => 'Choose from common locations',
        'menu_name' => 'Locations',
    );
    register_taxonomy('locations', array('whats-happening', 'community-info', 'concert'), array(
        'hierarchical' => false,
        'labels' => $loc_labels,
        'query_var' => true,
        'update_count_callback' => '_update_post_term_count',
        'rewrite' => array('slug' => 'locations')
    ));
}