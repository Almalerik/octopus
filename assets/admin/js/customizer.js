/**
 * customizer.js
 * 
 * Theme Customizer enhancements for a better user experience. Contains handlers
 * to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {

	var $colorStyle = $('#octopus-color-schema-css'), api = wp.customize;
	if (!$colorStyle.length) {
		$colorStyle = $('head').append('<style type="text/css" id="octopus-color-schema-css" />').find('#octopus-color-schema-css');
	}

	// Site title and description.
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});
	// Header text color.
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
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
	wp.customize('container_class', function(value) {
		value.bind(function(to) {
			$('#page').removeClass('container-fluid container').addClass(to).removeAttr('style');

			// If is set to container, set the max-width from the
			// container_max_width settings
			if ('container' === to) {
				var maxWidth = parseInt(wp.customize.value('container_max_width')());
				maxWidth = (isNaN(maxWidth)) ? 1000 : maxWidth;
				$('#page').css('max-width', maxWidth + "px");
			}

		});
	});

	// Container wrapper max width
	wp.customize('container_max_width', function(value) {
		value.bind(function(to) {
			to = (isNaN(to)) ? 1000 : parseInt(to);
			$('#page').css('max-width', to + "px");
		});
	});

	// Grid system class collapse
	wp.customize('gridsystem_class', function(value) {
		value.bind(function(to) {
			var columnClass = "";
			if ($('#octopus-sidebar-left').length > 0) {
				// Get the new class
				columnClass = to + wp.customize('left_sidebar_grid_size').get();
				$('#octopus-sidebar-left').attr('class', removeBootstrapGridClass($('#octopus-sidebar-left').attr('class')) + columnClass);
			}
			if ($('#octopus-sidebar-right').length > 0) {
				// Get the new class
				columnClass = to + wp.customize('right_sidebar_grid_size').get();
				$('#octopus-sidebar-right').attr('class', removeBootstrapGridClass($('#octopus-sidebar-right').attr('class')) + columnClass);
			}
			if ($('#primary').length > 0) {
				// Get the new class
				columnClass = to + wp.customize('content_sidebar_grid_size').get();
				$('#primary').attr('class', removeBootstrapGridClass($('#primary').attr('class')) + columnClass);
			}
		});
	});

	// Left sidebar grid size
	wp.customize('left_sidebar_grid_size', function(value) {
		value.bind(function(to) {
			if ($('#octopus-sidebar-left').length > 0) {
				var newColumnClass = wp.customize('gridsystem_class').get() + to;
				$('#octopus-sidebar-left').attr('class', newColumnClass);
			}
		});
	});

	// container sidebar grid size
	wp.customize('content_sidebar_grid_size', function(value) {
		value.bind(function(to) {
			if ($('#primary').length > 0) {
				var newColumnClass = wp.customize('gridsystem_class').get() + to;
				$('#primary').attr('class', 'content-area ' + newColumnClass);
			}
		});
	});

	// Right sidebar grid size
	wp.customize('right_sidebar_grid_size', function(value) {
		value.bind(function(to) {
			if ($('#octopus-sidebar-right').length > 0) {
				var newColumnClass = wp.customize('gridsystem_class').get() + to;
				$('#octopus-sidebar-right').attr('class', newColumnClass);
			}
		});
	});

	// Colors
	var colorSettings = [ 'color_text', 'color_link', 'color_link_visited', 'color_link_hover', 'header_bg_color', 'header_bg_color_opacity', 'header_bg_color_opacity_onscroll', 'header_title_color', 'header_desription_color', 'header_nav_color' ];
	var i;
	for (i = 0; i < colorSettings.length; ++i) {
		wp.customize(colorSettings[i], function(value) {
			value.bind(function(to) {
				updateColorCss(wp, $colorStyle);
			});
		});
	}

	// Header Max width
	wp.customize('header_max_width', function(value) {
		value.bind(function(to) {
			to = (isNaN(to)) ? 1170 : parseInt(to);
			$('.octopus-navbar-wrapper').css('max-width', to + "px");
			$('.octopus-navbar-wrapper').octopus_fix_long_menu();
		});
	});

	// Header position
	wp.customize('header_position', function(value) {
		value.bind(function(to) {
			if ('' === to) {
				$('.octopus-header-sticky-top .octopus-navbar-default').octopus_sticky_header('destroy');
				$('.site-header').removeClass('octopus-header-sticky-top');
			} else {
				$('.site-header').addClass(to);
				$('.octopus-header-sticky-top .octopus-navbar-default').octopus_sticky_header();
			}
		});
	});

	// Header banner layout
	wp.customize('header_banner_layout', function(value) {
		value.bind(function(to) {
			$('.site-header').removeClass('octopus-fullscreen-banner octopus-header-inside-banner').addClass(to);
			if (to === 'octopus-fullscreen-banner') {
				$('.octopus-fullscreen-banner').octopus_fullscreen_banner();
			} else {
				$('.octopus-header-banner').css('height', wp.customize('header_banner_height').get() + 'px');
			}
		});
	});

	// Header banner height
	wp.customize('header_banner_height', function(value) {
		value.bind(function(to) {
			if (isNaN(parseInt(to))) {
				to = 400;
			}
			$('.octopus-header-banner').css('height', to + 'px');
		});
	});

	/*
	 * // Hide title only in homepage
	 * wp.customize('loungeact[hide_title_in_homepage]', function(value) {
	 * value.bind(function(to) { if (true === to) { $('.site-title').css({
	 * 'clip' : 'rect(1px, 1px, 1px, 1px)', 'position' : 'absolute' }); } else {
	 * $('.site-title').css({ 'clip' : 'auto', 'position' : 'relative' }); } });
	 * }); // Container wrapper wp.customize('loungeact[container_class]',
	 * function(value) { value.bind(function(to) {
	 * $('#page').removeClass('container-fluid
	 * container').addClass(to).removeAttr('style'); if ('container' === to) {
	 * var width = wp.customize.value('loungeact[container_max_width]')();
	 * $('#page').css('max-width', width); } }); }); // Container wrapper max
	 * width wp.customize('loungeact[container_max_width]', function(value) {
	 * value.bind(function(to) { $('#page.container').css('max-width', to); });
	 * }); // Header fixed top wp.customize('loungeact[header_fixed_top]',
	 * function(value) { value.bind(function(to) { if ('' === to) {
	 * $('.lougeact-header.navbar-fixed-top').next().css('margin-top', '0');
	 * $('.lougeact-header').removeClass('navbar-fixed-top'); } else {
	 * $('.lougeact-header').addClass('navbar-fixed-top');
	 * $('.lougeact-header.navbar-fixed-top').next().css('margin-top',
	 * $('.lougeact-header.navbar-fixed-top').outerHeight()); } }); }); //
	 * Header background color
	 * wp.customize('loungeact[header_background_color]', function(value) {
	 * value.bind(function(to) {
	 * //console.log(wp.get_setting('loungeact[header_background_opacity]'));
	 * var opacity = wp.customize('loungeact[header_background_opacity]').get();
	 * $('.navbar-default').css('background-color', hexToRgba(to, opacity,
	 * true)); }); }); // Header background opacity
	 * wp.customize('loungeact[header_background_opacity]', function(value) {
	 * value.bind(function(to) { var bgColor =
	 * wp.customize('loungeact[header_background_color]').get();
	 * $('.navbar-default').css('background-color', hexToRgba(bgColor, to,
	 * true)); }); }); // Site title color
	 * wp.customize('loungeact[site_title_color]', function(value) {
	 * value.bind(function(to) { if (false === to) { $('.site-title
	 * a').css('color', 'transparent'); } else { $('.site-title a').css('color',
	 * to); } }); }); // Blog description color
	 * wp.customize('loungeact[blogdescription_color]', function(value) {
	 * value.bind(function(to) { if (false === to) {
	 * $('.site-description').css('color', 'transparent'); } else {
	 * $('.site-description').css('color', to); } }); });
	 * 
	 * //Slider height wp.customize('loungeact[slider_height]', function(value) {
	 * value.bind(function(to) { $('.loungeact-banner').css('height', to); });
	 * }); // FullScreen slider wp.customize('loungeact[slider_fullscreen]',
	 * function(value) { value.bind(function(to) { if (false === to) {
	 * $('#page').removeClass('loungeact-fullscreen-slider'); } else {
	 * $('#page').addClass('loungeact-fullscreen-slider'); } }); }); // Slide
	 * Opacity wp.customize('loungeact[slide_overlay_opacity]', function(value) {
	 * value.bind(function(to) { $('.flexslider-overlay').css('opacity', to);
	 * }); });
	 */
})(jQuery);

