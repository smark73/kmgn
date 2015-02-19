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
    $search_qry = get_search_query(); 
    // create an array of search terms and compose a sql statement fragment for it
    // first define our stopwords (not relevant in searches & too many results)
    $stopwords = array('a', 'about', 'above', 'above', 'across', 'after', 'afterwards', 'again', 'against', 'all', 'almost', 'alone', 'along', 'already', 'also','although','always','am','among', 'amongst', 'amoungst', 'amount',  'an', 'and', 'another', 'any','anyhow','anyone','anything','anyway', 'anywhere', 'are', 'around', 'as',  'at', 'back','be','became', 'because','become','becomes', 'becoming', 'been', 'before', 'beforehand', 'behind', 'being', 'below', 'beside', 'besides', 'between', 'beyond', 'bill', 'both', 'bottom','but', 'by', 'call', 'can', 'cannot', 'cant', 'co', 'con', 'could', 'couldnt', 'cry', 'de', 'describe', 'detail', 'do', 'done', 'down', 'due', 'during', 'each', 'eg', 'eight', 'either', 'eleven','else', 'elsewhere', 'empty', 'enough', 'etc', 'even', 'ever', 'every', 'everyone', 'everything', 'everywhere', 'except', 'few', 'fifteen', 'fify', 'fill', 'find', 'fire', 'first', 'five', 'for', 'former', 'formerly', 'forty', 'found', 'four', 'from', 'front', 'full', 'further', 'get', 'give', 'go', 'had', 'has', 'hasnt', 'have', 'he', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'hereupon', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'however', 'hundred', 'ie', 'if', 'in', 'inc', 'indeed', 'interest', 'into', 'is', 'it', 'its', 'itself', 'keep', 'last', 'latter', 'latterly', 'least', 'less', 'ltd', 'made', 'many', 'may', 'me', 'meanwhile', 'might', 'mill', 'mine', 'more', 'moreover', 'most', 'mostly', 'move', 'much', 'must', 'my', 'myself', 'name', 'namely', 'neither', 'never', 'nevertheless', 'next', 'nine', 'no', 'nobody', 'none', 'noone', 'nor', 'not', 'nothing', 'now', 'nowhere', 'of', 'off', 'often', 'on', 'once', 'one', 'only', 'onto', 'or', 'other', 'others', 'otherwise', 'our', 'ours', 'ourselves', 'out', 'over', 'own','part', 'per', 'perhaps', 'please', 'put', 'rather', 're', 'same', 'see', 'seem', 'seemed', 'seeming', 'seems', 'serious', 'several', 'she', 'should', 'show', 'side', 'since', 'sincere', 'six', 'sixty', 'so', 'some', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhere', 'still', 'such', 'system', 'take', 'ten', 'than', 'that', 'the', 'their', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'therefore', 'therein', 'thereupon', 'these', 'they', 'thickv', 'thin', 'third', 'this', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'to', 'together', 'too', 'top', 'toward', 'towards', 'twelve', 'twenty', 'two', 'un', 'under', 'until', 'up', 'upon', 'us', 'very', 'via', 'was', 'we', 'well', 'were', 'what', 'whatever', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'whereupon', 'wherever', 'whether', 'which', 'while', 'whither', 'who', 'whoever', 'whole', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yet', 'you', 'your', 'yours', 'yourself', 'yourselves', 'the');
    $search_terms = explode(" ", $search_qry);
    $sql_search_terms = array();
    foreach($search_terms as $term){
        //check terms to see if in stopwords array for better results
        if(!in_array($term, $stopwords)){
            $sql_search_terms[] = "post_content LIKE '%%" . sanitize_text_field($term) . "%%' OR post_title LIKE '%%" . sanitize_text_field($term) . "%%'";
        }
    }
    
    // Queries
    //prepare the queries and escape the wildcards %=escape and %=wildcard
    // first get advertising page parent id for use in 2 query
   
    $var_for_adv_pg = "advertise-on-northern-arizona-radio";
    $sql_adv_pg = "
                SELECT ID
                FROM $gcmaz_wpdb->posts
                WHERE post_name = '%s'
                ";
    $get_adv_page_id = $gcmaz_wpdb->get_var($gcmaz_wpdb->prepare($sql_adv_pg, $var_for_adv_pg));  // J

    // the C, D, E  ... denote placeholders in the wpdb->prepare statement in order where 
    // the sql statement has %s, %d denoting "string" or "integer" 
    // (see ++++ blueprint)
    $var_for_publish = "publish"; //C
    $var_for_page = "page"; //D
    $var_for_post = "post"; //E
    $var_for_whats = "whats-happening"; //F
    $var_for_concert = "concert"; //G
    $var_for_community = "community-info"; //H
    $var_for_splash = "splash-post"; //I
    
    $sql =  "
                SELECT *
                FROM $gcmaz_wpdb->posts
                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                    AND post_status = '%s'
                    AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                    AND post_parent != %d
                ORDER BY post_date DESC
                 ";
    
    //print_r($sql);

    //get the results
    // ++++ blueprint of the statement
    // $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare( "the sql query", C, D, E, F, G, H, I, J)
    $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash, $get_adv_page_id));

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
                    //$clink = get_the_category();
                    $plink = get_permalink();
                    //$link = $clink[0] . str_replace(home_url(), OUTGOING_URL, $plink);
                    $link = str_replace(home_url(), OUTGOING_URL, $plink);
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