<?php

// Remove page header for front page
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'skm_hdr_title' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


// Remove Page Title
//remove_action( 'genesis_post_title', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Content Area
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'page_loop' );


function page_loop(){

    //output Genesis standard components so page get styled
    echo "<article class='entry'>";
    genesis_entry_header_markup_open();
    genesis_do_post_title();
    genesis_entry_header_markup_close();
    echo "<div class='entry-content'>";

    ?>


            <div class="wthr-wrp">

                <div class="wthr-lnks centered">
                    <a id="flagstaff" class="wthrcty txtshdw">Flagstaff</a>
                    <a id="prescott" class="wthrcty txtshdw">Prescott</a>
                    <a id="sedona" class="wthrcty txtshdw">Sedona</a>
                    <a id="gc" class="wthrcty txtshdw">Grand Canyon</a>
                </div>
                <div id="weather"></div>
                <div class="wthr-spnsrs centered">
                    <p>Weather Brought To You By:</p>
                    <a href="http://www.flagstaffmedicalcenter.com/" target="_blank"><img src="/media/fmc.jpg" width="196" height="45" alt="Flagstaff Medical Center"/></a>
                    <a href="http://www.superiorpropaneinc.com/" target="_blank"><img src="/media/superior-propane.jpg" width="168" height="46" alt="Superior Propane" /></a>
                    <a href="http://www.wvmb.com/" target="_blank"><img src="/media/wallick-volk.jpg" width="160" height="46" alt="Wallick and Volk" /></a>
                    <br/><br/>
                </div>
            </div>
        </div>
    </article>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
    <script type="text/javascript">
        jQuery(function($){
            $(document).ready(function(){
                var html = '';
                var $w = function($z,$woeid){
                    $.simpleWeather({
                        location: $z,
                        woeid: $woeid,
                        unit: 'f',
                        success: function(weather) {
                            html = '<h2>'+weather.city+', '+weather.region+'</h2>';
                            html += '<img style="float:left;" width="125px" src="'+weather.image+'">';
                            html += '<p>'+weather.temp+'&deg; '+weather.units.temp+'</p>';
                            html += '<p style="font-size:16px;color:#4765a0;">'+weather.currently+'<br/>';
                            html += 'Wind '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</p>';
                            html += '<p><a href="'+weather.link+'" target="_blank" style="color:#4f91c5;margin-top:30px;">View Full Forecast &raquo;</a></p>';

                            $("#weather").html(html);
                        },
                        error: function(error) {
                            $("#weather").html('<p>'+error+'</p>');
                        }
                    });
                };
                $w('86001', '2404049');
                $('#flagstaff').click(function(){ $w('86001', '2404049'); return false; });
                $('#prescott').click(function(){ $w('86301', '2476440'); return false; });
                $('#sedona').click(function(){ $w('86336', '2490551'); return false; });
                $('#gc').click(function(){ $w('86023', '23506246'); return false; });
            });
        });
    </script>
        
    <?php
}



// genesis child theme
genesis();