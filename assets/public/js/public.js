jQuery.noConflict()(function($) {
	"use strict";

	$.fn.extend({
		octopus_fix_long_menu : function() {
			var mastheadWidth = $(this).outerWidth();
			var sitebrandingWidth = $('.site-logo-wrapper', $(this)).outerWidth(true) + $('.site-title-wrapper', $(this)).outerWidth(true);
			var menuWidth = 0;
			jQuery('#primary-menu > li', $(this)).each(function() {
				menuWidth += $(this).outerWidth(true);
			});
			menuWidth += parseInt(jQuery('#navbar').css('padding-left')) + parseInt(jQuery('#navbar').css('padding-right'));
			if ((mastheadWidth - 35) < (sitebrandingWidth + menuWidth)) {
				$(this).addClass('octopus-fix-long-menu');
			} else {
				$(this).removeClass('octopus-fix-long-menu');
			}
		},

		octopus_fullscreen_banner : function() {
			var windowHeight = $(window).height();
			if ($("#wpadminbar").length > 0) {
				windowHeight = windowHeight - jQuery("#wpadminbar").outerHeight();
			}
			$('.octopus-header-banner', $(this)).css('height', windowHeight);
			/*
			 * if ($('.lougeact-header').length > 0){ $(this).css('top',
			 * -$('.lougeact-header').outerHeight()); }
			 */
		},

		octopus_sticky_header : function(action) {
			if ('destroy' === action) {
				$(this).trigger("sticky_kit:detach");
			} else {
				var wpadminbarHeight = 0;
				if ($('#wpadminbar').length > 0 && $('#wpadminbar').css('position') == 'fixed') {
					wpadminbarHeight = $('#wpadminbar').height();
				}
				$(this).stick_in_parent({
					'sticky_class' : 'octopus-header-sticked',
					'parent' : $('#page'),
					'offset_top' : wpadminbarHeight
				});
			}
			return this;
		},

		octopus_swiper : function() {
			var options = {
				direction : 'horizontal'
			};
			if ($('.swiper-pagination', this).length) {
				options['pagination'] = '.swiper-pagination';
				options['paginationClickable'] = true;
			}
			if ($('.swiper-button-next', this).length) {
				options['nextButton'] = '.swiper-button-next';
				options['prevButton'] = '.swiper-button-prev';
			}
			if ( $(this).data('octopusSliderLoop') == '1' ) {
				options['loop'] = 1;
			}
			if ( $(this).data('octopusSliderAutoplay') != '' && $(this).data('octopusSliderAutoplay') != '0' ) {
				options['autoplay'] = '5000';
			}
			
			var mySwiper = new Swiper('.swiper-container', options);
			return mySwiper;
		}
	});

	/***************************************************************************
	 * PortFolio
	 **************************************************************************/
	var octopusPortfolio = (function($) {
		'use strict';

		var $grid = $('.octopus-portfolio-items'), $filterOptions = $('.octopus-portfolio-filters'), $sizer = $grid.find('.shuffle__sizer'),

		init = function() {

			// None of these need to be executed synchronously
			setTimeout(function() {
				listen();
				setupFilters();
			}, 100);

			// instantiate the plugin
			$grid.shuffle({
				itemSelector : '.octopus-portfolio-item',
				delimeter : ','
			});

			// Destroy it! o_O
			// $grid.shuffle('destroy');
		},

		// Set up button clicks
		setupFilters = function() {
			var $btns = $filterOptions.find('.btn');
			$btns.on('click', function() {
				var $this = $(this), isActive = $this.hasClass('active'), group = isActive ? 'all' : $this.data('group');

				// Hide current label, show current label in title
				if (!isActive) {
					$('.octopus-portfolio-filters .active').removeClass('active');
				}

				$this.toggleClass('active');

				// Filter elements
				$grid.shuffle('shuffle', group);
			});

			$btns = null;
		},

		// Re layout shuffle when images load. This is only needed
		// below 768 pixels because the .picture-item height is auto and
		// therefore
		// the height of the picture-item is dependent on the image
		// I recommend using imagesloaded to determine when an image is loaded
		// but that doesn't support IE7
		listen = function() {

			// Get all images inside shuffle
			$grid.find('img').each(function() {
				var proxyImage;

				// Image already loaded
				if (this.complete && this.naturalWidth !== undefined) {
					return;
				}

				// If none of the checks above matched, simulate loading on
				// detached element.
				proxyImage = new Image();
				$(proxyImage).on('load', function() {
					$(this).off('load');
					$grid.shuffle('update');
					;
				});

				proxyImage.src = this.src;
			});

			// Because this method doesn't seem to be perfect.
			setTimeout(function() {
				$grid.shuffle('update');
				;
			}, 500);
		};

		return {
			init : init
		};
	}(jQuery));

	$(document).ready(function() {

		octopusPortfolio.init();

		$('.octopus-swiper').octopus_swiper();

		// Fix primary long menu
		$('.octopus-navbar-wrapper').octopus_fix_long_menu();
		// FullHeight slider
		$('.octopus-fullscreen-banner').octopus_fullscreen_banner();

		// Check if a submenu go outside container
		jQuery(".octopus-navbar-nav li").on('mouseenter mouseleave', function(e) {
			if (jQuery('ul', this).length) {
				var elm = jQuery('ul:first', this);
				var off = elm.offset();
				var l = off.left;
				var w = elm.width();
				var docH = jQuery(window).height();
				var docW = jQuery(window).width();

				var isEntirelyVisible = (l + w <= docW);

				if (!isEntirelyVisible) {
					elm.addClass('open-left');
				} else {
					elm.removeClass('open-left');
				}
			}
		});

		// Responsive submenu open
		$("body").on("click", ".octopus-navbar-nav .octopus-toggle-icon", function(e) {
			e.preventDefault();
			var $pli = $(this).closest("li");
			if ($pli.hasClass("open")) {
				// Change icon
				$(this).removeClass("fa-caret-square-o-up");
				$(this).addClass("fa-caret-square-o-down");
				// Animate menu close
				$(".dropdown-menu:first", $pli).slideUp(300, function() {
					$pli.removeClass("open");
					// Remove display: none added to jQuery because could break
					// submenu if windows resize
					$(this).attr("style", "");
				});
			} else {
				$(this).removeClass("fa-caret-square-o-down");
				$(this).addClass("fa-caret-square-o-up");
				$pli.addClass("open");
				$(".dropdown-menu:first", $pli).slideDown(300);
			}
		});

		// Scrolling class
		$(window).scroll(function() {
			var scroll = $(window).scrollTop();
			if (scroll >= 50) {
				$("#page").addClass("octopus-scrolling");
			} else {
				$("#page").removeClass("octopus-scrolling");
			}
		});
		// This is necessary if user refresh page when not top
		if ($(window).scrollTop() >= 50) {
			$("#page").addClass("octopus-scrolling");
		}

		// Sticky Header
		$('.octopus-header-sticky-top .octopus-navbar-default').octopus_sticky_header();

		$(window).resize(function() {
			// Fix primary long menu on resize
			$('.octopus-navbar-wrapper').octopus_fix_long_menu();
			$('.octopus-fullscreen-banner').octopus_fullscreen_banner();

			// Close all menu
			$('.octopus-navbar-nav').find('.dropdown.open').each(function() {
				$(this).children('a').find('.octopus-toggle-icon').click();
				$(this).children('.sub-menu').attr('style', '');
			});
		});

		// Smooth scroll
		/*
		 * $('a[href^="#"]').on('click',function (e) { e.preventDefault();
		 * 
		 * var target = this.hash; var $target = $(target);
		 * 
		 * //Fixed Menu and wp menu offset var offset = $target.offset().top; if (
		 * $('#masthead').hasClass('octopus-header-sticky-top') ) { offset -=
		 * $('#site-navigation').height() } if ($('#wpadminbar').length > 0 &&
		 * $('#wpadminbar').css('position') == 'fixed') { offset -=
		 * $('#wpadminbar').height(); }
		 * 
		 * $('html, body').stop().animate({ 'scrollTop': offset }, 900, 'swing',
		 * function () { window.location.hash = target; }); });
		 */

		// Cache selectors
		var lastId;
		var topMenu = $("#site-navigation");
		var defaultActive = topMenu.find('li.active');
		// Calculate header height and wp menu if exist and fixed
		var topMenuHeight = topMenu.outerHeight();
		if ($('#wpadminbar').length) {
			if ($('#wpadminbar').css('position') === 'fixed') {
				topMenuHeight += $('#wpadminbar').outerHeight();
			} else {
				if ($('body').scrollTop() < $('#wpadminbar').outerHeight()) {
					topMenuHeight += $('#wpadminbar').outerHeight() - $('body').scrollTop();
				}
			}
		}
		// All list items
		var menuItems = topMenu.find('a[href*="#"]');

		// Anchors corresponding to menu items
		var scrollItems = menuItems.map(function() {
			var href = $(this).attr("href");
			var anchor = $("<a />").attr("href", href)[0].hash.replace(/^#/, "");
			var item = $("#" + anchor);
			if (item.length) {
				return item;
			}
		});

		// Bind click handler to menu items
		// so we can get a fancy scroll animation
		menuItems.click(function(e) {
			var href = $(this).attr("href");
			// Get the anchor
			href = $("<a />").attr("href", href)[0].hash.replace(/^#/, "");
			if ($("#" + href).length) {
				var offsetTop = href === "#" ? 0 : $("#" + href).offset().top - topMenuHeight + 1;
				$('html, body').stop().animate({
					scrollTop : offsetTop
				}, 600);
				e.preventDefault();
			}
		});

		// Bind to scroll
		$(window).scroll(function() {
			// Get container scroll position
			var fromTop = $(this).scrollTop() + topMenuHeight;

			// Get id of current scroll item
			var cur = scrollItems.map(function() {
				if ($(this).offset().top < fromTop && ($(this).offset().top + $(this).outerHeight()) > fromTop)
					return this;
			});
			// Get the id of the current element
			cur = cur[cur.length - 1];
			var id = cur && cur.length ? cur[0].id : "";
			if (lastId !== id) {
				lastId = id;
				// Set/remove active class
				menuItems.parent().removeClass("active");
				if (id !== '' && menuItems.filter("[href*=#" + id + "]").length) {
					// Set/remove active class
					menuItems.filter("[href*=#" + id + "]").parent().addClass("active");
					defaultActive.removeClass('active');
				} else {
					defaultActive.addClass('active');
				}
			}
		});

	});

	// 
	/*
	 * if ($('#page').hasClass('loungeact-header-fixed-top')){ if
	 * ($(window).scrollTop() >= 50) {}
	 * $(".lougeact-wrapper").addClass("lougeact-scrolling"); } // Fix Wp-Admin
	 * ToolBar /* if ($("#wpadminbar").length > 0) { fixWpAdminBarHeight();
	 * $(window).resize(function() { fixWpAdminBarHeight(); }); }
	 */

	// Sticky Header
	/*
	 * $('.navbar-sticky-top').stick_in_parent({'sticky_class' :
	 * 'loungeact-header-sticked', 'parent': $('body')});
	 * 
	 * $('.loungeact-fullscreen-banner
	 * .loungeact-banner').loungeact_fullscreen_banner();
	 * 
	 * $(window).resize(function() { $('.loungeact-fullscreen-banner
	 * .loungeact-banner').loungeact_fullscreen_banner(); }); // Responsive
	 * submenu open // Fix content if header is fixed top if
	 * ($('.lougeact-header.navbar-fixed-top').length > 0) {
	 * $('.lougeact-header.navbar-fixed-top').next().css('margin-top',
	 * $('.lougeact-header.navbar-fixed-top').outerHeight()); }
	 */

	// Slide menu
	/*
	 * $(".navbar-toggle").each(function() { if ($(this).attr('data-toggle')) {
	 * var datatoggle = $(this).attr('data-toggle'); if (datatoggle ===
	 * 'loungeact-menu-slide-left' || datatoggle ===
	 * 'loungeact-menu-slide-right') { $(this).on('click', function() { var
	 * $datatarget = $($(this).attr('data-target')); if
	 * (!$datatarget.hasClass('loungeact-out')) {
	 * $datatarget.toggleClass('loungeact-out') $datatarget.stop().animate({
	 * 'left' : '0' }, 400); } else { $datatarget.toggleClass('loungeact-out')
	 * $datatarget.stop().animate({ 'left' : '-75%' }, 400); } }); } } });
	 * 
	 * });
	 * 
	 * /** Fix Wp-Admin ToolBar
	 */
	/*
	 * function fixWpAdminBarHeight() {
	 * 
	 * var selectorToFix = [ '.lougeact-header.navbar-fixed-top',
	 * '.navbar-fixed-top .navbar-collapse.loungeact-menu-slide-left' ]; for
	 * (var i = 0; i < selectorToFix.length; i++) { // Check if exist if
	 * ($(selectorToFix[i]).length > 0) { var topMargin =
	 * jQuery("#wpadminbar").outerHeight() - jQuery("body").scrollTop();
	 * topMargin = topMargin < 0 ? 0 : topMargin; $(selectorToFix[i]).css("top",
	 * jQuery("#wpadminbar").outerHeight()); } } }
	 */

});
