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
		}
	});

	$(document).ready(function() {

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
