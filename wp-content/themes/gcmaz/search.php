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
    //$wpdb->show_errors();
    //$gcmaz_wpdb->show_errors();

    
/*********************************
 *  INITIALIZE VARS
 ********************************/
    // since 2 queries, possible total number is 2x this
    $rows_to_return = 100;
    //results per page (needs to stay above sql statements)
    $results_per_page = 2;
    
    
/************************************
 * GET SEARCH TERMS AND PREPARE SQL STATEMENT
 *  I.  create an array of search terms
 *  II. define and remove stop words
 *  III. compose sql statement
 *  IV. call the search function or return no results
 ***********************************/
   
    // I. CREATE ARRAY OF SEARCH TERMS
    $search_qry = get_search_query(); 
    $search_terms = explode(" ", $search_qry);
    
    // II.  DEFINE AND REMOVE STOP WORDS
    $stopwords = array('a', 'about', 'above', 'above', 'across', 'after', 'afterwards', 'again', 'against', 'all', 'almost', 'alone', 'along', 'already', 'also','although','always','am','among', 'amongst', 'amoungst', 'amount',  'an', 'and', 'another', 'any','anyhow','anyone','anything','anyway', 'anywhere', 'are', 'around', 'as',  'at', 'back','be','became', 'because','become','becomes', 'becoming', 'been', 'before', 'beforehand', 'behind', 'being', 'below', 'beside', 'besides', 'between', 'beyond', 'bill', 'both', 'bottom','but', 'by', 'call', 'can', 'cannot', 'cant', 'co', 'con', 'could', 'couldnt', 'cry', 'de', 'describe', 'detail', 'do', 'done', 'down', 'due', 'during', 'each', 'eg', 'eight', 'either', 'eleven','else', 'elsewhere', 'empty', 'enough', 'etc', 'even', 'ever', 'every', 'everyone', 'everything', 'everywhere', 'except', 'few', 'fifteen', 'fify', 'fill', 'find', 'fire', 'first', 'five', 'for', 'former', 'formerly', 'forty', 'found', 'four', 'from', 'front', 'full', 'further', 'get', 'give', 'go', 'had', 'has', 'hasnt', 'have', 'he', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'hereupon', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'however', 'hundred', 'ie', 'if', 'in', 'inc', 'indeed', 'interest', 'into', 'is', 'it', 'its', 'itself', 'keep', 'last', 'latter', 'latterly', 'least', 'less', 'ltd', 'made', 'many', 'may', 'me', 'meanwhile', 'might', 'mill', 'mine', 'more', 'moreover', 'most', 'mostly', 'move', 'much', 'must', 'my', 'myself', 'name', 'namely', 'neither', 'never', 'nevertheless', 'next', 'nine', 'no', 'nobody', 'none', 'noone', 'nor', 'not', 'nothing', 'now', 'nowhere', 'of', 'off', 'often', 'on', 'once', 'one', 'only', 'onto', 'or', 'other', 'others', 'otherwise', 'our', 'ours', 'ourselves', 'out', 'over', 'own','part', 'per', 'perhaps', 'please', 'put', 'rather', 're', 'same', 'see', 'seem', 'seemed', 'seeming', 'seems', 'serious', 'several', 'she', 'should', 'show', 'side', 'since', 'sincere', 'six', 'sixty', 'so', 'some', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhere', 'still', 'such', 'system', 'take', 'ten', 'than', 'that', 'the', 'their', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'therefore', 'therein', 'thereupon', 'these', 'they', 'thickv', 'thin', 'third', 'this', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'to', 'together', 'too', 'top', 'toward', 'towards', 'twelve', 'twenty', 'two', 'un', 'under', 'until', 'up', 'upon', 'us', 'very', 'via', 'was', 'we', 'well', 'were', 'what', 'whatever', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'whereupon', 'wherever', 'whether', 'which', 'while', 'whither', 'who', 'whoever', 'whole', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yet', 'you', 'your', 'yours', 'yourself', 'yourselves', 'the');
    //$stopwords = array('');  // debug stopword probs
    
    // remove stopwords from our search term array
    // if only stop words - the first one stays populated 
    foreach( $stopwords as $stopword ){
        if( array_search ( $stopword, $search_terms ) ){
            $key = array_search( $stopword, $search_terms );
            unset($search_terms[$key]);
        }
    }

    // III. COMPOSE THE SQL STATEMENT
    // init array of final terms
    $sql_search_terms = array();

    // keep track of count
    $temp_count = 0;
    
    // add each term to our statement
    foreach($search_terms as $term){
        if( isset( $term ) && $term != '' ){
            //check terms to see if in stopwords array for better results
            $sql_search_terms[] = "post_content LIKE '%%" . sanitize_text_field($term) . "%%' OR post_title LIKE '%%" . sanitize_text_field($term) . "%%'";
            $temp_count ++;
        }
    }
    
    // IV. CALL THE SEARCH FUNCTION OR RETURN NO RESULTS
    if( $temp_count == 0 ){
        //no (useable) search terms so we'll skip the query and ask to search again
       $results = null;
    } else {
        // call our search function 
        $results = run_the_queries($gcmaz_wpdb, $wpdb, $sql_search_terms, $rows_to_return, $results_per_page);
    }
    
    
