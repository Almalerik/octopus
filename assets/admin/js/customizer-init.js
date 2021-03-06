jQuery(document).ready(function($) {

	wp.customize.section('sidebar-widgets-homepage-features').panel('octopus_homepage_features');
	wp.customize.section('sidebar-widgets-homepage-features').priority('20');
	jQuery('body').on('click', '.octopus-goto-swh-features', function() {
		wp.customize.section('sidebar-widgets-homepage-features').focus();
	});

	wp.customize.section('sidebar-widgets-homepage-highlights').panel('octopus_homepage_highlights');
	wp.customize.section('sidebar-widgets-homepage-highlights').priority('20');
	jQuery('body').on('click', '.octopus-goto-swh-highlights', function() {
		wp.customize.section('sidebar-widgets-homepage-highlights').focus();
	});

	wp.customize.section('sidebar-widgets-homepage-staff').panel('octopus_homepage_staff');
	wp.customize.section('sidebar-widgets-homepage-staff').priority('20');
	jQuery('body').on('click', '.octopus-goto-swh-staff', function() {
		wp.customize.section('sidebar-widgets-homepage-staff').focus();
	});
	
	// Show or hide container max width
	/*
	 * $('#customize-control-octopus_container_class select').on('change',
	 * function () { if (wp.customize('container_class').get() ===
	 * 'container-fluid') {
	 * wp.customize.control('octopus_container_max_width').deactivate(); } else {
	 * wp.customize.control('octopus_container_max_width').activate(); } });
	 */

});

(function(api) {
	api.controlConstructor.select = api.Control.extend({
		ready : function() {
			/**
			 * Add a listener to the Page layout control to update grid size
			 * according to the number of columns selected.
			 */
			if ('octopus_page_layout' === this.id) {
				this.setting.bind('change', function(value) {
					if (value == 'left-sidebar') {
						api.control('octopus_left_sidebar_grid_size').container.find('select').val('3').change();
						api.control('octopus_content_sidebar_grid_size').container.find('select').val('9').change();
					} else if (value == 'right-sidebar') {
						api.control('octopus_right_sidebar_grid_size').container.find('select').val('3').change();
						api.control('octopus_content_sidebar_grid_size').container.find('select').val('9').change();
					} else if (value == 'all-sidebar') {
						api.control('octopus_left_sidebar_grid_size').container.find('select').val('3').change();
						api.control('octopus_right_sidebar_grid_size').container.find('select').val('3').change();
						api.control('octopus_content_sidebar_grid_size').container.find('select').val('6').change();
					}
				});
			}


			/**
			 * Add a listener to the octopus_header_banner_layout control to
			 * activate or deactivate header_banner_height.
			 */
			if ('octopus_header_banner_layout' === this.id) {
				this.setting.bind('change', function(value) {
					if (value === 'octopus-fullscreen-banner') {
						api.control('octopus_header_banner_height').deactivate();
					} else {
						api.control('octopus_header_banner_height').activate();
					}
				});
			}
		}

	});

})(wp.customize);