<div class="takeover-hdr-wrap">

    <?php $ptko_settings = get_option('ptko_settings'); ?>
    
    <a href="<?php echo esc_url($ptko_settings['ptko_link']);?>" target="_blank" id="tkobtn" onclick="ga('send', 'event', 'takeover', 'click', 'EDITME');">
        <div class="hidden-xs">
            <div class="takeover-hdr centered" style="height:100%;">
                <div class="takeover-hdr1 centered">
                    <img src="/media/transparent.png" width="1000" alt="" style="width:100%;max-width:1000px;height:100px;" />
                </div>
                <div class="takeover-hdr2 centered">
                    <img src="<?php echo esc_url($ptko_settings['ptko_hdrimg']);?>" width="1000" alt="NAU" style="width:100%;max-width:1000px;" />
                </div>
            </div>
        </div>

        <div class="hidden-sm hidden-md hidden-lg">
            <div class="centered">
                <img src="<?php echo esc_url($ptko_settings['ptko_hdrimg']);?>" width="1000" alt="NAU" style="width:100%;max-width:1000px;" />
            </div>
        </div>

    </a>
</div>