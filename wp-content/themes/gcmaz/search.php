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
    //echo ("<h1>SHOW DB ERRORS ON</h1>");
    //$wpdb->show_errors();
    //$gcmaz_wpdb->show_errors();

    
/*********************************
 *  INITIALIZE VARS
 ********************************/
    // since 2 queries, possible total number is 2x this
    $rows_to_return = 100;
    // DEFINE OUR RESULTS PER PAGE FOR PAGINATION
    $results_per_page = 12;
    // STATION RELATED VARS
    $station_name = "93-9 The Mountain";
    $pages_to_ignore_gcmaz = array(1882, 1881, 1880, 1879, 1878, 1877, 1846, 1845, 15);
    $pages_to_ignore_local = array(619, 21);
    
/************************************
 * GET SEARCH TERMS AND PREPARE SQL STATEMENT
 *  I.  create an array of search terms
 *  II. define and remove stop words
 *  III. compose sql statement of search terms
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
        $results = run_the_queries($gcmaz_wpdb, $wpdb, $sql_search_terms, $rows_to_return, $pages_to_ignore_gcmaz, $pages_to_ignore_local);
        //split the results into an array of arrays with our defined number of results per page
        $paginated_results = array_chunk($results, $results_per_page);
    }
    
    
/**********************************************
 *  THE SEARCH FUNCTION
 *********************************************/
    function run_the_queries($gcmaz_wpdb, $wpdb, $sql_search_terms, $rows_to_return, $pages_to_ignore_gcmaz, $pages_to_ignore_local){
        /*******************************************************
         * 2 Queries (gcmaz domain & local site)
         * 
         *   I.  unfinished - pages to ignore
         *   II. Prep vars for the statement
         *   III.  To filter or not
         *   IV.  The Queries
         *   V.   Functions (merge, object to array, sort)
         * 
         *  Notes about the prepare statement:
         *  a.    escape the wildcards %=escape and %=wildcard
         *  b.    the C, D, E  ... denote placeholders in the wpdb->prepare statement in order where 
         *  c.     the sql statement has %s, %d denoting "string" or "integer"
         *  d.    blueprint of the prepared statement
         *         $rows = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare( "the sql query", C, D, E, F, G, H, I, J, K, L, M, N, O, P)
         *  e.    variables used in "local" end with _local to avoid collision
         ********************************************************/

        // I.  array of pages on gcmaz we don't want to return
        // need to set this up as options in custom gcmaz plugin instead of hardcoded (select pages to ignore in search results)
        $pages_to_ignore_gcmaz = $pages_to_ignore_gcmaz;
        $pages_to_ignore_local = $pages_to_ignore_local;
            
        // II.  INIT VARS FOR THE SQL PREPARE STATEMENT
        $var_for_publish = "publish";
        $var_for_page = "page";
        $var_for_post = "post";
        $var_for_whats = "whats-happening";
        $var_for_concert = "concert";
        $var_for_community = "community-info";
        $var_for_splash = "splash-post";
        
        $var_for_publish_local = "publish";
        $var_for_page_local = "page";
        $var_for_post_local = "post";
        $var_for_splash_local = "splash-post";

        
        // III.  FILTER OR NOT
        // the default search isn't filtered, but it can be refined in which case the following vars will be populated
    
        //check for search filter vars - to filter by domain, posts, pages
        if ( isset( $_POST['filter_the_search'] ) ){
            // not default search, filters in play
            //domain
            if (isset( $_POST['showDomain'] ) ){
                $showDomain = sanitize_text_field( $_POST['showDomain'] );
            } else {
                $showDomain = 'gcmaz';
            }
            //pages
            if (isset( $_POST['showPages'] ) ){
                $showPages = true;
            } else {
                $showPages = false;
            }
            //posts
            if( isset( $_POST['showPosts'] ) ){
                $showPosts = true;
            } else {
                $showPosts = false;
            }
            //news
            if( isset( $_POST['showNews'] ) ){
                $showNews = true;
            } else {
                $showNews = false;
            }
        } else {
            // default search
            $showDomain = 'gcmaz';
            $showPosts = true;
            $showPages = true;
            $showNews = true;
        } 
        
        // IV.  THE QUERIES
        //-----------------------------------------------------
        //     FILTERED SEARCH TO SHOW KAFF NEWS
        //-----------------------------------------------------
        // don't bother with local search
        // search gcmaz.com for KAFF News "posts" only
        if( $showDomain == 'news' || ( $showDomain == 'gcmaz' && $showNews == true && $showPosts == false && $showPages == false ) ){
            $sql =  "
                    SELECT ID, post_date, post_title, guid, post_name, post_type
                    FROM $gcmaz_wpdb->posts
                    WHERE (" . implode(' OR ', $sql_search_terms) . ")
                        AND post_status = '%s'
                        AND (post_type = '%s')
                        AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                    ORDER BY post_date DESC
                    LIMIT $rows_to_return
                     ";
            //for debugging
            //echo "<div style='background:yellow;color:red'>NEWS</div>";
            //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_post);
            //print_r($prepared_statement);

            $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_post));
            
            // convert to array
            $results = convert_results_to_array($rows_gcmaz);
            // dont need to merge, just sort
            $results = sort_results($results);
            
            return $results;
        }

        
        //--------------------------------------------------------------------------------
        //     DEFAULT SEARCH  & FILTERED SEARCH THAT SHOWS POSTS & PAGES
        //--------------------------------------------------------------------------------
        
        if( ( $showPosts == true && $showPages == true ) || ( $showPosts == false && $showPages == false ) ){
            
            if ($showDomain == 'local') {
                //LOCAL ONLY
                //SKIPS NEWS
                    $sql_local =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";

                //for debugging
                //echo "<div style='background:yellow;color:red'>LOCAL PAGES AND POSTS, SKIPS NEWS</div>";
                //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local);
                //print_r($prepared_statement_local);

                $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local));

                // convert to array
                $rows_local = convert_results_to_array($rows_local);
                //sort results
                $results = sort_results($rows_local);
                
                return $results;
                
            } else {
                // ENTIRE DOMAIN
                // WITH NEWS
                if ($showNews == true){
                    // QUERY1) GCMAZ.com 
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
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

                    $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash));

                    // QUERY 2) LOCAL Search
                        $sql_local =  "
                                SELECT ID, post_date, post_title, guid, post_name, post_type
                                FROM $wpdb->posts
                                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                    AND post_status = '%s'
                                    AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                    AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                ORDER BY post_date DESC
                                LIMIT $rows_to_return
                                 ";

                    //for debugging
                    //echo "<div style='background:yellow;color:red'>ALL PAGES AND POSTS WITH NEWS</div>";
                    //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local);
                    //print_r($prepared_statement_local);

                    $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local));

                    // convert to array
                    $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                    $rows_local = convert_results_to_array($rows_local);
                    // merge results
                    $results = merge_results($rows_gcmaz, $rows_local);
                    //sort results
                    $results = sort_results($results);

                    return $results;
                
                } else {
                    // ENTIRE DOMAIN
                    // WITHOUT NEWS

                    // QUERY1) GCMAZ.com 
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $gcmaz_wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";
                    //for debugging
                    //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash);
                    //print_r($prepared_statement);

                    $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash));

                    // QUERY 2) LOCAL Search
                        $sql_local =  "
                                SELECT ID, post_date, post_title, guid, post_name, post_type
                                FROM $wpdb->posts
                                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                    AND post_status = '%s'
                                    AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                    AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                ORDER BY post_date DESC
                                LIMIT $rows_to_return
                                 ";

                    //for debugging
                    //echo "<div style='background:yellow;color:red'>ALL PAGES AND POSTS WITHOUT NEWS</div>";
                    //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local);
                    //print_r($prepared_statement_local);

                    $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local, $var_for_post_local, $var_for_splash_local));

                    // convert to array
                    $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                    $rows_local = convert_results_to_array($rows_local);
                    // merge results
                    $results = merge_results($rows_gcmaz, $rows_local);
                    //sort results
                    $results = sort_results($results);

                    return $results;

                }
            }
        }
        
        
        //-----------------------------------------------------
        //     FILTERED SEARCH TO SHOW POSTS NOT PAGES
        //-----------------------------------------------------

            if( $showPosts == true && $showPages == false ){

                if ($showDomain == 'local'){
                    // LOCAL ONLY
                    // SKIPS NEWS
                        $sql_local =  "
                                SELECT ID, post_date, post_title, guid, post_name, post_type
                                FROM $wpdb->posts
                                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                    AND post_status = '%s'
                                    AND (post_type = '%s' OR post_type = '%s')
                                    AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                ORDER BY post_date DESC
                                LIMIT $rows_to_return
                                 ";
                     
                     //for debugging
                     //echo "<div style='background:yellow;color:red'>LOCAL POSTS, SKIPS NEWS</div>";
                        
                    $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local));
                    
                    // convert to array
                    $rows_local = convert_results_to_array($rows_local);
                    //sort results
                    $results = sort_results($rows_local);
                    
                    return $results;
                    
                } else {
                    //  ENTIRE DOMAIN
                    // WITH NEWS
                    if($showNews == true){
                        // QUERY 1) gcmaz.com
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $gcmaz_wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";
                        //for debugging
                        //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash);
                        //print_r($prepared_statement);

                        // GET RESULTS  see notes (blueprint) for details
                        $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_post, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash));

                        // QUERY 2) LOCAL Search
                            $sql_local =  "
                                    SELECT ID, post_date, post_title, guid, post_name, post_type
                                    FROM $wpdb->posts
                                    WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                        AND post_status = '%s'
                                        AND (post_type = '%s' OR post_type = '%s')
                                        AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                    ORDER BY post_date DESC
                                    LIMIT $rows_to_return
                                     ";

                        //for debugging
                        //echo "<div style='background:yellow;color:red'>ALL POSTS WITH NEWS</div>";
                        //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local);
                        //print_r($prepared_statement_local);

                        $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local));

                        // convert to array
                        $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                        $rows_local = convert_results_to_array($rows_local);
                        // merge results
                        $results = merge_results($rows_gcmaz, $rows_local);
                        //sort results
                        $results = sort_results($results);

                        return $results;
                    
                    } else {
                        // ENTIRE DOMAIN
                        // WITHOUT NEWS
                        // QUERY 1) gcmaz.com
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $gcmaz_wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s' OR post_type = '%s' OR post_type = '%s' OR post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";
                        //for debugging
                        //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash);
                        //print_r($prepared_statement);

                        // GET RESULTS  see notes (blueprint) for details
                        $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_whats, $var_for_concert, $var_for_community, $var_for_splash));

                        // QUERY 2) LOCAL Search
                            $sql_local =  "
                                    SELECT ID, post_date, post_title, guid, post_name, post_type
                                    FROM $wpdb->posts
                                    WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                        AND post_status = '%s'
                                        AND (post_type = '%s' OR post_type = '%s')
                                        AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                    ORDER BY post_date DESC
                                    LIMIT $rows_to_return
                                     ";

                        //for debugging
                        //echo "<div style='background:yellow;color:red'>ALL POSTS WITHOUT NEWS</div>";
                        //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local);
                        //print_r($prepared_statement_local);

                        $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local));

                        // convert to array
                        $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                        $rows_local = convert_results_to_array($rows_local);
                        // merge results
                        $results = merge_results($rows_gcmaz, $rows_local);
                        //sort results
                        $results = sort_results($results);

                        return $results;
                    }
                }

            }
        
        
        //-----------------------------------------------------
        //     FILTERED SEARCH TO SHOW PAGES NOT POSTS
        //-----------------------------------------------------
            
        if( $showPosts == false && $showPages == true){

            if ($showDomain == 'local'){
                // LOCAL ONLY
                // SKIPS NEWS
                    $sql_local =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";

                //for debugging
                //echo "<div style='background:yellow;color:red'>LOCAL PAGES, SKIPS NEWS</div>";
                //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local);
                //print_r($prepared_statement_local);

                $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local));
                // convert to array
                $rows_local = convert_results_to_array($rows_local);
                //sort results
                $results = sort_results($rows_local);
                
                return $results;
                
            } else {
                // ENTIRE DOMAIN                
                // WITH NEWS
                if($showNews == true){

                    // QUERY 1) gcmaz.com
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $gcmaz_wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s' OR post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";
                    //for debugging
                    //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page);
                    //print_r($prepared_statement);

                    $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_post, $var_for_page));

                    // QUERY 2) local
                    // --------------------------
                    // PREPARE THE STATEMENT
                        $sql_local =  "
                                SELECT ID, post_date, post_title, guid, post_name, post_type
                                FROM $wpdb->posts
                                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                    AND post_status = '%s'
                                    AND (post_type = '%s')
                                    AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                ORDER BY post_date DESC
                                LIMIT $rows_to_return
                                 ";

                    //for debugging
                    //echo "<div style='background:yellow;color:red'>ALL PAGES WITH NEWS</div>";
                    //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local);
                    //print_r($prepared_statement_local);

                    //GET RESULTS  see notes (blueprint) for details
                    $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local));

                    // convert to array
                    $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                    $rows_local = convert_results_to_array($rows_local);
                    // merge results
                    $results = merge_results($rows_gcmaz, $rows_local);
                    //sort results
                    $results = sort_results($results);

                    return $results;
                    
                } else {
                    // ENTIRE DOMAIN
                    // WITHOUT NEWS
                    // QUERY 1) gcmaz.com
                        $sql =  "
                            SELECT ID, post_date, post_title, guid, post_name, post_type
                            FROM $gcmaz_wpdb->posts
                            WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                AND post_status = '%s'
                                AND (post_type = '%s')
                                AND ID NOT IN (" . implode($pages_to_ignore_gcmaz, ", ") . ")
                            ORDER BY post_date DESC
                            LIMIT $rows_to_return
                             ";
                    //for debugging
                    //$prepared_statement = $gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page);
                    //print_r($prepared_statement);

                    $rows_gcmaz = $gcmaz_wpdb->get_results($gcmaz_wpdb->prepare($sql, $var_for_publish, $var_for_page));

                    // QUERY 2) local
                    // --------------------------
                    // PREPARE THE STATEMENT
                        $sql_local =  "
                                SELECT ID, post_date, post_title, guid, post_name, post_type
                                FROM $wpdb->posts
                                WHERE (" . implode(' OR ', $sql_search_terms) . ")
                                    AND post_status = '%s'
                                    AND (post_type = '%s')
                                    AND ID NOT IN (" . implode($pages_to_ignore_local, ", ") . ")
                                ORDER BY post_date DESC
                                LIMIT $rows_to_return
                                 ";

                    //for debugging
                    //echo "<div style='background:yellow;color:red'>ALL PAGES WITHOUT NEWS</div>";
                    //$prepared_statement_local = $wpdb->prepare($sql_local, $var_for_publish_local, $var_for_post_local, $var_for_splash_local);
                    //print_r($prepared_statement_local);

                    //GET RESULTS  see notes (blueprint) for details
                    $rows_local = $wpdb->get_results($wpdb->prepare($sql_local, $var_for_publish_local, $var_for_page_local));

                    // convert to array
                    $rows_gcmaz = convert_results_to_array($rows_gcmaz);
                    $rows_local = convert_results_to_array($rows_local);
                    // merge results
                    $results = merge_results($rows_gcmaz, $rows_local);
                    //sort results
                    $results = sort_results($results);

                    return $results;
                }
            }
        }

} // end run_the_queries()
    