/**********************************************
 *  THE SEARCH FUNCTION
 *********************************************/
    function run_the_queries($gcmaz_wpdb, $wpdb, $sql_search_terms, $rows_to_return, $results_per_page){
        /*******************************************************
         * 2 Queries (gcmaz domain & local site)
         * 
         *   I.  unfinished - pages to ignore
         *   II. Prepare the statement
         *   III. Get the results
         *   IV.  Merge and sort the results
         * 
         *  Notes about the prepare statement:
         *  a.    escape the wildcards %=escape and %=wildcard
         *  b.    the C, D, E  ... denote placeholders in the wpdb->prepare statement in order where 
         *  c.     the sql statement has %s, %d denoting "string" or "integer"
         *  d.    blueprint of the prepared statement
         *         $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare( "the sql query", C, D, E, F, G, H, I, J, K, L, M, N, O, P)
         *  e.    variables used in "local" end with _local to avoid collision
         ********************************************************/
        // QUERY 1) GCMAZ.com search
        // I. 
            // array of pages on gcmaz we don't want to return
            // need to set this up as options in custom gcmaz plugin instead of hardcoded (select pages to ignore in search results)
            $pages_to_ignore_gcmaz = array(1882, 1881, 1880, 1879, 1878, 1877, 1846, 1845, 15);


        // II.  PREPARE THE STATEMENT
        $var_for_publish = "publish"; //C
        $var_for_page = "page"; //D
        $var_for_post = "post"; //E
        $var_for_whats = "whats-happening"; //F
        $var_for_concert = "concert"; //G
        $var_for_community = "community-info"; //H
        $var_for_splash = "splash-post"; //I

        $sql =  "
                    SELECT ID, post_date, post_title, guid, post_name
                    FROM $gcmaz_wpdb->posts
                    WHERE (" . implode(' OR ', $sql_search_terms) . ")
                        AND post_status = '%s'
                        AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                        AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                    ORDER BY post_date DESC
                    LIMIT $rows_to_return
                     ";

        //for debugging
        //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash);
        //print_r($prepared_statement);

        //  III.  GET RESULTS  see notes (blueprint) for details
        $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash));

        //$debug_rows1_total = "<br/>rows1: " . $gcmaz_wpdb->num_rows;
        //print_r($debug_rows1_total);


        // QUERY 2) LOCAL Search

        //  I.  
            // array of pages on gcmaz we don't want to return
            // need to set this up as options in custom gcmaz plugin instead of hardcoded (select pages to ignore in search results)
            $pages_to_ignore_local = array(619, 21, );

        // II.  PREPARE THE STATEMENT
        $var_for_publish_local = "publish"; //C
        $var_for_page_local = "page"; //D
        $var_for_post_local = "post"; //E
        $var_for_whats_local = "whats-happening"; //F
        $var_for_concert_local = "concert"; //G
        $var_for_community_local = "community-info"; //H
        $var_for_splash_local = "splash-post"; //I

        $sql_local =  "
                    SELECT ID, post_date, post_title, guid, post_name
                    FROM $wpdb->posts
                    WHERE (" . implode(' OR ', $sql_search_terms) . ")
                        AND post_status = '%s'
                        AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                        AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                    ORDER BY post_date DESC
                    LIMIT $rows_to_return
                     ";

        //$debug_rows2_total = "<br/>rows2: " . $wpdb->num_rows;
        //print_r($debug_rows2_total);

        //for debugging
        //$prepared_statement = $wpdb->prepare($sql_local, $var_for_publish, $var_for_page, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash, $get_adv_page_id_local);
        //print_r($prepared_statement);

        //  III.  GET RESULTS  see notes (blueprint) for details
        $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_whats_local, $var_for_concert_local, $var_for_community_local, $var_for_splash_local));


       
         //  IV.  MERGE AND SORT THE RESULTS
             /*  - need to convert stdClass object to an array first
                  - merge the queries
                  - merge arrays
                  - sort array by post_date  */
        // convert
        $results_gcmaz = object_to_array($rows);
        $results_local = object_to_array($rows_local);
        // merge
        $results_merged = array_merge( $results_gcmaz, $results_local );
        // sort
        uasort( $results_merged, function( $a, $b ) {
            return strtotime( $a['post_date'] ) - strtotime( $b['post_date'] );
        });
        $results = array_reverse( $results_merged );
        
        return $results;
        
        
        // --------  PAGINATION 
        // get returned rows from query
        //$total_results = $gcmaz_wpdb->num_rows + $wpdb->num_rows;  <- doesnt work so count array instead
        $total_results = count($results);
        //$debug_tr = "<br/>total results: " . $total_results;
        //print_r($debug_tr);

        //total pages
        //$total_pages = ceil($total_results / $results_per_page);
        //$debug_tp= "<br/>total pages: " . $total_pages;
        //print_r($debug_tp);


    // debug array
    //$debug_rg = "<br/>results gcmaz: " . count($results_gcmaz);
    //$debug_rl = "<br/>results local: " . count($results_local);
    //$debug_m = "<br/>results merged: " . count($results_merged);
    //$debug_s = "<br/>results sorted: " . count($results);
    //print_r($debug_rg);
    //print_r($debug_rl);
    //print_r($debug_m);
    //print_r($debug_s);

    } // end run_the_queries()
    
    
