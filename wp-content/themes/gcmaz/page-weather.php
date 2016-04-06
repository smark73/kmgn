<div class="in-cnt-wrp row wthr-wrp">
    <div class="centered rbn-hdg">
        <div class="page-header">
            <h3 class="txtshdw">Area Weather &nbsp; <span class="glyphicon glyphicon-certificate yellow"></span> <span class="glyphicon glyphicon-cloud white"></span></h3>
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
        <p style="font-size:11px;font-weight:700;margin:20px auto 10px;color:#4f91c5">Weather Brought To You By:</p>
        <a href="http://www.flagstaffmedicalcenter.com/" target="_blank"><img src="/media/fmc.jpg" width="196" height="45" alt="Flagstaff Medical Center"/></a>
        <a href="http://www.superiorpropaneinc.com/" target="_blank"><img src="/media/superior-propane.jpg" width="168" height="46" alt="Superior Propane" /></a>
        <a href="http://www.wvmb.com/" target="_blank"><img src="/media/wallick-volk.jpg" width="160" height="46" alt="Wallick and Volk" /></a>
        <br/><br/>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
<script type="text/javascript">
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
        $w('86001', '');
        $('#flagstaff').click(function(){ $w('86001', ''); return false; });
        $('#prescott').click(function(){ $w('86301', ''); return false; });
        $('#sedona').click(function(){ $w('86336', ''); return false; });
        $('#gc').click(function(){ $w('86023', ''); return false; });
    });
</script>