<?php
// leaderboard ads are created in the adrotate plugin
// each ad is assigned to a group(s)
// pages are assigned a group below (and in the plugin), which is how we tell the page which ads we want to display

if($post->post_title == 'Home'){
    $groupnum = 10;
} elseif($post->post_type == 'whats-happening') {
    $groupnum = 11;
} elseif($post->post_type == 'community-info') {
    $groupnum = 12;
} elseif($post->post_type == 'concert') {
    $groupnum = 13;
}

// since groupnum is populated from above, lets echo necessary html to display it
if($groupnum !== null){
    if(substr(adrotate_group($groupnum), 0, 2) != "<a"){
        // no ads in our group or error retrieving them
        // (test to see if it returned an <a tag ... if not, it must be an error message)
        // see adrotate-output.php for list of errors
    } else {
        echo '<div class="hidden-xs expldrbrd centered">';
             echo adrotate_group($groupnum);
        echo '</div><div class="col-xs-12 hidden-sm hidden-md hidden-lg centered">';
            echo adrotate_group($groupnum);
        echo '</div>';
    }
} 
