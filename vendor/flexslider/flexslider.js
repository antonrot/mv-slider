jQuery(window).load(function() {
	jQuery('.flexslider').flexslider({
		animation: SLIDER_OPTIONS.animation,
		touch: true,
		slideshowSpeed: SLIDER_OPTIONS.slideshowSpeed,
		animationSpeed: SLIDER_OPTIONS.animationSpeed,
		directionNav: false,
		smoothHeight: true,
		controlNav: SLIDER_OPTIONS.controlNav,
	});
});