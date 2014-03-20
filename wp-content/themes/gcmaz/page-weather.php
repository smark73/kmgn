<div class="in-cnt-wrp row wthr-wrp">
    <div class="centered rbn-hdg">
        <div class="page-header">
            <h3 class="txtshdw">Area Weather &nbsp; <span class="glyphicon glyphicon-certificate yellow"></span> <span class="glyphicon glyphicon-cloud lt-blue"></span></h3>
        </div>
    </div>
    <div class="wthr-lnks centered">
        <a id="flagstaff" class="wthrcty txtshdw">Flagstaff</a>
        <a id="prescott" class="wthrcty txtshdw">Prescott</a>
        <a id="sedona" class="wthrcty txtshdw">Sedona</a>
        <a id="gc" class="wthrcty txtshdw">Grand Canyon</a>
    </div>
    <div id="weather"></div>
    <div class="wthr-spnsrs centered">
        <p style="font-size:11px;font-weight:700;margin:20px auto 10px;color:#dfedf7">Weather Brought To You By:</p>
        <a href="http://www.flagstaffmedicalcenter.com/" target="_blank"><img src="/media/fmc.jpg" width="196" height="45" alt="Flagstaff Medical Center"/></a>
        <a href="http://www.superiorpropaneinc.com/" target="_blank"><img src="/media/superior-propane.jpg" width="168" height="46" alt="Superior Propane" /></a>
        <a href="http://www.wvmb.com/" target="_blank"><img src="/media/wallick-volk.jpg" width="160" height="46" alt="Wallick and Volk" /></a>
        <br/><br/>
    </div>
</div>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/2.3.0/jquery.simpleWeather.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var $w = function($z,$woeid){
            $.simpleWeather({
                zipcode: $z,
                woeid: $woeid,
                unit: 'f',
                success: function(weather) {
                    html = '<h2>'+weather.city+', '+weather.region+'</h2>';
                    html += '<img style="float:left;" width="125px" src="'+weather.image+'">';
                    html += '<p>'+weather.temp+'&deg; '+weather.units.temp+'<span>'+weather.currently+'</span></p>';
                    html += '<a href="'+weather.link+'" target="_blank">View Forecast &raquo;</a>';
                    $("#weather").html(html);
                },
                error: function(error) {
                    $("#weather").html('<p>'+error+'</p>');
                }
            });
        }
        $w('86001', '12794772');
        $('#flagstaff').click(function(){ $w('86001', '12794772'); return false; });
        $('#prescott').click(function(){ $w('86301', '12794808'); return false; });
        $('#sedona').click(function(){ $w('86336', '12794784'); return false; });
        $('#gc').click(function(){ $w('86023', '12794831'); return false; });
    });
</script>