/*
 === Advanced Youtube Channel Pagination ===
 Contributors: Balasaheb Bhise
 
 
 */
$ = jQuery.noConflict();

$(document).ready(function () {

    var channelIdValue = $("#youtube_channel_id_field_name").val();
    var apiKeyValue = $("#youtube_channel_api_key_field_name").val();
    var maxResultsVideo = $("#youtube_channel_result_per_page_field_name").val();
    var gridPreRowList = $("#youtube_channel_grid_on_page_field_name").val();

    $("#pageTokenNext").on("click", function (event) {
        $("#pageToken").val($("#pageTokenNext").val());
        youtubeChannelVedioApiCallPlayListId();
    });

    $("#pageTokenPrev").on("click", function (event) {
        $("#pageToken").val($("#pageTokenPrev").val());
        youtubeChannelVedioApiCallPlayListId();
    });

    youtubeChannelVedioApiCallPlayListId();
    // Get  Playlist
    function youtubeChannelVedioApiCallPlayListId() {
        $.get(
                "https://www.googleapis.com/youtube/v3/channels", {
                    part: 'contentDetails',
                    id: channelIdValue,
                    key: apiKeyValue
                }, function (data) {
            $.each(data.items, function (i, item) {
                //var playListId = item.contentDetails.relatedPlaylists.uploads;
                // use our Actual Playlist ID
                var playListId = 'PLOJW20xKwaRCMTPpnLDgZxlEhCVlt0zKr';
                youtubeChannelVedioApiCall(playListId);
            });
        });
    }

    function youtubeChannelVedioApiCall(playListId) {
        $.ajax({
            cache: false,
            data: $.extend({
                key: apiKeyValue,
                part: 'snippet',
                playlistId: playListId,
            }, {maxResults: maxResultsVideo, order: 'date', type: 'video', pageToken: $("#pageToken").val()}),
            dataType: 'json',
            type: 'GET',
            timeout: 5000,
            url: 'https://www.googleapis.com/youtube/v3/playlistItems'
        }).done(function (channelData) {

            var items = channelData.items;
            total_video_count = Object.keys(items).length;

            if (typeof channelData.prevPageToken === "undefined") {
                $("#pageTokenPrev").hide();
            } else {
                $("#pageTokenPrev").show();
            }
            if (typeof channelData.nextPageToken === "undefined" || total_video_count < maxResultsVideo) {
                $("#pageTokenNext").hide();
            } else {
                $("#pageTokenNext").show();
            }

            $("#pageTokenPrev").val(channelData.prevPageToken);

            $("#pageTokenNext").val(channelData.nextPageToken);

            if (items[0]) {
                var current_videoId = items[0].snippet.resourceId.videoId;
                $("#youtube-channel-video .display-watch-video").html('<div class="col-sm-12 "><iframe width="100%" src="https://www.youtube.com/embed/' + current_videoId + '?listType=playlist&list=PLOJW20xKwaRCMTPpnLDgZxlEhCVlt0zKr&loop=1&rel=0" frameborder="0" allowfullscreen="" style="width:auto;height:auto;min-width:350px;min-height:250px;"></iframe><h2> ' + items[0].snippet.title + '</h2></div>');
            }

            grid_video_list = 0;
            videoList = '';
            $.each(items, function (index, e) {
                videoList = videoList + '<div class="col-lg-3 col-md-4 col-sm-' + gridPreRowList + ' ycv-list-snippet"><div class="item-list-box"><div class="ycv-simple-thumb-wrap"><img class="img-responsive" alt="' + e.snippet.title + '" src="' + e.snippet.thumbnails.medium.url + '"></div><div class="current-video-id" style="display:none">' + e.snippet.resourceId.videoId + '</div><div class="title">' + e.snippet.title + '</div></div></div>';
            });
            $("#yc-pagination-watch").html(videoList);
            videoList = '';
        });
    }
    $('#youtube-channel-pagination #yc-pagination-watch').on('click', '.ycv-list-snippet', function () {
        var currentVideoId = $(this).find(".current-video-id").text();
        var video_snippet = $(this).find(".title").text();
        $("#youtube-channel-video .display-watch-video").html('<div class="col-sm-12"><iframe width="100%" src="https://www.youtube.com/embed/' + currentVideoId + '?listType=playlist&list=PLOJW20xKwaRCMTPpnLDgZxlEhCVlt0zKr&autoplay=1&loop=1&rel=0" frameborder="0" allowfullscreen="" style="width:auto;height:auto;min-width:350px;min-height:250px;"></iframe><h2> ' + video_snippet + '</h2></div>');
    });

});
