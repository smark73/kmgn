<?php
    $adrotate_group_var = 15;
    // first, check if adrotate plugin is even active
    // detect plugin - front end use only
    include_once( ABSPATH . 'wp-admin/includes/plugin.php');
    // check for plugin by using plugin name
    if( is_plugin_active( 'adrotate/adrotate.php' ) ){

        /*test if adrotate is populated or not */
        if( substr( adrotate_group( $adrotate_group_var ), 0, 5) == "<span" || substr( adrotate_group( $adrotate_group_var ), 0, 2) == "<!" ) {
            // no adrotate to display
                echo
                    '<div class="listenlive row">
                        <div class="strm-lft col-md-12 col-sm-12 col-xs-12">
                            <a class="listenlive-txt centered" href="http://player.listenlive.co/36601" target="_blank">
                                Listen Live <span class="glyphicon glyphicon-play"></span>
                            </a>
                        </div>
                    </div>';
        } else {
            // we have an ad to squeeze in
                echo
                    '<div class="listenlive row">
                        <div class="strm-lft col-md-9 col-sm-9 col-xs-7">
                            <a class="listenlive-txt centered" href="http://player.listenlive.co/36601" target="_blank">
                                Listen Live <span class="glyphicon glyphicon-play"></span>
                            </a>
                        </div>
                        <div class="strm-spnsr col-md-3 col-sm-3 col-xs-5">' .
                            adrotate_group( $adrotate_group_var ) .
                        '</div>
                    </div>';
        }
    
    } else {
        // not active anyways
        echo
            '<div class="listenlive row">
                <div class="strm-lft col-md-12 col-sm-12 col-xs-12">
                    <a class="listenlive-txt centered" href="http://player.listenlive.co/36601" target="_blank">
                        Listen Live <span class="glyphicon glyphicon-play"></span>
                    </a>
                </div>
            </div>';
    }
?>