/**
 * Remove Bootstrap grid system class
 * 
 * @param c
 *            String with all element class
 * @returns {String}
 */
function removeBootstrapGridClass(classString) {
	console.log(classString);
	var result = classString.split(' ');
	var i;
	for (i = 0; i < result.length; ++i) {
		if (result[i].indexOf('col-') > -1) {
			result.splice(i, 1);
		}
	}
	console.log(result.join(' '));
	return result.join(' ') + ' ';
}

/**
 * 
 */
function updateColorCss(wp, $colorStyle) {
	var css = '';
	css += 'body {color: ' + wp.customize('color_text').get() + ';}';
	css += 'a {color: ' + wp.customize('color_link').get() + ';}';
	css += 'a:visited {color: ' + wp.customize('color_link_visited').get() + ';}';
	css += 'a:hover, a:focus, a:active {color: ' + wp.customize('color_link_hover').get() + ';}';

	// Header background
	var bgColor = wp.customize('header_bg_color').get();
	var opacity = wp.customize('header_bg_color_opacity').get();
	var opacityOnScroll = wp.customize('header_bg_color_opacity_onscroll').get();
	css += '.octopus-navbar-default {background-color: ' + hexToRgba(bgColor, opacity, true) + ';}';
	css += '.octopus-scrolling .octopus-navbar-default {background-color: ' + hexToRgba(bgColor, opacityOnScroll, true) + ';}';

	// Header colors
	css += '.site-title a, .site-title a:hover, .site-title a:focus, .site-title a:active, .site-title a:visited  {color: ' + wp.customize('header_title_color').get() + ';}';
	css += '.site-description {color: ' + wp.customize('header_desription_color').get() + ';}';
	css += '.navbar-default .navbar-nav > li > a, .navbar-default .navbar-toggle .icon-bar {color: ' + wp.customize('header_nav_color').get() + ';}';

	$colorStyle.html(css);
}

function hexToRgba(hex, opacity, returnRgba) {

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