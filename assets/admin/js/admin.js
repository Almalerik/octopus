/*******************************************************************************
 * jQuery UI Accordion init
 ******************************************************************************/
jQuery.fn.octopus_accordion = function() {
	jQuery(".ui-accordion-header-icon", jQuery(this)).remove();
	jQuery(this).accordion({
		active : false,
		collapsible : true,
		heightStyle : "content",
		icons : {
			"header" : "octopus-accordion-close",
			"activeHeader" : "octopus-accordion-open"
		}
	});
}

/*******************************************************************************
 * Select2 FontAwesome init
 ******************************************************************************/
/*
 * Select2 theme menu template to show icons
 */
function formatMenuIcon(icon) {
	if (!icon.id) {
		return icon.text;
	}
	var $icon = jQuery('<span><i class="fa ' + icon.id + '"></i> ' + icon.text + '</span>');
	return $icon;
};
/*
 * Select2 PostList init
 */
jQuery.fn.octopus_select2_fa = function() {
	jQuery(this).select2({
		'width' : 'resolve',
		'closeOnSelect' : true,
		'ajax' : {
			url : ajaxurl,
			dataType : 'json',
			delay : 250,
			data : function(params) {
				return {
					action : "octopus_get_fontawesome",
					// search term
					search: params.term // search term
				};
			},
			cache : true
		},
		'templateResult' : formatMenuIcon,
		'templateSelection' : formatMenuIcon
	});
	jQuery(this).trigger("change");
}

/*******************************************************************************
 * Select2 Post list init
 ******************************************************************************/
jQuery.fn.octopus_select2_posts= function() {
	jQuery(this).select2({
		'width' : 'resolve',
		'closeOnSelect' : true,
		'ajax' : {
			url : ajaxurl,
			dataType : 'json',
			delay : 250,
			data : function(params) {
				return {
					action : "octopus_get_post_json",
					// search term
					title : params.term,
					type : "post, page"
				};
			},
			cache : true
		},
		'templateResult' : function(data) {
			return data.text;
		},
		'templateSelection' : function(data) {
			return data.text;
		}
	});
	jQuery(this).trigger("change");
}

