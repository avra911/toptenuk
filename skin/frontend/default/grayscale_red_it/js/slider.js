jQuery.noConflict();	

// Enabling home page slider
jQuery(document).ready(function() { 
slider = jQuery('#slider-content'); 
slider.before('<div id="stripNav0" class="stripNav">') 
		.cycle({ fx: 'scrollLeft', timeout: 8000, speed: 2000, next: '.stripNavL', prev: '.stripNavR', pager:'#stripNav0' }); }); 
nextLink = jQuery('#stripNavLa'); 
prevLink = jQuery('#stripNavRa'); 
changeFx = function(fx) { opts = $(slider).data('cycle.opts'); opts.currFx = fx; opts.fx = fx; slider.cycle.saveOriginalOpts(opts); }
