<?php
if($post->post_title == 'Home'){
    dynamic_sidebar('sidebar-homepage');
} elseif($post->post_type == 'concert'){
    dynamic_sidebar('sidebar-concert');
} elseif($post->post_type == 'whats-happening'){
    dynamic_sidebar('sidebar-whats');
} elseif($post->post_type == 'community-info'){
    dynamic_sidebar('sidebar-community');
} elseif($post->post_title == 'On Air Shows'){
    dynamic_sidebar('sidebar-onair');
} elseif($post->post_title == 'Area Weather'){
    dynamic_sidebar('sidebar-weather');
} elseif($post->post_name == 'song-requests'){
    dynamic_sidebar('sidebar-songrequests');
} else {
    dynamic_sidebar('sidebar-primary');
}
?>