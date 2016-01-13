

(function($) {


	// Head style with custom css
	var $octopusCustomStyle = $('#octopus-custom-style');
	if (!$octopusCustomStyle.length) {
		$octopusCustomStyle = $('head').append('<style type="text/css" id="octopus-custom-style" />').find('#octopus-custom-style');
	}


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



	// Element wrapper max width
	wp.customize('wrapped_element_max_width', function(value) {
		value.bind(function(to) {
			updateHeadCustomCss(wp, $octopusCustomStyle);
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
	/*
	var colorSettings = [ 'color_text', 'color_link', 'color_link_visited', 'color_link_hover', 'header_bg_color', 'header_bg_color_opacity', 'header_bg_color_opacity_onscroll', 'header_title_color', 'header_desription_color', 'header_nav_color', 'homepage_features_bg_color',
			'homepage_features_text_color', 'homepage_features_description_color', 'homepage_highlights_bg_color', 'homepage_highlights_text_color', 'homepage_highlights_description_color', 'homepage_portfolio_bg_color', 'homepage_portfolio_text_color',
			'homepage_portfolio_description_color', 'header_nav_decoration_hover', 'header_nav_decoration_active' ];
	var i;
	for (i = 0; i < colorSettings.length; ++i) {
		wp.customize(colorSettings[i], function(value) {
			value.bind(function(to) {
				updateColorCss(wp, $colorStyle);
			});
		});
	}*/

	// Wrapped element
	var wrappedElement = {
		'header_wrapped' : '.octopus-navbar-wrapper',
		'homepage_features_wrapped' : '.octopus-features-wrapper',
		'homepage_highlights_wrapped' : '.octopus-highlights-wrapper',
		'homepage_portfolio_wrapped' : '.octopus-portfolio-wrapper',
	};
	$.each(wrappedElement, function(key, selector) {
		wp.customize(key, function(value) {
			value.bind(function(to) {
				if (to) {
					$(selector).addClass("octopus-wrapper");
				} else {
					$(selector).removeClass("octopus-wrapper");
				}
				if (selector === '.octopus-navbar-wrapper') {
					$(selector).octopus_fix_long_menu();
				}
			});
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

	// Homepage Features Show
	wp.customize('homepage_features_show', function(value) {
		value.bind(function(to) {
			$('.octopus-features-sidebar').toggleClass('hidden');
		});
	});
	// Homepage Features title and description.
	wp.customize('homepage_features_title', function(value) {
		value.bind(function(to) {
			var $elem = $('.octopus-features-title');
			var descr = '<span class="octopus-decoration-line"><span>' + wp.customize('homepage_features_description').get() + '</span></span';
			if (!$elem.length) {
				$elem = $('.octopus-features-wrapper').prepend('<h2 class="octopus-features-title"></h2>').find('.octopus-features-wrapper');
			}
			$('.octopus-features-title').text(to).append(descr);
			if ('' === to) {
				$('.octopus-features-title').addClass("hidden");
			} else {
				$('.octopus-features-title').removeClass("hidden");
			}
		});
	});
	wp.customize('homepage_features_description', function(value) {
		value.bind(function(to) {
			$('.octopus-decoration-line span').text(to);
		});
	});

	// Homepage Highlights Show
	wp.customize('octopus_homepage_highlights_show', function(value) {
		value.bind(function(to) {
			$('.octopus-highlights-sidebar').toggleClass('hidden');
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
	var result = classString.split(' ');
	var i;
	for (i = 0; i < result.length; ++i) {
		if (result[i].indexOf('col-') > -1) {
			result.splice(i, 1);
		}
	}
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
	css += '.octopus-navbar-default .navbar-nav > li > a, \
		   .octopus-navbar-default .navbar-nav > li > a:hover, \
		   .octopus-navbar-default .navbar-nav > li > a:focus, \
		   .octopus-navbar-default .navbar-nav > .active > a, \
		   .octopus-navbar-default .navbar-nav > .active > a:hover, \
		   .octopus-navbar-default .navbar-nav > .active > a:focus {color: '
			+ wp.customize('header_nav_color').get() + ';}';
	css += '.octopus-navbar-default .navbar-toggle .icon-bar {background-color: ' + wp.customize('header_nav_color').get() + ';}';
	css += '.octopus-navbar-default .navbar-nav > li > a:hover, .octopus-navbar-default .navbar-nav > li > a:focus {border-color: ' + wp.customize('header_nav_decoration_hover').get() + ';}';
	css += '.octopus-navbar-default .navbar-nav > .active > a, .octopus-navbar-default .navbar-nav > .active > a:hover, .octopus-navbar-default .navbar-nav > .active > a:focus {border-color: ' + wp.customize('header_nav_decoration_active').get() + ';}';

	// Homepage features
	css += '.octopus-features-sidebar {background-color: ' + wp.customize('homepage_features_bg_color').get() + ';}'
	css += '.octopus-features-sidebar .widget-title {color: ' + wp.customize('homepage_features_text_color').get() + ';}'
	css += '.octopus-features-sidebar .widget-description {color: ' + wp.customize('homepage_features_description_color').get() + ';}'

	$colorStyle.html(css);
}

/**
 * 
 */
function updateHeadCustomCss(wp, $octopusCustomStyle) {
	var css = '';
	var sanitazeValue = (isNaN(wp.customize('wrapped_element_max_width').get())) ? 1170 : parseInt(wp.customize('wrapped_element_max_width').get());
	css += '.container-fluid .octopus-wrapper {max-width: ' + sanitazeValue + 'px;}';
	$octopusCustomStyle.html(css);
}


