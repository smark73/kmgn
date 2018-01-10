// fix "synchronous xmlhttprequest on the main thread is deprecated"
//http://stackoverflow.com/questions/28322636/synchronous-xmlhttprequest-warning-and-script
jQuery(document).ready(function(){
	jQuery.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
	    options.async = true;
	});
});