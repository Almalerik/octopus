/**
 * customizer.js
 * 
 * Theme Customizer enhancements for a better user experience. Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ( $ ) {
    // Site title and description.
    wp.customize('blogname', function ( value ) {
	value.bind(function ( to ) {
	    $('.site-title a').text(to);
	});
    });
    wp.customize('blogdescription', function ( value ) {
	value.bind(function ( to ) {
	    $('.site-description').text(to);
	});
    });
    // Header text color.
    wp.customize('header_textcolor', function ( value ) {
	value.bind(function ( to ) {
	    if ('blank' === to) {
		$('.site-title').css({
		    'clip' : 'rect(1px, 1px, 1px, 1px)',
		    'position' : 'absolute'
		});
	    } else {
		$('.site-title').css({
		    'clip' : 'auto',
		    'position' : 'relative'
		});
		$('.site-title').css({
		    'color' : to
		});
	    }
	});
    });

    // Container wrapper
    wp.customize('container_class', function ( value ) {
	value.bind(function ( to ) {
	    $('#page').removeClass('container-fluid container').addClass(to).removeAttr('style');

	    // If is set to container, set the max-width from the container_max_width settings
	    if ('container' === to) {
		var maxWidth = parseInt(wp.customize.value('container_max_width')());
		maxWidth = (isNaN(maxWidth)) ? 1000 : maxWidth;
		$('#page').css('max-width', maxWidth + "px");
	    }

	});
    });

    // Container wrapper max width
    wp.customize('container_max_width', function ( value ) {
	value.bind(function ( to ) {
	    to = (isNaN(to)) ? 1000 : parseInt(to);
	    $('#page').css('max-width', to + "px");
	});
    });


    /*
     * // Hide title only in homepage wp.customize('loungeact[hide_title_in_homepage]', function(value) { value.bind(function(to) { if (true === to) { $('.site-title').css({ 'clip' : 'rect(1px, 1px, 1px, 1px)', 'position' : 'absolute' }); } else { $('.site-title').css({ 'clip' : 'auto', 'position' : 'relative' }); } }); }); // Container wrapper wp.customize('loungeact[container_class]', function(value) { value.bind(function(to) { $('#page').removeClass('container-fluid container').addClass(to).removeAttr('style'); if ('container' === to) { var width = wp.customize.value('loungeact[container_max_width]')(); $('#page').css('max-width', width); } }); }); // Container wrapper max width wp.customize('loungeact[container_max_width]', function(value) { value.bind(function(to) { $('#page.container').css('max-width', to); }); }); // Header fixed top wp.customize('loungeact[header_fixed_top]',
     * function(value) { value.bind(function(to) { if ('' === to) { $('.lougeact-header.navbar-fixed-top').next().css('margin-top', '0'); $('.lougeact-header').removeClass('navbar-fixed-top'); } else { $('.lougeact-header').addClass('navbar-fixed-top'); $('.lougeact-header.navbar-fixed-top').next().css('margin-top', $('.lougeact-header.navbar-fixed-top').outerHeight()); } }); }); // Header background color wp.customize('loungeact[header_background_color]', function(value) { value.bind(function(to) { //console.log(wp.get_setting('loungeact[header_background_opacity]')); var opacity = wp.customize('loungeact[header_background_opacity]').get(); $('.navbar-default').css('background-color', hexToRgba(to, opacity, true)); }); }); // Header background opacity wp.customize('loungeact[header_background_opacity]', function(value) { value.bind(function(to) { var bgColor =
     * wp.customize('loungeact[header_background_color]').get(); $('.navbar-default').css('background-color', hexToRgba(bgColor, to, true)); }); }); // Site title color wp.customize('loungeact[site_title_color]', function(value) { value.bind(function(to) { if (false === to) { $('.site-title a').css('color', 'transparent'); } else { $('.site-title a').css('color', to); } }); }); // Blog description color wp.customize('loungeact[blogdescription_color]', function(value) { value.bind(function(to) { if (false === to) { $('.site-description').css('color', 'transparent'); } else { $('.site-description').css('color', to); } }); });
     * 
     * //Slider height wp.customize('loungeact[slider_height]', function(value) { value.bind(function(to) { $('.loungeact-banner').css('height', to); }); }); // FullScreen slider wp.customize('loungeact[slider_fullscreen]', function(value) { value.bind(function(to) { if (false === to) { $('#page').removeClass('loungeact-fullscreen-slider'); } else { $('#page').addClass('loungeact-fullscreen-slider'); } }); }); // Slide Opacity wp.customize('loungeact[slide_overlay_opacity]', function(value) { value.bind(function(to) { $('.flexslider-overlay').css('opacity', to); }); });
     */
})(jQuery);

function hexToRgba ( hex, opacity, returnRgba ) {

    opacity = !opacity ? 1 : opacity;
    var parsing = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    var result = parsing ? {
	r : parseInt(parsing[1], 16),
	g : parseInt(parsing[2], 16),
	b : parseInt(parsing[3], 16),
	o : opacity
    } : {
	r : 0,
	g : 0,
	b : 0,
	o : 0
    };

    if (returnRgba) {
	var array_values = new Array();
	for ( var key in result) {
	    array_values.push(result[key]);
	}
	return 'rgba(' + array_values.join(", ") + ')';
    } else {
	return result;
    }
}