// V.  FUNCTIONS
/***********************************
 * CONVERT stdClass OBJECT TO ARRAY 
 **************************************/
function convert_results_to_array($object_to_convert){
        $results_in_array = object_to_array($object_to_convert);
        return $results_in_array;
}

/***************************************
 * MERGE
            - merge the queries
            - merge arrays
 *****************************************/
function merge_results ($results_gcmaz, $results_local){
        // merge
        $results_merged = array_merge( $results_gcmaz, $results_local );
        return $results_merged;
}

/*******************************************
 * SORT
            - sort array by post_date
 *******************************************/
function sort_results($results_to_sort){
    // sort
    uasort( $results_to_sort, function( $a, $b ) {
        return strtotime( $a['post_date'] ) - strtotime( $b['post_date'] );
    });
    $results_sorted = array_reverse( $results_to_sort );

    return $results_sorted;
}
    
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
    
/*****************************************
 *  GET & MODIFY THE PAGE URL FOR SEARCH FILTER FORM
 *******************************************/
    
    function get_search_filter_form_url(){
        //$get_url = $_SERVER['REQUEST_URI'];
        //$get_query = $_SERVER['QUERY_STRING'];
        $get_cur_search_var = get_query_var('s');
        $set_url = "/?s=" . $get_cur_search_var;
        echo $set_url;
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
            
            <div id="search-filter-toggle">Refine Search Results<span class="caret"></span></div>
            <br class="clearfix">
            <form name="searchFilterForm" method="post" action="<?php get_search_filter_form_url();?>">
                <div id="search-filter" class="search-filter-hide">
                    <div class="search-filter-left">
                        <p class="search-filter-info">Search Where:</p>
                        <div class="radio">
                            <label><input type="radio" name="showDomain" value="gcmaz" class="searchGcmaz" checked="checked">All Great Circle Media</label>
                        </div>
                         <div class="radio">
                            <label><input type="radio" name="showDomain" value="local" class="searchLocal">Only <?php echo $station_name; ?></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="showDomain" value="news" class="searchNews" >KAFF News</label>
                        </div>
                    </div>
                    <div class="search-filter-right">
                        <p class="search-filter-info">Show What:</p>
                        <div class="checkbox chkbxPages">
                            <label><input type="checkbox" name="showPages" id="showPages" value="true" checked>Station Info</label>
                        </div>
                        <div class="checkbox chkbxPosts">
                            <label><input type="checkbox" name="showPosts" id="showPosts" value="true" checked>Events, Concerts,Contests</label>
                        </div>
                        <div class="checkbox chkbxNews">
                            <label><input type="checkbox" name="showNews" id="showNews" value="true" checked>News Stories</label>
                        </div>
                        <input type="hidden" name="filter_the_search" id="filter_the_search" value="true">
                    </div>
                    <div class="clearfix"></div>
                    <button type="submit" name="submitSearchFilter" class="submitSearchFilter btn btn-md btn-primary">    Filter Results    </button>
                    <div class="clearfix"></div>
                </div>
            </form>
            
            <div class="clearfix"></div>
            
            
            <?php if( !empty( $results ) ) : ?>
            
                <?php
                    // Get the show var and validate it
                    (int) $show = get_query_var('show', 1);
                    if( preg_match("/[^0-9]/", $show)){
                        wp_die ('Invalid page number');
                    }
                ?>

                <ul class="search-result-list list-unstyled">
                    <?php
                        // the needed array key is $show - 1;
                        $result_page = $show - 1;
                        foreach( $paginated_results[$result_page] as $result ) {
                            
                            $page_var = $show;
                            
                            $id = $result['ID'];
                            $title  = $result['post_title'];
                            $post_type = $result['post_type'];

                            // don't display non-linked items
                            if( isset( $result['guid'] ) && isset( $result['post_name'] ) ){
                                $link = create_useable_link( $result['guid'], $result['post_name']);
                                $pdate = pretty_date( $result['post_date'] );
                                echo "<li class='$post_type'><a href='$link' rel='bookmark' title='$title' class='list-group-item'>$title<p class='search-result-date'>$pdate</p></a></li>";
                            }
                        }
                    ?>
                </ul>
            
            
            <?php
                // PAGINATION
                // prepare search terms for the url query var
                $url_search_terms = implode('+', $search_terms);
                $pagination_btns = '';
                //if more than one page of results, loop through paginated results for our pagination links
                if( count( $results ) > $results_per_page ){
                    echo "<div class='pagination'>";
                    for ( $i=1; $i < count($paginated_results) +1; $i++ ) {
                        if($i == $show){
                            $btn_class = 'page-numbers current';
                        } else {
                            $btn_class = 'page-numbers';
                        }

                        echo "<a href=/?s=" . $url_search_terms . "&show=" . $i . " class='" . $btn_class . "'>" . $i . "</a>";
                    }
                    echo "</div>";
                }
            ?>
            
            <?php else : ?>
                <h4 class="blue">No results.  Please search again.</h4>
            <?php endif; ?>
            
        </section>
    </article>
</div>

<?php
    wp_reset_query();
    $post = $post_bu;
?>
