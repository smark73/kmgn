// Change Genesis Superfish menu default settings with this arguments file
// https://code.garyjones.co.uk/change-superfish-arguments
// https://gist.github.com/GaryJones/1707986
// For Genesis 2.0 and later:

jQuery(function ($) {
	'use strict';
	$('.js-superfish').superfish({
		'delay': 200, // 0.1 second delay on mouseout
		'animation': {'opacity': 'show', 'height': 'show'}, // fade-in and slide-down animation
		'dropShadows': false, // disable drop shadows
		'speed': 'fast'
	});
});