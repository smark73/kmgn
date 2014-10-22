<?php
    //store global post object to retrieve at end
    global $post;
    $post_bu = $post;
   
    // db vars defined in wp-config
    // create a new wpdb object with external db connection 
    $gcmaz_wpdb = new wpdb(DB_USER_SRCH, DB_PASSWORD_SRCH, DB_NAME_SRCH, DB_HOST_SRCH);
    //set table names prefix
    $gcmaz_wpdb->set_prefix(DB_SRCH_PREFIX);
    
    //show errors
    //$gcmaz_wpdb->show_errors();
    
    //get the search input 
    $s = get_search_query();
    
    // Queries
    //prepare the queries and escape the wildcards %=escape and %=wildcard
    // first get advertising page parent id for use in 2 query
    $sql_adv_pg = "
                SELECT ID
                FROM $gcmaz_wpdb->posts
                WHERE post_name = 'advertise-on-northern-arizona-radio'
                ";
    $get_adv_page_id = $gcmaz_wpdb->get_var($gcmaz_wpdb->prepare($sql_adv_pg));
    
    $sql =  "
                SELECT *
                FROM $gcmaz_wpdb->posts
                WHERE (post_content LIKE '%%$s%%' OR post_title LIKE '%%$s%%')
                    AND post_status = 'publish'
                    AND (post_type = 'page' OR post_type = 'post' OR post_type = 'whats-happening' OR post_type = 'concert' OR post_type = 'community-info' OR post_type = 'splash-post')
                    AND post_parent != $get_adv_page_id
                ORDER BY post_date DESC
                 ";
    
    //get the results
    $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql));

?>

<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <h4>Search Results</h4>
    </div>
    <div class="search-hdr">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <article>
        <?php get_search_form(); ?>
        
        <?php // -------- get gcmaz.com domain search results first ?>
        <?php if($rows) : ?>
            <?php
                foreach($rows as $post) {
                    // populate post object with search results
                    setup_postdata($post);
                    $id = $post->ID;
                    $title  = $post->post_title;
                    //$desc = apply_filters('the_content', get_the_excerpt());
                    $clink = get_the_category();
                    $plink = get_permalink();
                    $link = $clink[0] . str_replace(home_url(), OUTGOING_URL, $plink);
                    if($link != ''){
                        // don't display non-linked items
                        echo "<h4><a href='$link' rel='bookmark' title='$title'>$title</a></h4>";
                    }
                }
                ?>
        <?php endif; ?>
        
        <?php
            // --------- get local site search results  (default WP search )
            while (have_posts()) {
                the_post();
                $id = get_the_ID();
                //get_template_part('templates/content', get_post_format());
                $title = get_the_title();
                $link = get_permalink();
                // dont' display advertising page results
                $adv_pg = get_page_by_path('advertise-on-northern-arizona-radio');
                $anc = get_post_ancestors($id);
                $adv_pg = $adv_pg->ID;
                if(!in_array($adv_pg, $anc)){
                    echo "<h4><a href='$link' rel='bookmark' title='$title'>$title</a></h4>";
                }
            }
        ?>
            
    </article>
</div>

<?php
    wp_reset_query();
    $post = $post_bu;
?>