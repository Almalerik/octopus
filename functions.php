<?php



/**
 * Load Slider
 */
require get_template_directory () . '/inc/post/slider.php';

/**
 * Load Feature
 */
require get_template_directory () . '/inc/post/feature.php';

/**
 * Load Feature Widget
 */
require get_template_directory () . '/inc/widget/feature-widget.php';

/**
 * Load HighLight Widget
 */
require get_template_directory () . '/inc/widget/highlight-widget.php';

/**
 * Load Portfolio
 */
require get_template_directory () . '/inc/post/portfolio.php';

/**
 * Load Staff
 */
require get_template_directory () . '/inc/post/staff.php';

// Change what's hidden by default for custom post
add_filter ( 'default_hidden_meta_boxes', 'octopus_hide_meta_lock', 10, 2 );
function octopus_hide_meta_lock($hidden, $screen) {
	if ( ('octopus_feature' == $screen->post_type) ||
	   	 ('octopus_portfolio' == $screen->post_type) ||
		('octopus_staff' == $screen->post_type) )
		$hidden = array (
				'slugdiv',
				'postcustom',
				'trackbacksdiv',
				'commentstatusdiv',
				'commentsdiv',
				'authordiv',
				'revisionsdiv'
		);
		// removed 'postexcerpt',
		return $hidden;
}