/*******************************************************
 * USEABLE LINKS
 *       - take domain from guid and append the permalink
 *       - can't simply use guid because it doesn't update with permalink changes
 *       - can't use permalink only because it doesn't include the domain )
 **********************************************/
    function create_useable_link($guid_in, $post_name_in){
        // get domain from guid
        //    find the last '.' and add 4 (1 for '.'  and 3 for the 'com')
        $pos_of_dot_b4_com = strripos($guid_in, '.') + 4;
        $searched_domain = substr( $guid_in, 0, $pos_of_dot_b4_com );
        // append permalink
        $link_result = $searched_domain . "/" . $post_name_in;

        return $link_result;
    }

/*******************************************************
 * PRETTY DATES
 **********************************************/
    function pretty_date($post_date_in){
        $p_date = strtotime( $post_date_in );
        $pretty_date = date("F j, Y", $p_date);
        return $pretty_date;
    }
/*******************************************************
 * PAGINATION of RESULTS
 **********************************************/
    $total_results = count($results);
    $total_pages = ceil($total_results / $results_per_page);
    //print_r($total_pages);
    //echo "<br/>";
    //print_r($total_results);
    
    function gcmaz_pagination(){
        
    }

?>

<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <h4>Search Results</h4>
    </div>
    <article>
        <?php get_search_form(); ?>
        <div class="search-hdr">
            <?php get_template_part('templates/page', 'header'); ?>
        </div>
        <section class="search-results">

            <?php if( !empty( $results ) ) : ?>
                <ul class="search-result-list list-unstyled">
                    <?php
                        foreach($results as $result) {
                            $id = $result['ID'];
                            $title  = $result['post_title'];

                            // don't display non-linked items
                            if( isset( $result['guid'] ) && isset( $result['post_name'] ) ){
                                $link = create_useable_link( $result['guid'], $result['post_name']);
                                $pdate = pretty_date( $result['post_date'] );
                                echo "<li><a href='$link' rel='bookmark' title='$title' class='list-group-item'>$title<p class='search-result-date'>$pdate</p></a></li>";
                            }
                        }
                    ?>
                </ul>
            <?php else : ?>
                <h4>No results.  Please search again.</h4>
            <?php endif; ?>
            
            <div style="margin:2% auto;padding:10px;display:block">
            <?php
                //display pagination
                //echo paginate_links( array(
                    //'base' => add_query_arg('page', '%#%'),
                    //'format' => '',
                    //'prev_text' => __('&laquo;'),
                    //'next_text' => __('&raquo;'),
                    //'total' => $total_pages,
                    //'current' => $paged
                //));
            ?>
            </div>
            
        </section>
    </article>
</div>

<?php
    wp_reset_query();
    $post = $post_bu;
?>