jQuery.noConflict()(function($) {
	"use strict";
	$(document).ready(function() {

		// Init accordion
		$(".octopus-accordion").octopus_accordion();
		// Init Select2 FontAwesome
		$(".octopus-cf-icon-select2").octopus_select2_fa();
		// Init Color Piker
		$('.octopus-colorpicker').wpColorPicker();
		// Init Select2 Posts list
		$(".octopus-cf-post-select2").octopus_select2_posts();

		/***********************************************************************
		 * SLIDER
		 **********************************************************************/
		var octopusEditSlideCounter = $("#octopus-edit-slides-wrapper li").length;
		// Enable sortable on slide table
		$('#octopus-edit-slides-wrapper .octopus-sortable').sortable({
			placeholder : "octopus-slide-sortable-placeholder",
			cursor : "move",
			handle : ".octopus-action-move",
			opacity : 0.5,
			appendTo : $('#octopus-edit-slides-wrapper'),
			axis : "y",
			scroll : true,
			activate : function(event, ui) {
				$("#octopus-edit-slides-wrapper .sortable").sortable("refreshPositions");
				$("#octopus-edit-slides-wrapper .sortable").sortable("refresh");
			},
			sort : function(event, ui) {
				var $target = $(event.target);
				if (!/html|body/i.test($target.offsetParent()[0].tagName)) {
					var top = event.pageY - $target.offsetParent().offset().top - (ui.helper.outerHeight(true) / 2);
					ui.helper.css({
						'top' : top + 'px'
					});
				}
			},
		});
		$("#octopus-edit-slides-wrapper .sortable").disableSelection();

		$("#octopus-edit-slides-wrapper .octopus-slide-title").change(function(e) {
			jQuery(".octopus-accordion-title", jQuery(this).closest("li")).html(jQuery(this).val());
		});

		// Add row slide
		$("#octopus-edit-slides-wrapper").on('click', '#octopus-edit-slide-add', function(e) {
			e.preventDefault();
			var $row = $("#octopus-edit-slide-template").clone(true, true);
			$row.removeAttr("id").removeClass("hidden");
			// Loop through all inputs
			$row.find('input, textarea, label, a, .octopus-cf-image-preview, .octopus-accordion-thumb').each(function() {

				if (!!$(this).attr('id')) {
					// Replace id
					$(this).attr('id', $(this).attr('id').replace('0', octopusEditSlideCounter));
				}
				if (!!$(this).attr('name')) {
					// Replace name
					$(this).attr('name', $(this).attr('name').replace('[0]', '[' + octopusEditSlideCounter + ']'));
				}

				if (!!$(this).attr('for')) {
					// Replace for
					$(this).attr('for', $(this).attr('for').replace('0', octopusEditSlideCounter));
				}

				if (!!$(this).attr('href')) {
					// Replace a
					$(this).attr('href', $(this).attr('href').replace('0', octopusEditSlideCounter));
				}

				if (!!$(this).attr('onclick')) {
					// Replace a
					$(this).attr('onclick', $(this).attr('onclick').replace(/0/g, octopusEditSlideCounter));
				}

			});
			// Close all accordion
			$("#octopus-edit-slides-wrapper .octopus-sortable").find('.octopus-accordion').accordion("option", "active", false);
			// Open new
			$row.find('.octopus-accordion:first h4:first').click();
			// Append new row
			$("#octopus-edit-slides-wrapper .octopus-sortable").append($row);
			octopusEditSlideCounter++;
		});

		// Delete row slide
		$("#octopus-edit-slides-wrapper").on('click', '.octopus-edit-slide-delete', function(e) {
			e.preventDefault();
			var r = confirm($("#octopus-slide-thumbnail-delete-msg").val());
			if (r == true) {
				var $wrapper = $(this).closest("li").remove();
			}
		});
		
		/***********************************************************************
		 * Font / Image / Custom html / Post
		 **********************************************************************/
		// Event click on "Add icon" button
		$("body").on('click', '.octopus-cf-add-font-icon', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".octopus-cf-container");
			$('.octopus-cf-add-font-icon-container, .octopus-cf-option-button', $container).toggle();
			// I need to remove select2-container because if this is a new
			// widget wp clone an exist widget without attach event
			$('.select2-container', $container).remove()
			$(".octopus-cf-icon-select2", $container).octopus_select2_fa();
		});
		// Event click on "Add media" button
		$("body").on('click', '.octopus-cf-add-image', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".octopus-cf-container");
			$('.octopus-cf-add-image-container, .octopus-cf-option-button', $container).toggle();
			$('.octopus-cf-options-val', $container).val('');
			$('.octopus-cf-image-preview', $container).html("");

		});
		// Event click on "Use post or page" button
		$("body").on('click', '.octopus-cf-select-post', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".octopus-cf-container");
			$('.octopus-cf-select-post-container, .octopus-cf-option-button', $container).toggle();
			// I need to remove select2-container because if this is a new
			// widget wp clone an exist widget without attach event
			$('.select2-container', $container).remove()
			$(".octopus-cf-post-select2", $container).octopus_select2_posts();
		});
		
		// Event click on trash menu button
		$("body").on('click', '.octopus-cf-option-reset', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".octopus-cf-container");
			$('.octopus-cf-options-val', $container).val('').change();
			$(this).closest('.octopus-cf-field-custom').toggle();
			$(".octopus-cf-option-button", $container).toggle();
		});
		
		/***********************************************************************
		 * Widget added or updated event
		 **********************************************************************/
		jQuery(document).on('widget-added widget-updated', function(e, widget) {
			// After updtae have to reinit Select2
			$(".octopus-cf-icon-select2", widget).octopus_select2_fa();
			$(".octopus-accordion").octopus_accordion();
			$('.octopus-colorpicker').wpColorPicker();
			$(".octopus-cf-post-select2").octopus_select2_posts();
		});
		
		
	});
});

function octopus_cf_media_button_click_jq(dialog_title, button_text, library_type, $preview_dom, $control_dom) {
	octopus_cf_media_button_click(dialog_title, button_text, library_type, $preview_dom.attr("id"), $control_dom.attr("id"));

}

function octopus_cf_media_button_click(dialog_title, button_text, library_type, preview_id, control_id, get_url) {

	event.preventDefault();

	// Extend the wp.media object
	custom_uploader = wp.media.frames.file_frame = wp.media({
		title : dialog_title,
		button : {
			text : button_text
		},
		library : {
			type : library_type
		},
		multiple : false
	});

	// When a file is selected, grab the URL and set it as the text field's
	// value
	custom_uploader.on('select', function() {

		attachment = custom_uploader.state().get('selection').first().toJSON();
		if (get_url) {
			jQuery('#' + control_id).val(attachment.url).change();
		} else {
			jQuery('#' + control_id).val(attachment.id).change();
		}

		if (preview_id != null || preview_id !== '') {

			var html = '';

			if (library_type == 'image') {
				var thumb_url = attachment.url;
				if (attachment != undefined) {
					thumb_url = (attachment.sizes != undefined && attachment.sizes.thumbnail != undefined) ? attachment.sizes.thumbnail.url : attachment.url;
				}
				html = '<img src="' + thumb_url + '">';
			}

			if (library_type == 'video') {
				html = '<video autoplay loop><source src="' + attachment.url + '" type="video/' + get_extension(attachment.url) + '" /></video>';
			}

			if (jQuery.isArray(preview_id)) {
				var i;
				for (i = 0; i < preview_id.length; i++) {
					jQuery('#' + preview_id[i]).empty().append(html);
				}
			} else {
				jQuery('#' + preview_id).empty().append(html);
			}

		}
	});

	// Open the uploader dialog
	custom_uploader.open();

}

function get_extension(url) {
	return url.substr((url.lastIndexOf('.') + 1));
}
