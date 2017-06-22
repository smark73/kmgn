<?php
/*
Template Name: Mickis Free Ride
*/
?>

<div class="in-cnt-wrp row">
    <div class="centered rbn-hdg">
        <?php get_template_part('templates/page', 'header'); ?>
    </div>
    <div class="pg-content">
        <?php get_template_part('templates/content', 'page'); ?>
       <div id="MickiFreeClips"></div>
       <div style="clear:both;"></div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {

    	var controller = new YTV('MickiFreeClips', {
       		//channelId: 'UCzhV348cX1pFjZzNXVwGT8Q'
       		playlist: 'PLOJW20xKwaRCMTPpnLDgZxlEhCVlt0zKr'
    	});

    	// manually hide the video titles - they show even thow showinfo=0
    	$hideYtpTitle = $(document).find('.ytp-title');
    	$hideYtpTitle.hide();
    });
</script>