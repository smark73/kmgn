<?php
global $post;

if(!empty( $post )){
    // need to keep is_search check first ... otherwise gets wrong sidebar as search info moves into post->info (a search for "concerts" calls the concerts sidebar)
    if( is_search() ) {
        //echo "<div style='background:yellow'>search</div>";
        dynamic_sidebar('sidebar-primary');
        
    } elseif(is_front_page()){
        //echo "<div style='background:yellow'>front page</div>";
        dynamic_sidebar('sidebar-homepage');
        
    } elseif($post->post_type == 'concert' || $post->post_name == 'concerts-northern-arizona'){
        //echo "<div style='background:yellow'>concert</div>";
        dynamic_sidebar('sidebar-concert');
        
    } elseif($post->post_type == 'whats-happening' || $post->post_name == 'whats-happening-northern-arizona'){
        //echo "<div style='background:yellow'>whats</div>";
        dynamic_sidebar('sidebar-whats');
        
    } elseif($post->post_type == 'community-info' || $post->post_name == 'northern-arizona-community-info'){
        //echo "<div style='background:yellow'>community</div>";
        dynamic_sidebar('sidebar-community');
        
    } elseif($post->post_name == 'radio-shows'){
        //echo "<div style='background:yellow'>on air</div>";
        dynamic_sidebar('sidebar-onair');
        
    } elseif($post->post_name == 'weather'){
        //echo "<div style='background:yellow'>weather</div>";
        dynamic_sidebar('sidebar-weather');
        
    } elseif($post->post_name == 'song-requests'){
        //echo "<div style='background:yellow'>requests</div>";
        dynamic_sidebar('sidebar-songrequests');
        
    } else {
        dynamic_sidebar('sidebar-primary');
    }
    
} else {
    
    dynamic_sidebar('sidebar-primary');
    
}
?>