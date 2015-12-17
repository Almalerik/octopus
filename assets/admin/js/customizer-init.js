jQuery(document).ready(function ( $ ) {

    // Show or hide container max width
    $('#customize-control-octopus_container_class select').on('change', function () {
	if (wp.customize('container_class').get() === 'container-fluid') {
	    wp.customize.control('octopus_container_max_width').deactivate();
	} else {
	    wp.customize.control('octopus_container_max_width').activate();
	}
    });

});
