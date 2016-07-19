<?php
// leaderboard ads are created in the adrotate plugin
// each ad is assigned to a group(s)
// pages are assigned a group below (and in the plugin), which is how we tell the page which ads we want to display
// first, check if adrotate plugin is even active

// detect plugin - front end use only
include_once( ABSPATH . 'wp-admin/includes/plugin.php');
// check for plugin by using plugin name
if( is_plugin_active( 'adrotate/adrotate.php' ) ){
    
    global $post;
    
    if(!empty( $post )){

        //compare the guid against our known ones
        //get current page/post guid
        $p_guid = get_the_guid($post->ID);

        //get the position of numbers after equal sign
        $guid_num_pos = strpos( $p_guid, "=" ) + 1;
        //get the numbers only from the guid
        $guid_num = substr( $p_guid, $guid_num_pos );

        //get the domain name & populate our guids (different guids on .dev and .com)
        if( strpos( $_SERVER['HTTP_HOST'], '.dev') !== false ){
            //on .dev site
            $guid_whats = 239;
            $guid_comm = 236;
            $guid_concerts = 241;
        } else {
            // on .com site
            $guid_whats = 513;
            $guid_comm = 509;
            $guid_concerts = 511;
        }

        if( is_front_page() ){
            $groupnum = 10;
        //} elseif($post->post_type == 'whats-happening') {
        } elseif( $guid_num == $guid_whats ) {
            $groupnum = 11;
        //} elseif($post->post_type == 'community-info') {
        } elseif( $guid_num == $guid_comm ) {
            $groupnum = 12;
        //} elseif($post->post_type == 'concert') {
        } elseif( $guid_num == $guid_concerts ) {
            $groupnum = 13;
        }

        // since groupnum is populated from above, lets echo necessary html to display it
        if(!empty( $groupnum )){
            if(substr(adrotate_group($groupnum), 0, 5) == "<span" || substr(adrotate_group($groupnum), 0, 2) == "<!"){
                // no ads in our group or error retrieving them
                // (test to see if it returned an <a tag ... if not, it must be an error message)
                // see adrotate-output.php for list of errors
            } else {
                echo '<div class="col-xs-12 expldrbrd centered">';
                     echo adrotate_group($groupnum);
                echo '</div>';
            }
        } 
    }

}