/*******************************************************************************
 * jQuery UI Accordion init
 ******************************************************************************/
jQuery.fn.octopus_accordion = function () {
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

jQuery.noConflict()(function ( $ ) {
    "use strict";
    $(document).ready(function () {

	// Init accordion
	$(".octopus-accordion").octopus_accordion();

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
	    activate : function ( event, ui ) {
		$("#octopus-edit-slides-wrapper .sortable").sortable("refreshPositions");
		$("#octopus-edit-slides-wrapper .sortable").sortable("refresh");
	    },
	    sort : function ( event, ui ) {
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

	$("#octopus-edit-slides-wrapper .octopus-slide-title").change(function ( e ) {
	    jQuery(".octopus-accordion-title", jQuery(this).closest("li")).html(jQuery(this).val());
	});

	// Add row slide
	$("#octopus-edit-slides-wrapper").on('click', '#octopus-edit-slide-add', function ( e ) {
	    e.preventDefault();
	    var $row = $("#octopus-edit-slide-template").clone(true, true);
	    $row.removeAttr("id").removeClass("hidden");
	    // Loop through all inputs
	    $row.find('input, textarea, label, a, .octopus-cf-image-preview').each(function () {

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
	$("#octopus-edit-slides-wrapper").on('click', '.octopus-edit-slide-delete', function ( e ) {
	    e.preventDefault();
	    var r = confirm($("#octopus-slide-thumbnail-delete-msg").val());
	    if (r == true) {
		var $wrapper = $(this).closest("li").remove();
	    }
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

			jQuery('#' + preview_id).empty().append(html);

		}
	});

	// Open the uploader dialog
	custom_uploader.open();

}

function get_extension(url) {
	return url.substr((url.lastIndexOf('.') + 1));
}
