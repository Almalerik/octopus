/*
 * jQuery UI Accordion init
 */
jQuery.fn.loungeact_accordion = function() {
	jQuery(".ui-accordion-header-icon", jQuery(this)).remove();
	jQuery(this).accordion({
		active : false,
		collapsible : true,
		heightStyle : "content",
		icons : {
			"header" : "loungeact-accordion-close",
			"activeHeader" : "loungeact-accordion-open"
		}
	});
}

/*
 * Select2 FontAwesome init
 */
jQuery.fn.loungeact_select2_fa = function() {
	jQuery(this).select2({
		'templateResult' : formatMenuIcon,
		'templateSelection' : formatMenuIcon,
		'width' : 'resolve',
		'closeOnSelect' : true
	});
};

/*
 * Select2 PostList init
 */
jQuery.fn.loungeact_select2_post_list = function() {
	jQuery(this).select2({
		'width' : 'resolve',
		'closeOnSelect' : true,
		'ajax' : {
			url : ajax_object.ajax_url,
			dataType : 'json',
			delay : 250,
			data : function(params) {
				return {
					action : "lougeact_get_post",
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
};

/*
 * Select2 theme menu template to show icons
 */
function formatMenuIcon(icon) {
	if (!icon.id) {
		return icon.text;
	}
	var $icon = jQuery('<span><i class="' + icon.element.value.toLowerCase() + '"></i> ' + icon.text + '</span>');
	return $icon;
};

jQuery.noConflict()(function($) {
	"use strict";
	$(document).ready(function() {

		$('.lougeact-colorpicker').wpColorPicker();

		/*
		 * CUSTOM FIELDS
		 */
		// Init Select2 FontAwesome
		$(".loungeact-cf-container .loungeact-cf-icon-select2").loungeact_select2_fa();

		// Init Select2 Post list
		$(".loungeact-cf-container .loungeact-cf-post-select2").loungeact_select2_post_list();

		// Init accordion
		$(".loungeact-accordion").loungeact_accordion();

		/*
		 * Widget added or updated event
		 */
		jQuery(document).on('widget-added widget-updated', function(e, widget) {
			// After updtae have to reinit Select2
			$(".loungeact-cf-icon-select2", widget).loungeact_select2_fa();
			$(".loungeact-cf-container .loungeact-cf-post-select2").loungeact_select2_post_list();
			$('.lougeact-colorpicker').wpColorPicker();
			$(".loungeact-accordion").loungeact_accordion();
		});

		// Event click on "Add icon" button
		$("body").on('click', '.loungeact-cf-container .loungeact-cf-add-font-icon', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".loungeact-cf-container");
			$('.loungeact-cf-add-font-icon-container, .loungeact-cf-option-button', $container).toggle();
			// I need to remove select2-container because if this is a new
			// widget wp clone an exist widget without attach event
			$('.select2-container', $container).remove()
			$(".loungeact-cf-icon-select2", $container).loungeact_select2_fa();
		});

		// Event click on "Add media" button
		$("body").on('click', '.loungeact-cf-container .loungeact-cf-add-image', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".loungeact-cf-container");
			$('.loungeact-cf-add-image-container, .loungeact-cf-option-button', $container).toggle();
			$('.loungeact-cf-options-val', $container).val('');
			$('.loungeact-cf-image-preview', $container).html("");

		});

		// Event on change preview image input
		$(".loungeact-cf-image-url").change(function(e) {
			$('.loungeact-cf-image-preview', $(this).closest(".loungeact-cf-field-custom ")).empty().append('<img src="' + $(this).val() + '">');
		});

		// Event click on "Add custom html" button
		$("body").on('click', '.loungeact-cf-container .loungeact-cf-add-custom', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".loungeact-cf-container");
			$('.loungeact-cf-add-custom-container, .loungeact-cf-option-button', $container).toggle();
		});

		// Event click on "Use post or page" button
		$("body").on('click', '.loungeact-cf-container .loungeact-cf-select-post', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".loungeact-cf-container");
			$('.loungeact-cf-select-post-container, .loungeact-cf-option-button', $container).toggle();
			// I need to remove select2-container because if this is a new
			// widget wp clone an exist widget without attach event
			$('.select2-container', $container).remove()
			$(".loungeact-cf-post-select2", $container).loungeact_select2_post_list();
		});

		// Event click on trash menu button
		$("body").on('click', '.loungeact-cf-container .loungeact-cf-option-reset', function(e) {
			e.preventDefault();
			var $container = $(this).closest(".loungeact-cf-container");
			$('.loungeact-cf-options-val', $container).val('').change();
			$(this).closest('.loungeact-cf-field-custom').toggle();
			$(".loungeact-cf-option-button", $container).toggle();
		})

		// END CUSTOM FIELDS

		/*
		 * SLIDER
		 */
		var loungeactEditSlideCounter = $("#loungeact-edit-slides-wrapper li").length;

		// Enable sortable on slide table
		$('#loungeact-edit-slides-wrapper .lougeact-sortable').sortable({
			placeholder : "loungeact-slide-sortable-placeholder",
			cursor : "move",
			handle : ".loungeact-action-move",
			opacity : 0.5,
			appendTo : $('#loungeact-edit-slides-wrapper'),
			axis : "y",
			scroll : true,
			activate : function(event, ui) {
				$("#loungeact-edit-slides-wrapper .sortable").sortable("refreshPositions");
				$("#loungeact-edit-slides-wrapper .sortable").sortable("refresh");
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
		$("#loungeact-edit-slides-wrapper .sortable").disableSelection();

		$("#loungeact-edit-slides-wrapper .loungeact-slide-title").change(function(e) {
			jQuery(".loungeact-accordion-title", jQuery(this).closest("li")).html(jQuery(this).val());
		});

		// Add row slide
		$("#loungeact-edit-slides-wrapper").on('click', '#loungeact-edit-slide-add', function(e) {
			e.preventDefault();
			var $row = $("#loungeact-edit-slide-template").clone(true, true);
			$row.removeAttr("id").removeClass("hidden");
			// Loop through all inputs
			$row.find('input, textarea, label, a, .loungeact-cf-image-preview').each(function() {

				if (!!$(this).attr('id')) {
					// Replace id
					$(this).attr('id', $(this).attr('id').replace('0', loungeactEditSlideCounter));
				}
				if (!!$(this).attr('name')) {
					// Replace name
					$(this).attr('name', $(this).attr('name').replace('[0]', '[' + loungeactEditSlideCounter + ']'));
				}

				if (!!$(this).attr('for')) {
					// Replace for
					$(this).attr('for', $(this).attr('for').replace('0', loungeactEditSlideCounter));
				}

				if (!!$(this).attr('href')) {
					// Replace a
					$(this).attr('href', $(this).attr('href').replace('0', loungeactEditSlideCounter));
				}

				if (!!$(this).attr('onclick')) {
					// Replace a
					$(this).attr('onclick', $(this).attr('onclick').replace(/0/g, loungeactEditSlideCounter));
				}

			});
			$("#loungeact-edit-slides-wrapper .lougeact-sortable").append($row);
			loungeactEditSlideCounter++;
		});

		// Delete row slide
		$("#loungeact-edit-slides-wrapper").on('click', '.loungeact-edit-slide-delete', function(e) {
			e.preventDefault();
			var r = confirm($("#loungeact-slide-thumbnail-delete-msg").val());
			if (r == true) {
				var $wrapper = $(this).closest("li").remove();
			}
		});

	});
});

function loungeact_cf_media_button_click_jq(dialog_title, button_text, library_type, $preview_dom, $control_dom) {
	loungeact_cf_media_button_click(dialog_title, button_text, library_type, $preview_dom.attr("id"), $control_dom.attr("id"));

}

function loungeact_cf_media_button_click(dialog_title, button_text, library_type, preview_id, control_id, get_url) {

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

			jQuery('#' + preview_id).empty().append(html);

		}
	});

	// Open the uploader dialog
	custom_uploader.open();

}

function get_extension(url) {
	return url.substr((url.lastIndexOf('.') + 1));
}
