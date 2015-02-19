<?php
global $post;
if(!empty( $post )){
    if(is_front_page()){
        dynamic_sidebar('sidebar-homepage');
    } elseif($post->post_type == 'concert' || $post->post_name == 'concerts-northern-arizona'){
        dynamic_sidebar('sidebar-concert');
    } elseif($post->post_type == 'whats-happening' || $post->post_name == 'whats-happening-northern-arizona'){
        dynamic_sidebar('sidebar-whats');
    } elseif($post->post_type == 'community-info' || $post->post_name == 'northern-arizona-community-info'){
        dynamic_sidebar('sidebar-community');
    } elseif($post->post_name == 'radio-shows'){
        dynamic_sidebar('sidebar-onair');
    } elseif($post->post_name == 'weather'){
        dynamic_sidebar('sidebar-weather');
    } elseif($post->post_name == 'song-requests'){
        dynamic_sidebar('sidebar-songrequests');
    } else {
        dynamic_sidebar('sidebar-primary');
    }
}
?>