jQuery(document).ready(function ( $ ) {

    // Show or hide container max width
    /*
    $('#customize-control-octopus_container_class select').on('change', function () {
	if (wp.customize('container_class').get() === 'container-fluid') {
	    wp.customize.control('octopus_container_max_width').deactivate();
	} else {
	    wp.customize.control('octopus_container_max_width').activate();
	}
    });*/

});

(function ( api ) {
    api.controlConstructor.select = api.Control.extend({
	ready : function () {
	    /**
	     * Add a listener to the Page layout control to update grid size according to the number of columns selected.
	     */
	    if ('octopus_page_layout' === this.id) {
		this.setting.bind('change', function ( value ) {
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
	     * Add a listener to the Container Class control to activate or deactivate octopus_container_max_width.
	     */
	    if ('octopus_container_class' === this.id) {
		this.setting.bind('change', function ( value ) {
		    if (value === 'container-fluid') {
			api.control('octopus_container_max_width').deactivate();
		    } else {
			api.control('octopus_container_max_width').activate();
		    }
		});
	    }
	}

    });

})(wp.customize);